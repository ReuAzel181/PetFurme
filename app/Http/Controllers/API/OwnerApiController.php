<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Pet;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class OwnerApiController extends Controller
{
    public function show(User $owner): JsonResponse
    {
        try {
            // If we have photo_data (binary data in DB), use that first
            // Otherwise, try to use the photo path
            return response()->json([
                'id' => $owner->id,
                'name' => $owner->name,
                'email' => $owner->email,
                'photo_data' => $owner->photo_data ? base64_encode($owner->photo_data) : null,
                // Only include avatar_url if photo_data is not available
                'avatar_url' => (!$owner->photo_data && $owner->photo) ? asset('storage/' . $owner->photo) : null,
            ]);
        } catch (\Exception $e) {
            Log::error('Error fetching owner data: ' . $e->getMessage());
            return response()->json(['error' => 'Failed to fetch owner data'], 500);
        }
    }

    public function pets(User $owner): JsonResponse
    {
        try {
            // Only get non-deleted pets
            $pets = $owner->pets()->whereNull('deleted_at')->get();
            
            if ($pets->isEmpty()) {
                return response()->json([]);
            }
            
            $petsData = $pets->map(function ($pet) {
                try {
                    return [
                        'id' => $pet->id,
                        'name' => $pet->name ?? 'Unknown',
                        'category' => $pet->category ?? 'Unknown',
                        'breed' => $pet->breed ?? '',
                        'age' => $pet->age ?? null,
                        'age_unit' => $pet->age_unit ?? 'years',
                        'weight' => $pet->weight ?? null,
                        'gender' => $pet->gender ?? '',
                        'photo_data' => $pet->photo_data ? base64_encode($pet->photo_data) : null,
                        'photo' => (!$pet->photo_data && $pet->photo && is_string($pet->photo)) ? $pet->photo : null
                    ];
                } catch (\Exception $e) {
                    Log::error('Error processing pet data: ' . $e->getMessage() . ' for pet ID: ' . $pet->id);
                    return null;
                }
            })->filter();
            
            return response()->json($petsData);
        } catch (\Exception $e) {
            Log::error('Error fetching pets: ' . $e->getMessage());
            return response()->json(['error' => 'Failed to fetch pets data: ' . $e->getMessage()], 500);
        }
    }
} 