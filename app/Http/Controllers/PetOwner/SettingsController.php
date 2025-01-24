<?php

namespace App\Http\Controllers\PetOwner;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SettingsController extends Controller
{
    public function index()
    {
        return view('pet-owner.settings.index');
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'notifications_enabled' => 'boolean',
            'email_notifications' => 'boolean',
            'sms_notifications' => 'boolean',
            'theme' => 'string|in:light,dark',
            'language' => 'string|in:en,es',
        ]);

        $user = auth()->user();
        $user->settings()->updateOrCreate(
            ['user_id' => $user->id],
            $validated
        );

        return back()->with('success', 'Settings updated successfully!');
    }
} 