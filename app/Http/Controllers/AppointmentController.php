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
        $appointments = Appointment::with(['pet', 'user', 'creator', 'confirmer'])
            ->select(
                'appointment.*',
                DB::raw('CASE 
                    WHEN users.id IS NOT NULL THEN users.name
                    ELSE appointment.owner_name
                END as display_name'),
                DB::raw('DATE(appointment_date) as appointment_date_display')
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
                END as display_name'),
                DB::raw('DATE(appointment_date) as appointment_date_display')
            )
            ->orderBy('archived_at', 'desc')
            ->get();

        return view('appointment.archived', [
            'appointments' => $archivedAppointments,
            'showArchived' => true
        ]);
    }

    public function create(Request $request)
    {
        $owners = User::where('role', 'pet_owner')->get();
        $pet = null;
        $owner = null;
        $ownerPets = collect();

        if ($request->pet_id) {
            $pet = Pet::with('owner')->findOrFail($request->pet_id);
            $owner = $pet->owner;
            $ownerPets = $owner->pets;
        } elseif ($request->owner_id) {
            $owner = User::with('pets')->findOrFail($request->owner_id);
            $ownerPets = $owner->pets;
            
            // If pet_id is provided in the URL, pre-select it
            if ($request->pet_id) {
                $pet = $ownerPets->firstWhere('id', $request->pet_id);
            }
        }

        return view('appointment.create', compact('pet', 'owner', 'owners', 'ownerPets'));
    }

    public function store(Request $request)
    {
        $rules = [
            'appointment_date' => 'required|date',
            'appointment_time' => 'required',
            'reason_for_visit' => 'required|string',
            'notes' => 'nullable|string',
        ];

        // Add conditional validation rules based on whether it's a walk-in or registered user
        if ($request->user_id === 'no_account') {
            $rules = array_merge($rules, [
                'owner_name' => 'required|string',
                'walkin_pet_name' => 'required|string',
                'walkin_pet_type' => 'required|string',
                'walkin_pet_age' => 'required|numeric|min:0',
                'walkin_age_unit' => 'required|in:years,months',
            ]);
        } else {
            $rules = array_merge($rules, [
                'user_id' => 'required|exists:users,id',
                'pet_id' => 'required|exists:pets,id',
            ]);
        }

        $validated = $request->validate($rules);

        try {
            DB::beginTransaction();

            $appointment = new Appointment($validated);
            
            // If logged in user is staff
            if (auth()->user()->isStaff()) {
                $appointment->status = 'confirmed';
                $appointment->created_by_type = 'staff';
                $appointment->created_by_id = auth()->id();
            } 
            // If regular user
            else {
                $appointment->status = 'pending';
                $appointment->created_by_type = 'user';
                $appointment->created_by_id = auth()->id();
            }
            
            if ($request->user_id === 'no_account') {
                // Handle walk-in appointment
                $appointment->owner_name = $validated['owner_name'];
                $appointment->pet_name = $validated['walkin_pet_name'];
                $appointment->pet_type = $validated['walkin_pet_type'];
                
                // Convert age to months if years is selected
                $age = $validated['walkin_pet_age'];
                if ($validated['walkin_age_unit'] === 'years') {
                    $age = $age * 12;
                }
                $appointment->pet_age = $age;
                
                $appointment->user_id = null;
                $appointment->pet_id = null;
            } else {
                // Handle registered user appointment
                $appointment->user_id = $validated['user_id'];
                $appointment->pet_id = $validated['pet_id'];
                // Get pet details from the database
                $pet = Pet::findOrFail($validated['pet_id']);
                $appointment->pet_name = $pet->name;
                $appointment->pet_type = $pet->category;
                $appointment->pet_age = $pet->age; // Assuming pet age is already in months in the database
            }

            $appointment->appointment_date = $validated['appointment_date'];
            $appointment->appointment_time = $validated['appointment_time'];
            $appointment->reason_for_visit = $validated['reason_for_visit'];
            $appointment->notes = $validated['notes'] ?? '';
            $appointment->deleted_by = null;

            // Combine date and time into scheduled_at
            $appointment->scheduled_at = $validated['appointment_date'] . ' ' . $validated['appointment_time'];

            $appointment->save();

            DB::commit();
            
            // Use flash message with session
            session()->flash('success', 'Appointment scheduled successfully');
            return redirect()->route('appointment.index');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()
                ->withInput()
                ->with('error', 'Failed to schedule appointment. Please try again.');
        }
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
        try {
            $appointment = Appointment::withTrashed()->findOrFail($id);
            $appointment->restore();

            return redirect()->back()->with('success', 'Appointment restored successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error restoring appointment: ' . $e->getMessage());
        }
    }

    public function destroy(Appointment $appointment)
    {
        try {
            DB::beginTransaction();
            
            // Set deleted_by before soft deleting
            $appointment->update([
                'deleted_by' => auth()->id()
            ]);
            
            $appointment->delete();
            
            DB::commit();
            return redirect()->back()->with('success', 'Appointment archived successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Failed to archive appointment.');
        }
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

    public function getDates()
    {
        $dates = Appointment::select('appointment_date')
            ->where('appointment_date', '>=', now()->format('Y-m-d'))
            ->distinct()
            ->pluck('appointment_date')
            ->map(function($date) {
                return $date->format('Y-m-d');
            });

        return response()->json(['dates' => $dates]);
    }

    public function confirm(Appointment $appointment)
    {
        $this->authorize('confirm-appointments');
        
        $appointment->update([
            'status' => 'confirmed',
            'confirmed_by' => auth()->id(),
            'confirmed_at' => now()
        ]);
        
        return back()->with('success', 'Appointment confirmed successfully');
    }

    public function show(Appointment $appointment)
    {
        return view('appointments.show', compact('appointment'));
    }
}
