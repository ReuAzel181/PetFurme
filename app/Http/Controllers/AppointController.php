<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AppointController extends Controller
{
    public function index()
    {
        return view('appointment.index');
    }
}