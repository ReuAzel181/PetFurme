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
        $appointments = Appointment::with(['pet', 'user'])
            ->select(
                'appointment.*',
                DB::raw('CASE 
                    WHEN users.id IS NOT NULL THEN users.name
                    ELSE appointment.owner_name
                END as display_name')
            )
            ->leftJoin('users', 'appointment.user_id', '=', 'users.id')
            ->get();
    
        return view('appointment.index', [
            'appointments' => $appointments,
            'showArchived' => false
        ]);
    }

    public function archived()
    {
        $archivedAppointments = DB::table('archived_appointments')
            ->leftJoin('users', 'archived_appointments.user_id', '=', 'users.id')
            ->select(
                'archived_appointments.*',
                DB::raw('CASE 
                    WHEN users.id IS NOT NULL THEN users.name
                    ELSE archived_appointments.owner_name
                END as display_name')
            )
            ->orderBy('archived_at', 'desc')
            ->get();

        return view('appointment.archived', [
            'appointments' => $archivedAppointments,
            'showArchived' => true
        ]);
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

    public function restore($id)
    {
        $archived = DB::table('archived_appointments')->where('id', $id)->first();
        
        if (!$archived) {
            return redirect()->back()->with('error', 'Archived appointment not found.');
        }

        // Restore to appointments table
        Appointment::create([
            'user_id' => $archived->user_id,
            'pet_id' => $archived->pet_id,
            'owner_name' => $archived->owner_name,
            'pet_name' => $archived->pet_name,
            'appointment_date' => $archived->appointment_date,
            'appointment_time' => $archived->appointment_time,
            'reason_for_visit' => $archived->reason_for_visit
        ]);

        // Remove from archive
        DB::table('archived_appointments')->where('id', $id)->delete();

        return redirect()->route('appointment.index')
            ->with('success', 'Appointment restored successfully.');
    }

    public function destroy($id)
    {
        $appointment = Appointment::findOrFail($id);
        
        // Insert into archived_appointments as cancelled
        DB::table('archived_appointments')->insert([
            'original_id' => $appointment->id,
            'user_id' => $appointment->user_id,
            'pet_id' => $appointment->pet_id,
            'owner_name' => $appointment->owner_name,
            'pet_name' => $appointment->pet_name,
            'appointment_date' => $appointment->appointment_date,
            'appointment_time' => $appointment->appointment_time,
            'reason_for_visit' => $appointment->reason_for_visit,
            'status' => 'cancelled',
            'archived_at' => now(),
            'created_at' => $appointment->created_at,
            'updated_at' => now()
        ]);

        // Delete from original table
        $appointment->delete();

        return redirect()->route('appointment.index')
            ->with('success', 'Appointment cancelled and archived.');
    }

    public function markAsCompleted(Request $request, $id)
    {
        $appointment = Appointment::findOrFail($id);
        
        // Insert into archived_appointments as completed
        DB::table('archived_appointments')->insert([
            'original_id' => $appointment->id,
            'user_id' => $appointment->user_id,
            'pet_id' => $appointment->pet_id,
            'owner_name' => $appointment->owner_name,
            'pet_name' => $appointment->pet_name,
            'appointment_date' => $appointment->appointment_date,
            'appointment_time' => $appointment->appointment_time,
            'reason_for_visit' => $appointment->reason_for_visit,
            'status' => 'completed',
            'notes' => $request->notes,
            'completed_at' => now(),
            'archived_at' => now(),
            'created_at' => $appointment->created_at,
            'updated_at' => now()
        ]);

        // Delete the original appointment
        $appointment->delete();

        return redirect()->route('appointment.index')
            ->with('success', 'Appointment marked as completed.');
    }

    public function completed()
    {
        $completedAppointments = DB::table('completed_appointments')
            ->leftJoin('users', 'completed_appointments.user_id', '=', 'users.id')
            ->select(
                'completed_appointments.*',
                DB::raw('CASE 
                    WHEN users.id IS NOT NULL THEN users.name
                    ELSE completed_appointments.owner_name
                END as display_name')
            )
            ->orderBy('completed_at', 'desc')
            ->get();

        return view('appointment.completed', [
            'appointments' => $completedAppointments
        ]);
    }
}
