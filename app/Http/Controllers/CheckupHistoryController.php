<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\CheckupHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CheckupHistoryController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'appointment_id' => 'required|exists:appointments,id',
            'pet_id' => 'required|exists:pets,id',
            'temperature' => 'nullable|numeric|between:35.0,43.0',
            'weight' => 'nullable|numeric|min:0.01',
            'heart_rate' => 'nullable|integer|min:1',
            'respiratory_rate' => 'nullable|integer|min:1',
            'existing_symptoms' => 'required|string',
            'examination_findings' => 'nullable|string',
            'results' => 'required|string',
            'current_medication' => 'nullable|string',
            'new_medication' => 'nullable|string',
            'treatment_notes' => 'nullable|string',
            'recommendations' => 'nullable|string',
            'followup_date' => 'nullable|date|after:today',
            'followup_type' => 'nullable|required_with:followup_date'
        ]);

        try {
            DB::beginTransaction();

            // Get the appointment to access owner info
            $appointment = Appointment::findOrFail($request->appointment_id);

            // Create the checkup history record
            $checkupHistory = CheckupHistory::create([
                'pet_id' => $validated['pet_id'],
                'category' => $appointment->reason_for_visit,
                'checkup_date' => now(),
                'temperature' => $validated['temperature'],
                'weight' => $validated['weight'],
                'heart_rate' => $validated['heart_rate'],
                'respiratory_rate' => $validated['respiratory_rate'],
                'existing_symptoms' => $validated['existing_symptoms'],
                'examination_findings' => $validated['examination_findings'],
                'results' => $validated['results'],
                'current_medication' => $validated['current_medication'],
                'new_medication' => $validated['new_medication'],
                'treatment_notes' => $validated['treatment_notes'],
                'recommendations' => $validated['recommendations'],
                'followup_date' => $validated['followup_date'],
                'followup_type' => $validated['followup_type'],
                'attending_vet_id' => auth()->id(),
                'status' => 'completed'
            ]);

            // Update the appointment status
            $appointment->update([
                'status' => 'completed',
                'completed_at' => now()
            ]);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Medical record saved successfully'
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Error saving medical record: ' . $e->getMessage()
            ], 422);
        }
    }

    public function sampleRecords()
    {
        // Sample data for demonstration
        $sampleRecords = [
            [
                'id' => 1,
                'pet_name' => 'Max',
                'owner_name' => 'John Doe',
                'checkup_date' => '2024-03-20',
                'vital_signs' => [
                    'temperature' => 38.5,
                    'weight' => 12.5,
                    'heart_rate' => 80,
                    'respiratory_rate' => 20
                ],
                'diagnosis' => [
                    'symptoms' => 'Lethargy, loss of appetite',
                    'findings' => 'Mild dehydration, elevated temperature',
                    'results' => 'Suspected viral infection',
                    'treatment' => 'Prescribed antibiotics and vitamins'
                ],
                'billing' => [
                    'services' => [
                        ['name' => 'Consultation', 'amount' => 500],
                        ['name' => 'Laboratory Test', 'amount' => 1200],
                    ],
                    'subtotal' => 1700,
                    'discount' => 100,
                    'total' => 1600,
                    'payment_status' => 'Paid',
                    'amount_paid' => 2000,
                    'change' => 400
                ],
                'status' => 'completed'
            ],
            // Add more sample records as needed
        ];

        return view('pages.medical-records', compact('sampleRecords'));
    }
} 