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

    Route::middleware(['auth', 'verified'])->group(function () {
        // Only keep this route for pets
        Route::get('/users/{user}/pets', function($user) {
            try {
                $pets = \App\Models\Pet::where('user_id', $user)
                    ->select('id', 'name', 'category', 'breed', 'age', 'weight', 'gender', 'photo')
                    ->get()
                    ->map(function($pet) {
                        return [
                            'id' => $pet->id,
                            'name' => $pet->name,
                            'category' => $pet->category,
                            'breed' => $pet->breed,
                            'age' => $pet->age,
                            'weight' => $pet->weight,
                            'gender' => $pet->gender,
                            'photo_url' => $pet->photo ? asset('storage/' . $pet->photo) : asset('storage/defaults/paw.png')
                        ];
                    });
                
                return response()->json(['pets' => $pets]);
            } catch (\Exception $e) {
                \Log::error('Error fetching pets', [
                    'user_id' => $user,
                    'error' => $e->getMessage()
                ]);
                return response()->json(['error' => 'Failed to load pets'], 500);
            }
        })->name('api.user.pets');
    });

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

    Route::get('/pets/{pet}', [App\Http\Controllers\Api\PetApiController::class, 'show']);

    Route::get('products/{product}/binary-image', [ProductImageController::class, 'getBinaryImage']);
