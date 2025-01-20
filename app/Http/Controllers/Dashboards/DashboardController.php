<?php

namespace App\Http\Controllers\Dashboards;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Order;
use App\Models\Product;
use App\Models\Purchase;
use App\Models\Quotation;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\Pet; 
use App\Models\User;
use App\Models\Appointment;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $totalPets = Pet::count();
        $todayPets = Pet::whereDate('created_at', today())->count();

        $appointments = Appointment::count();
        $todayAppointments = Appointment::whereDate('created_at', today())->count();

        \Log::info('Dashboard Counts:', [
            'total_pets' => $totalPets,
            'today_pets' => $todayPets,
            'total_appointments' => $appointments,
            'today_appointments' => $todayAppointments
        ]);

        $orders = Order::where("user_id", auth()->id())->count();
        $products = Product::where("user_id", auth()->id())->count();
        $todayProducts = Product::whereDate('created_at', today())->count();
        $todayOrders = Order::whereDate('created_at', today())->count();
        $categories = Category::where("user_id", auth()->id())->count();
        $totalPetOwners = User::where('role', 'pet_owner')->count(); 
        $todayPetOwners = User::where('role', 'pet_owner')->whereDate('created_at', today())->count(); 

        $fromDate = $request->input('from_date', today()->subDays(7)->format('Y-m-d'));
        $toDate = $request->input('to_date', today()->format('Y-m-d'));

        $sortBy = $request->input('sort_by', 'date');

        $recentEvents = $this->getRecentEvents($fromDate, $toDate, $sortBy);

        // Calculate growth percentages
        $lastMonthPets = Pet::whereMonth('created_at', now()->subMonth()->month)
            ->whereYear('created_at', now()->subMonth()->year)
            ->count();
        $petGrowth = $lastMonthPets > 0 ? (($totalPets - $lastMonthPets) / $lastMonthPets) * 100 : 0;

        // Calculate appointment growth
        $lastMonthAppointments = Appointment::whereMonth('created_at', now()->subMonth()->month)
            ->whereYear('created_at', now()->subMonth()->year)
            ->count();
        $appointmentGrowth = $lastMonthAppointments > 0 
            ? (($appointments - $lastMonthAppointments) / $lastMonthAppointments) * 100 
            : 0;

        $averageOrders = Order::whereDate('created_at', '>=', now()->subDays(30))
            ->whereDate('created_at', '<', today())
            ->count() / 30;
        $orderGrowth = $averageOrders > 0 ? (($todayOrders - $averageOrders) / $averageOrders) * 100 : 0;

        $ownerGrowth = $todayPetOwners > 0 ? (($totalPetOwners - $todayPetOwners) / $todayPetOwners) * 100 : 0;

        // Format appointments for calendar
        $calendarAppointments = Appointment::select(
            'id',
            'appointment_date as start',
            'reason_for_visit as title',
            'appointment_time',
            'owner_name',
            'pet_name',
            DB::raw("CONCAT(
                'Owner: ', owner_name,
                '\nPet: ', COALESCE(pet_name, 'Not specified'),
                '\nTime: ', TIME_FORMAT(appointment_time, '%h:%i %p'),
                '\nReason: ', reason_for_visit
            ) as description")
        )->get()->map(function($appointment) {
            return [
                'id' => $appointment->id,
                'title' => $appointment->title,
                'start' => $appointment->start,
                'description' => $appointment->description,
                'backgroundColor' => '#3788d8',
                'borderColor' => '#3788d8',
                'textColor' => '#ffffff',
                'extendedProps' => [
                    'time' => $appointment->appointment_time,
                    'owner' => $appointment->owner_name,
                    'pet' => $appointment->pet_name,
                    'description' => $appointment->description
                ]
            ];
        });

        // Get monthly statistics
        $monthlyStats = $this->getMonthlyStats();

        return view('dashboard', compact(
            'totalPets',
            'todayPets',
            'petGrowth',
            'appointments',
            'todayAppointments',
            'appointmentGrowth',
            'orderGrowth',
            'totalPetOwners',
            'todayPetOwners',
            'products',
            'orders',
            'todayProducts',
            'todayOrders',
            'categories',
            'recentEvents',
            'fromDate',
            'toDate',
            'sortBy',
            'calendarAppointments',
            'monthlyStats',
            'ownerGrowth'
        ));
    }

    private function getRecentEvents($fromDate, $toDate, $sortBy)
    {
        // Upcoming appointments (next 7 days)
        $appointments = Appointment::select(
            'appointment_date as date',
            DB::raw('"appointment" as type'),
            DB::raw("CONCAT(
                COALESCE(owner_name, 'Unknown Owner'),
                ' - ',
                reason_for_visit,
                ' at ',
                TIME_FORMAT(appointment_time, '%h:%i %p')
            ) as description"),
            'created_at'
        )->whereBetween('appointment_date', [now(), now()->addDays(7)]);

        // Low stock products (below threshold)
        $lowStock = Product::select(
            DB::raw('CURRENT_DATE as date'),
            DB::raw('"low_stock" as type'),
            DB::raw("CONCAT(
                name,
                ' - Only ',
                quantity,
                ' items remaining'
            ) as description"),
            'updated_at as created_at'
        )->where('quantity', '<=', DB::raw('quantity_alert'))
          ->where('quantity', '>', 0);

        // Out of stock products
        $outOfStock = Product::select(
            DB::raw('CURRENT_DATE as date'),
            DB::raw('"out_of_stock" as type'),
            DB::raw("CONCAT(
                name,
                ' is out of stock'
            ) as description"),
            'updated_at as created_at'
        )->where('quantity', '=', 0);

        // New products added today
        $newProducts = Product::select(
            DB::raw('DATE(created_at) as date'),
            DB::raw('"new_product" as type'),
            DB::raw("CONCAT(
                name,
                ' - ',
                COALESCE(selling_price, 0),
                ' PHP'
            ) as description"),
            'created_at'
        )->whereDate('created_at', today());

        // Recent pets
        $pets = Pet::select(
            DB::raw('DATE(created_at) as date'),
            DB::raw('"new_pet" as type'),
            DB::raw("CONCAT(
                name, 
                ' - ', 
                COALESCE(breed, 'Unknown Breed'),
                CASE 
                    WHEN age IS NOT NULL THEN CONCAT(', ', age, ' years old')
                    ELSE ''
                END
            ) as description"),
            'created_at'
        )->whereBetween('created_at', [$fromDate, $toDate]);

        // Recent pet owners
        $petOwners = User::select(
            DB::raw('DATE(created_at) as date'),
            DB::raw('"new_pet_owner" as type'),
            DB::raw("CONCAT(
                name,
                CASE 
                    WHEN email IS NOT NULL THEN CONCAT(' - ', email)
                    ELSE ''
                END
            ) as description"),
            'created_at'
        )->where('role', 'pet_owner')
          ->whereBetween('created_at', [$fromDate, $toDate]);

        // Recent orders
        $recentOrders = Order::select(
            DB::raw('DATE(created_at) as date'),
            DB::raw('"new_order" as type'),
            DB::raw("CONCAT(
                'Order #',
                invoice_no,
                ' - ',
                COALESCE(pay, 0),
                ' PHP'
            ) as description"),
            'created_at'
        )->whereBetween('created_at', [$fromDate, $toDate]);

        // Combine all events
        $events = $appointments
            ->union($lowStock)
            ->union($outOfStock)
            ->union($newProducts)
            ->union($pets)
            ->union($petOwners)
            ->union($recentOrders);

        // Enhanced sorting with better context
        switch ($sortBy) {
            case 'type':
                $events = $events->orderBy('type')->orderByDesc('date');
                break;
            case 'description':
                $events = $events->orderBy('description')->orderByDesc('date');
                break;
            case 'date':
            default:
                $events = $events->orderByDesc('date')->orderByDesc('created_at');
                break;
        }

        return $events->get();
    }

    private function getMonthlyStats()
    {
        $months = collect(range(1, 12))->map(function($month) {
            $date = now()->month($month);
            return [
                'month' => $date->format('M'),
                'appointments' => Appointment::whereMonth('created_at', $month)
                    ->whereYear('created_at', now()->year)
                    ->count(),
                'pets' => Pet::whereMonth('created_at', $month)
                    ->whereYear('created_at', now()->year)
                    ->count(),
                'orders' => Order::whereMonth('created_at', $month)
                    ->whereYear('created_at', now()->year)
                    ->count(),
                'petOwners' => User::where('role', 'pet_owner')
                    ->whereMonth('created_at', $month)
                    ->whereYear('created_at', now()->year)
                    ->count(),
            ];
        });

        return $months;
    }

    public function getStatistics(Request $request)
    {
        $month = $request->get('month', now()->month);
        $year = $request->get('year', now()->year);

        $statistics = $this->getMonthlyStatistics($month, $year);

        return response()->json([
            'labels' => $statistics->pluck('month'),
            'appointments' => $statistics->pluck('appointments'),
            'pets' => $statistics->pluck('pets'),
            'orders' => $statistics->pluck('orders'),
            'petOwners' => $statistics->pluck('petOwners'),
        ]);
    }

    private function getMonthlyStatistics($month, $year)
    {
        $startDate = Carbon::create($year, $month, 1)->startOfMonth();
        $months = collect();

        // Get data for the last 12 months from the selected month
        for ($i = 11; $i >= 0; $i--) {
            $currentDate = $startDate->copy()->subMonths($i);
            $months->push([
                'month' => $currentDate->format('M'),
                'appointments' => Appointment::whereYear('created_at', $currentDate->year)
                    ->whereMonth('created_at', $currentDate->month)
                    ->count(),
                'pets' => Pet::whereYear('created_at', $currentDate->year)
                    ->whereMonth('created_at', $currentDate->month)
                    ->count(),
                'orders' => Order::whereYear('created_at', $currentDate->year)
                    ->whereMonth('created_at', $currentDate->month)
                    ->count(),
                'petOwners' => User::where('role', 'pet_owner')
                    ->whereYear('created_at', $currentDate->year)
                    ->whereMonth('created_at', $currentDate->month)
                    ->count(),
            ]);
        }

        return $months;
    }
}
