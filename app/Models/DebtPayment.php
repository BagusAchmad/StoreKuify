<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DebtPayment extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'customer_id',
        'amount',
        'payment_method',
        'debt_before',
        'debt_after',
        'reference',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'amount' => 'decimal:2',
        'debt_before' => 'decimal:2',
        'debt_after' => 'decimal:2',
    ];

    /**
     * Get the customer that made this payment.
     */
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
}
