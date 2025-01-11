<?php

namespace App\Http\Controllers;

use App\Models\Pet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PetController extends Controller
{
    // Display a listing of the pets
    public function index()
    {
        $pets = Pet::all();
        return view('pet.index', compact('pets'));
    }

    // Show the form for creating a new pet
    public function create()
    {
        return view('pet.create');
    }

    // Store a newly created pet in storage
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|string|max:255',
            'breed' => 'nullable|string|max:255',
            'age' => 'nullable|integer|min:0',
            'owner_name' => 'required|string|max:255',
            'allergies' => 'nullable|string',
            'notes' => 'nullable|string',
            'category' => 'required|string|max:255',
            'photo' => 'nullable|image|max:2048', // Validate the photo upload
        ]);

        // Handle file upload
        $photoPath = null;
        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('pet_photos', 'public');
        }

        // Create the pet
        Pet::create(array_merge($request->all(), ['photo' => $photoPath]));

        return redirect()->route('pets.index')->with('success', 'Pet added successfully!');
    }

    // Show the form for editing the specified pet
    public function edit(Pet $pet)
    {
        return view('pet.edit', compact('pet'));
    }

    // Update the specified pet in storage
    public function update(Request $request, Pet $pet)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|string|max:255',
            'breed' => 'nullable|string|max:255',
            'age' => 'nullable|integer|min:0',
            'owner_name' => 'required|string|max:255',
            'allergies' => 'nullable|string',
            'notes' => 'nullable|string',
            'category' => 'required|string|max:255',
            'photo' => 'nullable|image|max:2048', // Validate the photo upload
        ]);

        // Handle file upload
        if ($request->hasFile('photo')) {
            if ($pet->photo) {
                Storage::disk('public')->delete($pet->photo); // Delete the old photo
            }
            $pet->photo = $request->file('photo')->store('pet_photos', 'public');
        }

        $pet->update($request->except('photo') + ['photo' => $pet->photo]);

        return redirect()->route('pets.index')->with('success', 'Pet updated successfully!');
    }

    // Remove the specified pet from storage
    public function destroy(Pet $pet)
    {
        if ($pet->photo) {
            Storage::disk('public')->delete($pet->photo); // Delete the photo
        }

        $pet->delete();

        return redirect()->route('pets.index')->with('success', 'Pet deleted successfully!');
    }
}
