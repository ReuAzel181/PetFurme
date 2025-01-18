<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\User;
use App\Models\Pet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AppointmentController extends Controller
{
    public function index()
    {
        $appointments = DB::table('appointment')
            ->leftJoin('pets', 'appointment.pet_id', '=', 'pets.id')
            ->leftJoin('users', 'appointment.user_id', '=', 'users.id')
            ->select(
                'appointment.*',
                'pets.name as pet_name',
                'pets.category as pet_type',
                'pets.age as pet_age',
                'users.name as owner_name',
                DB::raw('CASE 
                    WHEN users.id IS NOT NULL THEN users.name
                    ELSE CONCAT(appointment.owner_name, " (No Account)")
                END as display_name')
            )
            ->get();
    
        return view('appointment.index', ['appointments' => $appointments]);
    }

    public function create()
    {
        $users = User::where('role', 'pet_owner')
            ->with(['pets' => function($query) {
                $query->select('id', 'user_id', 'name', 'age', 'category');
            }])
            ->get(['id', 'name', 'email']);

        return view('appointment.create', compact('users'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'nullable|exists:users,id',
            'owner_name' => 'required_without:user_id|string|max:255',
            'pet_id' => 'nullable|exists:pets,id',
            'pet_name' => 'required_without:pet_id|string|max:255',
            'appointment_date' => 'required|date',
            'appointment_time' => 'required',
            'reason_for_visit' => 'required|string', // JSON-encoded string
        ]);

        // Create the appointment
        Appointment::create([
            'user_id' => $request->user_id,
            'owner_name' => $request->user_id ? null : $request->owner_name,
            'pet_id' => $request->pet_id,
            'pet_name' => $request->pet_name,
            'appointment_date' => $request->appointment_date,
            'appointment_time' => $request->appointment_time,
            'reason_for_visit' => $request->reason_for_visit, // Already JSON encoded from frontend
        ]);

        return redirect()->route('appointment.index')
            ->with('success', 'Appointment created successfully.');
    }

    public function edit($id)
    {
        $appointment = Appointment::with(['pet', 'user'])->findOrFail($id);
        $users = User::where('role', 'pet_owner')
            ->with(['pets' => function($query) {
                $query->select('id', 'user_id', 'name', 'age', 'category');
            }])
            ->get(['id', 'name', 'email']);
        
        // Decode the JSON string to array
        if (is_string($appointment->reason_for_visit)) {
            $appointment->reason_for_visit = json_decode($appointment->reason_for_visit, true);
        }

        return view('appointment.edit', compact('appointment', 'users'));
    }

    public function update(Request $request, $id)
    {
        $appointment = Appointment::findOrFail($id);
        
        $validatedData = $request->validate([
            'user_id' => 'nullable|exists:users,id',
            'owner_name' => 'required_without:user_id|nullable|string',
            'pet_id' => 'nullable|exists:pets,id',
            'pet_name' => 'required|string',
            'pet_type' => 'required|string',
            'pet_age' => 'required|integer',
            'appointment_date' => 'required|date',
            'appointment_time' => 'required',
            'reason_for_visit' => 'required'
        ]);

        // Clean up the reason_for_visit before saving
        if (is_string($validatedData['reason_for_visit'])) {
            $reasons = json_decode($validatedData['reason_for_visit'], true);
            $validatedData['reason_for_visit'] = json_encode($reasons);
        }

        $appointment->update($validatedData);

        return redirect()->route('appointment.index')
            ->with('success', 'Appointment updated successfully');
    }

    public function destroy($id)
    {
        $appointment = Appointment::findOrFail($id);
        $appointment->delete();

        return redirect()->route('appointment.index')
            ->with('success', 'Appointment deleted successfully.');
    }
}
