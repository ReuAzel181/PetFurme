<?php

namespace App\Http\Controllers;

use App\Models\Pet;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // Get total pets count
        $totalPets = Pet::count();
        
        // Get today's pets (using today's date)
        $todayPets = Pet::whereDate('created_at', Carbon::now()->toDateString())->count();

        // For debugging - let's log the counts and dates
        \Log::info('Pet Counts:', [
            'total' => $totalPets,
            'today' => $todayPets,
            'today_date' => Carbon::now()->toDateString(),
            'sample_pet_dates' => Pet::pluck('created_at')->toArray()
        ]);

        return view('dashboard', [
            'totalPets' => $totalPets,
            'todayPets' => $todayPets,
            // Add other variables as needed
        ]);
    }
} 