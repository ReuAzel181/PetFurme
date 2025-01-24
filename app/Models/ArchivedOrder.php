<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ArchivedOrder extends Model
{
    protected $fillable = [
        'uuid',
        'original_id',
        'user_id',
        'customer_name',
        'order_date',
        'total_products',
        'sub_total',
        'vat',
        'total',
        'invoice_no',
        'note',
        'is_paid',
        'amount_received',
        'change_amount',
        'paid_at',
        'payment_note',
        'archive_reason',
        'archive_note',
        'archived_at',
        'deleted_by'
    ];
    
    protected $casts = [
        'is_paid' => 'boolean',
        'order_date' => 'datetime',
        'paid_at' => 'datetime',
        'archived_at' => 'datetime',
        'amount_received' => 'decimal:2',
        'change_amount' => 'decimal:2',
        'total' => 'decimal:2',
        'sub_total' => 'decimal:2',
        'vat' => 'decimal:2'
    ];

    public function archivedDetails()
    {
        return $this->hasMany(ArchivedOrderDetail::class, 'archived_order_id');
    }

    public function scopeByReason($query, $reason)
    {
        return $query->where('archive_reason', $reason);
    }

    public function deletedBy()
    {
        return $this->belongsTo(User::class, 'deleted_by');
    }
} 