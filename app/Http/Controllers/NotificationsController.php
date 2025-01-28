<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Appointment;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class NotificationsController extends Controller
{
    public function index()
    {
        // Add debugging
        \Log::info('Notifications controller hit');
        
        $notifications = Product::where('quantity', '<=', DB::raw('quantity_alert'))->get();
        \Log::info('Notifications count: ' . $notifications->count());
        
        $expiringProducts = Product::where('expiry_date', '<=', now()->addDays(30))->get();
        \Log::info('Expiring products count: ' . $expiringProducts->count());
        
        $upcomingAppointments = Appointment::where('scheduled_at', '>=', now())
            ->where('scheduled_at', '<=', now()->addWeek())
            ->where('status', '!=', 'completed')
            ->where('status', '!=', 'cancelled')
            ->orderBy('scheduled_at')
            ->get();
        \Log::info('Upcoming appointments count: ' . $upcomingAppointments->count());

        return view('notifications.index', compact('notifications', 'expiringProducts', 'upcomingAppointments'));
    }

    public function markAllRead()
    {
        // Add your mark all as read logic here
        return redirect()->back()->with('success', 'All notifications marked as read');
    }
} 