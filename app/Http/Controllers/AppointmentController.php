<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\User;
use App\Models\Pet;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Vaccination;
use App\Models\Checkup;
use App\Models\GroomingSession;
use App\Models\Surgery;
use App\Models\LaboratoryTest;

class AppointmentController extends Controller
{
    public function index()
    {
        $appointments = Appointment::with(['user', 'pet', 'creator', 'confirmer', 'pet' => function($query) {
            $query->select('id', 'name', 'photo', 'photo_data');
        }])
            ->latest()
            ->get();
    
        // Fetch only active products with stock
        $products = Product::where('quantity', '>', 0)
                         ->select('id', 'name', 'selling_price', 'quantity')
                         ->get()
                         ->map(function($product) {
                             // Convert the price to a proper format (since it's stored in cents)
                             $product->selling_price = $product->selling_price / 100;
                             return $product;
                         });

        return view('appointment.index', [
            'appointments' => $appointments,
            'showArchived' => false,
            'products' => $products
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
        \Log::info('Appointment store method called', [
            'request_all' => $request->all(),
            'reason_for_visit' => $request->reason_for_visit,
            'is_vaccination' => $request->reason_for_visit === 'Vaccination',
        ]);

        try {
            DB::beginTransaction();

            // Base validation rules
            $rules = [
                'appointment_date' => 'required|date',
                'appointment_time' => 'required',
                'reason_for_visit' => 'required|string',
                'owner_id' => 'required_without:owner_name|exists:users,id,deleted_at,NULL',
                'pet_id' => 'required_without:walkin_pet_name|exists:pets,id,deleted_at,NULL',
                // Walk-in fields
                'owner_name' => 'required_if:owner_id,no_account|nullable|string',
                'walkin_pet_name' => 'required_if:owner_id,no_account|nullable|string',
                'walkin_pet_type' => 'required_if:owner_id,no_account|nullable|string',
                'walkin_pet_age' => 'required_if:owner_id,no_account|nullable|numeric',
                'walkin_age_unit' => 'required_if:owner_id,no_account|nullable|in:months,years'
            ];

            // Add vaccination-specific rules if vaccination is selected
            if ($request->reason_for_visit === 'Vaccination') {
                // Extract vaccination data from the nested array
                if (!empty($request->vaccine) && is_array($request->vaccine)) {
                    $vaccineData = $request->vaccine[0];
                    // Map the nested data to flat fields
                    $request->merge([
                        'vaccine_type' => $vaccineData['type'] ?? null,
                        'batch_number' => $vaccineData['batch_number'] ?? null,
                        'next_due_date' => $vaccineData['next_due_date'] ?? null,
                        'administered_by' => $vaccineData['administered_by'] ?? null,
                        'reactions' => $vaccineData['reactions'] ?? null
                    ]);
                }

                $rules = array_merge($rules, [
                    'vaccine_type' => 'required|string',
                    'batch_number' => 'required|string',
                    'next_due_date' => 'required|date',
                    'administered_by' => 'required|string'
                ]);
                
                \Log::info('Vaccination validation rules applied', [
                    'rules' => $rules,
                    'vaccine_data' => [
                        'type' => $request->vaccine_type,
                        'batch' => $request->batch_number,
                        'due_date' => $request->next_due_date,
                        'admin_by' => $request->administered_by
                    ]
                ]);
            }

            try {
                $validated = $request->validate($rules);
                \Log::info('Validation passed', ['validated_data' => $validated]);
            } catch (\Illuminate\Validation\ValidationException $e) {
                \Log::error('Validation failed', [
                    'errors' => $e->errors(),
                    'request_data' => $request->all()
                ]);
                throw $e;
            }
            
            // Create the appointment
            $appointment = new Appointment();
            $appointment->appointment_date = $validated['appointment_date'];
            $appointment->appointment_time = $validated['appointment_time'];
            $appointment->reason_for_visit = json_encode([$validated['reason_for_visit']]);
            $appointment->notes = $request->notes ?? '';
            
            // Handle the reason_for_visit JSON format
            $reasonForVisit = $validated['reason_for_visit'];
            if (is_string($reasonForVisit)) {
                $reasonForVisit = [$reasonForVisit];
            }
            $appointment->reason_for_visit = json_encode($reasonForVisit);

            // Handle walk-in vs registered user
            if ($request->owner_id === 'no_account') {
                $appointment->owner_name = $validated['owner_name'];
                $appointment->pet_name = $validated['walkin_pet_name'];
                $appointment->pet_type = $validated['walkin_pet_type'];
                
                $age = $validated['walkin_pet_age'];
                if ($validated['walkin_age_unit'] === 'years') {
                    $age = $age * 12;
                }
                $appointment->pet_age = $age;
            } else {
                $appointment->user_id = $validated['owner_id'];
                $appointment->pet_id = $validated['pet_id'];
                
                $pet = Pet::findOrFail($validated['pet_id']);
                $appointment->pet_name = $pet->name;
                $appointment->pet_type = $pet->category;
                $appointment->pet_age = $pet->age;
            }

            // Set status and created by info
            if (auth()->user()->isStaff()) {
                $appointment->status = 'confirmed';
                $appointment->created_by_type = 'staff';
            } else {
                $appointment->status = 'pending';
                $appointment->created_by_type = 'user';
            }
            $appointment->created_by_id = auth()->id();

            // Set scheduled_at
            $appointment->scheduled_at = $validated['appointment_date'] . ' ' . $validated['appointment_time'];

            \Log::info('About to save appointment', ['appointment' => $appointment->toArray()]);
            $appointment->save();
            \Log::info('Appointment saved', ['id' => $appointment->id]);

            // Create vaccination record if needed
            if ($appointment->id && $validated['reason_for_visit'] === 'Vaccination') {
                \Log::info('Creating vaccination record', [
                    'vaccine_type' => $validated['vaccine_type'],
                    'batch_number' => $validated['batch_number'],
                    'next_due_date' => $validated['next_due_date']
                ]);
                
                Vaccination::create([
                    'appointment_id' => $appointment->id,
                    'pet_id' => $appointment->pet_id,
                    'type' => $validated['vaccine_type'],
                    'batch_number' => $validated['batch_number'],
                    'date_given' => $appointment->appointment_date,
                    'next_due_date' => $validated['next_due_date'],
                    'reactions' => $request->reactions,
                ]);
            }

            DB::commit();
            \Log::info('Transaction committed');

            return redirect()->route('appointment.index')
                ->with('success', 'Appointment scheduled successfully!');

        } catch (\Illuminate\Validation\ValidationException $e) {
            DB::rollBack();
            \Log::error('Validation exception caught', [
                'errors' => $e->errors(),
                'request_data' => $request->all()
            ]);
            return back()
                ->withInput()
                ->withErrors($e->validator)
                ->with('error_section', 'vaccination');
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Appointment creation error', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'request_data' => $request->all()
            ]);
            
            return back()
                ->withInput()
                ->withErrors(['error' => 'Error creating appointment: ' . $e->getMessage()]);
        }
    }

    private function createServiceRecord($appointment, $serviceType, $request)
    {
        \Log::info('Creating service record', [
            'serviceType' => $serviceType,
            'appointmentId' => $appointment->id,
            'request' => $request->all()
        ]);

        switch ($serviceType) {
            case 'Vaccination':  // Note the capital V to match the form value
                try {
                    $vaccination = Vaccination::create([
                        'appointment_id' => $appointment->id,
                        'pet_id' => $appointment->pet_id,
                        'type' => $request->vaccine_type,
                        'batch_number' => $request->batch_number,
                        'date_given' => $appointment->appointment_date,
                        'next_due_date' => $request->next_due_date,
                        'reactions' => $request->reactions,
                    ]);
                    \Log::info('Vaccination record created', ['vaccination' => $vaccination]);
                } catch (\Exception $e) {
                    \Log::error('Error creating vaccination record', [
                        'error' => $e->getMessage(),
                        'data' => [
                            'appointment_id' => $appointment->id,
                            'pet_id' => $appointment->pet_id,
                            'vaccine_type' => $request->vaccine_type,
                            'batch_number' => $request->batch_number,
                            'date_given' => $appointment->appointment_date,
                            'next_due_date' => $request->next_due_date,
                        ]
                    ]);
                    throw $e;
                }
                break;
            
            case 'checkup':
                Checkup::create([
                    'appointment_id' => $appointment->id,
                    'pet_id' => $appointment->pet_id,
                    'date' => $appointment->appointment_date,
                    'service_type' => 'routine', // or get from request if you have a field for this
                    'findings' => $request->findings ?? '',
                    'vital_signs' => $request->vital_signs ?? '',
                    'treatment' => $request->treatment ?? '',
                    'medications' => $request->medications ?? '',
                    'next_visit' => $request->next_visit ?? $appointment->appointment_date,
                    'notes' => $request->checkup_notes ?? '',
                ]);
                break;
            
            case 'grooming':
                GroomingSession::create([
                    'appointment_id' => $appointment->id,
                    'pet_id' => $appointment->pet_id,
                    'date' => $appointment->appointment_date,
                    'services_done' => json_encode($request->grooming_services ?? []),
                    'products_used' => json_encode($request->products_used ?? []),
                    'notes' => $request->grooming_notes ?? '',
                ]);
                break;
            
            case 'surgery':
                Surgery::create([
                    'appointment_id' => $appointment->id,
                    'pet_id' => $appointment->pet_id,
                    'surgery_type' => $request->surgery_type ?? '',
                    'pre_surgery_notes' => $request->pre_surgery_notes ?? '',
                    'anesthesia_used' => $request->anesthesia_used ?? '',
                    'procedure_notes' => $request->procedure_notes ?? '',
                    'recovery_notes' => $request->recovery_notes ?? '',
                    'post_surgery_care' => $request->post_surgery_care ?? '',
                    'follow_up_date' => $request->follow_up_date ?? $appointment->appointment_date,
                ]);
                break;
            
            case 'laboratory':
                LaboratoryTest::create([
                    'appointment_id' => $appointment->id,
                    'pet_id' => $appointment->pet_id,
                    'test_type' => $request->test_type ?? '',
                    'results' => $request->results ?? '',
                    'interpretation' => $request->interpretation ?? '',
                    'recommendations' => $request->recommendations ?? '',
                    'date_performed' => $appointment->appointment_date,
                    'follow_up_date' => $request->lab_follow_up_date ?? null,
                ]);
                break;
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

    public function deleteMultiple(Request $request)
    {
        try {
            $ids = $request->ids;
            
            DB::beginTransaction();
            
            Appointment::whereIn('id', $ids)->update([
                'deleted_by' => auth()->id()
            ]);
            
            Appointment::whereIn('id', $ids)->delete();
            
            DB::commit();
            
            return response()->json([
                'success' => true,
                'message' => 'Appointments deleted successfully'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Error deleting appointments: ' . $e->getMessage()
            ], 500);
        }
    }

    public function updateStatus(Request $request, Appointment $appointment)
    {
        try {
            $validatedData = $request->validate([
                'status' => 'required|in:confirmed,cancelled'
            ]);

            $updateData = [
                'status' => $validatedData['status']
            ];

            // Store confirmation details in the actions column as JSON
            if ($validatedData['status'] === 'confirmed') {
                $updateData['actions'] = json_encode([
                    'confirmed_by' => auth()->id(),
                    'confirmed_at' => now()->format('Y-m-d H:i:s'),
                    'confirmer_name' => auth()->user()->name
                ]);
            }

            $appointment->update($updateData);

            return response()->json([
                'success' => true,
                'message' => 'Appointment status updated successfully',
                'appointment' => $appointment->fresh()
            ]);
        } catch (\Exception $e) {
            \Log::error('Error updating appointment status', [
                'appointment_id' => $appointment->id,
                'error' => $e->getMessage()
            ]);
            return response()->json([
                'success' => false,
                'message' => 'Error updating appointment status: ' . $e->getMessage()
            ], 500);
        }
    }
}
