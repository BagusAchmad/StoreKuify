<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'user_id',
        'customer_id',
        'transaction_number',
        'subtotal',
        'discount',
        'total',
        'amount_paid',
        'remaining_amount',
        'status',
        'payment_method',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'subtotal' => 'decimal:2',
        'discount' => 'decimal:2',
        'total' => 'decimal:2',
        'amount_paid' => 'decimal:2',
        'remaining_amount' => 'decimal:2',
    ];

    /**
     * Get the cashier user who made the transaction.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the customer for the transaction.
     */
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    /**
     * Get the items sold in this transaction.
     */
    public function items()
    {
        return $this->hasMany(TransactionItem::class);
    }
}
