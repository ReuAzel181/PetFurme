<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\User; 
use Illuminate\Http\Request;

class AppointmentController extends Controller
{
    public function index()
    {
        // Fetch all appointments
        $appointment = Appointment::all(); // Fetch data from the 'appointment' table

        // Pass appointments to the view
        return view('appointment.index', ['appointment' => $appointment]);
    }

    public function create()
    {
        // Fetch all users
        $users = User::all();
    
        // Pass the users to the view
        return view('appointment.create', ['users' => $users]);
    }
    
    public function store(Request $request)
    {
        // Validate and save a new appointment
        $request->validate([
            'pet_name' => 'required|string|max:255',
            'owner_name' => 'required|string|max:255',
            'appointment_date' => 'required|date',
            'appointment_time' => 'required',
        ]);

        // Save the new appointment
        Appointment::create($request->all());

        return redirect()->route('appointment.index')->with('success', 'Appointment created successfully.');
    }

    public function edit($id)
    {
        // Fetch the specific appointment for editing
        $appointment = Appointment::findOrFail($id);

        // Fetch all users
        $users = User::all();

        // Pass appointment and users to the edit view
        return view('appointment.edit', compact('appointment', 'users'));
    }

    public function update(Request $request, $id)
    {
        // Validate the data
        $request->validate([
            'pet_name' => 'required|string|max:255',
            'owner_name' => 'required|string|max:255',
            'appointment_date' => 'required|date',
            'appointment_time' => 'required',
        ]);

        // Update the specific appointment
        $appointment = Appointment::findOrFail($id);
        $appointment->update($request->all());

        return redirect()->route('appointment.index')->with('success', 'Appointment updated successfully.');
    }

    public function destroy($id)
    {
        // Delete the specific appointment
        $appointment = Appointment::findOrFail($id);
        $appointment->delete();

        return redirect()->route('appointment.index')->with('success', 'Appointment deleted successfully.');
    }
}
