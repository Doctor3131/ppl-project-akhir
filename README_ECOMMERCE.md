# E-Commerce Multi Vendor Application

Aplikasi e-commerce multi vendor berbasis Laravel dengan PostgreSQL sebagai database. Aplikasi ini memiliki 2 role utama: **Admin** dan **Penjual (Seller)**.

## Fitur Utama

### Halaman Publik (Pengunjung)
- ✅ Melihat katalog produk
- ✅ Mencari produk berdasarkan nama atau deskripsi
- ✅ Filter produk berdasarkan kategori
- ✅ Melihat detail produk
- ❌ Tidak ada fitur wishlist dan keranjang
- ❌ Tidak ada fitur checkout

### Penjual (Seller)
- ✅ Register akun seller (menunggu approval admin)
- ✅ Login ke dashboard seller
- ✅ Menambah produk baru
- ✅ Edit produk yang sudah dibuat
- ✅ Hapus produk
- ✅ Upload gambar produk
- ✅ Melihat daftar produk yang dimiliki

### Admin
- ✅ Login ke dashboard admin
- ✅ Melihat statistik (pending sellers, approved sellers, total products, total categories)
- ✅ Approve/reject registrasi seller
- ✅ Menambah kategori produk
- ✅ Edit kategori produk
- ✅ Hapus kategori produk
- ✅ Melihat daftar seller

## Teknologi yang Digunakan

- **Backend:** Laravel 12
- **Database:** PostgreSQL
- **Frontend:** Blade Templates + Tailwind CSS
- **Authentication:** Laravel Fortify
- **File Storage:** Laravel Storage (public disk)

## Requirement

- PHP >= 8.2
- Composer
- Node.js & NPM
- PostgreSQL >= 12

## Instalasi

### 1. Clone Repository

```bash
cd ppl-project-akhir
```

### 2. Install Dependencies

```bash
# Install PHP dependencies
composer install

# Install Node dependencies
npm install
```

### 3. Setup Environment

Copy file `.env.example` ke `.env`:

```bash
cp .env.example .env
```

Generate application key:

```bash
php artisan key:generate
```

### 4. Konfigurasi Database PostgreSQL

Edit file `.env` dan sesuaikan dengan konfigurasi PostgreSQL Anda:

```env
DB_CONNECTION=pgsql
DB_HOST=127.0.0.1
DB_PORT=5432
DB_DATABASE=ecommerce_multivendor
DB_USERNAME=postgres
DB_PASSWORD=your_password
```

Buat database PostgreSQL baru:

```bash
# Login ke PostgreSQL
psql -U postgres

# Buat database
CREATE DATABASE ecommerce_multivendor;

# Keluar dari PostgreSQL
\q
```

### 5. Run Migration & Seeder

Jalankan migration untuk membuat tabel:

```bash
php artisan migrate
```

Jalankan seeder untuk membuat admin default:

```bash
php artisan db:seed --class=AdminSeeder
```

### 6. Setup Storage Link

Buat symbolic link untuk storage:

```bash
php artisan storage:link
```

### 7. Build Assets

Compile frontend assets:

```bash
# Development
npm run dev

# Production
npm run build
```

### 8. Jalankan Aplikasi

```bash
php artisan serve
```

Aplikasi akan berjalan di: `http://localhost:8000`

## Akun Default

### Admin
- **Email:** admin@example.com
- **Password:** password

## Struktur Database

### Users Table
- `id` - Primary Key
- `name` - Nama user
- `email` - Email (unique)
- `password` - Password (hashed)
- `role` - Enum: admin, seller
- `status` - Enum: pending, approved, rejected
- `email_verified_at` - Timestamp
- `remember_token` - Token
- `created_at`, `updated_at` - Timestamps

### Categories Table
- `id` - Primary Key
- `name` - Nama kategori
- `description` - Deskripsi kategori (nullable)
- `created_at`, `updated_at` - Timestamps

### Products Table
- `id` - Primary Key
- `user_id` - Foreign Key ke users
- `category_id` - Foreign Key ke categories
- `name` - Nama produk
- `description` - Deskripsi produk (nullable)
- `price` - Harga produk (decimal)
- `stock` - Stok produk (integer)
- `image` - Path gambar (nullable)
- `created_at`, `updated_at` - Timestamps

## Routes

### Public Routes
- `GET /` - Redirect ke katalog (`/catalog`)
- `GET /catalog` - Halaman katalog produk dengan filter dan search
- `GET /catalog/{product}` - Detail produk
- `GET /login` - Halaman login
- `POST /login` - Proses login
- `GET /register` - Halaman register seller (Step 1)
- `POST /register` - Proses register seller
- `GET /complete-profile` - Lengkapi profil seller (Step 2)
- `POST /complete-profile` - Simpan profil seller

### API Routes (Location)
- `GET /api/location/cities/{provinceId}` - Get cities by province ID
- `GET /api/location/districts/{cityId}` - Get districts by city ID
- `GET /api/location/villages/{districtId}` - Get villages by district ID
- `GET /api/location/seller-cities?province=NAME` - Get cities from approved sellers

### Seller Routes (Middleware: auth, seller)
- `GET /seller/dashboard` - Dashboard seller
- `GET /seller/products` - Daftar produk seller
- `GET /seller/products/create` - Form tambah produk
- `POST /seller/products` - Simpan produk baru
- `GET /seller/products/{id}/edit` - Form edit produk
- `PUT /seller/products/{id}` - Update produk
- `DELETE /seller/products/{id}` - Hapus produk

### Admin Routes (Middleware: auth, admin)
- `GET /admin/dashboard` - Dashboard admin
- `GET /admin/categories` - Daftar kategori
- `GET /admin/categories/create` - Form tambah kategori
- `POST /admin/categories` - Simpan kategori baru
- `GET /admin/categories/{id}/edit` - Form edit kategori
- `PUT /admin/categories/{id}` - Update kategori
- `DELETE /admin/categories/{id}` - Hapus kategori
- `GET /admin/sellers` - Daftar seller
- `POST /admin/sellers/{id}/approve` - Approve seller
- `POST /admin/sellers/{id}/reject` - Reject seller

## Middleware

### AdminMiddleware
Memastikan user yang mengakses adalah admin dan sudah login.

### SellerMiddleware
Memastikan user yang mengakses adalah seller yang sudah di-approve dan sudah login.

## Flow Aplikasi

### 1. Register Seller (2-Step Process)
1. **Step 1**: Seller mengisi form registrasi dasar (nama, email, password)
2. Seller menerima email verifikasi
3. **Step 2**: Setelah verifikasi email, seller melengkapi profil:
   - Data toko (nama toko, deskripsi)
   - Data PIC (nama, telepon, email, no KTP)
   - Alamat lengkap (provinsi → kota → kecamatan → kelurahan → RT/RW → alamat)
   - Upload foto diri dan scan KTP
4. Status seller: `pending`
5. Seller tidak bisa login sampai di-approve admin

### 2. Admin Approve Seller
1. Admin login ke dashboard
2. Admin melihat daftar seller pending
3. Admin approve/reject seller
4. Status seller berubah menjadi `approved` atau `rejected`

### 3. Seller Menambah Produk
1. Seller yang sudah approved login
2. Seller masuk ke dashboard
3. Seller klik "Add New Product"
4. Seller isi form produk (nama, kategori, deskripsi, harga, stok, gambar)
5. Produk tersimpan dan muncul di katalog publik

### 4. Pengunjung Melihat Produk
1. Buka halaman home (katalog)
2. Bisa search produk
3. Bisa filter berdasarkan kategori
4. Klik produk untuk melihat detail

## Folder Structure

```
ppl-project-akhir/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── HomeController.php
│   │   │   ├── Auth/
│   │   │   │   ├── LoginController.php
│   │   │   │   └── RegisterController.php
│   │   │   ├── Seller/
│   │   │   │   ├── DashboardController.php
│   │   │   │   └── ProductController.php
│   │   │   └── Admin/
│   │   │       ├── DashboardController.php
│   │   │       ├── CategoryController.php
│   │   │       └── SellerController.php
│   │   └── Middleware/
│   │       ├── AdminMiddleware.php
│   │       └── SellerMiddleware.php
│   └── Models/
│       ├── User.php
│       ├── Category.php
│       └── Product.php
├── database/
│   ├── migrations/
│   │   ├── 0001_01_01_000000_create_users_table.php
│   │   ├── 2025_11_27_093318_create_categories_table.php
│   │   └── 2025_11_27_093325_create_products_table.php
│   └── seeders/
│       ├── DatabaseSeeder.php
│       └── AdminSeeder.php
├── resources/
│   └── views/
│       ├── layouts/
│       │   └── app.blade.php
│       ├── home.blade.php
│       ├── product-detail.blade.php
│       ├── auth/
│       │   ├── login.blade.php
│       │   └── register.blade.php
│       ├── seller/
│       │   ├── dashboard.blade.php
│       │   └── products/
│       │       ├── create.blade.php
│       │       └── edit.blade.php
│       └── admin/
│           ├── dashboard.blade.php
│           ├── categories/
│           │   ├── index.blade.php
│           │   ├── create.blade.php
│           │   └── edit.blade.php
│           └── sellers/
│               └── index.blade.php
└── routes/
    └── web.php
```

## Testing

### Manual Testing Flow

#### 1. Test Admin
```bash
# Login sebagai admin
Email: admin@example.com
Password: password

# Test fitur:
- View dashboard (statistik)
- Create category
- View categories
- Edit category
- Delete category (jika tidak ada produk)
- View sellers list
- Approve/reject seller
```

#### 2. Test Seller Registration & Approval
```bash
# Register seller baru
- Isi form registrasi
- Coba login (harus gagal karena pending)
- Login sebagai admin
- Approve seller
- Login sebagai seller (berhasil)
```

#### 3. Test Seller Product Management
```bash
# Login sebagai seller
- View dashboard
- Create product
- Upload image
- Edit product
- Delete product
```

#### 4. Test Public Catalog
```bash
# Tanpa login
- Browse catalog
- Search products
- Filter by category
- View product detail
```

## Troubleshooting

### Error: SQLSTATE[08006] Unable to connect to database
**Solusi:** Pastikan PostgreSQL sudah berjalan dan kredensial di `.env` sudah benar.

```bash
# Check PostgreSQL status
sudo systemctl status postgresql

# Start PostgreSQL
sudo systemctl start postgresql
```

### Error: The storage link could not be created
**Solusi:** Hapus symlink yang ada dan buat ulang.

```bash
# Remove existing symlink
rm public/storage

# Create new symlink
php artisan storage:link
```

### Error: Class "App\Http\Middleware\AdminMiddleware" not found
**Solusi:** Clear cache dan dump autoload.

```bash
php artisan config:clear
php artisan cache:clear
composer dump-autoload
```

### Image tidak muncul
**Solusi:** Pastikan storage link sudah dibuat dan permission folder storage sudah benar.

```bash
php artisan storage:link
chmod -R 775 storage
chmod -R 775 bootstrap/cache
```

## Screenshot Aplikasi

### 1. Halaman Home (Katalog Produk)
- Grid produk dengan gambar
- Search bar
- Filter kategori
- Pagination

### 2. Halaman Detail Produk
- Gambar produk besar
- Informasi lengkap produk
- Informasi seller

### 3. Halaman Login
- Form login email & password
- Link ke register

### 4. Halaman Register Seller
- Form registrasi
- Info tentang approval process

### 5. Dashboard Seller
- Daftar produk seller
- Tombol add product
- Tombol edit & delete

### 6. Form Add/Edit Product
- Form lengkap dengan upload image
- Preview image
- Validasi form

### 7. Dashboard Admin
- Cards statistik
- Quick actions
- Alert untuk pending sellers

### 8. Admin - Categories Management
- Table kategori
- Tombol add, edit, delete

### 9. Admin - Sellers Management
- Table sellers dengan status
- Tombol approve/reject
- Filter by status

## Kontribusi

Aplikasi ini dibuat sebagai project akhir PPL. Silakan fork dan modifikasi sesuai kebutuhan Anda.

## Lisensi

MIT License