<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Gloudemans\Shoppingcart\Facades\Cart;
use App\Http\Requests\Invoice\StoreInvoiceRequest;
use App\Models\User;
use Illuminate\Support\Str;

class InvoiceController extends Controller
{
    public function create(StoreInvoiceRequest $request)
    {
        // First get the user
        $user = User::findOrFail($request->customer_id);
        
        // Get or create customer record
        $customer = Customer::firstOrCreate(
            ['user_id' => $user->id],
            [
                'uuid' => Str::uuid(),
                'name' => $user->name,
                'email' => $user->email,
                'phone' => $user->phone
            ]
        );

        $carts = Cart::content();

        return view('invoices.create', [
            'customer' => $customer,
            'carts' => $carts
        ]);
    }
}
