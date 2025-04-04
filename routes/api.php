    <?php

    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Route;
    use App\Http\Controllers\API\V1\ProductController;
    use App\Http\Controllers\ApiMessageController;
    use App\Http\Controllers\Auth\AuthenticatedSessionController;
    
    // Bwiset eto lang pala
    use App\Http\Controllers\MessageController;
    use App\Http\Controllers\Dashboards\DashboardController;
    use App\Http\Controllers\AppointmentController;
    use App\Http\Controllers\Api\OwnerApiController;
    use App\Http\Controllers\Api\PetApiController;
    use App\Http\Controllers\Api\ProductImageController;
    use App\Http\Controllers\PetController;
    use App\Models\User;

    // For the login and logout routes
    Route::post('/login', [AuthenticatedSessionController::class, 'store'])->name('api.login');
    Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('api.logout');

    // Public routes
    Route::post('login', [AuthenticatedSessionController::class, 'store']);


    // Route for sending a message
    Route::post('/send-message', [MessageController::class, 'sendMessage'])->name('api.send-message');
    
    // Protected routes
    Route::middleware('auth:sanctum')->group(function () {
        Route::get('messages', [ApiMessageController::class, 'index'])->name('api.messages.index');
        Route::post('messages', [ApiMessageController::class, 'store'])->name('api.messages.store');
    });

    Route::get('products/', [ProductController::class, 'index'])->name('api.product.index');

    Route::get('/users/{user}/pets', function (App\Models\User $user) {
        return $user->pets;
    })->name('api.user.pets');

    Route::get('/statistics', [DashboardController::class, 'getStatistics'])->name('api.statistics');

    Route::get('/appointments/dates', [AppointmentController::class, 'getDates']);

    Route::get('/check-cookie-consent', function () {
        return response()->json([
            'consent' => request()->cookie('cookie_consent', 'declined')
        ])->header('Cache-Control', 'no-store, no-cache, must-revalidate');
    })->middleware('web');

    Route::get('/pet/{pet}/checkup-history/{category}', [App\Http\Controllers\Api\PetCheckupController::class, 'getHistory']);

    Route::get('/pets/{pet}/medical-history', function ($pet) {
        // Return the medical history for the pet
        $history = \App\Models\MedicalRecord::where('pet_id', $pet)
            ->orderBy('checkup_date', 'desc')
            ->get()
            ->map(function ($record) {
                return [
                    'id' => $record->id,
                    'checkup_date' => $record->checkup_date,
                    'diagnosis' => $record->diagnosis,
                    'treatment' => $record->treatment,
                    'status' => $record->status,
                ];
            });

        return response()->json($history);
    });

    Route::get('/owners/{owner}', [App\Http\Controllers\Api\OwnerApiController::class, 'show']);
    Route::get('/owners/{owner}/pets', [App\Http\Controllers\Api\OwnerApiController::class, 'pets']);
    Route::get('/pets/{pet}', [PetApiController::class, 'show']);

    Route::get('products/{product}/binary-image', [ProductImageController::class, 'getBinaryImage']);

    // Pet routes
    Route::get('/pets/{id}/details', [PetController::class, 'show']);
    Route::get('/pets/{id}/appointments', [PetController::class, 'getAppointments']);
    Route::get('/appointments/services/{type}', [AppointmentController::class, 'getServiceRecords']);

    Route::post('/findings', [App\Http\Controllers\FindingsController::class, 'store'])
        ->name('findings.store');

    Route::get('/findings/{appointment}/history', [FindingsController::class, 'history'])
        ->name('findings.history');

    Route::get('/pets/{pet}/vaccinations', [AppointmentController::class, 'getPetVaccinations'])
        ->name('api.pet.vaccinations');

    // Add a simple direct route for easier debugging
    Route::get('/debug/pet/{pet_id}/vaccinations', function($pet_id) {
        \Log::info('Debug vaccination endpoint called for pet ID: ' . $pet_id);
        $vaccinations = \App\Models\ApptVaccination::where('pet_id', $pet_id)
            ->orderBy('date_given', 'desc')
            ->get();
        
        \Log::info('Found ' . $vaccinations->count() . ' vaccination records via direct query');
        return $vaccinations;
    });

    // Add this route for direct database debugging
    Route::get('/debug/raw-vaccinations/{pet_id}', function($pet_id) {
        // Log the request
        \Log::info('Raw vaccination query for pet ID: ' . $pet_id);
        
        // Execute a direct query to see what's in the database
        $results = \DB::select('SELECT * FROM appt_vaccinations WHERE pet_id = ?', [$pet_id]);
        
        // Log the results
        \Log::info('Raw query results: ' . count($results) . ' records found');
        
        return response()->json([
            'pet_id' => $pet_id,
            'count' => count($results),
            'records' => $results
        ]);
    });

    // Route for checking user role
    Route::post('/check-role', function (Request $request) {
        $email = $request->input('email');
        $user = User::where('email', $email)->first();
        
        if ($user) {
            return response()->json([
                'exists' => true,
                'role' => $user->role
            ]);
        }
        
        return response()->json([
            'exists' => false
        ]);
    });

    // Make sure the test route comes BEFORE the main route and has a different pattern
    Route::get('/pets/test-history/{id}', function ($id) {
        try {
            // Simple test with minimal dependencies
            $pet = \App\Models\Pet::find($id);
            
            if (!$pet) {
                return response()->json([
                    'success' => false,
                    'message' => 'Pet not found'
                ]);
            }
            
            return response()->json([
                'success' => true,
                'pet_id' => $pet->id,
                'pet_name' => $pet->name,
                'test' => 'If you can see this, JSON responses are working'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Test failed: ' . $e->getMessage()
            ]);
        }
    });

    // Then the main route
    Route::get('/pets/{id}/history', [App\Http\Controllers\PetController::class, 'getHistory']);

    // Update the simplified history endpoint
    Route::get('/pets/{id}/simple-history', function ($id) {
        try {
            // Get the pet
            $pet = \App\Models\Pet::find($id);
            if (!$pet) {
                return response()->json([
                    'success' => false,
                    'message' => 'Pet not found'
                ]);
            }
            
            // Get completed appointments with more fields
            $appointments = \App\Models\Appointment::where('pet_id', $id)
                ->where('status', 'completed')
                ->select('id', 'appointment_date', 'appointment_time', 'reason_for_visit', 'status', 'scheduled_at')
                ->orderBy('appointment_date', 'desc')
                ->get()
                ->map(function($appointment) {
                    // Format the date and time for easier use in JavaScript
                    return [
                        'id' => $appointment->id,
                        'appointment_date' => $appointment->appointment_date,
                        'appointment_time' => $appointment->appointment_time,
                        'reason_for_visit' => $appointment->reason_for_visit,
                        'status' => $appointment->status,
                        'formatted_date' => $appointment->appointment_date ? date('M j, Y', strtotime($appointment->appointment_date)) : null,
                        'formatted_time' => $appointment->appointment_time
                    ];
                });
            
            // Get findings (minimal fields)
            $appointmentIds = collect($appointments)->pluck('id')->toArray();
            $findings = \App\Models\Finding::whereIn('appointment_id', $appointmentIds)
                ->select('id', 'appointment_id', 'diagnosis', 'recommendations', 'treatment_plan')
                ->get();
            
            return response()->json([
                'success' => true,
                'pet' => [
                    'id' => $pet->id,
                    'name' => $pet->name
                ],
                'appointments' => $appointments,
                'findings' => $findings
            ])->header('Content-Type', 'application/json');
        } catch (\Exception $e) {
            \Log::error('Error in simple history endpoint', [
                'pet_id' => $id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ], 500)->header('Content-Type', 'application/json');
        }
    });
