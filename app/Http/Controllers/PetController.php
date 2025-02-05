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
                'type' => 'required|string|max:255',
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
            } else {
                $validated['photo'] = null;
            }

            // Create the pet record with explicit data
            $pet = Pet::create([
                'user_id' => $validated['user_id'],
                'name' => $validated['name'],
                'category' => $validated['category'],
                'type' => $validated['type'],
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
            ], 201);

        } catch (\Exception $e) {
            \Log::error('Pet creation error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error registering pet: ' . $e->getMessage()
            ], 422);
        }
    }

    public function update(Request $request, Pet $pet)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required|string',
            'type' => 'required|string|max:255',
            'user_id' => 'nullable|exists:users,id',
            'owner_name' => 'nullable|string|max:255',
            'breed' => 'nullable|string|max:255',
            'gender' => 'nullable|in:Male,Female',
            'age' => 'nullable|numeric',
            'weight' => 'nullable|numeric',
            'allergies' => 'nullable|string',
            'notes' => 'nullable|string',
            'photo' => 'nullable|image|max:2048',
        ]);

        // Update the pet with all fields
        $updateData = [
            'name' => $request->name,
            'category' => $request->category,
            'type' => $request->type,
            'breed' => $request->breed,
            'gender' => $request->gender,
            'age' => $request->age,
            'weight' => $request->weight,
            'allergies' => $request->allergies,
            'notes' => $request->notes,
        ];

        // Handle user_id and owner_name separately
        if ($request->filled('user_id')) {
            $updateData['user_id'] = $request->user_id;
            $updateData['owner_name'] = null;
        } else {
            $updateData['user_id'] = null;
            $updateData['owner_name'] = $request->owner_name;
        }

        // Handle photo update
        if ($request->hasFile('photo')) {
            if ($pet->photo) {
                Storage::disk('public')->delete($pet->photo);
            }
            $photoPath = $request->file('photo')->store('pet_photos', 'public');
            $updateData['photo'] = $photoPath;
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

    public function getMedicalHistory(Pet $pet)
    {
        // Fetch medical history records for the pet
        $medicalHistory = $pet->medicalRecords()
            ->select('date', 'service', 'diagnosis', 'treatment', 'notes')
            ->orderBy('date', 'desc')
            ->get();

        return response()->json($medicalHistory);
    }

    public function getPetsByUser($userId)
    {
        $pets = Pet::where('user_id', $userId)
            ->select(
                'id',
                'name',
                'category',
                'type',
                'breed',
                'gender',
                'age',
                'weight',
                'size'  // Include size if needed
            )
            ->get();

        \Log::info('Pets data:', ['pets' => $pets->toArray()]);
        
        return response()->json(['pets' => $pets]);
    }

    public function getPetsForOwner($userId)
    {
        $pets = Pet::where('user_id', $userId)
            ->select(
                'id',
                'name',
                'category',
                'type',
                'breed',
                'gender',
                'age',
                'weight',
                'size'
            )
            ->get()
            ->map(function ($pet) {
                // Ensure all values are properly formatted and not null
                return [
                    'id' => $pet->id,
                    'name' => $pet->name,
                    'category' => $pet->category,
                    'type' => $pet->type ?? $pet->category, // Fallback to category if type is null
                    'breed' => $pet->breed ?? '',
                    'gender' => $pet->gender ?? '',
                    'age' => $pet->age ?? '',
                    'weight' => $pet->weight ? number_format($pet->weight, 2) : '', // Format weight to 2 decimal places
                    'size' => $pet->size ?? ''
                ];
            });

        // Debug log to verify the data
        \Log::debug('Fetched pets data:', $pets->toArray());
        
        return response()->json(['pets' => $pets]);
    }

    // Add this test endpoint to check pet data
    public function testPetData($id)
    {
        $pet = Pet::find($id);
        return response()->json([
            'pet' => $pet,
            'debug' => [
                'breed' => $pet->breed,
                'weight' => $pet->weight,
                'gender' => $pet->gender
            ]
        ]);
    }
}
