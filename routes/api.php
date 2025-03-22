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
