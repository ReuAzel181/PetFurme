<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pet;
use App\Models\User;
use App\Models\Appointment;
use Illuminate\Support\Facades\Schema;

class AdminDashboardController extends Controller
{
    public function index()
    {
        // Get counts for dashboard stats
        $stats = [
            'total_pets' => Pet::count(),
            'total_users' => User::where('role', 'pet_owner')->count(),
            'total_appointments' => Appointment::count(),
            'pending_appointments' => 0  // Default to 0
        ];

        // Only query pending appointments if the status column exists
        if (Schema::hasColumn('appointment', 'status')) {
            $stats['pending_appointments'] = Appointment::where('status', 'pending')->count();
        }

        // Get recent appointments
        $recent_appointments = Appointment::with(['pet', 'user'])
            ->latest('appointment_date')
            ->take(5)
            ->get();

        // Add status if it doesn't exist and handle null relationships
        $recent_appointments = $recent_appointments->map(function ($appointment) {
            $appointment->status = $appointment->status ?? 'pending';
            
            // Use the direct columns if relationships are null
            $appointment->owner_name = $appointment->user ? $appointment->user->name : ($appointment->owner_name ?? 'Walk-in');
            $appointment->pet_name = $appointment->pet ? $appointment->pet->name : ($appointment->pet_name ?? 'N/A');
            
            return $appointment;
        });

        return view('admin.dashboard', compact('stats', 'recent_appointments'));
    }
} 