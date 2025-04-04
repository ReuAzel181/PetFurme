<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Pet;
use App\Models\Appointment;
use App\Models\Finding;
use Illuminate\Http\Request;

class PetApiController extends Controller
{
    public function show(Pet $pet)
    {
        try {
            // Use only the necessary attributes
            return response()->json([
                'id' => $pet->id,
                'name' => $pet->name,
                'category' => $pet->category,
                'breed' => $pet->breed,
                'age' => $pet->age,
                'weight' => $pet->weight,
                'gender' => $pet->gender,
                'user_id' => $pet->user_id,
                'photo_url' => $pet->photo_url // Using the accessor
            ]);
        } catch (\Exception $e) {
            \Log::error('Error in PetApiController@show', [
                'pet_id' => $pet->id,
                'error' => $e->getMessage()
            ]);
            return response()->json(['error' => 'Failed to fetch pet data'], 500);
        }
    }

    /**
     * Get pet's appointment and findings history
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function getHistory($id)
    {
        try {
            $pet = Pet::findOrFail($id);
            
            // Get completed appointments for this pet
            $appointments = Appointment::where('pet_id', $id)
                ->where('status', 'completed')
                ->orderBy('scheduled_at', 'desc')
                ->get();
            
            // Get findings for these appointments
            $appointmentIds = $appointments->pluck('id')->toArray();
            $findings = Finding::whereIn('appointment_id', $appointmentIds)->get();
            
            return response()->json([
                'success' => true,
                'pet' => $pet,
                'appointments' => $appointments,
                'findings' => $findings
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch pet history: ' . $e->getMessage()
            ], 500);
        }
    }
} 