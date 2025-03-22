<?php

namespace App\Http\Controllers;

use App\Models\Finding;
use App\Models\Appointment;
use Illuminate\Http\Request;

class FindingsController extends Controller
{
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'appointment_id' => 'required|exists:appointment,id',
                'additional_notes' => 'nullable|string',
                'recommendations' => 'nullable|string',
                'diagnosis' => 'nullable|string',
                'treatment_plan' => 'nullable|string',
                'follow_up_date' => 'nullable|date'
            ]);

            // Get the appointment to retrieve the pet_id
            $appointment = Appointment::findOrFail($validated['appointment_id']);
            
            // Filter out null values from validated data
            $validated = array_filter($validated, function($value) {
                return $value !== null;
            });

            // Get the user ID from the session or request
            $userId = session('user_id') ?? $request->header('X-User-Id');
            
            if (!$userId) {
                throw new \Exception('User not authenticated');
            }

            // Add pet_id and created_by to validated data
            $validated['pet_id'] = $appointment->pet_id;
            $validated['created_by'] = $userId;
            $validated['status'] = 'pending';

            $finding = Finding::create($validated + [
                'findings_data' => json_encode($request->except([
                    '_token', 'appointment_id', 
                    'additional_notes', 'recommendations',
                    'diagnosis', 'treatment_plan', 'follow_up_date'
                ]))
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Findings saved successfully',
                'data' => $finding
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error saving findings: ' . $e->getMessage()
            ], 500);
        }
    }

    public function history($appointmentId)
    {
        try {
            $findings = Finding::where('appointment_id', $appointmentId)
                ->orderBy('created_at', 'desc')
                ->get();
            
            return response()->json($findings);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error fetching findings history: ' . $e->getMessage()
            ], 500);
        }
    }
} 