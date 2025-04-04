<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Pet;
use App\Models\Appointment;
use App\Models\Finding;
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
                'photo' => 'nullable|image|max:2048',
                'photo_data' => 'nullable|string',
            ]);

            // Debug the incoming photo_data
            \Log::info('Photo data received:', [
                'has_photo_data' => $request->has('photo_data'),
                'photo_data_length' => $request->filled('photo_data') ? strlen($request->photo_data) : 0,
                'photo_data_sample' => $request->filled('photo_data') ? substr($request->photo_data, 0, 30) . '...' : 'none'
            ]);

            // Handle photo data
            if ($request->filled('photo_data')) {
                // Store the binary data directly in the database
                $binaryData = base64_decode($request->photo_data);
                
                // Verify the binary data was decoded properly
                if ($binaryData === false) {
                    \Log::error('Failed to decode base64 data');
                    throw new \Exception('Invalid image data provided');
                }
                
                \Log::info('Decoded binary data:', [
                    'length' => strlen($binaryData),
                    'is_binary' => !ctype_print($binaryData)
                ]);
                
                // Store the binary data directly
                $validated['photo_data'] = $binaryData;
                $validated['photo'] = null; // Clear the file path since we're using binary data
            } 
            // Fallback to file upload if no base64 data
            elseif ($request->hasFile('photo')) {
                $photoPath = $request->file('photo')->store('pet_photos', 'public');
                $validated['photo'] = $photoPath;
                $validated['photo_data'] = null;
            } else {
                $validated['photo'] = null;
                $validated['photo_data'] = null;
            }

            // Create the pet record with explicit data
            $pet = new Pet();
            $pet->user_id = $validated['user_id'];
            $pet->name = $validated['name'];
            $pet->category = $validated['category'];
            $pet->type = $validated['type'];
            $pet->breed = $validated['breed'];
            $pet->gender = $validated['gender'];
            $pet->age = $validated['age'];
            $pet->weight = $validated['weight'];
            $pet->allergies = $validated['allergies'] ?? null;
            $pet->notes = $validated['notes'] ?? null;
            $pet->photo = $validated['photo'];
            $pet->photo_data = $validated['photo_data'];
            
            $pet->save();
            
            // Log the saved pet data
            \Log::info('Pet saved:', [
                'pet_id' => $pet->id,
                'has_photo' => !empty($pet->photo),
                'has_photo_data' => !empty($pet->photo_data),
                'photo_data_type' => !empty($pet->photo_data) ? gettype($pet->photo_data) : 'null'
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Pet registered successfully',
                'redirect' => route('pets.index')
            ]);

        } catch (\Exception $e) {
            \Log::error('Error creating pet:', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return response()->json([
                'success' => false,
                'message' => 'Failed to register pet: ' . $e->getMessage()
            ], 500);
        }
    }

    public function update(Request $request, Pet $pet)
    {
        try {
            $request->validate([
                'name' => 'required|string|max:255',
                'category' => 'required|string',
                'type' => 'nullable|string|max:255',
                'user_id' => 'nullable|exists:users,id',
                'owner_name' => 'nullable|string|max:255',
                'breed' => 'nullable|string|max:255',
                'gender' => 'nullable|in:Male,Female',
                'age' => 'nullable|numeric',
                'weight' => 'nullable|numeric',
                'allergies' => 'nullable|string',
                'notes' => 'nullable|string',
                'photo' => 'nullable|image|max:2048',
                'photo_data' => 'nullable|string',
            ]);

            // Photo handling
            if ($request->filled('photo_data')) {
                // New photo uploaded (binary data)
                $binaryData = base64_decode($request->photo_data);
                $pet->photo_data = $binaryData;
                $pet->photo = null; // Clear file path
            } 
            elseif ($request->hasFile('photo')) {
                // File upload method
                $photoPath = $request->file('photo')->store('pet_photos', 'public');
                $pet->photo = $photoPath;
                $pet->photo_data = null;
            }
            elseif ($request->input('removePhoto') == '1') {
                // Photo removed
                $pet->photo = null;
                $pet->photo_data = null;
            }
            // else - No changes to photo, keep existing data
            
            // Update other fields
            $pet->name = $request->name;
            $pet->category = $request->category;
            $pet->type = $request->type ?? null;
            $pet->breed = $request->breed;
            $pet->gender = $request->gender;
            $pet->age = $request->age;
            $pet->weight = $request->weight;
            $pet->allergies = $request->allergies;
            $pet->notes = $request->notes;

            if ($request->filled('user_id')) {
                $pet->user_id = $request->user_id;
                $pet->owner_name = null;
            } else {
                $pet->user_id = null;
                $pet->owner_name = $request->owner_name;
            }

            $pet->save();
            
            return response()->json([
                'success' => true,
                'message' => 'Pet updated successfully',
                'redirect' => route('pets.index')
            ]);
        } catch (\Exception $e) {
            \Log::error('Failed to update pet', [
                'pet_id' => $pet->id,
                'error' => $e->getMessage()
            ]);
            
            return response()->json([
                'success' => false,
                'message' => 'Failed to update pet: ' . $e->getMessage()
            ], 500);
        }
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
                        // Add this for direct access to binary data
                        $response['photo_data'] = $base64Data;
                        
                        \Log::info('Pet photo data found and encoded', [
                            'pet_id' => $pet->id,
                            'data_length' => strlen($base64Data)
                        ]);
                    } else {
                        throw new \Exception('Failed to encode photo data');
                    }
                } catch (\Exception $e) {
                    \Log::warning('Failed to encode pet photo:', ['pet_id' => $id, 'error' => $e->getMessage()]);
                    $response['photo_url'] = asset('storage/defaults/paw.png');
                }
            } elseif ($pet->photo && Storage::disk('public')->exists($pet->photo)) {
                $response['photo_url'] = asset('storage/' . $pet->photo);
                \Log::info('Using file path for pet photo', ['pet_id' => $pet->id, 'path' => $pet->photo]);
            } else {
                $response['photo_url'] = asset('storage/defaults/paw.png');
                \Log::info('No photo found for pet, using default', ['pet_id' => $pet->id]);
            }

            \Log::info('Pet data response', ['pet_id' => $pet->id, 'has_photo_url' => isset($response['photo_url']), 'has_photo_data' => isset($response['photo_data'])]);
            
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

    /**
     * Get pet's appointment and findings history
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function getHistory($id)
    {
        try {
            \Log::info('Pet history API called for pet ID: ' . $id);
            
            $pet = Pet::findOrFail($id);
            \Log::info('Pet found', ['pet_id' => $pet->id, 'name' => $pet->name]);
            
            // Get completed appointments for this pet
            $appointments = Appointment::where('pet_id', $id)
                ->where('status', 'completed')
                ->orderBy('scheduled_at', 'desc')
                ->get();
            \Log::info('Found appointments', ['count' => $appointments->count()]);
            
            // Get findings for these appointments
            $appointmentIds = $appointments->pluck('id')->toArray();
            $findings = Finding::whereIn('appointment_id', $appointmentIds)->get();
            \Log::info('Found findings', ['count' => $findings->count()]);
            
            // Handle potential circular references in serialization
            $petData = $pet->toArray();
            $appointmentsData = $appointments->toArray();
            $findingsData = $findings->toArray();
            
            // Return a clean JSON response
            return response()->json([
                'success' => true,
                'pet' => $petData,
                'appointments' => $appointmentsData,
                'findings' => $findingsData
            ])->header('Content-Type', 'application/json');
        } catch (\Exception $e) {
            \Log::error('Failed to fetch pet history', [
                'pet_id' => $id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch pet history: ' . $e->getMessage()
            ], 500)->header('Content-Type', 'application/json');
        }
    }
}
