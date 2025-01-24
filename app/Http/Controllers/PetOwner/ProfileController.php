<?php

namespace App\Http\Controllers\PetOwner;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function index()
    {
        return view('pet-owner.profile.index');
    }

    public function setup()
    {
        return view('pet-owner.profile.setup');
    }

    public function storeSetup(Request $request)
    {
        $validated = $request->validate([
            'phone' => 'required|string|max:20',
            'address' => 'required|string|max:255',
            'emergency_contact_name' => 'required|string|max:255',
            'emergency_contact_phone' => 'required|string|max:20',
        ]);

        auth()->user()->update($validated + ['profile_completed' => true]);

        return redirect()->route('pet-owner.dashboard')
            ->with('success', 'Profile setup completed successfully!');
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . auth()->id(),
            'phone' => 'required|string|max:20',
            'address' => 'required|string|max:255',
        ]);

        auth()->user()->update($validated);

        return redirect()->route('pet-owner.profile')
            ->with('success', 'Profile updated successfully!');
    }
} 