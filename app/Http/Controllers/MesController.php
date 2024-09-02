<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MesController extends Controller
{
    public function index()
    {
        return view('message.index');
    }
}