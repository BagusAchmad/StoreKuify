<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Category extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'slug',
        'description',
        'is_active',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * The "booted" method of the model.
     */
    protected static function booted()
    {
        // Automatically generate slug from name when creating
        static::creating(function ($category) {
            if (empty($category->slug)) {
                $category->slug = Str::slug($category->name);
            }
        });

        // Automatically update slug from name when updating
        static::updating(function ($category) {
            $category->slug = Str::slug($category->name);
        });

        // Check for active products before deleting
        static::deleting(function ($category) {
            if ($category->products()->exists()) {
                throw new \Exception("Kategori tidak dapat dihapus karena masih memiliki barang.");
            }
        });
    }

    /**
     * Get the products for the category.
     */
    public function products()
    {
        return $this->hasMany(Product::class);
    }

    /**
     * Get the route key for the model.
     */
    public function getRouteKeyName(): string
    {
        return 'slug';
    }
}
