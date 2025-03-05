<?php

namespace App\Http\Controllers\PetOwner;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\User;
use App\Models\Pet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AppointmentController extends Controller
{
    public function index()
    {
        $appointments = Appointment::with(['user', 'pet'])
            ->latest()
            ->get();

        return view('petowner.appointments.index', compact('appointments'));
    }

    public function create()
    {
        $owners = User::where('role', 'pet_owner')->get();
        $pets = Pet::all();

        return view('petowner.appointments.create', compact('owners', 'pets'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'appointment_date' => 'required|date',
            'appointment_time' => 'required',
            'owner_id' => 'required|exists:users,id',
            'pet_id' => 'required|exists:pets,id',
        ]);

        $appointment = Appointment::create($validatedData);

        return redirect()->route('petowner.appointments.index')
            ->with('success', 'Appointment created successfully!');
    }

    // Add other methods as needed (edit, update, destroy, etc.)
}