<?php

use App\Models\User;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CustomerController;

use App\Http\Controllers\NotificationController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\PetController;
use App\Http\Controllers\SalesController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\PagesController;

use App\Http\Controllers\Dashboards\DashboardController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\Order\DueOrderController;
use App\Http\Controllers\Order\OrderCompleteController;
use App\Http\Controllers\Order\OrderPendingController;
use App\Http\Controllers\PosController;
use App\Http\Controllers\Product\ProductController;
use App\Http\Controllers\Product\ProductExportController;
use App\Http\Controllers\Product\ProductImportController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Purchase\PurchaseController;
use App\Http\Controllers\Quotation\QuotationController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\UnitController;

use App\Http\Controllers\UserController; // <------ Include the UserController
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\MessageController;
use App\Services\MessageService;

use Supabase\CreateClient;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\Auth\PasswordResetController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\ArchivesController;

use App\Http\Controllers\PetOwner;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\UserManagementController;

use App\Http\Controllers\NotificationsController;
use App\Http\Controllers\PetOwner\PetOwnerProductController;
use App\Http\Controllers\PetOwner\DashboardController as PetOwnerDashboardController;

use App\Http\Controllers\CheckupHistoryController;
use App\Http\Controllers\BackupController;

Route::get('/messages', [MessageController::class, 'index'])->name('messages.index');
Route::get('/messages/chat/{id}', [MessageController::class, 'chat'])->name('messages.chat');
Route::get('/messages/users', [MessageController::class, 'showUsers'])->name('messages.users');
Route::post('/messages/send/{id}', [MessageController::class, 'sendMessage'])->name('messages.send');

Route::get('/messages', [MessageController::class, 'index'])->name('messages.index');
Route::resource('messages', MessageController::class);



Route::get('/test-supabase', function () {
    // Create a new Supabase client
    $supabase = new CreateClient(
        config('supabase.url'),  // Supabase URL from config
        config('supabase.key')   // Supabase API key from config
    );

    // Attempt to fetch data from a specific table
    $response = $supabase->from('your_table_name')->select('*')->execute();

    // Check for errors and return the response
    if ($response->error) {
        return response()->json(['error' => $response->error->message], 500);
    }

    return response()->json($response->data);
});


Route::get('/test-supabase', function (MessageService $messageService) {
    $conversations = $messageService->getConversations();
    return response()->json($conversations);
});

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route Notification <------
    Route::middleware(['auth', 'verified'])->group(function () {
        Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
        Route::post('/notifications/mark-all-read', [NotificationController::class, 'markAllRead'])
            ->name('notifications.markAllRead');
});


// Fetch Pet
// Route::get('/api/users/{id}/pets', function ($id) {
//     $pets = App\Models\Pet::where('user_id', $id)->get();
//     return response()->json($pets);
// });


Route::middleware(['auth', 'verified'])->group(function () {
    // ... other routes ...
    
    // Pets API route
    Route::get('/api/users/{user}/pets', function($user) {
        try {
            \Log::info('Fetching pets for user', ['user_id' => $user]);
            
            // First get the user details
            $userData = \App\Models\User::find($user);
            
            // Then get the pets with category
            $pets = \App\Models\Pet::where('user_id', $user)
                ->select('id', 'name', 'category', 'age')
                ->get();
            
            \Log::info('Found pets', ['count' => $pets->count(), 'pets' => $pets->toArray()]);
            
            return response()->json([
                'user' => [
                    'name' => $userData ? $userData->name : 'No Account',
                    'has_account' => !is_null($userData)
                ],
                'pets' => $pets
            ]);
        } catch (\Exception $e) {
            \Log::error('Error fetching pets', [
                'user_id' => $user,
                'error' => $e->getMessage()
            ]);
            return response()->json([
                'error' => $e->getMessage()
            ], 500);
        }
    })->name('api.user.pets');
});


 // Route Appointment <------
 Route::get('/appointment', [AppointmentController::class, 'index'])->name('appointment.index');
 Route::get('/appointment/create', [AppointmentController::class, 'create'])->name('appointment.create');
 Route::post('/appointment', [AppointmentController::class, 'store'])->name('appointment.store');
 Route::get('/appointment/{id}/edit', [AppointmentController::class, 'edit'])->name('appointment.edit');
 Route::put('/appointment/{id}', [AppointmentController::class, 'update'])->name('appointment.update');
 Route::delete('/appointment/{appointment}', [AppointmentController::class, 'destroy'])->name('appointment.destroy');

// Route Pet and Sales
Route::middleware(['auth', 'verified'])->group(function () {
    Route::resource('pets', PetController::class);
    Route::get('/pet', [PetController::class, 'index'])->name('pet.index');
    Route::get('/sales', [PetController::class, 'index'])->name('sales.index');
});


Route::get('/', function () {
    // If already authenticated, redirect based on role
    if (auth()->check()) {
        if (auth()->user()->role === 'pet_owner') {
            return redirect()->route('pet-owner.dashboard');
        }
        return redirect()->route('dashboard');
    }
    
    // Show login page for unauthenticated users
    return view('auth.login');
})->name('home');

// Keep the localhost development route
Route::get('php/', function () {
    if (request()->getHost() === 'localhost' || request()->getHost() === '127.0.0.1') {
        return phpinfo();
    }
    return redirect('/');
});

// Apply cache.response middleware to specific asset routes
Route::middleware('cache.response')->group(function () {
    // Static assets
    Route::get('/dist/css/{file}', function($file) {
        return response()->file(public_path("dist/css/{$file}"));
    })->name('css.file');

    Route::get('/dist/js/{file}', function($file) {
        return response()->file(public_path("dist/js/{$file}"));
    })->name('js.file');

    Route::get('/assets/img2/{file}', function($file) {
        return response()->file(public_path("assets/img2/{$file}"));
    })->name('image.file');
});

// Existing User Management Routes
Route::prefix('user-management')->middleware(['auth', 'verified'])->group(function () {
    Route::get('/', [UserController::class, 'index'])->name('user-management.index'); // All users
    Route::get('/create', [UserController::class, 'create'])->name('user-management.create'); // Add User
    Route::get('/{id}/edit', [UserController::class, 'edit'])->name('user-management.edit'); // Edit User
    Route::delete('/{id}', [UserController::class, 'destroy'])->name('user-management.destroy'); // Delete User
    Route::put('/{id}', [UserController::class, 'update'])->name('users.update'); // Update User
    Route::post('/', [UserController::class, 'store'])->name('users.store'); // Store User
    Route::get('/pet-owner', [UserController::class, 'petOwner'])->name('user-management.pet-owner'); // Pet Owners
    Route::get('/sub-admin', [UserController::class, 'subAdmin'])->name('user-management.sub-admin'); // Sub Admins
    Route::get('/admin', [UserController::class, 'admin'])->name('user-management.admin'); // Admins
});


// New Dynamic Role View Route
Route::get('user-management/{role}', function ($role) {
    $allowedRoles = ['pet_owner', 'sub_admin', 'admin'];
    if (!in_array($role, $allowedRoles)) {
        abort(404); // Abort if role is invalid
    }

    $users = \App\Models\User::where('role', $role)->get(); // Fetch users by role
    return view("users.$role", compact('users')); // Return the correct view
})->name('user-management.role');

Route::middleware(['auth', 'verified'])->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Route::resource('/users', UserController::class); //->except(['show']);
    Route::put('/user/change-password/{username}', [UserController::class, 'updatePassword'])->name('users.updatePassword');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::get('/profile/settings', [ProfileController::class, 'settings'])->name('profile.settings');
    Route::get('/profile/store-settings', [ProfileController::class, 'store_settings'])->name('profile.store.settings');
    Route::post('/profile/store-settings', [ProfileController::class, 'store_settings_store'])->name('profile.store.settings.store');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::resource('/suppliers', SupplierController::class);
    Route::resource('/categories', CategoryController::class);
    Route::resource('/units', UnitController::class);

    // Route Products
    Route::get('products/import/', [ProductImportController::class, 'create'])->name('products.import.view');
    Route::post('products/import/', [ProductImportController::class, 'store'])->name('products.import.store');
    Route::get('products/export/', [ProductExportController::class, 'create'])->name('products.export.store');
    Route::resource('products', ProductController::class);



    // Route POS
    Route::get('/pos', [PosController::class, 'index'])->name('pos.index');
    Route::post('/pos/add-to-cart/{product}', [PosController::class, 'addCartItem'])->name('pos.addCartItem');
    Route::post('/pos/cart/update/{rowId}', [PosController::class, 'updateCartItem'])->name('pos.updateCartItem');
    Route::delete('/pos/cart/delete/{rowId}', [PosController::class, 'deleteCartItem'])->name('pos.deleteCartItem');

    //Route::post('/pos/invoice', [PosController::class, 'createInvoice'])->name('pos.createInvoice');
    Route::delete('/cart/{rowId}', [CartController::class, 'destroy'])->name('cart.destroy');
    Route::post('/cart/add/{product}', [CartController::class, 'add'])->name('cart.add');
    Route::post('/cart/update/{rowId}', [CartController::class, 'update'])->name('cart.update');
    Route::get('/cart/totals', [CartController::class, 'getCartTotals'])->name('cart.totals');

    // Orders routes - make sure archived route is before resource route
    // Route::get('/orders/archived', [OrderController::class, 'archived'])->name('orders.archived');
    Route::delete('/orders/{order}', [OrderController::class, 'destroy'])
        ->name('orders.destroy')
        ->whereUuid('order');
    Route::resource('orders', OrderController::class)->except(['destroy']);

    // Add these routes for appointments
    Route::resource('appointment', AppointmentController::class);
    
    // Single API route for fetching pets
    Route::get('/api/users/{user}/pets', function($user) {
        try {
            \Log::info('Fetching pets for user', ['user_id' => $user]);
            
            // First get the user details
            $userData = \App\Models\User::find($user);
            
            // Then get the pets with category
            $pets = \App\Models\Pet::where('user_id', $user)
                ->select('id', 'name', 'category', 'age')
                ->get();
            
            \Log::info('Found pets', ['count' => $pets->count(), 'pets' => $pets->toArray()]);
            
            return response()->json([
                'user' => [
                    'name' => $userData ? $userData->name : 'No Account',
                    'has_account' => !is_null($userData)
                ],
                'pets' => $pets
            ]);
        } catch (\Exception $e) {
            \Log::error('Error fetching pets', [
                'user_id' => $user,
                'error' => $e->getMessage()
            ]);
            return response()->json([
                'error' => $e->getMessage()
            ], 500);
        }
    })->name('api.user.pets');

    Route::get('/sales', [SalesController::class, 'index'])->name('sales.index');

});

require __DIR__.'/auth.php';

Route::get('test/', function (){
    return view('test');
});

Route::resource('users', UserController::class);

// Or if you prefer to define them individually:
Route::group(['prefix' => 'users', 'as' => 'users.'], function () {
    Route::get('/', [UserController::class, 'index'])->name('index');
    Route::get('/create', [UserController::class, 'create'])->name('create');
    Route::post('/', [UserController::class, 'store'])->name('store');
    Route::get('/{user}/edit', [UserController::class, 'edit'])->name('edit');
    Route::put('/{user}', [UserController::class, 'update'])->name('update');
    Route::delete('/{user}', [UserController::class, 'destroy'])->name('destroy');
});

// Add this with your other routes
Route::get('/search', [SearchController::class, 'search'])->name('search');
Route::get('/search/suggestions', [SearchController::class, 'suggestions'])->name('search.suggestions');

// Add this temporarily for debugging
Route::get('orders/debug/{id}', function($id) {
    $order = \App\Models\Order::find($id);
    dd([
        'id' => $id,
        'order_exists' => $order ? true : false,
        'order' => $order
    ]);
});

// Update this route to use the controller method directly
Route::post('/orders/store', [OrderController::class, 'store'])->name('orders.store');

Route::patch('/orders/{order:uuid}/mark-as-paid', [App\Http\Controllers\OrderController::class, 'markAsPaid'])
    ->name('orders.mark-as-paid');

Route::get('/sales/export', [SalesController::class, 'export'])->name('sales.export');

Route::get('/orders/{uuid}/revert-status', [OrderController::class, 'revertStatus'])
    ->name('orders.revert-status');

Route::get('/pages', function () {
    return view('pages.index');
})->name('pages.index');

// Settings Routes
Route::prefix('settings')->name('settings.')->group(function () {
    Route::get('/', function () {
        return view('settings.index');
    })->name('index');
    
    Route::get('/store', function () {
        return view('settings.store');
    })->name('store');
    
    Route::get('/invoice', function () {
        return view('settings.invoice');
    })->name('invoice');
    
    Route::get('/notifications', function () {
        return view('settings.notifications');
    })->name('notifications');
    
    Route::get('/backup', function () {
        return view('settings.backup');
    })->name('backup');
});

Route::get('/appointments/archived', [AppointmentController::class, 'archived'])->name('appointment.archived');
Route::patch('/appointments/{appointment}/restore', [AppointmentController::class, 'restore'])->name('appointment.restore');
Route::patch('/appointments/{appointment}/complete', [AppointmentController::class, 'markAsCompleted'])->name('appointment.complete');
Route::get('/appointments/completed', [AppointmentController::class, 'completed'])->name('appointment.completed');

Route::patch('/orders/{order}/complete', [OrderController::class, 'markAsCompleted'])
    ->name('orders.complete');

Route::patch('/orders/{order}/cancel', [OrderController::class, 'cancel'])->name('orders.cancel');

// Add this route inside your authenticated routes group
Route::get('/orders/{order:uuid}/print-invoice', [OrderController::class, 'printInvoice'])
    ->name('orders.print-invoice');

Route::get('/orders/deleted', [OrderController::class, 'deleted'])->name('orders.deleted');

Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/sales', [SalesController::class, 'index'])->name('sales.index');
    Route::get('/analytics/archives', [ArchivesController::class, 'index'])->name('analytics.archives');
    Route::get('/pages', [PagesController::class, 'index'])->name('pages.index');
    Route::get('/settings', [SettingsController::class, 'index'])->name('settings.index');
    
    // Add other settings routes if needed
    Route::prefix('settings')->name('settings.')->group(function () {
        Route::get('/store', [SettingsController::class, 'store'])->name('store');
        Route::get('/invoice', [SettingsController::class, 'invoice'])->name('invoice');
        Route::get('/notifications', [SettingsController::class, 'notifications'])->name('notifications');
        Route::get('/backup', [SettingsController::class, 'backup'])->name('backup');
    });
});

Route::post('/pets/{pet}/restore', [PetController::class, 'restore'])->name('pets.restore');
Route::delete('/pets/{id}/force-delete', [PetController::class, 'forceDelete'])->name('pets.forceDelete');

Route::get('/storage-test', function() {
    $path = 'test.txt';
    Storage::disk('public')->put($path, 'test');
    
    return [
        'file_exists' => Storage::disk('public')->exists($path),
        'storage_path' => Storage::disk('public')->path($path),
        'public_url' => Storage::url($path),
        'storage_link_exists' => file_exists(public_path('storage')),
    ];
});

Route::post('/orders/{id}/restore', [OrderController::class, 'restore'])
    ->name('orders.restore');

Route::post('/appointments/{appointment}/restore', [AppointmentController::class, 'restore'])
    ->name('appointment.restore');

// Add these routes
Route::get('/appointments/{id}/restore', [ArchivesController::class, 'restoreAppointment'])->name('appointments.restore');
Route::get('/appointments/{id}/view', [ArchivesController::class, 'viewAppointment'])->name('appointments.view');

// Appointment routes
Route::resource('appointments', AppointmentController::class);
Route::get('/appointments/create', [AppointmentController::class, 'create'])
    ->name('appointments.create');

// Add these routes if they don't exist
Route::get('/analytics/archives', [ArchivesController::class, 'index'])->name('analytics.archives');
Route::get('/appointments/{id}/restore', [ArchivesController::class, 'restoreAppointment'])->name('appointments.restore');
Route::get('/appointments/{id}/view', [ArchivesController::class, 'viewAppointment'])->name('appointments.view');

Route::post('/users/{user}/restore', [UserController::class, 'restore'])
    ->name('users.restore')
    ->withTrashed();

// Authentication routes
Route::middleware('guest')->group(function () {
    Route::get('login', [AuthenticatedSessionController::class, 'create'])->name('login');
    Route::post('login', [AuthenticatedSessionController::class, 'store']);
    Route::get('register', [RegisteredUserController::class, 'create'])->name('register');
    Route::post('register', [RegisteredUserController::class, 'store']);
    Route::post('register/send-otp', [RegisterController::class, 'sendOTP'])
        ->name('register.send-otp');
});

Route::middleware(['auth', 'role:pet_owner'])->group(function () {
    Route::get('/pet-owner/dashboard', [App\Http\Controllers\PetOwner\DashboardController::class, 'index'])
        ->name('pet-owner.dashboard.home');
});

// Pet owner routes
Route::middleware(['auth', 'verified', 'role:pet_owner'])->prefix('pet-owner')->name('pet-owner.')->group(function () {
    Route::get('/dashboard', [App\Http\Controllers\PetOwner\DashboardController::class, 'index'])->name('dashboard');
    
    // Profile routes
    Route::get('/profile', [PetOwner\ProfileController::class, 'index'])->name('profile');
    Route::get('/profile/setup', [PetOwner\ProfileController::class, 'setup'])->name('profile.setup');
    Route::post('/profile/setup', [PetOwner\ProfileController::class, 'storeSetup'])->name('profile.setup.store');
    Route::put('/profile', [PetOwner\ProfileController::class, 'update'])->name('profile.update');
    
    // Settings routes
    Route::get('/settings', [PetOwner\SettingsController::class, 'index'])->name('settings');
    Route::post('/settings', [PetOwner\SettingsController::class, 'update'])->name('settings.update');
    
    // Pet routes
    Route::resource('pets', PetOwner\PetController::class);
    
    // Appointment routes
    Route::resource('appointments', PetOwner\AppointmentController::class);

    // Messages Routes - Updated for unified messaging
    Route::get('/messages', [App\Http\Controllers\PetOwner\MessagesController::class, 'index'])
        ->name('messages.index');
    Route::get('/messages/chat', [App\Http\Controllers\PetOwner\MessagesController::class, 'show'])
        ->name('messages.show');
    Route::post('/messages', [App\Http\Controllers\PetOwner\MessagesController::class, 'store'])
        ->name('messages.store');  // Removed {admin_id} parameter
});

Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])
    ->middleware('auth')
    ->name('logout');

Route::get('/storage-debug', function() {
    $testFile = 'test.txt';
    $disk = Storage::disk('public');
    
    // Try to write a test file
    $disk->put($testFile, 'test');
    
    return [
        'app_url' => config('app.url'),
        'storage_path' => storage_path('app/public'),
        'public_path' => public_path('storage'),
        'file_written' => $disk->exists($testFile),
        'storage_link_exists' => file_exists(public_path('storage')),
        'storage_directory_writable' => is_writable(storage_path('app/public')),
        'example_image_path' => $disk->path($testFile),
        'example_image_url' => Storage::url($testFile)
    ];
});

Route::get('/check-storage', function() {
    // Create test files in each directory
    $directories = ['user_photos', 'pet_photos', 'products'];
    $results = [];
    
    foreach ($directories as $dir) {
        $testFile = $dir . '/test.txt';
        $disk = Storage::disk('public');
        
        // Try to create directory if it doesn't exist
        if (!$disk->exists($dir)) {
            $disk->makeDirectory($dir);
        }
        
        // Try to write a test file
        $disk->put($testFile, 'test');
        
        $results[$dir] = [
            'directory_exists' => $disk->exists($dir),
            'directory_path' => storage_path('app/public/' . $dir),
            'directory_writable' => is_writable(storage_path('app/public/' . $dir)),
            'test_file_exists' => $disk->exists($testFile),
            'test_file_url' => Storage::url($testFile)
        ];
    }
    
    return [
        'app_url' => config('app.url'),
        'storage_link_exists' => file_exists(public_path('storage')),
        'storage_path' => storage_path('app/public'),
        'public_path' => public_path('storage'),
        'directories' => $results
    ];
});

Route::post('/appointments/{appointment}/confirm', [AppointmentController::class, 'confirm'])
    ->name('appointment.confirm')
    ->middleware(['auth', 'staff']);

Route::get('user-management/export/{format}', [UserManagementController::class, 'export'])->name('user-management.export');

Route::post('user-management/export-selected', [UserManagementController::class, 'exportSelected'])
    ->name('user-management.export-selected');

Route::middleware(['auth'])->group(function () {
    Route::get('/notifications', [NotificationsController::class, 'index'])->name('notifications.index');
    Route::post('/notifications/mark-all-read', [NotificationsController::class, 'markAllRead'])
        ->name('notifications.markAllRead');

    // Remove the auth middleware temporarily for testing
    Route::get('/test-sms', function() {
        try {
            $twilio = new \Twilio\Rest\Client(
                env('TWILIO_ACCOUNT_SID'),  // Use env() directly for testing
                env('TWILIO_AUTH_TOKEN')
            );

            dd([
                'step' => 'Twilio client created',
                'config' => [
                    'account_sid' => env('TWILIO_ACCOUNT_SID'),
                    'auth_token' => substr(env('TWILIO_AUTH_TOKEN'), 0, 5) . '...',  // Show first 5 chars only
                    'from_number' => env('TWILIO_PHONE_NUMBER'),
                    'to_number' => '+639214017593'
                ]
            ]);

            $message = $twilio->messages->create(
                "+639214017593",  // Your number
                [
                    'from' => env('TWILIO_PHONE_NUMBER'),
                    'body' => "Hello! This is a test message from PawfectCare."
                ]
            );

            return [
                'success' => true,
                'message' => 'SMS sent successfully!',
                'message_sid' => $message->sid
            ];

        } catch (\Exception $e) {
            return [
                'success' => false,
                'error' => $e->getMessage(),
                'config' => [
                    'account_sid' => env('TWILIO_ACCOUNT_SID'),
                    'from_number' => env('TWILIO_PHONE_NUMBER')
                ]
            ];
        }
    });
});

Route::get('/test', function() {
    return 'Route is working!';
});

// Admin & Sub-admin message routes
Route::middleware(['auth', 'can:access-admin'])->group(function () {
    Route::get('/admin/messages', [App\Http\Controllers\Admin\MessagesController::class, 'index'])
        ->name('admin.messages.index');
    Route::get('/admin/messages/{conversation}', [App\Http\Controllers\Admin\MessagesController::class, 'show'])
        ->name('admin.messages.show');
    Route::post('/admin/messages/{conversation}', [App\Http\Controllers\Admin\MessagesController::class, 'store'])
        ->name('admin.messages.store');
});

Route::view('privacy-policy', 'privacy-policy')->name('privacy-policy');

Route::get('/test-twilio', function () {
    try {
        $twilio = new \Twilio\Rest\Client(
            env('TWILIO_ACCOUNT_SID'),
            env('TWILIO_AUTH_TOKEN')
        );

        $toNumber = '+639214017593'; // Example number
        $fromNumber = env('TWILIO_PHONE_NUMBER'); // Your Twilio number

        // Log the details before sending the message
        \Log::info('Twilio Client Created', [
            'account_sid' => env('TWILIO_ACCOUNT_SID'),
            'from_number' => $fromNumber,
            'to_number' => $toNumber,
        ]);

        // Send a test message
        $message = $twilio->messages->create(
            $toNumber,
            [
                'from' => $fromNumber,
                'body' => 'This is a test message from your Laravel application!'
            ]
        );

        // Log the response from Twilio
        \Log::info('Twilio SMS Response:', [
            'sid' => $message->sid,
            'status' => $message->status,
            'to' => $toNumber,
            'body' => 'This is a test message from your Laravel application!'
        ]);

        return response()->json([
            'success' => true,
            'message' => 'SMS sent successfully!',
            'message_sid' => $message->sid
        ]);
    } catch (\Exception $e) {
        \Log::error('Twilio SMS Error: ' . $e->getMessage());
        return response()->json([
            'success' => false,
            'error' => $e->getMessage()
        ]);
    }
});

Route::post('/pet-owner/pets', [PetController::class, 'store'])->name('pet-owner.pets.store');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/pet-owner/pets/create', [App\Http\Controllers\PetOwner\PetOwnerController::class, 'create'])->name('pet-owner.pets.create');
    Route::post('/pet-owner/pets', [App\Http\Controllers\PetOwner\PetOwnerController::class, 'store'])->name('pet-owner.pets.store');
    // Add other routes as needed
});

Route::middleware(['auth', 'role:pet_owner'])->prefix('pet-owner')->name('pet-owner.')->group(function () {
    Route::get('/products', [PetOwnerProductController::class, 'index'])->name('products.index');
});

// Add the dashboard route
Route::middleware(['auth', 'verified', 'role:pet_owner'])->group(function () {
    Route::get('/pet-owner/dashboard', function () {
        return view('pet-owner.dashboard');
    })->name('pet-owner.dashboard');
});

Route::get('/test-log', function() {
    \Log::info('Test log entry');
    return 'Logged! Check storage/logs/laravel.log';
});

// Add this near your other route groups
Route::middleware(['auth', 'role:pet_owner'])->group(function () {
    Route::get('/', [PetOwnerDashboardController::class, 'index'])
        ->name('pet-owner.dashboard');
    
    Route::get('/pet-owner/dashboard', [PetOwnerDashboardController::class, 'index'])
        ->name('pet-owner.dashboard');
});

Route::get('/check-email', [RegisterController::class, 'checkEmail'])
    ->name('check.email')
    ->middleware('guest');

Route::post('/verify-otp', [RegisterController::class, 'verifyOTP'])
    ->name('verify.otp')
    ->middleware('guest');

Route::post('/resend-verification', [RegisterController::class, 'resendVerification'])
    ->name('verification.resend')
    ->middleware('guest');

// Add this route temporarily and remove after use
Route::get('/verify-all-users', function() {
    if (!app()->environment('production')) {
        $count = \App\Models\User::whereNull('email_verified_at')
            ->update(['email_verified_at' => now()]);
        return "{$count} users have been verified.";
    }
    return 'Not available in production.';
});

// Add this route
Route::get('/pages/medical-records', [CheckupHistoryController::class, 'sampleRecords'])->name('pages.medical-records');

Route::get('/api/pets/{pet}/medical-history', [PetController::class, 'getMedicalHistory']);

// Add this test route
Route::get('/test/pet/{id}', [PetController::class, 'testPetData']);

Route::match(['post', 'delete'], '/user-management/{user}/verify', [UserController::class, 'verify'])->name('user-management.verify');

Route::post('/pets/{pet}/verify', [PetController::class, 'verify'])->name('pets.verify');

Route::get('/backup/download/{type}', [BackupController::class, 'downloadArchiveBackup'])
    ->name('backup.download')
    ->middleware(['auth', 'admin']); // Ensure only admins can download backups

// Update the backup routes
Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/backup/download/{type}', [BackupController::class, 'downloadArchiveBackup'])
        ->name('backup.download');
    Route::post('/backup/auto', [BackupController::class, 'autoBackup'])
        ->name('backup.auto');
});

Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/backups', [BackupController::class, 'listBackups'])->name('backup.list');
    Route::get('/backups/download/{filename}', [BackupController::class, 'downloadBackupFile'])->name('backup.download-file');
});

Route::post('/messages/mark-as-read/{userId}', [MessageController::class, 'markAsRead'])->name('messages.markAsRead');

Route::post('/appointments/delete-multiple', [AppointmentController::class, 'deleteMultiple'])->name('appointment.deleteMultiple');
Route::patch('/appointments/{appointment}/status', [AppointmentController::class, 'updateStatus'])->name('appointment.updateStatus');
