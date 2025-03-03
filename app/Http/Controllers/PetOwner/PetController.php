<?php

namespace App\Http\Controllers\PetOwner;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pet;

class PetController extends Controller
{
    public function index()
    {
        $pets = auth()->user()->pets()->latest()->get();
        return view('pet-owner.pets.index', compact('pets'));
    }

    public function create()
    {
        return view('pet-owner.pets.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|string|max:255',
            'breed' => 'required|string|max:255',
            'age' => 'required|numeric|min:0',
            'gender' => 'required|in:male,female',
            'weight' => 'required|numeric|min:0',
            'photo' => 'nullable|image|max:2048',
        ]);

        $pet = auth()->user()->pets()->create($validated);

        if ($request->hasFile('photo')) {
            $path = $request->file('photo')->store('pet_photos', 'public');
            $pet->update(['photo' => $path]);
        }

        return redirect()->route('pet-owner.pets.index')
            ->with('success', 'Pet added successfully!');
    }

    public function edit(Pet $pet)
    {
        $this->authorize('update', $pet);
        return view('pet-owner.pets.edit', compact('pet'));
    }

    public function update(Request $request, Pet $pet)
    {
        $this->authorize('update', $pet);
        
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|string|max:255',
            'breed' => 'required|string|max:255',
            'age' => 'required|numeric|min:0',
            'gender' => 'required|in:male,female',
            'weight' => 'required|numeric|min:0',
            'photo' => 'nullable|image|max:2048',
        ]);

        $pet->update($validated);

        if ($request->hasFile('photo')) {
            $path = $request->file('photo')->store('pet_photos', 'public');
            $pet->update(['photo' => $path]);
        }

        return redirect()->route('pet-owner.pets.index')
            ->with('success', 'Pet updated successfully!');
    }

    public function destroy(Pet $pet)
    {
        $this->authorize('delete', $pet);
        $pet->delete();
        
        return redirect()->route('pet-owner.pets.index')
            ->with('success', 'Pet deleted successfully!');
    }
} 