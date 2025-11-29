<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    protected $fillable = [
        "user_id",
        "category_id",
        "name",
        "description",
        "price",
        "stock",
        "image",
    ];

    protected $casts = [
        "price" => "decimal:2",
        "stock" => "integer",
    ];

    /**
     * Get the seller that owns the product
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the category that owns the product
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Get all ratings for the product
     */
    public function ratings(): HasMany
    {
        return $this->hasMany(ProductRating::class);
    }

    /**
     * Get average rating for the product
     */
    public function averageRating(): float
    {
        return round($this->ratings()->avg("rating") ?? 0, 1);
    }

    /**
     * Get total rating count
     */
    public function ratingCount(): int
    {
        return $this->ratings()->count();
    }

    /**
     * Check if product is low stock (< 2)
     */
    public function isLowStock(): bool
    {
        return $this->stock < 2;
    }

    /**
     * Scope untuk produk dengan stock rendah
     */
    public function scopeLowStock($query)
    {
        return $query->where("stock", "<", 2);
    }
}
