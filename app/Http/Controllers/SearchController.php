<?php

namespace App\Http\Controllers;

use App\Models\Pet;
use App\Models\User;
use App\Models\Product;
use App\Models\Appointment;
use App\Models\Category;
use App\Models\Notification;
use App\Models\Order;
use App\Models\Customer;
use App\Models\Supplier;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    private $commands = [
        'add' => [
            'pet' => [
                'text' => 'Add New Pet',
                'type' => 'Command',
                'url' => 'pets.create',
                'icon' => 'fas fa-paw text-primary',
                'keywords' => ['pet']
            ],
            'product' => [
                'text' => 'Add New Product',
                'type' => 'Command',
                'url' => 'products.create',
                'icon' => 'fas fa-box text-warning',
                'keywords' => ['product']
            ],
            'customer' => [
                'text' => 'Add New Customer',
                'type' => 'Command',
                'url' => 'customers.create',
                'icon' => 'fas fa-user-plus text-success',
                'keywords' => ['customer']
            ],
            'order' => [
                'text' => 'Add New Order',
                'type' => 'Command',
                'url' => 'orders.create',
                'icon' => 'fas fa-shopping-cart text-info',
                'keywords' => ['order']
            ],
            'appointment' => [
                'text' => 'Add New Appointment',
                'type' => 'Command',
                'url' => 'appointments.create',
                'icon' => 'fas fa-calendar-plus text-success',
                'keywords' => ['appointment']
            ],
            'invoice' => [
                'text' => 'Add New Invoice',
                'type' => 'Command',
                'url' => 'invoices.create',
                'icon' => 'fas fa-file-invoice text-danger',
                'keywords' => ['invoice']
            ]
        ],
        'show' => [
            'pets' => [
                'text' => 'Show All Pets',
                'type' => 'Command',
                'url' => 'pets.index',
                'icon' => 'fas fa-list text-primary',
                'keywords' => ['pets']
            ],
            'products' => [
                'text' => 'Show All Products',
                'type' => 'Command',
                'url' => 'products.index',
                'icon' => 'fas fa-boxes text-warning',
                'keywords' => ['products']
            ],
            'orders' => [
                'text' => 'Show All Orders',
                'type' => 'Command',
                'url' => 'orders.index',
                'icon' => 'fas fa-list-alt text-info',
                'keywords' => ['orders']
            ],
            'customers' => [
                'text' => 'Show All Customers',
                'type' => 'Command',
                'url' => 'customers.index',
                'icon' => 'fas fa-users text-success',
                'keywords' => ['customers']
            ],
            'appointments' => [
                'text' => 'Show All Appointments',
                'type' => 'Command',
                'url' => 'appointments.index',
                'icon' => 'fas fa-calendar text-primary',
                'keywords' => ['appointments']
            ],
            'messages' => [
                'text' => 'Show All Messages',
                'type' => 'Command',
                'url' => 'messages.index',
                'icon' => 'fas fa-envelope text-info',
                'keywords' => ['messages', 'inbox', 'mail']
            ],
            'notifications' => [
                'text' => 'Show All Notifications',
                'type' => 'Command',
                'url' => 'notifications.index',
                'icon' => 'fas fa-bell text-warning',
                'keywords' => ['notifications', 'alerts']
            ]
        ]
    ];

    public function suggestions(Request $request)
    {
        $query = strtolower(trim($request->input('q')));
        
        // Return empty if query is too short
        if (strlen($query) < 1) {
            return response()->json([
                [
                    'text' => 'Type "add" to create new items',
                    'type' => 'Help',
                    'icon' => 'fas fa-plus-circle text-primary',
                    'url' => '#'
                ],
                [
                    'text' => 'Type "show" to view lists',
                    'type' => 'Help',
                    'icon' => 'fas fa-list text-info',
                    'url' => '#'
                ]
            ]);
        }

        $parts = explode(' ', $query);
        $command = $parts[0];
        $search = $parts[1] ?? '';

        if (!isset($this->commands[$command])) {
            return response()->json([]);
        }

        $suggestions = collect($this->commands[$command])
            ->when($search, function($collection) use ($search) {
                return $collection->filter(function($item, $key) use ($search) {
                    return str_contains($key, $search) || 
                           in_array($search, $item['keywords']);
                });
            })
            ->values()
            ->map(function($item) {
                $item['url'] = route($item['url']);
                return $item;
            })
            ->take(5);

        return response()->json($suggestions);
    }

    public function search(Request $request)
    {
        $query = strtolower(trim($request->input('q')));
        
        if (!$query) {
            return back();
        }

        $parts = explode(' ', $query);
        $command = $parts[0];
        $subCommand = $parts[1] ?? '';

        if (isset($this->commands[$command][$subCommand])) {
            return redirect()->route($this->commands[$command][$subCommand]['url']);
        }

        return redirect()->route('dashboard')
            ->with('message', 'Try commands like "add pet" or "show products"');
    }
} 