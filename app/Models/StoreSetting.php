<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StoreSetting extends Model
{
    protected $fillable = [
        'shop_name',
        'shop_address',
        'shop_logo',
        'qris_image',
    ];

    /**
     * Get or create the single current store settings record.
     */
    public static function current(): self
    {
        return static::firstOrCreate([], [
            'shop_name' => 'StoreKuify',
            'shop_address' => 'Jl. Kebon Jeruk Raya No. 42, RT 01/RW 03, Jakarta Barat',
            'shop_logo' => null,
            'qris_image' => null,
        ]);
    }
}
