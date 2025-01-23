<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Order extends Model
{
    use SoftDeletes;

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
        'note',
        'order_status',
        'is_paid',
        'amount_received',
        'change_amount',
        'paid_at',
        'deleted_at',
        'deletion_reason'
    ];

    protected $casts = [
        'order_date' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'is_paid' => 'boolean',
        'paid_at' => 'datetime',
        'amount_received' => 'decimal:2',
        'change_amount' => 'decimal:2',
        'completed_at' => 'datetime',
        'deleted_at' => 'datetime'
    ];

    protected $with = ['details', 'details.product'];

    public function details()
    {
        return $this->hasMany(OrderDetail::class);
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

    public function getRouteKeyName()
    {
        return 'uuid';
    }

    public function getPaymentStatusAttribute()
    {
        if ($this->is_paid) {
            return 'paid';
        }
        if ($this->order_status === 'completed') {
            return 'completed';
        }
        return 'pending';
    }

    public function getPaymentStatusColorAttribute()
    {
        return [
            'paid' => 'success',
            'completed' => 'success',
            'pending' => 'warning'
        ][$this->payment_status];
    }

    public function markAsIncomplete()
    {
        $this->update([
            'order_status' => 'pending',
            'completed_at' => null
        ]);
    }

    public function markAsComplete()
    {
        $this->update([
            'order_status' => 'completed',
            'completed_at' => now()
        ]);
    }

    public const STATUSES = [
        'pending' => 'pending',
        'completed' => 'completed',
        'cancelled' => 'cancelled'
    ];

    public function getStatusAttribute()
    {
        if ($this->deleted_at) {
            return 'deleted';
        }
        return $this->order_status;
    }

    public function getOrderStatusColorAttribute()
    {
        if ($this->deleted_at) {
            return 'danger';
        }
        
        return match($this->order_status) {
            'completed' => 'success',
            'pending' => 'warning',
            'cancelled' => 'danger',
            default => 'secondary'
        };
    }
}
