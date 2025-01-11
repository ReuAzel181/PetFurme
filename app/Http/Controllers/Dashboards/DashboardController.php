<?php

namespace App\Http\Controllers\Dashboards;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Order;
use App\Models\Product;
use App\Models\Purchase;
use App\Models\Quotation;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\Pet; 
use App\Models\User;


class DashboardController extends Controller
{
    public function index()
    {
        $orders = Order::where("user_id", auth()->id())->count();
        $products = Product::where("user_id", auth()->id())->count();

        $purchases = Purchase::where("user_id", auth()->id())->count();
        $todayPurchases = Purchase::whereDate('date', today()->format('Y-m-d'))->count();
        $todayProducts = Product::whereDate('created_at', today()->format('Y-m-d'))->count();
        $todayQuotations = Quotation::whereDate('created_at', today()->format('Y-m-d'))->count();
        $todayOrders = Order::whereDate('created_at', today()->format('Y-m-d'))->count();

        $categories = Category::where("user_id", auth()->id())->count();
        $quotations = Quotation::where("user_id", auth()->id())->count();

        $pets = Pet::where("user_id", auth()->id())->count();
        $todayPets = Pet::where("user_id", auth()->id())->whereDate('created_at', today()->format('Y-m-d'))->count();

        $totalPetOwners = User::where('role', 'pet_owner')->count(); 
        $todayPetOwners = User::where('role', 'pet_owner')->whereDate('created_at', today())->count(); 

        return view('dashboard', compact(
            'pets', 
            'totalPetOwners', 
            'todayPetOwners',
            'todayPets', 
            'products', 
            'orders', 
            'purchases', 
            'todayPurchases', 
            'todayProducts', 
            'todayQuotations', 
            'todayOrders', 
            'categories', 
            'quotations'
        ));
    }

    
}
