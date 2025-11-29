# SRS Implementation Documentation
## MartPlace - Platform E-Commerce

**Tanggal:** 29 November 2025  
**Versi:** 1.0.0

---

## 📋 Daftar Isi

1. [Ringkasan Implementasi](#ringkasan-implementasi)
2. [Requirement yang Diimplementasikan](#requirement-yang-diimplementasikan)
3. [Struktur Database](#struktur-database)
4. [Struktur File & Folder](#struktur-file--folder)
5. [API Routes](#api-routes)
6. [Testing Guide](#testing-guide)
7. [Troubleshooting](#troubleshooting)

---

## Ringkasan Implementasi

Project ini telah diperbarui untuk memenuhi seluruh kriteria SRS (Software Requirements Specification) MartPlace. Implementasi mencakup:

- ✅ Sistem katalog produk publik dengan fitur pencarian lengkap
- ✅ Sistem rating dan komentar untuk pengunjung umum
- ✅ Dashboard grafis untuk Admin dan Seller
- ✅ Sistem laporan lengkap untuk Admin dan Seller
- ✅ Notifikasi email otomatis
- ✅ Export data ke CSV

---

## Requirement yang Diimplementasikan

### Fungsionalitas Penjual (Seller) dan Platform

#### ✅ SRS-MartPlace-01: Registrasi sebagai penjual
**Status:** IMPLEMENTED (sudah ada sebelumnya)

**Elemen Data:**
- Nama toko (`shop_name`)
- Deskripsi singkat (`shop_description`)
- Nama PIC (`pic_name`)
- No Handphone PIC (`pic_phone`)
- Email PIC (`pic_email`)
- Alamat (nama jalan) PIC (`street_address`)
- RT (`rt`)
- RW (`rw`)
- Nama kelurahan (`kelurahan`)
- Kabupaten/Kota (`kota_kabupaten`)
- Propinsi (`province`)
- No. KTP PIC (`pic_ktp_number`)
- Foto PIC (`pic_photo_path`)
- File upload KTP PIC (`ktp_file_path`)

**Lokasi File:**
- Model: `app/Models/SellerVerification.php`
- Migration: `database/migrations/2025_11_28_044740_add_seller_details_to_seller_table.php`

---

#### ✅ SRS-MartPlace-02: Verifikasi registrasi penjual
**Status:** IMPLEMENTED (sudah ada sebelumnya)

**Fitur:**
- Admin dapat melihat daftar seller yang pending
- Admin dapat approve atau reject seller
- Notifikasi email dikirim ke seller setelah verifikasi
- Email berisi informasi aktivasi akun (jika diterima) atau alasan penolakan (jika ditolak)

**Lokasi File:**
- Controller: `app/Http/Controllers/Admin/SellerController.php`
- Views: `resources/views/admin/sellers/`

---

#### ✅ SRS-MartPlace-03: Upload produk oleh penjual
**Status:** IMPLEMENTED (sudah ada sebelumnya)

**Elemen Data Produk:**
- Nama produk (`name`)
- Deskripsi (`description`)
- Kategori (`category_id`)
- Harga (`price`)
- Stok (`stock`)
- Gambar produk (`image`)

**Lokasi File:**
- Controller: `app/Http/Controllers/Seller/ProductController.php`
- Model: `app/Models/Product.php`
- Views: `resources/views/seller/products/`

---

### Fungsionalitas Katalog Produk dan Pengunjung

#### ✅ SRS-MartPlace-04: Katalog produk untuk pengunjung umum
**Status:** NEWLY IMPLEMENTED ✨

**Fitur:**
- Katalog dapat diakses tanpa login
- Menampilkan semua produk dari seller yang approved
- Setiap produk menampilkan:
  - Gambar produk
  - Nama produk
  - Harga
  - Rating rata-rata
  - Jumlah komentar/rating
  - Nama toko
  - Lokasi toko (kota/kabupaten, provinsi)
  - Status stok

**Lokasi File:**
- Controller: `app/Http/Controllers/CatalogController.php`
- Views: 
  - `resources/views/catalog/index.blade.php` (list produk)
  - `resources/views/catalog/show.blade.php` (detail produk)
- Routes: `routes/web.php` (lines ~18-26)

**URLs:**
- Katalog: `GET /catalog`
- Detail Produk: `GET /catalog/{product}`

---

#### ✅ SRS-MartPlace-05: Pencarian produk
**Status:** NEWLY IMPLEMENTED ✨

**Filter yang Tersedia:**
1. **Nama Produk** - Pencarian berdasarkan nama produk (LIKE search)
2. **Nama Toko** - Pencarian berdasarkan nama toko (LIKE search)
3. **Kategori Produk** - Filter berdasarkan kategori
4. **Kota/Kabupaten** - Filter berdasarkan lokasi toko (kota/kabupaten)
5. **Provinsi** - Filter berdasarkan lokasi toko (provinsi)

**Sorting Options:**
- Terbaru (default)
- Harga terendah
- Harga tertinggi
- Nama A-Z
- Nama Z-A
- Rating tertinggi

**Lokasi Implementasi:**
- Controller: `app/Http/Controllers/CatalogController.php` method `index()`
- View: `resources/views/catalog/index.blade.php` (filter section)

**Contoh Query:**
```
GET /catalog?search=laptop&category_id=1&province=Jawa%20Barat&sort=price_asc
```

---

#### ✅ SRS-MartPlace-06: Pemberian komentar dan rating
**Status:** NEWLY IMPLEMENTED ✨

**Fitur:**
- Pengunjung dapat memberikan rating (1-5 bintang)
- Pengunjung dapat memberikan komentar (opsional)
- Wajib mengisi: Nama, Nomor HP, Email
- Setelah submit, pengunjung menerima email ucapan terima kasih
- Rating dan komentar langsung ditampilkan di halaman produk

**Validasi:**
- `visitor_name`: required, string, max 255
- `visitor_phone`: required, string, max 20
- `visitor_email`: required, email, max 255
- `rating`: required, integer, min 1, max 5
- `comment`: optional, string, max 1000

**Lokasi File:**
- Controller: `app/Http/Controllers/RatingController.php`
- Model: `app/Models/ProductRating.php`
- Migration: `database/migrations/2025_11_29_040653_create_product_ratings_table.php`
- Email Template: `resources/views/emails/rating-thankyou.blade.php`
- View (form): `resources/views/catalog/show.blade.php` (rating form section)

**Database Table: `product_ratings`**
```
- id (bigint, primary key)
- product_id (foreign key to products)
- visitor_name (string)
- visitor_phone (string, max 20)
- visitor_email (string)
- rating (integer, 1-5)
- comment (text, nullable)
- created_at, updated_at
```

**URL:**
- Submit Rating: `POST /products/{product}/rating`

---

### Fungsionalitas Dashboard (Grafis)

#### ✅ SRS-MartPlace-07: Dashboard grafis untuk platform (Admin)
**Status:** NEWLY IMPLEMENTED ✨

**Grafik/Data yang Ditampilkan:**

1. **Sebaran jumlah produk berdasarkan kategori**
   - Data: `$productsByCategory`
   - Format: Collection dengan `category_name` dan `total`

2. **Sebaran jumlah toko berdasarkan lokasi provinsi**
   - Data: `$sellersByProvince`
   - Format: Collection dengan `province` dan `total`

3. **Jumlah user penjual aktif dan tidak aktif**
   - Data: `$sellerStatusData`
   - Format: Array dengan keys: `active`, `pending`, `rejected`

4. **Jumlah pengunjung yang memberikan komentar dan rating**
   - Data: `$ratingsData`
   - Format: Array dengan keys:
     - `total_ratings`: Total semua rating
     - `unique_visitors`: Jumlah visitor unik (berdasarkan email)
     - `with_comment`: Rating yang memiliki komentar
     - `without_comment`: Rating tanpa komentar

**Data Tambahan:**
- Rating distribution (1-5 stars)
- Recent ratings (5 terbaru)
- Recent products (5 terbaru)
- Top rated products (5 teratas)
- Monthly trends (6 bulan terakhir)

**Lokasi File:**
- Controller: `app/Http/Controllers/Admin/DashboardController.php`
- View: `resources/views/admin/dashboard.blade.php`

**URL:**
- Dashboard Admin: `GET /admin/dashboard`

**Rekomendasi Library untuk Visualisasi:**
- Chart.js (https://www.chartjs.org/)
- ApexCharts (https://apexcharts.com/)
- Google Charts (https://developers.google.com/chart)

---

#### ✅ SRS-MartPlace-08: Dashboard grafis untuk penjual (Seller)
**Status:** NEWLY IMPLEMENTED ✨

**Grafik/Data yang Ditampilkan:**

1. **Sebaran jumlah stok setiap produk**
   - Data: `$stockByProduct`
   - Format: Collection dengan `id`, `name`, `stock`, `price`, `category`

2. **Sebaran nilai rating per produk**
   - Data: `$ratingByProduct`
   - Format: Collection dengan `id`, `name`, `average_rating`, `rating_count`, `category`
   - Diurutkan berdasarkan rating tertinggi

3. **Sebaran pemberi rating berdasarkan lokasi provinsi**
   - Data: `$ratingsByProvince`
   - Format: Collection dengan `domain` (email domain) dan `total`
   - Note: Karena visitor tidak login, lokasi diambil dari domain email

**Data Tambahan:**
- Rating distribution (1-5 stars) untuk produk seller
- Stock distribution by category
- Recent ratings (5 terbaru)
- Low stock products (stock < 2)
- Monthly trends (6 bulan terakhir)
- Average rating by month
- Top rated products milik seller

**Statistik Dasar:**
- Total produk
- Total stok
- Jumlah produk low stock
- Total rating yang diterima

**Lokasi File:**
- Controller: `app/Http/Controllers/Seller/DashboardController.php`
- View: `resources/views/seller/dashboard.blade.php`

**URL:**
- Dashboard Seller: `GET /seller/dashboard`

---

### Fungsionalitas Laporan

#### Laporan untuk Platform (Admin)

#### ✅ SRS-MartPlace-09: Laporan daftar akun penjual aktif dan tidak aktif
**Status:** NEWLY IMPLEMENTED ✨

**Fitur:**
- Menampilkan semua akun penjual dengan status
- Filter berdasarkan status: All, Approved, Pending, Rejected
- Statistik: Total, Active, Pending, Rejected
- Export ke CSV

**Kolom Laporan:**
- No
- Nama
- Email
- Nama Toko
- No. HP
- Status (Aktif/Pending/Tidak Aktif)
- Tanggal Registrasi
- Aksi (Link ke detail)

**Lokasi File:**
- Controller: `app/Http/Controllers/Admin/ReportController.php`
- Method: `sellerAccounts()`, `exportSellerAccounts()`
- View: `resources/views/admin/reports/seller-accounts.blade.php`

**URL:**
- View Report: `GET /admin/reports/seller-accounts`
- Export CSV: `GET /admin/reports/seller-accounts/export`

---

#### ✅ SRS-MartPlace-10: Laporan daftar penjual (toko) untuk setiap lokasi provinsi
**Status:** NEWLY IMPLEMENTED ✨

**Fitur:**
- Menampilkan daftar toko/seller yang approved per provinsi
- Filter berdasarkan provinsi
- Statistik per provinsi
- Export ke CSV

**Kolom Laporan:**
- No
- Nama Toko
- PIC (Person In Charge)
- Email
- Telepon
- Provinsi
- Kota/Kabupaten
- Alamat Lengkap (jalan, RT/RW, kelurahan)

**Lokasi File:**
- Controller: `app/Http/Controllers/Admin/ReportController.php`
- Method: `sellersByProvince()`, `exportSellersByProvince()`
- View: `resources/views/admin/reports/sellers-by-province.blade.php`

**URL:**
- View Report: `GET /admin/reports/sellers-by-province`
- Export CSV: `GET /admin/reports/sellers-by-province/export`

---

#### ✅ SRS-MartPlace-11: Laporan daftar produk dan ratingnya
**Status:** NEWLY IMPLEMENTED ✨

**Fitur:**
- Menampilkan produk diurutkan berdasarkan rating (descending)
- Filter berdasarkan kategori dan provinsi
- Menampilkan rata-rata rating dan jumlah rating
- Export ke CSV

**Kolom Laporan:**
- No
- Nama Produk
- Nama Toko
- Kategori
- Harga
- Rating (rata-rata)
- Jumlah Rating
- Provinsi

**Lokasi File:**
- Controller: `app/Http/Controllers/Admin/ReportController.php`
- Method: `productsByRating()`, `exportProductsByRating()`
- View: `resources/views/admin/reports/products-by-rating.blade.php`

**URL:**
- View Report: `GET /admin/reports/products-by-rating`
- Export CSV: `GET /admin/reports/products-by-rating/export`

---

#### Laporan untuk Penjual (Seller)

#### ✅ SRS-MartPlace-12: Laporan daftar stock produk (diurutkan berdasarkan stock)
**Status:** NEWLY IMPLEMENTED ✨

**Fitur:**
- Menampilkan produk milik seller diurutkan berdasarkan stock (descending)
- Filter berdasarkan kategori
- Menampilkan rating, kategori, dan harga
- Statistik: Total produk, Total stock, Low stock count, Out of stock count
- Export ke CSV

**Kolom Laporan:**
- No
- Nama Produk
- Kategori
- Harga
- Stock
- Rating (rata-rata)
- Jumlah Rating

**Lokasi File:**
- Controller: `app/Http/Controllers/Seller/ReportController.php`
- Method: `stockReport()`, `exportStockReport()`
- View: `resources/views/seller/reports/stock.blade.php`

**URL:**
- View Report: `GET /seller/reports/stock`
- Export CSV: `GET /seller/reports/stock/export`

---

#### ✅ SRS-MartPlace-13: Laporan daftar stock produk (diurutkan berdasarkan rating)
**Status:** NEWLY IMPLEMENTED ✨

**Fitur:**
- Menampilkan produk milik seller diurutkan berdasarkan rating (descending)
- Filter berdasarkan kategori
- Menampilkan stock, kategori, dan harga
- Statistik: Total produk, Average rating, Total ratings, Products with ratings
- Export ke CSV

**Kolom Laporan:**
- No
- Nama Produk
- Kategori
- Harga
- Stock
- Rating (rata-rata)
- Jumlah Rating

**Lokasi File:**
- Controller: `app/Http/Controllers/Seller/ReportController.php`
- Method: `ratingReport()`, `exportRatingReport()`
- View: `resources/views/seller/reports/rating.blade.php`

**URL:**
- View Report: `GET /seller/reports/rating`
- Export CSV: `GET /seller/reports/rating/export`

---

#### ✅ SRS-MartPlace-14: Laporan stock barang yang harus segera dipesan
**Status:** NEWLY IMPLEMENTED ✨

**Fitur:**
- Menampilkan produk dengan stock < 2 (kriteria: segera dipesan)
- Filter berdasarkan kategori
- Diurutkan berdasarkan stock (ascending) - yang paling kritis di atas
- Status: "Habis" (stock = 0) atau "Segera Habis" (stock = 1)
- Statistik: Low stock count, Out of stock, Stock 1, Total value
- Export ke CSV

**Kolom Laporan:**
- No
- Nama Produk
- Kategori
- Harga
- Stock
- Rating (rata-rata)
- Jumlah Rating
- Status (Habis/Segera Habis)

**Lokasi File:**
- Controller: `app/Http/Controllers/Seller/ReportController.php`
- Method: `lowStockReport()`, `exportLowStockReport()`
- View: `resources/views/seller/reports/low-stock.blade.php`

**URL:**
- View Report: `GET /seller/reports/low-stock`
- Export CSV: `GET /seller/reports/low-stock/export`

---

## Struktur Database

### Tabel Baru

#### 1. `product_ratings`
Table untuk menyimpan rating dan komentar dari pengunjung.

```sql
CREATE TABLE product_ratings (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    product_id BIGINT NOT NULL,
    visitor_name VARCHAR(255) NOT NULL,
    visitor_phone VARCHAR(20) NOT NULL,
    visitor_email VARCHAR(255) NOT NULL,
    rating INTEGER NOT NULL DEFAULT 5,
    comment TEXT NULL,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    
    FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE,
    INDEX idx_product_id (product_id),
    INDEX idx_rating (rating)
);
```

**Relasi:**
- `product_ratings.product_id` → `products.id` (Many-to-One)

---

### Tabel yang Sudah Ada (Updated)

#### 1. `users`
Tabel untuk user authentication (Admin dan Seller).

**Roles:**
- `admin` - Administrator platform
- `seller` - Penjual/Toko

**Status:**
- `pending` - Menunggu verifikasi
- `approved` - Disetujui (aktif)
- `rejected` - Ditolak

---

#### 2. `seller` (SellerVerification)
Tabel untuk menyimpan detail informasi seller/toko.

**Kolom Utama:**
- `user_id` (FK to users)
- `shop_name` - Nama toko
- `shop_description` - Deskripsi toko
- `pic_name` - Nama PIC
- `pic_phone` - No HP PIC
- `pic_email` - Email PIC
- `pic_ktp_number` - No KTP PIC
- `street_address` - Alamat jalan
- `rt` - RT
- `rw` - RW
- `kelurahan` - Kelurahan
- `kota_kabupaten` - Kota/Kabupaten
- `province` - Provinsi
- `pic_photo_path` - Path foto PIC
- `ktp_file_path` - Path file KTP
- `status` - Status verifikasi
- `rejection_reason` - Alasan penolakan (jika ditolak)
- `verified_at` - Timestamp verifikasi

---

#### 3. `products`
Tabel untuk menyimpan produk yang dijual oleh seller.

**Kolom Utama:**
- `user_id` (FK to users) - Pemilik produk (seller)
- `category_id` (FK to categories)
- `name` - Nama produk
- `description` - Deskripsi produk
- `price` - Harga (decimal 10,2)
- `stock` - Jumlah stok
- `image` - Path gambar produk

**Methods Tambahan di Model:**
- `averageRating()` - Menghitung rata-rata rating
- `ratingCount()` - Menghitung jumlah rating
- `isLowStock()` - Mengecek apakah stok rendah (< 2)

---

#### 4. `categories`
Tabel untuk kategori produk.

**Kolom:**
- `id`
- `name` - Nama kategori
- `description` - Deskripsi kategori

---

### Diagram ERD Relasi

```
users (1) ----< (1) seller
users (1) ----< (*) products
categories (1) ----< (*) products
products (1) ----< (*) product_ratings
```

---

## Struktur File & Folder

### Controllers

```
app/Http/Controllers/
├── CatalogController.php              # Katalog publik (SRS-04, 05)
├── RatingController.php                # Rating & komentar (SRS-06)
├── HomeController.php                  # Homepage
├── Admin/
│   ├── DashboardController.php         # Dashboard admin (SRS-07)
│   ├── ReportController.php            # Laporan admin (SRS-09, 10, 11)
│   ├── SellerController.php            # Manajemen seller (SRS-02)
│   └── CategoryController.php          # Manajemen kategori
└── Seller/
    ├── DashboardController.php         # Dashboard seller (SRS-08)
    ├── ProductController.php           # Manajemen produk (SRS-03)
    └── ReportController.php            # Laporan seller (SRS-12, 13, 14)
```

### Models

```
app/Models/
├── User.php                            # User model
├── SellerVerification.php              # Seller/toko model
├── Product.php                         # Produk model
├── ProductRating.php                   # Rating model (NEW)
└── Category.php                        # Kategori model
```

### Views

```
resources/views/
├── catalog/                            # NEW
│   ├── index.blade.php                 # Katalog produk (SRS-04, 05)
│   └── show.blade.php                  # Detail produk + rating form (SRS-06)
├── emails/                             # NEW
│   └── rating-thankyou.blade.php       # Email terima kasih (SRS-06)
├── admin/
│   ├── dashboard.blade.php             # Dashboard admin (SRS-07)
│   ├── reports/                        # NEW
│   │   ├── seller-accounts.blade.php   # Laporan SRS-09
│   │   ├── sellers-by-province.blade.php # Laporan SRS-10
│   │   └── products-by-rating.blade.php  # Laporan SRS-11
│   └── sellers/
│       ├── index.blade.php             # List seller
│       └── show.blade.php              # Detail seller
└── seller/
    ├── dashboard.blade.php             # Dashboard seller (SRS-08)
    ├── products/                       # Manajemen produk
    │   ├── index.blade.php
    │   ├── create.blade.php
    │   └── edit.blade.php
    └── reports/                        # NEW
        ├── stock.blade.php             # Laporan SRS-12
        ├── rating.blade.php            # Laporan SRS-13
        └── low-stock.blade.php         # Laporan SRS-14
```

### Migrations

```
database/migrations/
├── 2025_11_27_075952_create_seller_table.php
├── 2025_11_28_044740_add_seller_details_to_seller_table.php
├── 2025_11_27_093318_create_categories_table.php
├── 2025_11_27_093325_create_products_table.php
└── 2025_11_29_040653_create_product_ratings_table.php  # NEW
```

---

## API Routes

### Public Routes (No Authentication)

```php
// Homepage
GET  /                              HomeController@index

// Catalog (SRS-04, 05)
GET  /catalog                       CatalogController@index
GET  /catalog/{product}             CatalogController@show

// Rating (SRS-06)
POST /products/{product}/rating     RatingController@store
```

### Admin Routes (Requires admin role)

```php
// Dashboard (SRS-07)
GET  /admin/dashboard               Admin\DashboardController@index

// Seller Management (SRS-02)
GET  /admin/sellers                 Admin\SellerController@index
GET  /admin/sellers/{id}            Admin\SellerController@show
POST /admin/sellers/{id}/approve    Admin\SellerController@approve
POST /admin/sellers/{id}/reject     Admin\SellerController@reject

// Reports (SRS-09, 10, 11)
GET  /admin/reports/seller-accounts              Admin\ReportController@sellerAccounts
GET  /admin/reports/seller-accounts/export       Admin\ReportController@exportSellerAccounts
GET  /admin/reports/sellers-by-province          Admin\ReportController@sellersByProvince
GET  /admin/reports/sellers-by-province/export   Admin\ReportController@exportSellersByProvince
GET  /admin/reports/products-by-rating           Admin\ReportController@productsByRating
GET  /admin/reports/products-by-rating/export    Admin\ReportController@exportProductsByRating

// Category Management
GET  /admin/categories              Admin\CategoryController@index
POST /admin/categories              Admin\CategoryController@store
PUT  /admin/categories/{id}         Admin\CategoryController@update
DELETE /admin/categories/{id}       Admin\CategoryController@destroy
```

### Seller Routes (Requires seller role & approved status)

```php
// Dashboard (SRS-08)
GET  /seller/dashboard              Seller\DashboardController@index

// Product Management (SRS-03)
GET  /seller/products               Seller\ProductController@index
GET  /seller/products/create        Seller\ProductController@create
POST /seller/products               Seller\ProductController@store
GET  /seller/products/{id}/edit     Seller\ProductController@edit
PUT  /seller/products/{id}          Seller\ProductController@update
DELETE /seller/products/{id}        Seller\ProductController@destroy

// Reports (SRS-12, 13, 14)
GET  /seller/reports/stock                Seller\ReportController@stockReport
GET  /seller/reports/stock/export         Seller\ReportController@exportStockReport
GET  /seller/reports/rating               Seller\ReportController@ratingReport
GET  /seller/reports/rating/export        Seller\ReportController@exportRatingReport
GET  /seller/reports/low-stock            Seller\ReportController@lowStockReport
GET  /seller/reports/low-stock/export     Seller\ReportController@exportLowStockReport
```

---

## Testing Guide

### 1. Setup Testing Environment

```bash
# Pastikan database sudah ter-setup
php artisan migrate:fresh --seed

# Jalankan server
composer run dev
# atau
php artisan serve
```

### 2. Test SRS-04: Katalog Produk Publik

**Test Case 1: Akses katalog tanpa login**
1. Buka browser
2. Akses: `http://127.0.0.1:8000/catalog`
3. **Expected:** Halaman katalog muncul tanpa perlu login

**Test Case 2: View product detail**
1. Klik salah satu produk di katalog
2. **Expected:** Halaman detail produk muncul dengan:
   - Gambar produk
   - Nama, harga, stock
   - Rating dan komentar
   - Informasi toko
   - Form untuk beri rating

### 3. Test SRS-05: Pencarian Produk

**Test Case 1: Search by product name**
1. Di halaman katalog, isi field "Cari Produk"
2. Klik tombol "Cari"
3. **Expected:** Produk yang sesuai ditampilkan

**Test Case 2: Filter by category**
1. Pilih kategori dari dropdown
2. Klik tombol "Cari"
3. **Expected:** Hanya produk dari kategori tersebut yang muncul

**Test Case 3: Filter by location**
1. Pilih provinsi dan/atau kota
2. Klik tombol "Cari"
3. **Expected:** Produk dari toko di lokasi tersebut yang muncul

**Test Case 4: Sort by rating**
1. Pilih "Rating Tertinggi" dari dropdown sort
2. Klik tombol "Cari"
3. **Expected:** Produk diurutkan dari rating tertinggi ke terendah

### 4. Test SRS-06: Rating & Komentar

**Test Case 1: Submit rating tanpa komentar**
1. Di halaman detail produk, scroll ke form rating
2. Isi: Nama, HP, Email
3. Pilih rating (1-5 bintang)
4. Klik "Kirim Rating & Komentar"
5. **Expected:** 
   - Success message muncul
   - Email terima kasih dikirim
   - Rating muncul di list komentar

**Test Case 2: Submit rating dengan komentar**
1. Ulangi langkah di atas, tapi isi juga field komentar
2. **Expected:**
   - Success message muncul
   - Email terima kasih dikirim dengan komentar
   - Rating dan komentar muncul di list

**Test Case 3: Validation error**
1. Submit form tanpa mengisi field wajib
2. **Expected:** Error validation muncul

### 5. Test SRS-07: Dashboard Admin

**Test Login Admin:**
- Email: `admin@martplace.com` (sesuaikan dengan seeder Anda)
- Password: (sesuaikan)

**Test Dashboard:**
1. Login sebagai admin
2. Akses: `/admin/dashboard`
3. **Expected:** Dashboard menampilkan:
   - Statistik: Total seller, produk, kategori
   - Chart produk per kategori
   - Chart seller per provinsi
   - Chart status seller (aktif/pending/rejected)
   - Data rating dan komentar
   - Recent activities

### 6. Test SRS-08: Dashboard Seller

**Test Login Seller:**
1. Login sebagai seller yang sudah approved
2. Akses: `/seller/dashboard`
3. **Expected:** Dashboard menampilkan:
   - Statistik produk dan stock
   - Chart stock per produk
   - Chart rating per produk
   - Low stock alerts
   - Recent ratings

### 7. Test SRS-09: Laporan Akun Penjual

1. Login sebagai admin
2. Akses: `/admin/reports/seller-accounts`
