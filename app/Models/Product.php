<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Product extends Model
{
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'category_id',
        'name',
        'sku',
        'image',
        'cost_price',
        'selling_price',
        'stock',
        'is_active',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'cost_price' => 'decimal:2',
        'selling_price' => 'decimal:2',
        'stock' => 'integer',
        'is_active' => 'boolean',
    ];

    /**
     * Get the route key for the model.
     */
    public function getRouteKeyName(): string
    {
        return 'sku';
    }

    /**
     * Boot the model.
     */
    protected static function booted()
    {
        static::creating(function ($product) {
            if (empty($product->sku)) {
                $product->sku = self::generateUniqueSku($product->category_id);
            }
        });
    }

    /**
     * Generate a collision-safe unique SKU based on category name.
     */
    public static function generateUniqueSku($categoryId)
    {
        $category = Category::find($categoryId);
        $prefix = 'PRD';
        
        if ($category) {
            // Take initials of category name (e.g. Sembako -> SBK)
            $words = explode(' ', $category->name);
            $initials = '';
            foreach ($words as $word) {
                $initials .= strtoupper(substr($word, 0, 1));
            }
            // Strip non-alpha characters and clamp length to 4
            $cleanInitials = preg_replace('/[^A-Z]/', '', $initials);
            $prefix = substr($cleanInitials, 0, 4) ?: 'PRD';
        }

        do {
            // Generate random uppercase alphanumeric suffix (5 characters)
            $suffix = strtoupper(Str::random(5));
            $sku = $prefix . '-' . $suffix;
        } while (self::where('sku', $sku)->withTrashed()->exists());

        return $sku;
    }

    /**
     * Get the category that owns the product.
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Get the profit for the product.
     * Formula: selling_price - cost_price
     */
    public function getProfitAttribute()
    {
        return $this->selling_price - $this->cost_price;
    }

    /**
     * Get the estimated inventory value for the product.
     * Formula: cost_price * stock
     */
    public function getInventoryValueAttribute()
    {
        return $this->cost_price * $this->stock;
    }

    /**
     * Get the dynamic stock status.
     * Logic:
     * - if is_active is false: "Nonaktif"
     * - if stock <= 0: "Habis"
     * - if stock <= low_stock_threshold: "Menipis"
     * - else: "Aktif"
     */
    public function getStockStatusAttribute()
    {
        if (!$this->is_active) {
            return 'Nonaktif';
        }

        if ($this->stock <= 0) {
            return 'Habis';
        }

        $threshold = config('storekuify.low_stock_threshold', 5);
        if ($this->stock <= $threshold) {
            return 'Menipis';
        }

        return 'Aktif';
    }
}
