<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Product;
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
    
        $products = Product::select('id', 'name', 'selling_price')->get();
    
        return view('users.index', compact('users', 'roles', 'role', 'products'));
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
            'store_name' => 'nullable|string|max:255',
            'store_address' => 'nullable|string|max:255',
            'store_email' => 'nullable|string|email|max:255',
            'password' => 'required|string|min:8',
            'role' => 'required|string|in:admin,sub_admin,pet_owner',
            'photo_binary' => 'required|string', // Base64 encoded image
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try {
            // Convert base64 to binary
            $photoBinary = null;
            if ($request->photo_binary) {
                // Remove the "data:image/jpeg;base64," part
                $base64Image = preg_replace('/^data:image\/\w+;base64,/', '', $request->photo_binary);
                $photoBinary = base64_decode($base64Image);
            }

            // Create the user
            $user = User::create([
                'username' => $request->username,
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone ?? null,
                'store_name' => $request->store_name ?? null,
                'store_address' => $request->store_address ?? null,
                'store_email' => $request->store_email ?? null,
                'password' => Hash::make($request->password),
                'role' => $request->role,
            ]);

            // Update photo separately to handle binary data
            if ($photoBinary) {
                $user->update(['photo' => $photoBinary]);
            }

            return redirect()->route('users.index')->with('success', 'User created successfully.');
        } catch (\Exception $e) {
            \Log::error('Error creating user: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Error creating user. Please try again.');
        }
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
            'photo_binary' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try {
            // Handle binary photo upload
            if ($request->photo_binary) {
                $base64Image = preg_replace('/^data:image\/\w+;base64,/', '', $request->photo_binary);
                $photoBinary = base64_decode($base64Image);
                $user->photo = $photoBinary;
            }
            // Handle traditional file upload
            elseif ($request->hasFile('photo')) {
                if ($user->photo && is_string($user->photo)) {
                    Storage::disk('public')->delete($user->photo);
                }
                $user->photo = $request->file('photo')->store('user_photos', 'public');
            }

            $user->username = $request->username;
            $user->name = $request->name;
            $user->email = $request->email;
            $user->phone = $request->phone;
            $user->save();

            return redirect()
                ->route('users.index')
                ->with('success', 'User updated successfully.');
        } catch (\Exception $e) {
            \Log::error('Error updating user: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Error updating user. Please try again.');
        }
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

    public function getPhoto($id)
    {
        $user = User::findOrFail($id);
        
        if (!$user->photo) {
            abort(404);
        }
        
        // If it's a file path, redirect to the file
        if (is_string($user->photo) && (str_starts_with($user->photo, 'user_photos/') || str_starts_with($user->photo, 'storage/'))) {
            return redirect(asset('storage/' . $user->photo));
        }
        
        // Otherwise, serve the binary data
        try {
            $finfo = new \finfo(FILEINFO_MIME_TYPE);
            $contentType = $finfo->buffer($user->photo) ?: 'image/jpeg';
            
            return response($user->photo)
                ->header('Content-Type', $contentType)
                ->header('Cache-Control', 'public, max-age=3600');
        } catch (\Exception $e) {
            \Log::error('Error serving photo: ' . $e->getMessage());
            abort(404);
        }
    }
}
