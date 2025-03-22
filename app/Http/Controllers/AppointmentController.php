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
use Carbon\Carbon;
use App\Models\Order;
use App\Models\ApptVaccination;

class AppointmentController extends Controller
{
    public function index()
    {
        $today = Carbon::now()->startOfDay();
        
        // Only show current and future appointments
        $appointments = Appointment::with(['user', 'pet'])
            ->where('appointment_date', '>=', $today)
            ->orderBy('appointment_date', 'asc')
            ->orderBy('appointment_time', 'asc')
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

    public function archives()
    {
        $today = Carbon::now()->startOfDay();
        
        // Get archived appointments (both soft-deleted and past appointments)
        $archivedAppointments = Appointment::with(['user', 'pet'])
            ->where(function($query) use ($today) {
                $query->where('appointment_date', '<', $today)
                      ->orWhereNotNull('deleted_at');
            })
            ->withTrashed() // Include soft-deleted records
            ->orderBy('appointment_date', 'desc')
            ->orderBy('appointment_time', 'desc')
            ->get();

        // Get other archived items from the existing system
        $archivedUsers = User::onlyTrashed()
            ->with(['deletedBy'])
            ->latest('deleted_at')
            ->paginate(10, ['*'], 'users_page');

        $archivedPets = Pet::onlyTrashed()
            ->with(['user', 'deletedBy'])
            ->latest('deleted_at')
            ->paginate(10, ['*'], 'pets_page');

        $archivedOrders = Order::onlyTrashed()
            ->with(['user', 'deletedBy'])
            ->latest('deleted_at')
            ->paginate(10, ['*'], 'orders_page');

        // Calculate appointment statistics
        $totalAppointments = $archivedAppointments->count();
        $completedAppointments = $archivedAppointments->where('status', 'completed')->count();
        $cancelledAppointments = $archivedAppointments->where('status', 'cancelled')->count();

        return view('analytics.archives', compact(
            'archivedAppointments',
            'archivedUsers',
            'archivedPets',
            'archivedOrders',
            'totalAppointments',
            'completedAppointments',
            'cancelledAppointments'
        ));
    }

    public function create(Request $request)
    {
        $owners = User::where('role', 'pet_owner')->get();
        $pet = null;
        $owner = null;
        $ownerPets = collect();

        if ($request->pet_id) {
            $pet = Pet::with(['owner', 'vaccinations'])->findOrFail($request->pet_id);
            $owner = $pet->owner;
            $ownerPets = $owner->pets;
        } elseif ($request->owner_id) {
            $owner = User::with(['pets.vaccinations'])->findOrFail($request->owner_id);
            $ownerPets = $owner->pets;
            
            if ($request->pet_id) {
                $pet = $ownerPets->firstWhere('id', $request->pet_id);
            }
        }

        return view('appointment.create', compact('pet', 'owner', 'owners', 'ownerPets'));
    }

    public function store(Request $request)
    {
        \Log::info('Appointment request data', [
            'all_data' => $request->all(),
            'reason_for_visit' => $request->reason_for_visit,
            'vaccination_data' => [
                'vaccine_type' => $request->vaccine_type,
                'batch_number' => $request->batch_number,
                'next_due_date' => $request->next_due_date,
                'vaccine_array' => $request->vaccine
            ]
        ]);

        \Log::info('Walk-in data debug', [
            'is_walkin' => $request->owner_id === 'no_account',
            'owner_name' => $request->owner_name,
            'pet_name' => $request->walkin_pet_name,
            'pet_type' => $request->walkin_pet_type,
            'pet_age' => $request->walkin_pet_age,
            'age_unit' => $request->walkin_age_unit
        ]);

        try {
            DB::beginTransaction();

            // Base validation rules
            $rules = [
                'appointment_date' => 'required|date_format:Y-m-d',
                'appointment_time' => 'required',
                'reason_for_visit' => 'required',
                'owner_id' => 'required|string',
                'pet_id' => 'required_if:owner_id,!=,no_account|nullable|exists:pets,id,deleted_at,NULL',
                'owner_name' => 'required_if:owner_id,no_account|nullable|string',
                'pet_name' => 'required_if:owner_id,no_account|nullable|string',
                'pet_type' => 'required_if:owner_id,no_account|nullable|string',
                'pet_age' => 'required_if:owner_id,no_account|nullable|numeric',
                'age_unit' => 'required_if:owner_id,no_account|nullable|in:months,years'
            ];

            // Add vaccination-specific rules if needed
            if (is_array($request->reason_for_visit) && in_array('Vaccination', $request->reason_for_visit)) {
                // Validation for nested vaccination fields
                $rules['vaccine.0.type'] = 'required|string';
                $rules['vaccine.0.batch_number'] = 'required|string';
                $rules['vaccine.0.next_due_date'] = 'required|date';
                $rules['vaccine.0.administered_by'] = 'required|string';
            } elseif ($request->reason_for_visit === 'Vaccination') {
                // Handle single string reason for visit
                if (!empty($request->vaccine) && is_array($request->vaccine)) {
                    $rules['vaccine.0.type'] = 'required|string';
                    $rules['vaccine.0.batch_number'] = 'required|string';
                    $rules['vaccine.0.next_due_date'] = 'required|date';
                    $rules['vaccine.0.administered_by'] = 'required|string';
                }
            }

            $validated = $request->validate($rules);
            
            // Create the appointment
            $appointment = new Appointment();
            $appointment->appointment_date = $validated['appointment_date'];
            
            // Convert 12-hour time format to 24-hour for MySQL
            $time = $validated['appointment_time'];
            if (strpos($time, 'AM') !== false || strpos($time, 'PM') !== false) {
                // Parse the time string properly
                $timeObj = \DateTime::createFromFormat('h:i A', $time);
                if ($timeObj) {
                    $time = $timeObj->format('H:i:s');
                } else {
                    // Try alternative format
                    $timeObj = \DateTime::createFromFormat('g:i A', $time);
                    if ($timeObj) {
                        $time = $timeObj->format('H:i:s');
                    }
                }
            }
            $appointment->appointment_time = $time;
            
            // Handle the reason_for_visit field properly
            $reasonForVisit = $validated['reason_for_visit'];

            // Clean up the reason_for_visit to prevent double encoding
            if (is_array($reasonForVisit)) {
                // Flatten and clean the array
                $cleanReasons = [];
                foreach ($reasonForVisit as $reason) {
                    // If it's a JSON string, decode it
                    if (is_string($reason) && (strpos($reason, '[') === 0 || strpos($reason, '{') === 0)) {
                        try {
                            $decoded = json_decode($reason, true);
                            if (is_array($decoded)) {
                                // Flatten nested arrays
                                foreach ($decoded as $item) {
                                    $cleanReasons[] = $item;
                                }
                            } else {
                                $cleanReasons[] = $reason;
                            }
                        } catch (\Exception $e) {
                            $cleanReasons[] = $reason;
                        }
                    } else {
                        $cleanReasons[] = $reason;
                    }
                }
                $reasonForVisit = $cleanReasons;
            } else if (!is_array($reasonForVisit)) {
                // Convert single value to array
                $reasonForVisit = [$reasonForVisit];
            }

            // Store just a simple JSON array
            $appointment->reason_for_visit = json_encode($reasonForVisit);

            // Debug log to check the value
            \Log::info('Setting reason_for_visit', [
                'input' => $validated['reason_for_visit'],
                'cleaned' => $reasonForVisit,
                'encoded' => json_encode($reasonForVisit)
            ]);

            $appointment->notes = $request->notes ?? '';

            // Handle walk-in vs registered user
            if ($request->owner_id === 'no_account') {
                // Log walk-in data before processing
                \Log::info('Processing walk-in', [
                    'owner_name' => $request->owner_name,
                    'pet_name' => $request->pet_name,
                    'pet_type' => $request->pet_type,
                    'pet_age' => $request->pet_age,
                    'age_unit' => $request->age_unit
                ]);
                
                $appointment->owner_name = $request->owner_name;
                $appointment->pet_name = $request->pet_name;
                $appointment->pet_type = $request->pet_type;
                
                // Calculate age in years for display
                $age = $request->pet_age;
                if ($request->age_unit === 'months') {
                    $age = round($age / 12, 1);
                }
                $appointment->pet_age = $age;
                
                // Explicitly set these to null for walk-ins
                $appointment->user_id = null;
                $appointment->pet_id = null;
                
                \Log::info('Walk-in data saved to appointment', [
                    'appointment_id' => $appointment->id,
                    'owner_name' => $appointment->owner_name,
                    'pet_name' => $appointment->pet_name,
                    'pet_type' => $appointment->pet_type,
                    'pet_age' => $appointment->pet_age
                ]);
            } else {
                // Get pet details
                $pet = Pet::findOrFail($request->pet_id);
                $appointment->user_id = $request->owner_id;
                $appointment->pet_id = $request->pet_id;
                $appointment->pet_name = $pet->name;
                $appointment->pet_type = $pet->type;
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

            // Set scheduled_at (also needs time conversion)
            $scheduledTime = $validated['appointment_time'];
            if (strpos($scheduledTime, 'AM') !== false || strpos($scheduledTime, 'PM') !== false) {
                $scheduledTime = date('H:i:s', strtotime($scheduledTime));
            }
            $appointment->scheduled_at = $validated['appointment_date'] . ' ' . $scheduledTime;

            $appointment->save();

            // Process service-specific data here
            if ($appointment->id) {
                // Check the type before decoding to avoid errors
                $reasonsArray = $appointment->reason_for_visit;
                
                // If it's already a string (JSON format), decode it
                if (is_string($reasonsArray)) {
                    $reasonsArray = json_decode($reasonsArray);
                } 
                // If it's already an array but not an object from json_decode
                else if (is_array($reasonsArray) && !isset($reasonsArray[0]->type)) {
                    // No need to decode, but ensure it's in the right format
                    $reasonsArray = (array) $reasonsArray;
                }
                
                // Debug the reason array to see its actual structure
                \Log::info('Reason array structure:', [
                    'raw_reasons' => $appointment->reason_for_visit,
                    'decoded_reasons' => $reasonsArray
                ]);
                
                // Function to normalize reason values (handle double-nested values)
                $normalizeReason = function($reason) {
                    // If this is a JSON string, decode it
                    if (is_string($reason) && (strpos($reason, '[') === 0 || strpos($reason, '{') === 0)) {
                        try {
                            $decoded = json_decode($reason, true);
                            if (is_array($decoded) && count($decoded) === 1) {
                                return $decoded[0];
                            }
                        } catch (\Exception $e) {
                            // Ignore decode errors
                        }
                    }
                    return $reason;
                };
                
                // Process each reason for visit
                foreach($reasonsArray as $reason) {
                    // Normalize the reason value
                    $normalizedReason = $normalizeReason($reason);
                    
                    \Log::info('Processing reason:', [
                        'original' => $reason,
                        'normalized' => $normalizedReason
                    ]);
                    
                    switch($normalizedReason) {
                        case 'Vaccination':
                            if (!empty($request->vaccine) && is_array($request->vaccine)) {
                                foreach ($request->vaccine as $vaccineData) {
                                    $vaccination = new ApptVaccination([
                                        'appointment_id' => $appointment->id,
                                        'pet_id' => $appointment->pet_id,
                                        'type' => $vaccineData['type'],
                                        'batch_number' => $vaccineData['batch_number'],
                                        'date_given' => $appointment->appointment_date,
                                        'next_due_date' => $vaccineData['next_due_date'],
                                        'administered_by' => $vaccineData['administered_by']
                                    ]);
                                    
                                    \Log::info('Creating vaccination record', [
                                        'data' => $vaccination->toArray()
                                    ]);
                                    
                                    if (!$vaccination->save()) {
                                        throw new \Exception('Failed to save vaccination record');
                                    }
                                }
                            }
                            break;
                            
                        case 'Grooming':
                            if (!empty($request->grooming)) {
                                $grooming = new GroomingSession();
                                $grooming->appointment_id = $appointment->id;
                                $grooming->pet_id = $appointment->pet_id;
                                $grooming->date = $appointment->appointment_date;
                                $grooming->services_done = json_encode($request->grooming['services_done'] ?? []);
                                $grooming->products_used = !empty($request->grooming['products_used']) ? 
                                    json_encode($request->grooming['products_used']) : null;
                                $grooming->notes = $request->grooming['notes'] ?? null;
                                $grooming->save();
                            }
                            break;
                        
                        case 'Check-up':
                        case 'Consultation':
                            if (!empty($request->checkup)) {
                                $checkup = new Checkup();
                                $checkup->appointment_id = $appointment->id;
                                $checkup->pet_id = $appointment->pet_id;
                                $checkup->date = $appointment->appointment_date;
                                $checkup->findings = $request->checkup['findings'] ?? '';
                                $checkup->vital_signs = $request->checkup['vital_signs'] ?? '';
                                $checkup->treatment = $request->checkup['treatment'] ?? '';
                                $checkup->medications = $request->checkup['medications'] ?? '';
                                $checkup->next_visit = $request->checkup['next_visit'] ?? null;
                                $checkup->notes = $request->checkup['notes'] ?? '';
                                $checkup->save();
                            }
                            break;
                            
                        case 'Surgery':
                            if (!empty($request->surgery)) {
                                $surgery = new Surgery();
                                $surgery->appointment_id = $appointment->id;
                                $surgery->pet_id = $appointment->pet_id;
                                $surgery->date = $appointment->appointment_date;
                                $surgery->surgery_type = $request->surgery['surgery_type'] ?? '';
                                $surgery->pre_surgery_notes = $request->surgery['pre_surgery_notes'] ?? '';
                                $surgery->post_surgery_care = $request->surgery['post_surgery_care'] ?? '';
                                $surgery->save();
                            }
                            break;
                            
                        case 'Laboratory':
                            if (!empty($request->laboratory)) {
                                $lab = new LaboratoryTest();
                                $lab->appointment_id = $appointment->id;
                                $lab->pet_id = $appointment->pet_id;
                                $lab->date = $appointment->appointment_date;
                                $lab->test_type = $request->laboratory['test_type'] ?? '';
                                $lab->notes = $request->laboratory['notes'] ?? '';
                                $lab->save();
                            }
                            break;
                    }
                }
            }

            DB::commit();

            return redirect()->route('appointment.index')
                ->with('success', 'Appointment scheduled successfully!');

        } catch (\Exception $e) {
            DB::rollBack();
            
            \Log::error('Appointment creation failed', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'request_data' => $request->all()
            ]);
            
            // More helpful error message for debugging
            $message = config('app.debug') ? $e->getMessage() : 'Error creating appointment. Please check the form and try again.';
            
            return redirect()->back()
                ->withInput()
                ->with('error', $message);
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
                        'administered_by' => $request->administered_by ?? null,
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

    // Add method to automatically archive past appointments
    public function archivePastAppointments()
    {
        $today = Carbon::now()->startOfDay();
        
        // Find past appointments that aren't already archived
        $pastAppointments = Appointment::where('appointment_date', '<', $today)
            ->whereNull('deleted_at')
            ->get();

        foreach($pastAppointments as $appointment) {
            // Soft delete the appointment to mark it as archived
            $appointment->delete();
        }

        return redirect()->back()->with('success', 'Past appointments have been archived.');
    }

    public function getServiceRecords($type, Request $request)
    {
        try {
            $appointmentIds = explode(',', $request->get('appointments'));
            
            $records = DB::table($type)
                ->whereIn('appointment_id', $appointmentIds)
                ->orderBy('date_given', 'desc')
                ->get();
                
            return response()->json($records);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function getPetVaccinations(Pet $pet)
    {
        \Log::info('Fetching vaccinations for pet', [
            'pet_id' => $pet->id,
            'request_path' => request()->path(),
            'request_method' => request()->method(),
            'all_request_params' => request()->all()
        ]);
        
        try {
            // Use the relationship instead of raw query for better handling
            $vaccinations = $pet->vaccinations()
                ->orderBy('date_given', 'desc')
                ->get();
            
            \Log::info('Vaccination records found', [
                'count' => $vaccinations->count(),
                'data' => $vaccinations->toArray()
            ]);
            
            return response()->json($vaccinations);
        } catch (\Exception $e) {
            \Log::error('Error fetching vaccinations', [
                'pet_id' => $pet->id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
