<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'phone',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [];

    /**
     * Get the transactions for the customer.
     */
    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    /**
     * Get the standalone debt payments for the customer.
     */
    public function debtPayments()
    {
        return $this->hasMany(DebtPayment::class);
    }

    /**
     * Get total outstanding debt dynamically.
     *
     * Formula: SUM(transactions.remaining_amount) - SUM(debt_payments.amount)
     * Never negative.
     */
    public function getTotalDebtAttribute()
    {
        if (array_key_exists('total_transaction_debt', $this->attributes)) {
            $transactionDebt = (float) ($this->attributes['total_transaction_debt'] ?? 0);
            $paidOff = (float) ($this->attributes['total_paid_off'] ?? 0);
            return max(0, $transactionDebt - $paidOff);
        }

        $transactionDebt = (float) $this->transactions()->sum('remaining_amount');
        $paidOff = (float) $this->debtPayments()->sum('amount');
        return max(0, $transactionDebt - $paidOff);
    }
}
