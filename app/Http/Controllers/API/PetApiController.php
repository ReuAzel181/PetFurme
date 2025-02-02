<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Pet;
use Illuminate\Http\JsonResponse;

class PetApiController extends Controller
{
    public function show(Pet $pet): JsonResponse
    {
        return response()->json([
            'id' => $pet->id,
            'name' => $pet->name,
            'category' => $pet->category,
            'breed' => $pet->breed,
            'age' => $pet->age,
            'age_unit' => $pet->age_unit,
            'weight' => $pet->weight,
            'gender' => $pet->gender,
            'photo_url' => $pet->photo ? asset('storage/' . $pet->photo) : null,
        ]);
    }
} 