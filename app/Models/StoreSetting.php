<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class StoreSetting extends Model
{
    public const CACHE_KEY = 'store_setting_current';

    protected $fillable = [
        'shop_name',
        'shop_address',
        'shop_logo',
        'qris_image',
    ];

    protected static function booted()
    {
        static::saved(function () {
            Cache::forget(self::CACHE_KEY);
        });

        static::deleted(function () {
            Cache::forget(self::CACHE_KEY);
        });
    }

    /**
     * Get or create the single current store settings record (cached).
     */
    public static function current(): self
    {
        return Cache::remember(self::CACHE_KEY, 3600, function () {
            return static::firstOrCreate([], [
                'shop_name' => 'StoreKuify',
                'shop_address' => 'Jl. Kebon Jeruk Raya No. 42, RT 01/RW 03, Jakarta Barat',
                'shop_logo' => null,
                'qris_image' => null,
            ]);
        });
    }
}
