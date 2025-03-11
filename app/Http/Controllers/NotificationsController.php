<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Appointment;
use App\Models\Notification;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class NotificationsController extends Controller
{
    public function index()
    {
        // Add debugging
        \Log::info('Notifications controller hit');
        
        // Get low stock notifications
        $notifications = Product::where('quantity', '<=', DB::raw('quantity_alert'))->get();
        \Log::info('Low stock notifications count: ' . $notifications->count());
        
        // Get system notifications (new pets, new users)
        $systemNotifications = Notification::where('read_at', null)
            ->where('user_id', auth()->id())
            ->orderBy('created_at', 'desc')
            ->get();
        \Log::info('System notifications count: ' . $systemNotifications->count());
        
        // Get upcoming appointments
        $upcomingAppointments = Appointment::where('scheduled_at', '>=', now())
            ->where('scheduled_at', '<=', now()->addWeek())
            ->where('status', '!=', 'completed')
            ->where('status', '!=', 'cancelled')
            ->orderBy('scheduled_at')
            ->get();
        \Log::info('Upcoming appointments count: ' . $upcomingAppointments->count());

        return view('notifications.index', compact('notifications', 'systemNotifications', 'upcomingAppointments'));
    }

    public function markAllRead()
    {
        Notification::where('user_id', auth()->id())
            ->whereNull('read_at')
            ->update(['read_at' => now()]);
            
        return redirect()->back()->with('success', 'All notifications marked as read');
    }
} 