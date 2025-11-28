<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SellerVerification extends Model
{
    use HasFactory;

    protected $table = "seller";

    protected $fillable = [
        "user_id",
        "shop_name",
        "shop_description",
        "pic_name",
        "pic_phone",
        "pic_email",
        "pic_ktp_number",
        "street_address",
        "rt",
        "rw",
        "kelurahan",
        "kota_kabupaten",
        "province",
        "pic_photo_path",
        "ktp_file_path",
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

    /**
     * Get full address
     */
    public function getFullAddressAttribute(): string
    {
        return sprintf(
            "%s, RT %s/RW %s, %s, %s, %s",
            $this->street_address,
            $this->rt,
            $this->rw,
            $this->kelurahan,
            $this->kota_kabupaten,
            $this->province,
        );
    }
}
