<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;
use Laravel\Fortify\TwoFactorAuthenticatable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, TwoFactorAuthenticatable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        "name",
        "email",
        "password",
        "role",
        "status",
        "is_active",
        "last_login_at",
        "deactivated_at",
        "reactivation_requested_at",
        "deactivation_reason",
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        "password",
        "two_factor_secret",
        "two_factor_recovery_codes",
        "remember_token",
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            "email_verified_at" => "datetime",
            "password" => "hashed",
            "is_active" => "boolean",
            "last_login_at" => "datetime",
            "deactivated_at" => "datetime",
            "reactivation_requested_at" => "datetime",
        ];
    }

    /**
     * Check if user is admin
     */
    public function isAdmin(): bool
    {
        return $this->role === "admin";
    }

    /**
     * Check if user is seller
     */
    public function isSeller(): bool
    {
        return $this->role === "seller";
    }

    /**
     * Check if user is approved
     */
    public function isApproved(): bool
    {
        return $this->status === "approved";
    }

    /**
     * Check if user/seller is active (separate from approval status)
     */
    public function isActive(): bool
    {
        return $this->is_active === true;
    }

    /**
     * Check if user/seller is deactivated
     */
    public function isDeactivated(): bool
    {
        return $this->is_active === false;
    }

    /**
     * Check if seller has pending reactivation request
     */
    public function hasRequestedReactivation(): bool
    {
        return $this->reactivation_requested_at !== null;
    }

    /**
     * Check if seller can access dashboard (approved AND active)
     */
    public function canAccessSellerDashboard(): bool
    {
        return $this->isSeller() && $this->isApproved() && $this->isActive();
    }

    /**
     * Scope for active users
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope for inactive/deactivated users
     */
    public function scopeInactive($query)
    {
        return $query->where('is_active', false);
    }

    /**
     * Scope for sellers with pending reactivation requests
     */
    public function scopePendingReactivation($query)
    {
        return $query->where('is_active', false)
                     ->whereNotNull('reactivation_requested_at');
    }

    /**
     * Get the seller details
     */
    public function seller(): HasOne
    {
        return $this->hasOne(SellerVerification::class);
    }

    /**
     * Get the products for the seller
     */
    public function products()
    {
        return $this->hasMany(Product::class);
    }

    /**
     * Get the user's initials
     */
    public function initials(): string
    {
        return Str::of($this->name)
            ->explode(" ")
            ->take(2)
            ->map(fn($word) => Str::substr($word, 0, 1))
            ->implode("");
    }
}
