<?php
namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function index()
    {
        // Use whereColumn for comparing columns in the query
        $notifications = Product::whereColumn('quantity', '<=', 'quantity_alert')->get();

        // Return the notifications view with the products that need attention
        return view('notifications.index', compact('notifications'));
    }
}
