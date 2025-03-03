<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;


class RegisteredUserController extends Controller
{
    public function __construct()
    {
        DB::enableQueryLog();
    }

    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        try {
            // Debug table structure
            $columns = DB::select('SHOW COLUMNS FROM users');
            \Log::info('Users table columns:', ['columns' => $columns]);
            
            // Debug table creation SQL
            $createTable = DB::select('SHOW CREATE TABLE users')[0];
            \Log::info('Table creation SQL:', ['create_table' => $createTable]);

            // Debug database structure
            $tableInfo = DB::select('SHOW CREATE TABLE users')[0];
            \Log::info('Users table structure:', ['table_info' => $tableInfo]);
            
            // Debug query log
            \Log::info('Current queries:', ['queries' => DB::getQueryLog()]);

            // Log the incoming request
            \Log::info('Registration attempt:', [
                'request_data' => $request->except(['password', 'password_confirmation'])
            ]);

            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users',
                'password' => 'required|string|min:8|confirmed'
            ]);

            \Log::info('Validation passed, attempting to create user');

            DB::beginTransaction();
            
            // Generate UUID
            $uuid = Str::uuid();
            
            \Log::info('Generated UUID:', ['uuid' => $uuid]);

            $userData = [
                'name' => $validated['name'],
                'email' => $validated['email'],
                'password' => Hash::make($validated['password']),
                'role' => 'pet_owner',
                'uuid' => $uuid,
                'address' => '',  // Empty string
                'username' => '',  // Empty string
                'phone' => '',    // Empty string
                'store_name' => '',  // Empty string
                'store_address' => '',  // Empty string
                'store_email' => '',   // Empty string
                'photo' => null,
                'email_verified_at' => null
            ];

            \Log::info('Attempting to create user with data:', [
                'user_data' => collect($userData)->except(['password'])->toArray()
            ]);

            $user = User::create($userData);

            \Log::info('User created successfully:', [
                'user_id' => $user->id,
                'uuid' => $user->uuid
            ]);

            DB::commit();
            
            Auth::login($user);

            return response()->json([
                'success' => true,
                'message' => 'Registration successful',
                'redirect' => route('pet-owner.dashboard')
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            
            \Log::error('Registration failed', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'request_data' => $request->except(['password', 'password_confirmation'])
            ]);

            return response()->json([
                'success' => false,
                'errors' => ['registration' => ['Registration failed. Please try again.']],
                'debug_info' => [
                    'error_type' => get_class($e),
                    'error_message' => $e->getMessage()
                ]
            ], 422);
        }
    }
}
