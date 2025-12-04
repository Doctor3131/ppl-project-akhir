# Seller Activation Status System (SRS-07)

## Overview

Sistem ini memisahkan **status persetujuan** (approval status) dari **status aktivitas** (activity status) untuk seller:

### Status Persetujuan (Approval Status)
- `pending` - Menunggu verifikasi admin
- `approved` - Disetujui oleh admin
- `rejected` - Ditolak oleh admin

### Status Aktivitas (Activity Status) - **SRS-07**
- `is_active = true` - Seller aktif (login dalam 30 hari terakhir)
- `is_active = false` - Seller non-aktif (tidak login > 30 hari, dinonaktifkan)

## Features

### 1. Login Tracking
- Setiap kali seller login, `last_login_at` diupdate otomatis
- Listener: `App\Listeners\UpdateLastLoginAt`

### 2. Auto-Deactivation
- Seller yang tidak login selama **30 hari** akan dinonaktifkan otomatis
- Email peringatan dikirim **H-7** (23 hari tidak login)
- Command: `php artisan sellers:check-activity`

### 3. Reactivation Request
- Seller yang dinonaktifkan dapat mengajukan reaktivasi
- Route: `/seller/reactivation`
- Admin harus menyetujui permintaan reaktivasi

### 4. Admin Management
- Admin dapat mengaktifkan/menonaktifkan seller manual
- Admin dapat melihat dan mengelola permintaan reaktivasi
- Route: `/admin/sellers/reactivation-requests`

## Database Fields (users table)

```php
$table->boolean('is_active')->default(true);
$table->timestamp('last_login_at')->nullable();
$table->timestamp('deactivated_at')->nullable();
$table->timestamp('reactivation_requested_at')->nullable();
$table->string('deactivation_reason')->nullable();
```

## Commands

### Check Seller Activity
```bash
# Dry run (no actual changes)
php artisan sellers:check-activity --dry-run

# Run with custom thresholds
php artisan sellers:check-activity --warning-days=23 --deactivate-days=30

# Normal run
php artisan sellers:check-activity
```

### Scheduled Task
Command dijadwalkan untuk berjalan setiap hari pukul 01:00 di `routes/console.php`.

## Routes

### Seller Routes
- `GET /seller/reactivation` - Halaman permintaan reaktivasi
- `POST /seller/reactivation` - Kirim permintaan reaktivasi

### Admin Routes
- `GET /admin/sellers/reactivation-requests` - Daftar permintaan reaktivasi
- `POST /admin/sellers/{id}/activate` - Aktifkan seller
- `POST /admin/sellers/{id}/deactivate` - Nonaktifkan seller
- `POST /admin/sellers/{id}/approve-reactivation` - Setujui reaktivasi
- `POST /admin/sellers/{id}/reject-reactivation` - Tolak reaktivasi

## Middleware

`seller.active` - Memastikan seller yang approved juga aktif (is_active = true)

```php
// Di routes/web.php
Route::middleware(['auth', 'seller', 'seller.active'])->group(function () {
    // Routes yang memerlukan seller aktif
});
```

## Email Notifications

1. **SellerInactivityWarning** - Dikirim H-7 sebelum auto-deactivation
2. **SellerDeactivated** - Dikirim saat akun dinonaktifkan
3. **SellerReactivated** - Dikirim saat akun direaktivasi

## Dashboard & Reports

### Admin Dashboard
- Chart baru: "Status Aktivitas Penjual" (Aktif vs Non-Aktif)
- Counter: Pending Reactivation Requests

### SRS-09 Report
- Laporan sekarang menampilkan **Status Persetujuan** DAN **Status Aktivitas**
- Filter berdasarkan kedua status
- PDF export dengan data lengkap

## Testing

```bash
# Test command
php artisan sellers:check-activity --dry-run

# Test routes
php artisan route:list --name=seller
php artisan route:list --name=admin.sellers
```
