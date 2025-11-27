# Quick Start Guide - E-Commerce Multi Vendor

## Setup Cepat

### 1. Konfigurasi Database

Edit file `.env`:

```env
DB_CONNECTION=pgsql
DB_HOST=127.0.0.1
DB_PORT=5432
DB_DATABASE=ecommerce_multivendor
DB_USERNAME=postgres
DB_PASSWORD=your_password
```

Buat database:

```bash
psql -U postgres -c "CREATE DATABASE ecommerce_multivendor;"
```

### 2. Install & Setup

```bash
# Install dependencies
composer install
npm install

# Setup aplikasi
php artisan key:generate
php artisan migrate:fresh --seed
php artisan storage:link

# Build assets
npm run build
```

### 3. Jalankan Aplikasi

```bash
php artisan serve
```

Buka browser: `http://localhost:8000`

## Akun Default

**Admin:**
- Email: `admin@example.com`
- Password: `password`

## Testing Flow

### 1. Test Admin (5 menit)
1. Login sebagai admin
2. Lihat dashboard dengan statistik
3. Klik "Manage Categories" dan coba tambah kategori baru
4. Klik "Manage Sellers" untuk lihat daftar seller

### 2. Test Register Seller (3 menit)
1. Logout dari admin
2. Klik "Register as Seller"
3. Isi form registrasi
4. Coba login (akan gagal karena pending)
5. Login lagi sebagai admin
6. Approve seller yang baru didaftarkan
7. Logout dan login sebagai seller yang sudah di-approve

### 3. Test Seller Dashboard (5 menit)
1. Login sebagai seller
2. Klik "Add New Product"
3. Isi form produk (nama, kategori, harga, stok)
4. Upload gambar produk
5. Submit
6. Edit produk yang baru dibuat
7. Lihat produk di dashboard

### 4. Test Public Catalog (3 menit)
1. Logout
2. Klik logo "E-Commerce" atau buka home
3. Lihat produk yang ditambahkan tadi
4. Coba search produk
5. Coba filter by category
6. Klik produk untuk lihat detail

## Fitur Utama

### Pengunjung (Tanpa Login)
- ✅ Browse katalog produk
- ✅ Search produk
- ✅ Filter by category
- ✅ Lihat detail produk
- ❌ Tidak ada wishlist, cart, checkout

### Seller
- ✅ Register (pending approval)
- ✅ Dashboard dengan list produk
- ✅ CRUD produk (Create, Read, Update, Delete)
- ✅ Upload gambar produk

### Admin
- ✅ Dashboard dengan statistik
- ✅ Approve/reject seller
- ✅ CRUD kategori
- ✅ View semua seller

## Struktur Role

```
┌─────────────────┐
│   Pengunjung    │ → Browse catalog, search, filter, view detail
└─────────────────┘

┌─────────────────┐
│     Seller      │ → Register → Pending → Admin Approve → Can manage products
└─────────────────┘

┌─────────────────┐
│      Admin      │ → Manage categories, approve sellers, view stats
└─────────────────┘
```

## Routes Penting

```
/                         → Katalog produk (public)
/login                    → Login page
/register                 → Register seller page
/seller/dashboard         → Seller dashboard (need login + approved)
/seller/products/create   → Add product form
/admin/dashboard          → Admin dashboard (need login as admin)
/admin/categories         → Manage categories
/admin/sellers            → Manage sellers
```

## Troubleshooting Cepat

### Database connection failed
```bash
# Check PostgreSQL running
sudo systemctl status postgresql
sudo systemctl start postgresql
```

### Image tidak muncul
```bash
# Recreate storage link
rm public/storage
php artisan storage:link
chmod -R 775 storage
```

### Cache error
```bash
php artisan config:clear
php artisan cache:clear
php artisan view:clear
composer dump-autoload
```

## Tips Development

1. **Hot Reload Assets:** Gunakan `npm run dev` di terminal terpisah
2. **Debug:** Check `storage/logs/laravel.log` untuk error
3. **Database Reset:** `php artisan migrate:fresh --seed` untuk reset database
4. **Test Email:** Tidak ada email verification, langsung bisa login setelah approved

## Next Steps

Setelah setup berhasil:

1. Login sebagai admin dan tambah beberapa kategori
2. Register beberapa akun seller dummy
3. Approve seller tersebut
4. Login sebagai seller dan tambah produk
5. Lihat produk muncul di katalog publik

Selamat mencoba! 🚀