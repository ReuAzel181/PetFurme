<?php

namespace App\Http\Controllers;

use App\Models\User;
use PDF;
use Illuminate\Http\Request;
use Carbon\Carbon;

class UserManagementController extends Controller
{
    public function export($format)
    {
        $users = User::with(['pets', 'appointments', 'orders'])->get();
        
        if ($format === 'csv') {
            $headers = [
                'Content-Type' => 'text/csv',
                'Content-Disposition' => 'attachment; filename=users.csv',
            ];
            
            $callback = function() use ($users) {
                $file = fopen('php://output', 'w');
                
                // Add CSV headers
                fputcsv($file, [
                    'ID', 'Name', 'Email', 'Phone', 'Address', 'Created At',
                    'Pets', 'Pet Details',
                    'Appointments', 'Appointment Details',
                    'Orders', 'Order Details'
                ]);
                
                // Add data rows
                foreach ($users as $user) {
                    // Format pets information
                    $petsCount = $user->pets->count();
                    $petDetails = $user->pets->map(function($pet) {
                        return "Name: {$pet->name}, Type: {$pet->type}, Breed: {$pet->breed}";
                    })->join(' | ');

                    // Format appointments information
                    $appointmentsCount = $user->appointments->count();
                    $appointmentDetails = $user->appointments->map(function($appointment) {
                        return "Date: {$appointment->appointment_date}, Service: {$appointment->service_type}, Status: {$appointment->status}";
                    })->join(' | ');

                    // Format orders information
                    $ordersCount = $user->orders->count();
                    $orderDetails = $user->orders->map(function($order) {
                        return "Order #{$order->id}, Total: {$order->total}, Status: {$order->status}, Date: {$order->created_at}";
                    })->join(' | ');

                    fputcsv($file, [
                        $user->id,
                        $user->name,
                        $user->email,
                        $user->phone,
                        $user->address,
                        $user->created_at,
                        $petsCount,
                        $petDetails,
                        $appointmentsCount,
                        $appointmentDetails,
                        $ordersCount,
                        $orderDetails
                    ]);
                }
                
                fclose($file);
            };
            
            return response()->stream($callback, 200, $headers);
        }
        
        if ($format === 'pdf') {
            $pdf = PDF::loadView('exports.users', ['users' => $users]);
            return $pdf->download('users.pdf');
        }
        
        return back()->with('error', 'Invalid export format');
    }

    public function exportSelected(Request $request)
    {
        $userIds = json_decode($request->users);
        $users = User::with(['pets', 'appointments', 'orders'])
            ->whereIn('id', $userIds)
            ->get();

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename=users_export.csv',
        ];
        
        $callback = function() use ($users) {
            $file = fopen('php://output', 'w');
            
            // Add CSV headers
            fputcsv($file, [
                'ID', 'Name', 'Email', 'Phone', 'Address', 'Created At',
                'Pets', 'Pet Details',
                'Appointments', 'Appointment Details',
                'Orders', 'Order Details'
            ]);
            
            // Add data rows
            foreach ($users as $user) {
                // Format pets information
                $petsCount = $user->pets->count();
                $petDetails = $user->pets->map(function($pet) {
                    return "Name: {$pet->name}, Type: {$pet->type}, Breed: {$pet->breed}";
                })->join(' | ');

                // Format appointments information
                $appointmentsCount = $user->appointments->count();
                $appointmentDetails = $user->appointments->map(function($appointment) {
                    return "Date: {$appointment->appointment_date}, Service: {$appointment->service_type}, Status: {$appointment->status}";
                })->join(' | ');

                // Format orders information
                $ordersCount = $user->orders->count();
                $orderDetails = $user->orders->map(function($order) {
                    return "Order #{$order->id}, Total: {$order->total}, Status: {$order->status}, Date: {$order->created_at}";
                })->join(' | ');

                fputcsv($file, [
                    $user->id,
                    $user->name,
                    $user->email,
                    $user->phone,
                    $user->address,
                    $user->created_at,
                    $petsCount,
                    $petDetails,
                    $appointmentsCount,
                    $appointmentDetails,
                    $ordersCount,
                    $orderDetails
                ]);
            }
            
            fclose($file);
        };
        
        return response()->stream($callback, 200, $headers);
    }

    public function index(Request $request)
    {
        // Your existing query logic here
        
        if ($request->ajax()) {
            return view('users.index', compact('users', 'roles'))->render();
        }
        
        return view('users.index', compact('users', 'roles'));
    }
} 