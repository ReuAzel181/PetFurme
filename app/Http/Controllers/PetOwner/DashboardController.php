<?php

namespace App\Http\Controllers\PetOwner;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;
use App\Models\Message;
use App\Models\Pet;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:pet_owner']);
    }

    public function index()
    {
        $user = auth()->user();
        
        // Get pets
        $pets = Pet::where('user_id', $user->id)
                   ->latest()
                   ->get();

        // Get appointments
        $appointments = $user->appointments ?? collect();

        // Get products
        $products = Product::query()
            ->select('id', 'name', 'selling_price as price', 'quantity as stock', 'product_image')
            ->latest()
            ->take(2)
            ->get()
            ->map(function ($product) {
                $product->image_url = $product->product_image ? 
                    asset('storage/' . $product->product_image) : 
                    asset('storage/defaults/no-image.jpg');
                return $product;
            });

        // Get messages
        $unreadMessages = Message::where('receiver_id', $user->id)
            ->whereNull('read_at')
            ->count();

        $latestMessage = Message::where(function($query) use ($user) {
                $query->where('receiver_id', $user->id)
                      ->orWhere('sender_id', $user->id);
            })
            ->latest()
            ->first();

        return view('pet-owner.dashboard', compact(
            'pets',
            'appointments',
            'products',
            'unreadMessages',
            'latestMessage'
        ));
    }
} 