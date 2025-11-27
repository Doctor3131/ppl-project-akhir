<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SellerVerification extends Model
{
    use HasFactory;

    protected $fillable = [
        "user_id",
        "ktp_number",
        "face_photo_path",
        "ktp_photo_path",
        "address",
        "status",
        "rejection_reason",
        "verified_at",
    ];

    protected $casts = [
        "verified_at" => "datetime",
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function isApproved(): bool
    {
        return $this->status === "approved";
    }

    public function isPending(): bool
    {
        return $this->status === "pending";
    }

    public function isRejected(): bool
    {
        return $this->status === "rejected";
    }
}
