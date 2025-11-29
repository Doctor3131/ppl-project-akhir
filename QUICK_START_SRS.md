# Quick Start Guide - SRS Features MartPlace

Panduan cepat untuk menggunakan dan testing fitur-fitur SRS yang telah diimplementasikan.

---

## 🚀 Quick Setup

### 1. Persiapan Database
```bash
# Fresh install dengan seed data
php artisan migrate:fresh --seed
```

### 2. Jalankan Aplikasi
```bash
# Opsi 1: Satu perintah (recommended)
composer run dev

# Opsi 2: Manual
php artisan serve
# Di terminal baru:
npm run dev
```

### 3. Akses Aplikasi
- **URL:** http://127.0.0.1:8000
- **Catalog Public:** http://127.0.0.1:8000/catalog

---

## 👥 Akun Testing Default

### Admin
```
Email: admin@martplace.com (sesuaikan dengan seeder)
Password: password (sesuaikan dengan seeder)
```

### Seller (Approved)
```
Email: taqi@gmail.com
Password: 12345678
```

### Seller (Pending/Belum Approved)
Buat akun baru dengan registrasi sebagai seller.

---

## 🎯 Testing SRS Features - Panduan Cepat

### ✅ SRS-04 & 05: Katalog Produk & Pencarian (PUBLIC)

**Tidak perlu login!**

1. **Akses Katalog:**
   ```
   http://127.0.0.1:8000/catalog
   ```

2. **Test Search:**
   - Isi field "Cari Produk" dengan nama produk
   - Klik tombol "Cari"
   - ✓ Produk yang sesuai muncul

3. **Test Filter Lokasi:**
   - Pilih "Provinsi" dari dropdown
   - Pilih "Kota/Kabupaten" dari dropdown
   - Klik "Cari"
   - ✓ Produk dari toko di lokasi tersebut muncul

4. **Test Sort:**
   - Pilih "Rating Tertinggi" dari dropdown sort
   - Klik "Cari"
   - ✓ Produk diurutkan dari rating tertinggi

5. **View Detail Produk:**
   - Klik salah satu produk
   - ✓ Halaman detail dengan info lengkap muncul
   - ✓ Rating dan komentar tampil
   - ✓ Form rating tersedia

---

### ✅ SRS-06: Rating & Komentar (PUBLIC)

**Tidak perlu login!**

1. **Buka Detail Produk:**
   ```
   http://127.0.0.1:8000/catalog/{id}
   ```

2. **Scroll ke Form Rating:**
   - Isi Nama: `Test User`
   - Isi HP: `081234567890`
   - Isi Email: `test@example.com` (gunakan email valid untuk cek notifikasi)
   - Klik bintang untuk pilih rating (1-5)
   - Isi komentar (opsional)
   - Klik "Kirim Rating & Komentar"

3. **Verifikasi:**
   - ✓ Success message muncul
   - ✓ Rating muncul di list komentar
   - ✓ Email terima kasih terkirim (cek inbox/spam)
   - ✓ Rata-rata rating terupdate

---

### ✅ SRS-07: Dashboard Admin

1. **Login sebagai Admin:**
   ```
   http://127.0.0.1:8000/login
   ```

2. **Akses Dashboard:**
   ```
   http://127.0.0.1:8000/admin/dashboard
   ```

3. **Verifikasi Data yang Muncul:**
   - ✓ Statistics cards (total seller, produk, kategori)
   - ✓ Data produk per kategori (`$productsByCategory`)
   - ✓ Data seller per provinsi (`$sellersByProvince`)
   - ✓ Status seller (aktif/pending/rejected)
   - ✓ Statistik rating dan komentar
   - ✓ Rating distribution (1-5 bintang)
   - ✓ Recent activities
   - ✓ Top rated products

**Note:** Untuk chart visual, Anda perlu implement library seperti Chart.js. Data sudah siap di controller.

---

### ✅ SRS-08: Dashboard Seller

1. **Login sebagai Seller (Approved):**
   ```
   Email: taqi@gmail.com
   Password: 12345678
   ```

2. **Akses Dashboard:**
   ```
   http://127.0.0.1:8000/seller/dashboard
   ```

3. **Verifikasi Data yang Muncul:**
   - ✓ Statistics: Total produk, stok, low stock, rating
   - ✓ Data stok per produk (`$stockByProduct`)
   - ✓ Data rating per produk (`$ratingByProduct`)
   - ✓ Stock by category
   - ✓ Low stock alerts
   - ✓ Recent ratings
   - ✓ Top rated products
   - ✓ Monthly trends

---

### ✅ SRS-09: Laporan Akun Penjual (Admin)

1. **Login sebagai Admin**

2. **Akses Laporan:**
   ```
   http://127.0.0.1:8000/admin/reports/seller-accounts
   ```

3. **Test Fitur:**
   - ✓ View statistics cards
   - ✓ View table dengan semua seller
   - ✓ Filter by status (Aktif/Pending/Ditolak)
   - ✓ Klik "Export CSV"
   - ✓ File CSV terdownload dengan data lengkap

---

### ✅ SRS-10: Laporan Seller per Provinsi (Admin)

1. **Login sebagai Admin**

2. **Akses Laporan:**
   ```
   http://127.0.0.1:8000/admin/reports/sellers-by-province
   ```

3. **Test Fitur:**
   - ✓ View statistics per provinsi
   - ✓ View table dengan seller + alamat lengkap
   - ✓ Filter by province
   - ✓ Klik "Export CSV"
   - ✓ File CSV berisi: nama toko, PIC, alamat lengkap, provinsi

---

### ✅ SRS-11: Laporan Produk by Rating (Admin)

1. **Login sebagai Admin**

2. **Akses Laporan:**
   ```
   http://127.0.0.1:8000/admin/reports/products-by-rating
   ```

3. **Test Fitur:**
   - ✓ Produk diurutkan dari rating tertinggi
   - ✓ Tampil: nama produk, toko, kategori, harga, rating, provinsi
   - ✓ Filter by category
   - ✓ Filter by province
   - ✓ Klik "Export CSV"

---

### ✅ SRS-12: Laporan Stock (Seller)

1. **Login sebagai Seller**

2. **Akses Laporan:**
   ```
   http://127.0.0.1:8000/seller/reports/stock
   ```

3. **Test Fitur:**
   - ✓ Produk diurutkan dari stock terbanyak
   - ✓ Statistics: total produk, total stock, low stock, out of stock
   - ✓ Tampil: nama produk, kategori, harga, stock, rating
   - ✓ Filter by category
   - ✓ Klik "Export CSV"

---

### ✅ SRS-13: Laporan Rating (Seller)

1. **Login sebagai Seller**

2. **Akses Laporan:**
   ```
   http://127.0.0.1:8000/seller/reports/rating
   ```

3. **Test Fitur:**
   - ✓ Produk diurutkan dari rating tertinggi
   - ✓ Statistics: total produk, average rating, total ratings
   - ✓ Tampil: nama produk, kategori, harga, stock, rating
   - ✓ Filter by category
   - ✓ Klik "Export CSV"

---

### ✅ SRS-14: Laporan Low Stock (Seller)

1. **Login sebagai Seller**

2. **Akses Laporan:**
   ```
   http://127.0.0.1:8000/seller/reports/low-stock
   ```

3. **Test Fitur:**
   - ✓ Hanya produk dengan stock < 2 yang tampil
   - ✓ Diurutkan dari stock terendah (paling kritis)
   - ✓ Status badge: "Habis" (stock=0) atau "Segera Habis" (stock=1)
   - ✓ Statistics: low stock count, out of stock, stock=1, total value
   - ✓ Visual warning (warna merah/orange)
   - ✓ Filter by category
   - ✓ Klik "Export CSV"

---

## 🎨 Implementasi Chart/Grafis (Opsional)

Data untuk chart sudah tersedia di controller. Untuk menampilkan chart visual:

### Option 1: Chart.js
```bash
npm install chart.js
```

**Di layout:**
```html
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
```

**Contoh implementasi di blade:**
```html
<canvas id="productsByCategoryChart"></canvas>

<script>
const ctx = document.getElementById('productsByCategoryChart');
new Chart(ctx, {
    type: 'bar',
    data: {
        labels: {!! json_encode($productsByCategory->pluck('category_name')) !!},
        datasets: [{
            label: 'Jumlah Produk',
            data: {!! json_encode($productsByCategory->pluck('total')) !!},
            backgroundColor: 'rgba(79, 70, 229, 0.5)'
        }]
    }
});
</script>
```

### Option 2: ApexCharts
```bash
npm install apexcharts
```

**Di layout:**
```html
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
```

### Option 3: Google Charts
```html
<script src="https://www.gstatic.com/charts/loader.js"></script>
```

---

## 📧 Testing Email Notification

### Setup Email (Development)

**Opsi 1: Mailtrap (Recommended)**
```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=your_username
MAIL_PASSWORD=your_password
MAIL_ENCRYPTION=tls
```

**Opsi 2: Log (Testing)**
```env
MAIL_MAILER=log
```
Email akan tersimpan di `storage/logs/laravel.log`

**Opsi 3: Gmail**
```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your_email@gmail.com
MAIL_PASSWORD=your_app_password
MAIL_ENCRYPTION=tls
```

### Test Email
1. Submit rating dengan email valid
2. Cek inbox (atau Mailtrap dashboard)
3. Verifikasi email berisi:
   - Nama visitor
   - Produk yang dirating
   - Rating bintang
   - Komentar (jika ada)
   - Link ke produk

---

## 🔍 Troubleshooting

### Issue: Katalog tidak muncul produk
**Solusi:**
```bash
# Pastikan ada seller yang approved dan punya produk
php artisan tinker
>>> User::where('role', 'seller')->update(['status' => 'approved']);
>>> exit
```

### Issue: Email tidak terkirim
**Solusi:**
1. Cek konfigurasi `.env`
2. Cek log: `storage/logs/laravel.log`
3. Gunakan `MAIL_MAILER=log` untuk testing
4. Pastikan queue running (jika pakai queue)

### Issue: Rating tidak tersimpan
**Solusi:**
1. Cek validation error message
2. Pastikan semua field required terisi
3. Cek database: `select * from product_ratings;`

### Issue: Export CSV error
**Solusi:**
1. Pastikan storage writable: `chmod -R 775 storage`
2. Cek browser download settings
3. Test dengan browser lain

### Issue: Dashboard data kosong
**Solusi:**
```bash
# Seed data testing
php artisan db:seed

# Atau manual insert via tinker
php artisan tinker
>>> factory(App\Models\Product::class, 10)->create();
```

---

## 📊 Data Testing

### Generate Data untuk Testing

**Via Tinker:**
```bash
php artisan tinker
```

**Create Products:**
```php
$seller = User::where('role', 'seller')->where('status', 'approved')->first();
$category = Category::first();

for ($i = 1; $i <= 10; $i++) {
    Product::create([
        'user_id' => $seller->id,
        'category_id' => $category->id,
        'name' => "Produk Test $i",
        'description' => "Deskripsi produk test $i",
        'price' => rand(10000, 1000000),
        'stock' => rand(0, 50),
        'image' => null
    ]);
}
```

**Create Ratings:**
```php
$product = Product::first();

for ($i = 1; $i <= 5; $i++) {
    \App\Models\ProductRating::create([
        'product_id' => $product->id,
        'visitor_name' => "Visitor $i",
        'visitor_phone' => "08123456789$i",
        'visitor_email' => "visitor$i@example.com",
        'rating' => rand(3, 5),
        'comment' => "Produk bagus sekali! Recommended."
    ]);
}
```

---

## ✅ Testing Checklist Cepat

### Public Features (No Login)
- [ ] Buka `/catalog` - berhasil tanpa login
- [ ] Search produk - hasil sesuai
- [ ] Filter by kategori - hasil sesuai
- [ ] Filter by lokasi - hasil sesuai
- [ ] Submit rating - berhasil & email terkirim

### Admin Features
- [ ] Login admin berhasil
- [ ] Dashboard tampil dengan data lengkap
- [ ] Report seller accounts - tampil & export
- [ ] Report sellers by province - tampil & export
- [ ] Report products by rating - tampil & export

### Seller Features
- [ ] Login seller berhasil
- [ ] Dashboard tampil dengan data lengkap
- [ ] Report stock - tampil & export
- [ ] Report rating - tampil & export
- [ ] Report low stock - tampil & export (hanya stock < 2)

---

## 📚 Dokumentasi Lengkap

Untuk dokumentasi detail, lihat:

1. **SRS_IMPLEMENTATION.md** - Dokumentasi lengkap implementasi SRS
2. **TESTING_CHECKLIST.md** - Checklist testing komprehensif (150+ test cases)
3. **CHANGELOG.md** - Daftar perubahan dan fitur baru
4. **README.md** - Panduan instalasi lengkap

---

## 🎯 Quick Navigation

### URLs Admin
```
/admin/dashboard                          - Dashboard
/admin/sellers                           - Manage Sellers
/admin/categories                        - Manage Categories
/admin/reports/seller-accounts           - Report SRS-09
/admin/reports/sellers-by-province       - Report SRS-10
/admin/reports/products-by-rating        - Report SRS-11
```

### URLs Seller
```
/seller/dashboard                        - Dashboard
/seller/products                         - Manage Products
/seller/reports/stock                    - Report SRS-12
/seller/reports/rating                   - Report SRS-13
/seller/reports/low-stock                - Report SRS-14
```

### URLs Public
```
/                                        - Homepage
/catalog                                 - Katalog Produk (SRS-04, 05)
/catalog/{id}                           - Detail Produk + Rating (SRS-06)
```

---

## 🚀 Next Steps

1. ✅ Test semua SRS requirements menggunakan checklist
2. ✅ Implement chart library (Chart.js/ApexCharts) untuk visualisasi
3. ✅ Customize styling sesuai branding
4. ✅ Add more seed data untuk testing
5. ✅ Configure production email settings
6. ✅ Deploy to production

---

## 💡 Tips

- Gunakan browser Incognito untuk test fitur public (tanpa login)
- Gunakan Mailtrap.io untuk test email di development
- Export CSV bisa dibuka di Excel atau Google Sheets
- Gunakan multiple browser untuk test role berbeda (admin & seller)
- Clear cache jika ada perubahan: `php artisan cache:clear`

---

**Selamat Testing! 🎉**

Jika ada pertanyaan atau issue, refer ke dokumentasi lengkap atau create issue di repository.