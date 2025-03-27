<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Pet;
use App\Models\Appointment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PetController extends Controller
{
    public function __construct()
    {
        // Comment out or modify the middleware
        // $this->middleware('can:manage-pets');
        
        // Instead, use auth middleware if you just want to ensure users are logged in
        $this->middleware('auth');
    }

    // Display a listing of the pets
    public function index()
    {
        try {
            // Get filter type from request
            $filterType = request()->get('filter', 'all'); // Default to 'all'
            
            // Base query with common eager loading
            $query = Pet::with([
                'user:id,name,email',
                'creator:id,name',
                'verifier:id,name',
                'appointments' => function($query) {
                    $query->whereNull('deleted_at')
                        ->orderBy('appointment_date', 'desc');
                }
            ])->whereNull('deleted_at'); // Only get non-deleted pets

            // Apply filters
            switch ($filterType) {
                case 'staff':
                    $query->whereNotNull('created_by');
                    break;
                case 'owners':
                    $query->whereNull('created_by');
                    break;
                // 'all' doesn't need additional filters
            }

            // Get all pets
            $pets = $query->latest()
                ->get()
                ->map(function($pet) {
                    return [
                        'id' => $pet->id,
                        'name' => $pet->name,
                        'category' => $pet->category,
                        'type' => $pet->type,
                        'breed' => $pet->breed,
                        'gender' => $pet->gender,
                        'age' => $pet->age,
                        'weight' => $pet->weight ? number_format($pet->weight, 2) : null,
                        'allergies' => $pet->allergies,
                        'notes' => $pet->notes,
                        'owner' => $pet->user ? [
                            'id' => $pet->user->id,
                            'name' => $pet->user->name,
                            'email' => $pet->user->email
                        ] : [
                            'name' => $pet->owner_name ?? 'No Owner'
                        ],
                        'created_by' => $pet->creator ? [
                            'id' => $pet->creator->id,
                            'name' => $pet->creator->name
                        ] : null,
                        'verified_by' => $pet->verifier ? [
                            'id' => $pet->verifier->id,
                            'name' => $pet->verifier->name
                        ] : null,
                        'photo_url' => $this->getPhotoUrl($pet),
                        'created_at' => $pet->created_at?->format('Y-m-d H:i:s'),
                        'status' => $pet->verified_by ? 'Verified' : 'Pending',
                        'appointments_count' => $pet->appointments->count(),
                        'latest_appointment' => $pet->appointments->first()
                    ];
                });

            // Separate pets into pending and verified collections
            $pendingPets = $pets->where('status', 'Pending')->values();
            $verifiedPets = $pets->where('status', 'Verified')->values();

            \Log::info('Fetched pets data:', [
                'total_count' => $pets->count(),
                'pending_count' => $pendingPets->count(),
                'verified_count' => $verifiedPets->count(),
                'filter_type' => $filterType
            ]);

            return view('pet.index', compact('pendingPets', 'verifiedPets', 'filterType'));

        } catch (\Exception $e) {
            \Log::error('Error fetching pets:', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return view('pet.index')->with('error', 'Error loading pets data');
        }
    }

    // Helper method to get photo URL
    private function getPhotoUrl($pet)
    {
        if ($pet->photo_data) {
            return 'data:image/jpeg;base64,' . base64_encode($pet->photo_data);
        }
        
        if ($pet->photo) {
            if (filter_var($pet->photo, FILTER_VALIDATE_URL)) {
                return $pet->photo;
            }
            return Storage::disk('public')->exists($pet->photo) 
                ? asset('storage/' . $pet->photo)
                : asset('storage/defaults/paw.png');
        }
        
        return asset('storage/defaults/paw.png');
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
        try {
            // Fetch active users for the dropdown
            $users = User::select('id', 'name', 'email')
                ->whereNull('deleted_at')
                ->orderBy('name')
                ->get();
            
            // Initialize an empty Pet model
            $pet = new Pet();
            
            return view('pet.create', compact('users', 'pet'));

        } catch (\Exception $e) {
            \Log::error('Error in pet create form:', [
                'error' => $e->getMessage()
            ]);
            return redirect()->route('pets.index')->with('error', 'Error loading create form');
        }
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

    public function verify(Request $request, Pet $pet)
    {
        try {
            if ($request->status === 'approved') {
                $pet->update([
                    'verified_by' => auth()->id(),
                    'verified_at' => now()
                ]);

                \Log::info('Pet verified successfully', [
                    'pet_id' => $pet->id,
                    'verified_by' => auth()->id()
                ]);

                return response()->json([
                    'success' => true,
                    'message' => 'Pet verified successfully'
                ]);
            }
            
            return response()->json([
                'success' => false,
                'message' => 'Invalid verification status'
            ], 422);

        } catch (\Exception $e) {
            \Log::error('Pet verification failed', [
                'pet_id' => $pet->id,
                'error' => $e->getMessage()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Failed to verify pet'
            ], 500);
        }
    }

    public function getAppointments($id)
    {
        try {
            $appointments = Appointment::where('pet_id', $id)
                ->whereNull('deleted_at')
                ->orderBy('appointment_date', 'desc')
                ->get();
                
            return response()->json($appointments);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function show($id)
    {
        try {
            $pet = Pet::with(['user'])->findOrFail($id);
            
            $response = [
                'id' => $pet->id,
                'name' => $pet->name,
                'category' => $pet->category,
                'breed' => $pet->breed,
                'age' => $pet->age,
                'weight' => $pet->weight,
                'gender' => $pet->gender,
                'user_id' => $pet->user_id,
                'owner' => $pet->user ? [
                    'id' => $pet->user->id,
                    'name' => $pet->user->name
                ] : null
            ];

            // Handle photo URL
            if ($pet->photo_data) {
                try {
                    $base64Data = base64_encode($pet->photo_data);
                    if ($base64Data) {
                        $response['photo_url'] = 'data:image/jpeg;base64,' . $base64Data;
                    } else {
                        throw new \Exception('Failed to encode photo data');
                    }
                } catch (\Exception $e) {
                    \Log::warning('Failed to encode pet photo:', ['pet_id' => $id, 'error' => $e->getMessage()]);
                    $response['photo_url'] = asset('storage/defaults/paw.png');
                }
            } elseif ($pet->photo && Storage::disk('public')->exists($pet->photo)) {
                $response['photo_url'] = asset('storage/' . $pet->photo);
            } else {
                $response['photo_url'] = asset('storage/defaults/paw.png');
            }

            return response()->json($response);
        } catch (\Exception $e) {
            \Log::error('Error in PetController@show', [
                'pet_id' => $id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return response()->json(['error' => 'Failed to fetch pet data'], 500);
        }
    }
}
