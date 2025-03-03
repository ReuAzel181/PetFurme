<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ArchivedOrderDetail extends Model
{
    protected $guarded = ['id'];
    
    protected $casts = [
        'unit_price' => 'decimal:2',
        'total' => 'decimal:2'
    ];

    public function archivedOrder()
    {
        return $this->belongsTo(ArchivedOrder::class);
    }
} 