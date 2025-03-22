<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Pet;

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
} 