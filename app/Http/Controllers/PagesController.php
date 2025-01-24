<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Supplier;
use App\Models\Category;
use App\Models\Unit;

class PagesController extends Controller
{
    public function index()
    {
        // Get counts for the dashboard cards
        $data = [
            'suppliers' => Supplier::where('user_id', auth()->id())->count(),
            'categories' => Category::where('user_id', auth()->id())->count(),
            'units' => Unit::where('user_id', auth()->id())->count(),
        ];

        return view('pages.index', $data);
    }
} 