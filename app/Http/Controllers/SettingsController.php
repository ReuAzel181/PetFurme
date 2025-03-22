<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ChargeSlip;

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
        $chargeSlips = ChargeSlip::with('appointment')
            ->orderBy('created_at', 'desc')
            ->paginate(10);
            
        return view('settings.invoice', compact('chargeSlips'));
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