<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TransactionItem extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'transaction_id',
        'product_id',
        'quantity',
        'price',
        'cost_price',
        'subtotal',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'price' => 'decimal:2',
        'cost_price' => 'decimal:2',
        'subtotal' => 'decimal:2',
        'quantity' => 'integer',
    ];

    /**
     * Get the transaction that owns this item.
     */
    public function transaction()
    {
        return $this->belongsTo(Transaction::class);
    }

    /**
     * Get the product associated with this item.
     */
    public function product()
    {
        return $this->belongsTo(Product::class)->withTrashed();
    }
}
