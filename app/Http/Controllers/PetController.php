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
        $pets = Pet::with('user')->get();

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
        // Fetch all users
        $users = User::all();
    
        // Pass the users to the view
        return view('pet.create', compact('users'));
    }
    // Store a newly created pet in storage
    public function store(Request $request)
    {
        $request->validate([
            'has_account' => 'required', // Whether the owner has an account
            'name' => 'required|string|max:255',
            'type' => 'required|string|max:255',
            'owner_name' => 'nullable|string|max:255',
            'category' => 'nullable|string|max:255',
            'gender' => 'nullable|string',
            'breed' => 'nullable|string|max:255',
            'age' => 'nullable|integer',
            'weight' => 'nullable|numeric',
            'allergies' => 'nullable|string',
            'notes' => 'nullable|string',
            'photo' => 'nullable|image|max:2048',
        ]);
    
        $user = null;
        $ownerName = null;
    
        if ($request->has_account === 'yes') {
            // Use an existing user
            $request->validate(['user_id' => 'required|exists:users,id']);
            $user = User::findOrFail($request->user_id);
        } else {
            // For unregistered owners
            $request->validate(['owner_name' => 'required|string|max:255']);
            $ownerName = $request->owner_name;
        }
    
        // Handle file upload
        $photoPath = null;
        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('pet_photos', 'public');
        }
    
        // Create the pet
        Pet::create([
            'user_id' => $user ? $user->id : null, // Set user_id to null if no user
            'owner_name' => $ownerName, // Set owner_name for unregistered owners
            'name' => $request->name,
            'type' => $request->type,
            'category' => $request->category,
            'gender' => $request->gender,
            'breed' => $request->breed,
            'age' => $request->age,
            'weight' => $request->weight,
            'allergies' => $request->allergies,
            'notes' => $request->notes,
            'photo' => $photoPath,
        ]);
    
        return redirect()->route('pets.index')->with('success', 'Pet added successfully!');
    }

    public function update(Request $request, Pet $pet)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|string|max:255',
            'user_id' => 'nullable|exists:users,id',
            'owner_name' => 'nullable|string|max:255',
            'breed' => 'nullable|string|max:255',
            'age' => 'nullable|integer',
            'weight' => 'nullable|numeric',
            'allergies' => 'nullable|string',
            'notes' => 'nullable|string',
            'photo' => 'nullable|image|max:2048',
        ]);

        // Handle photo upload
        if ($request->hasFile('photo')) {
            if ($pet->photo) {
                Storage::disk('public')->delete($pet->photo);
            }
            $pet->photo = $request->file('photo')->store('pet_photos', 'public');
        }

        // Update the pet
        $pet->update([
            'user_id' => $request->user_id, // Assign user if selected
            'owner_name' => $request->user_id ? null : $request->owner_name, // Clear owner_name if user_id is set
            'name' => $request->name,
            'type' => $request->type,
            'breed' => $request->breed,
            'age' => $request->age,
            'weight' => $request->weight,
            'allergies' => $request->allergies,
            'notes' => $request->notes,
        ]);

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
