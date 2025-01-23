<?php

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

Route::get('/messages', [MessageController::class, 'index'])->name('messages.index');
Route::get('/messages/chat/{id}', [MessageController::class, 'chat'])->name('messages.chat');
Route::get('/messages/users', [MessageController::class, 'showUsers'])->name('messages.users');
Route::post('/messages/send/{id}', [MessageController::class, 'sendMessage'])->name('messages.send');

Route::get('/messages', [MessageController::class, 'index'])->name('messages.index');
Route::resource('messages', MessageController::class);



Route::get('/test-supabase', function () {
    $supabase = new \Supabase\CreateClient(
        config('supabase.url'),
        config('supabase.key')
    );

    $response = $supabase->from('messages')->select('*')->execute();

    if (isset($response->error)) {
        return response()->json(['error' => $response->error], 500);
    }

    return response()->json(['data' => $response->data], 200);
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
 Route::delete('/appointment/{id}', [AppointmentController::class, 'destroy'])->name('appointment.destroy');

// Route Pet and Sales
Route::middleware(['auth', 'verified'])->group(function () {
    Route::resource('pets', PetController::class);
    Route::get('/pet', [PetController::class, 'index'])->name('pet.index');
    Route::get('/sales', [PetController::class, 'index'])->name('sales.index');
});


Route::get('php/', function () {
    return phpinfo();
});

Route::get('/', function () {
    if (Auth::check()) {
        return redirect('/dashboard');
    }
    return redirect('/login');
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
    Route::resource('/products', \App\Http\Controllers\Product\ProductController::class);



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
    Route::get('/orders/archived', [OrderController::class, 'archived'])->name('orders.archived');
    Route::delete('/orders/{uuid}/delete', [OrderController::class, 'destroy'])->name('orders.destroy');
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

// Update these routes
Route::get('/forgot-password', [PasswordResetController::class, 'showForgotForm'])
    ->name('password.request');
Route::post('/forgot-password', [PasswordResetController::class, 'sendOTP'])
    ->name('password.email');
Route::get('/verify-otp', [PasswordResetController::class, 'showOTPForm'])
    ->name('password.otp');
Route::post('/verify-otp', [PasswordResetController::class, 'verifyOTP'])
    ->name('password.verify-otp');
Route::match(['get', 'post'], '/reset-password', [PasswordResetController::class, 'showResetForm'])
    ->name('password.reset');
Route::post('/reset-password/update', [PasswordResetController::class, 'resetPassword'])
    ->name('password.update');

// Add these registration routes
Route::post('/register/send-otp', [RegisterController::class, 'sendOTP'])
    ->name('register.send-otp');
Route::post('/register/verify-otp', [RegisterController::class, 'verifyOTP'])
    ->name('register.verify-otp');
