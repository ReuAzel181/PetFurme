<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\JsonResponse;

class OwnerApiController extends Controller
{
    public function show(User $owner): JsonResponse
    {
        return response()->json([
            'id' => $owner->id,
            'name' => $owner->name,
            'email' => $owner->email,
            'avatar_url' => $owner->photo ? asset('storage/' . $owner->photo) : null,
        ]);
    }

    public function pets(User $owner): JsonResponse
    {
        $pets = $owner->pets()->get()->map(function ($pet) {
            return [
                'id' => $pet->id,
                'name' => $pet->name,
                'category' => $pet->category,
                'breed' => $pet->breed,
                'age' => $pet->age,
                'age_unit' => $pet->age_unit,
                'weight' => $pet->weight,
                'gender' => $pet->gender,
                'photo_url' => $pet->photo ? asset('storage/' . $pet->photo) : null,
            ];
        });

        return response()->json($pets);
    }
} 