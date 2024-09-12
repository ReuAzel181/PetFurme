<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\User\StoreUserRequest;
use App\Http\Requests\User\UpdateUserRequest;

class UserController extends Controller
{
    public function index()
    {
        // TODO: Select columns
        $users = User::all();

        return view('users.index', [
            'users' => $users
        ]);
    }

    public function petOwner()
    {
        // Fetch users with the "Pet Owner" role
        $users = User::where('role', 'pet_owner')->get();

        return view('users.pet-owner', ['users' => $users]);
    }

    public function subAdmin()
    {
        // Fetch users with the "Sub Admin" role
        $users = User::where('role', 'sub_admin')->get();

        return view('users.sub-admin', ['users' => $users]);
    }

    public function create()
    {
        return view('users.create');
    }
    public function userManagementOverview()
    {
        // You can return a view or redirect to a default page
        return view('users.user-management-overview');
    }


    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'type' => 'required|in:pet_owner,sub_admin',
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'number_of_pets' => 'nullable|required_if:type,pet_owner|integer',
            'address' => 'nullable|required_if:type,pet_owner|string',
        ]);

        $validatedData['password'] = Hash::make($validatedData['password']);
        
        // Create user
        $user = User::create($validatedData);

        // Handle file upload
        if ($request->hasFile('photo')) {
            $file = $request->file('photo');
            $filename = hexdec(uniqid()).'.'.$file->getClientOriginalExtension();
            $file->storeAs('profile/', $filename, 'public');
            $user->update(['photo' => $filename]);
        }

        return redirect()
            ->route('users.index')
            ->with('success', 'New User has been created!');
    }


    public function show(User $user)
    {
        return view('users.show', [
           'user' => $user
        ]);
    }

    public function edit(User $user)
    {
        return view('users.edit', [
            'user' => $user
        ]);
    }

    public function update(UpdateUserRequest $request, User $user)
    {

//        if ($validatedData['email'] != $user->email) {
//            $validatedData['email_verified_at'] = null;
//        }

        $user->update($request->except('photo'));

        /**
         * Handle upload image with Storage.
         */
        if($request->hasFile('photo')){

            // Delete Old Photo
            if($user->photo){
                unlink(public_path('storage/profile/') . $user->photo);
            }

            // Prepare New Photo
            $file = $request->file('photo');
            $fileName = hexdec(uniqid()).'.'.$file->getClientOriginalExtension();

            // Store an image to Storage
            $file->storeAs('profile/', $fileName, 'public');

            // Save DB
            $user->update([
                'photo' => $fileName
            ]);
        }

        return redirect()
            ->route('users.index')
            ->with('success', 'User has been updated!');
    }

    public function updatePassword(Request $request, String $username)
    {
        # Validation
        $validated = $request->validate([
            'password' => 'required_with:password_confirmation|min:6',
            'password_confirmation' => 'same:password|min:6',
        ]);

        # Update the new Password
        User::where('username', $username)->update([
            'password' => Hash::make($validated['password'])
        ]);

        return redirect()
            ->route('users.index')
            ->with('success', 'User has been updated!');
    }

    public function destroy(User $user)
    {
        /**
         * Delete photo if exists.
         */
        if($user->photo){
            unlink(public_path('storage/profile/') . $user->photo);
        }

        $user->delete();

        return redirect()
            ->route('users.index')
            ->with('success', 'User has been deleted!');
    }
}
