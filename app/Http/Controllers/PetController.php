<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Pet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PetController extends Controller
{
    // Display a listing of the pets
    public function index()
    {
        // Fetch all pets with their associated users
        $pets = Pet::with(['appointments' => function($query) {
            $query->orderBy('appointment_date', 'desc');
        }, 'user'])->get();

            // Use the static methods for counts
        $totalPets = Pet::getTotalCount();
        $todayPets = Pet::getTodayCount();

        // Pass data to the view
        return view('pet.index', compact('pets', 'totalPets', 'todayPets'));
    }

    public function edit(Pet $pet)
    {
        // Fetch all users for the dropdown (if linking a user is required)
        $users = User::all();

        return view('pet.edit', compact('pet', 'users'));
    }


    // Show the form for creating a new pet
    public function create()
    {
        // Fetch all users for the dropdown
        $users = User::all();
        
        // Initialize an empty Pet model
        $pet = new Pet();
        
        // Use 'pet.create' instead of 'pets.create'
        return view('pet.create', compact('users', 'pet'));
    }
    // Store a newly created pet in storage
    public function store(Request $request)
    {
        try {
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

            // Create the pet record with explicit data
            $pet = Pet::create([
                'user_id' => $validated['user_id'],
                'name' => $validated['name'],
                'category' => $validated['category'],
                'breed' => $validated['breed'],
                'gender' => $validated['gender'],
                'age' => $validated['age'],
                'weight' => $validated['weight'],
                'allergies' => $validated['allergies'] ?? null,
                'notes' => $validated['notes'] ?? null,
                'photo' => $validated['photo'] ?? null,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Pet registered successfully',
                'redirect' => route('pets.index')
            ]);

        } catch (\Exception $e) {
            \Log::error('Pet creation error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error creating pet: ' . $e->getMessage()
            ], 500);
        }
    }

    public function update(Request $request, Pet $pet)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required|string',
            'user_id' => 'nullable|exists:users,id',
            'owner_name' => 'nullable|string|max:255',
            'breed' => 'nullable|string|max:255',
            'age' => 'nullable|numeric',
            'weight' => 'nullable|numeric',
            'allergies' => 'nullable|string',
            'notes' => 'nullable|string',
            'photo' => 'nullable|image|max:2048',
        ]);

        // Update the image handling
        if ($request->hasFile('photo')) {
            // Delete old photo if exists
            if ($pet->photo) {
                Storage::disk('public')->delete($pet->photo);
            }
            
            // Store new photo
            $data['photo'] = $request->file('photo')->store('pet_photos', 'public');
        }

        // Convert age to months if years is selected
        $age = $request->age;
        if ($request->age_unit === 'years' && $age) {
            $age = $age * 12; // Convert years to months
        }

        // Update the pet with corrected owner_name logic and type
        $updateData = [
            'name' => $request->name,
            'category' => $request->category,
            'breed' => $request->breed,
            'age' => $age,
            'weight' => $request->weight,
            'allergies' => $request->allergies,
            'notes' => $request->notes,
        ];

        // Handle user_id and owner_name separately
        if ($request->filled('user_id')) {
            $updateData['user_id'] = $request->user_id;
            $updateData['owner_name'] = null;  // Clear owner_name when user is selected
        } else {
            $updateData['user_id'] = null;
            $updateData['owner_name'] = $request->owner_name;  // Set owner_name when no user is selected
        }

        $pet->update($updateData);

        return redirect()->route('pets.index')->with('success', 'Pet updated successfully!');
    }

    // Remove the specified pet from storage
    public function destroy(Pet $pet)
    {
        if ($pet->photo) {
            Storage::disk('public')->delete($pet->photo);
        }

        $pet->deleted_by = auth()->id();
        $pet->save();
        
        $pet->delete();

        return redirect()->route('pets.index')->with('success', 'Pet deleted successfully!');
    }

    public function restore($id)
    {
        try {
            $pet = Pet::withTrashed()->findOrFail($id);
            $pet->restore();

            return response()->json([
                'success' => true,
                'message' => 'Pet restored successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to restore pet'
            ], 500);
        }
    }

    public function forceDelete($id)
    {
        try {
            $pet = Pet::withTrashed()->findOrFail($id);
            $pet->forceDelete();
            
            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }
}
