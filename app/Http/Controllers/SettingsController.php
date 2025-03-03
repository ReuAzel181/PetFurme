<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SettingsController extends Controller
{
    public function index()
    {
        return view('settings.index');
    }

    public function store()
    {
        return view('settings.store');
    }

    public function invoice()
    {
        return view('settings.invoice');
    }

    public function notifications()
    {
        return view('settings.notifications');
    }

    public function backup()
    {
        return view('settings.backup');
    }
} 