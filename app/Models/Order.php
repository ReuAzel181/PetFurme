<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Order extends Model
{
    protected $guarded = [
        'id',
    ];

    protected $fillable = [
        'uuid',
        'user_id',
        'order_date',
        'total_products',
        'sub_total',
        'vat',
        'total',
        'invoice_no',
        'reference',
        'is_paid',
        'amount_received',
        'change_amount',
        'paid_at',
        'payment_note'
    ];

    protected $casts = [
        'order_date' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'is_paid' => 'boolean',
        'paid_at' => 'datetime',
        'amount_received' => 'decimal:2',
        'change_amount' => 'decimal:2'
    ];

    public function details()
    {
        return $this->hasMany(OrderDetails::class);
    }

    public function scopeSearch($query, $value): void
    {
        $query->where('invoice_no', 'like', "%{$value}%");
    }

    /**
     * Get the user that owns the Category
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
