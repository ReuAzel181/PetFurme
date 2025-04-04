<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    // Display all users or filter by role
    public function index(Request $request)
    {
        $users = User::withCount(['pets', 'appointments', 'orders'])
            ->with([
                'pets', 
                'appointments.pet',
                'orders.details.product',
                'orders' => function($query) {
                    $query->latest();
                }
            ])
            ->when($request->query('role'), function($query, $role) {
                if ($role !== 'all') {
                    $query->where('role', $role);
                }
            })
            ->get();
    
        // Get the role from the query parameter or default to 'all'
        $role = $request->query('role', 'all');
    
        // Pass roles for filtering buttons
        $roles = [
            'all' => 'All',
            'pet_owner' => 'Pet Owners',
            'sub_admin' => 'Sub Admins',
            'admin' => 'Admins',
        ];
    
        return view('users.index', compact('users', 'roles', 'role'));
    }

    // Display pet owners
    public function petOwner()
    {
        $users = User::where('role', 'pet_owner')->get();
        return view('users.pet-owner', compact('users'));
    }

    // Display sub admins
    public function subAdmin()
    {
        $users = User::where('role', 'sub_admin')->get();
        return view('users.sub-admin', compact('users'));
    }

    public function admin()
    {
        $users = User::where('role', 'admin')->get(); // Fetch admin users
        return view('users.admin', compact('users'));
    }

    // Show create user form
    public function create()
    {
        return view('users.create');
    }

    // Store a new user
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username' => 'required|string|max:255',
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'phone' => 'nullable|string|max:20',
            'pet_name' => 'nullable|string|max:255',
            'pet_type' => 'nullable|string|max:255',
            'store_name' => 'nullable|string|max:255',
            'store_address' => 'nullable|string|max:255',
            'store_email' => 'nullable|string|email|max:255',
            'password' => 'required|string|min:8',
            'role' => 'required|string|in:admin,sub_admin,pet_owner',
            'photo' => 'nullable|image|max:2048', // Max size: 2MB
        ]);
    
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
    
        if ($request->hasFile('photo')) {
            $photo = $request->file('photo');
            
            // Store locally
            $filename = 'user_' . time() . '_' . uniqid() . '.' . $photo->getClientOriginalExtension();
            $localPath = 'user_photos/' . $filename;
            $photo->storeAs('public/' . 'user_photos', $filename);
            
            // Read file contents for database storage
            $photoData = file_get_contents($photo->getRealPath());
            
            // Create user with both photo storage methods
            $user = User::create([
                'username' => $request->username,
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone ?? 'N/A',
                'pet_name' => $request->pet_name ?? 'N/A',
                'pet_type' => $request->pet_type ?? 'N/A',
                'store_name' => $request->store_name ?? 'N/A',
                'store_address' => $request->store_address ?? 'N/A',
                'store_email' => $request->store_email ?? 'N/A',
                'password' => Hash::make($request->password),
                'role' => $request->role,
                'photo' => $localPath,  // Store the file path
                'photo_data' => $photoData  // Store the binary data
            ]);
        }
    
        return redirect()->route('user-management.index')->with('success', 'User created successfully.');
    }
    


    // Show edit user form
    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('users.edit', compact('user'));
    }

    // Update user details
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);
        
        $validator = Validator::make($request->all(), [
            'username' => 'required|string|max:255|unique:users,username,'.$id,
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,'.$id,
            'phone' => 'nullable|string|max:20',
            'photo' => 'nullable|image|max:2048',
        ]);

        if ($validator->fails()) {
            return redirect()
                ->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Handle photo upload if a new photo is provided
        if ($request->hasFile('photo')) {
            // Delete old photo if exists
            if ($user->photo) {
                Storage::disk('public')->delete($user->photo);
            }
            
            $photo = $request->file('photo');
            
            // Store locally
            $filename = 'user_' . time() . '_' . uniqid() . '.' . $photo->getClientOriginalExtension();
            $localPath = 'user_photos/' . $filename;
            $photo->storeAs('public/' . 'user_photos', $filename);
            
            // Read file contents for database storage
            $photoData = file_get_contents($photo->getRealPath());
            
            // Update photo fields
            $user->photo = $localPath;
            $user->photo_data = $photoData;
        }

        // Update user fields
        $user->username = $request->username;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->role = $request->role;
        
        // Update password if provided
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }
        
        $user->save();

        return redirect()
            ->route('users.index')
            ->with('success', 'User updated successfully.');
    }

    // Delete a user
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('user-management.index')->with('success', 'User deleted successfully.');
    }

    public function restore($id)
    {
        $user = User::onlyTrashed()->findOrFail($id);
        $user->restore();

        return response()->json([
            'success' => true,
            'message' => 'User restored successfully'
        ]);
    }

    public function verify(User $user, Request $request)
    {
        if (!auth()->user()->role === 'admin' && !auth()->user()->role === 'sub_admin') {
            return back()->with('error', 'Unauthorized action.');
        }

        if ($request->isMethod('DELETE')) {
            // Deverify the user
            $user->update([
                'verified_by' => null
            ]);
            return back()->with('success', 'User verification has been removed.');
        }

        // Verify the user
        $user->update([
            'verified_by' => auth()->id()
        ]);

        return back()->with('success', 'User has been verified successfully.');
    }
}
