<?php

namespace App\Http\Controllers\PetOwner;

use App\Http\Controllers\Controller;
use App\Models\Pet;
use Illuminate\Http\Request;

class PetOwnerController extends Controller
{
    public function create()
    {
        // Return the view for creating a new pet
        return view('pet-owner.pets.create');
    }

    public function store(Request $request)
    {
        // Validate and store the pet
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'name' => 'required|string|max:255',
            'category' => 'required|string',
            'breed' => 'required|string|max:255',
            'gender' => 'required|in:Male,Female',
            'age' => 'required|numeric|min:0',
            'weight' => 'required|numeric|min:0',
            'allergies' => 'nullable|string',
            'notes' => 'nullable|string',
            'photo' => 'nullable|image|max:2048'
        ]);

        // Handle photo upload
        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('pet_photos', 'public');
            $validated['photo'] = $photoPath;
        }

        // Create the pet record
        Pet::create($validated);

        return redirect()->route('pet-owner.pets.index')->with('success', 'Pet registered successfully!');
    }

    // Other methods (index, edit, update, etc.) can be added here
} 