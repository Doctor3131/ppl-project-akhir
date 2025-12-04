<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProductRating extends Model
{
    protected $fillable = [
        "product_id",
        "visitor_name",
        "visitor_phone",
        "visitor_email",
        "province",
        "rating",
        "comment",
    ];

    protected $casts = [
        "rating" => "integer",
    ];

    /**
     * Get the product that owns the rating
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Scope untuk filter berdasarkan rating tertentu
     */
    public function scopeWithRating($query, $rating)
    {
        return $query->where("rating", $rating);
    }

    /**
     * Scope untuk mendapatkan rating terbaru
     */
    public function scopeLatest($query)
    {
        return $query->orderBy("created_at", "desc");
    }
}
