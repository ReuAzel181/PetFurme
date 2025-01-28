<?php

namespace App\Http\Controllers\PetOwner;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;
use App\Models\Message;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'pet.owner']);
    }

    public function index()
    {
        $user = auth()->user();
        $pets = $user->pets;
        $appointments = $user->appointments;

        // Fetch products with correct column names
        $products = Product::query()
            ->select('id', 'name', 'selling_price', 'quantity', 'product_image')
            ->latest()
            ->take(2)
            ->get();

        // Transform product image URLs
        $products->transform(function ($product) {
            $product->image_url = $product->product_image ? 
                asset('storage/' . $product->product_image) : 
                asset('storage/defaults/no-image.jpg');
            
            $product->price = $product->selling_price;
            $product->stock = $product->quantity;
            return $product;
        });

        // Get unread messages count
        $unreadMessages = Message::where('receiver_id', $user->id)
            ->whereNull('sent_at')  // assuming sent_at null means unread
            ->count();

        // Get latest message
        $latestMessage = Message::where('receiver_id', $user->id)
            ->orWhere('sender_id', $user->id)
            ->latest()
            ->first();

        return view('pet-owner.dashboard', compact(
            'unreadMessages',
            'latestMessage',
            'pets',
            'appointments',
            'products'
        ));
    }
} 