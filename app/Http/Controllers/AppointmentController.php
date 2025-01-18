<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\User;
use App\Models\Pet;
use App\Models\Reason;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class AppointmentController extends Controller
{
    public function index()
    {
        $appointment = DB::table('appointment')
            ->leftJoin('pets', 'appointment.pet_id', '=', 'pets.id')
            ->leftJoin('users', 'appointment.user_id', '=', 'users.id')
            ->select(
                'appointment.*',
                'pets.name as pet_name',
                'pets.type as pet_type',
                'pets.age as pet_age',
                'users.name as user_name'
            )
            ->get();
    
        return view('appointment.index', ['appointment' => $appointment]);
    }
    

    public function create()
    {
        $users = User::where('role', 'pet_owner')
            ->with(['pets' => function($query) {
                $query->select('id', 'user_id', 'name', 'type', 'age');
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
            'reason_for_visit' => json_encode($request->reason_for_visit), // Store reasons as JSON
        ]);
    
        return redirect()->route('appointment.index')->with('success', 'Appointment created successfully.');
    }
    

    public function edit($id)
    {
        $appointment = Appointment::findOrFail($id);
        $users = User::where('role', 'pet_owner')->get(); // Fetch all pet owners
        $pets = Pet::where('user_id', auth()->id())->get(); // Fetch pets for the logged-in user
    
        $reasons = ['Vaccination', 'Grooming', 'Checkup', 'Other']; // Predefined reasons
    
        return view('appointment.edit', compact('appointment', 'users', 'pets', 'reasons'));
    }
    

    public function update(Request $request, $id)
    {
        $appointment = Appointment::findOrFail($id);
        
        $validatedData = $request->validate([
            'user_id' => 'nullable|exists:users,id',
            'pet_id' => 'nullable|exists:pets,id',
            'owner_name' => 'required_without:user_id|nullable|string',
            'pet_name' => 'required|string',
            'pet_type' => 'required|string',
            'pet_age' => 'required|integer',
            'appointment_date' => 'required|date',
            'appointment_time' => 'required',
            'reason_for_visit' => 'required'
        ]);

        $appointment->update($validatedData);

        return redirect()->route('appointment.index')
            ->with('success', 'Appointment updated successfully');
    }
    

    public function destroy($id)
    {
        $appointment = Appointment::findOrFail($id);
        $appointment->delete();

        return redirect()->route('appointment.index')->with('success', 'Appointment deleted successfully.');
    }
}
