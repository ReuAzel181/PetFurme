<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    protected $fillable = [
        'uuid',
        'order_id',
        'user_id',
        'invoice_no',
        'amount_received',
        'change_amount',
        'total_amount',
        'payment_note',
        'payment_date'
    ];

    protected $casts = [
        'payment_date' => 'datetime',
        'amount_received' => 'decimal:2',
        'change_amount' => 'decimal:2',
        'total_amount' => 'decimal:2'
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
} 