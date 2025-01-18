<?php
namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class NotificationController extends Controller
{
    public function index()
    {
        $notifications = Product::where('quantity', '<=', DB::raw('quantity_alert'))
            ->where('user_id', auth()->id())
            ->orderBy('quantity', 'asc')
            ->get();

        \Log::info('Fetched notifications:', [
            'count' => $notifications->count(),
            'products' => $notifications->toArray()
        ]);

        // Initialize empty collection for expiring products
        $expiringProducts = collect();

        return view('notifications.index', compact('notifications', 'expiringProducts'));
    }

    public function markAllRead()
    {
        // You could store this in a notifications table or update product status
        // For now, we'll just redirect back with a success message
        return redirect()->route('notifications.index')
            ->with('success', __('All notifications have been marked as read'));
    }
}
