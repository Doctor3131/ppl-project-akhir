# Testing Checklist - SRS MartPlace Implementation

## 📋 Overview
Dokumen ini berisi checklist lengkap untuk testing semua requirement SRS MartPlace yang telah diimplementasikan.

---

## 🚀 Pre-Testing Setup

### 1. Database Setup
```bash
# Fresh database dengan data seed
php artisan migrate:fresh --seed
```

### 2. Start Application
```bash
# Jalankan aplikasi
composer run dev
# atau
php artisan serve
```

### 3. Email Configuration (Optional)
Untuk testing email notifikasi, pastikan `.env` sudah dikonfigurasi:
```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=your_username
MAIL_PASSWORD=your_password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=noreply@martplace.com
MAIL_FROM_NAME="${APP_NAME}"
```

---

## ✅ Testing Checklist

### SRS-MartPlace-01: Registrasi Penjual ✓ (Already Implemented)

- [ ] **TC-01-01:** Akses halaman registrasi seller
  - URL: `/register`
  - Pilih role "Seller"
  - Expected: Form registrasi muncul dengan semua field yang diperlukan

- [ ] **TC-01-02:** Submit form registrasi dengan data lengkap
  - Isi semua field: nama toko, deskripsi, PIC name, email, HP, alamat lengkap (RT/RW/Kelurahan/Kota/Provinsi), No KTP, upload foto PIC, upload file KTP
  - Expected: Registrasi berhasil, status "pending"

- [ ] **TC-01-03:** Validasi field wajib
  - Submit form tanpa mengisi field wajib
  - Expected: Error validation muncul

- [ ] **TC-01-04:** Validasi format email
  - Masukkan email invalid
  - Expected: Error "format email tidak valid"

- [ ] **TC-01-05:** Validasi upload file
  - Upload file dengan format/ukuran tidak sesuai
  - Expected: Error validation muncul

---

### SRS-MartPlace-02: Verifikasi Registrasi ✓ (Already Implemented)

- [ ] **TC-02-01:** Admin view pending sellers
  - Login sebagai admin
  - URL: `/admin/sellers`
  - Expected: List seller dengan status "pending" tampil

- [ ] **TC-02-02:** Admin approve seller
  - Klik detail seller yang pending
  - Klik tombol "Approve"
  - Expected: 
    - Status berubah menjadi "approved"
    - Email notifikasi terkirim ke seller
    - Email berisi informasi aktivasi akun

- [ ] **TC-02-03:** Admin reject seller
  - Klik detail seller yang pending
  - Isi alasan penolakan
  - Klik tombol "Reject"
  - Expected:
    - Status berubah menjadi "rejected"
    - Email notifikasi terkirim
    - Email berisi alasan penolakan

- [ ] **TC-02-04:** Seller login setelah approved
  - Login dengan akun seller yang sudah approved
  - Expected: Berhasil login, redirect ke dashboard seller

- [ ] **TC-02-05:** Seller login sebelum approved
  - Login dengan akun seller yang masih pending/rejected
  - Expected: Access denied atau pesan "akun belum disetujui"

---

### SRS-MartPlace-03: Upload Produk ✓ (Already Implemented)

- [ ] **TC-03-01:** Akses halaman tambah produk
  - Login sebagai seller (approved)
  - URL: `/seller/products/create`
  - Expected: Form tambah produk muncul

- [ ] **TC-03-02:** Upload produk dengan data lengkap
  - Isi: Nama produk, kategori, deskripsi, harga, stok, upload gambar
  - Expected: Produk berhasil ditambahkan

- [ ] **TC-03-03:** Edit produk
  - Klik edit pada salah satu produk
  - Ubah data
  - Expected: Data berhasil diupdate

- [ ] **TC-03-04:** Delete produk
  - Klik delete pada salah satu produk
  - Expected: Produk terhapus dari database

- [ ] **TC-03-05:** Validasi field produk
  - Submit tanpa mengisi field wajib
  - Expected: Error validation muncul

---

### SRS-MartPlace-04: Katalog Produk Publik ✨ (Newly Implemented)

- [ ] **TC-04-01:** Akses katalog tanpa login
  - Buka browser dalam mode incognito/private
  - URL: `http://127.0.0.1:8000/catalog`
  - Expected: Halaman katalog muncul tanpa perlu login

- [ ] **TC-04-02:** Tampilan produk di katalog
  - Lihat list produk
  - Expected: Setiap produk menampilkan:
    - Gambar produk
    - Nama produk
    - Harga
    - Rating rata-rata (bintang)
    - Jumlah rating
    - Nama toko
    - Lokasi (kota, provinsi)
    - Badge stok (jika stok rendah)

- [ ] **TC-04-03:** Klik produk untuk detail
  - Klik salah satu produk
  - Expected: Redirect ke halaman detail produk

- [ ] **TC-04-04:** Rating dan komentar ditampilkan
  - Di halaman detail, scroll ke bagian komentar
  - Expected: List rating dan komentar dari pengunjung tampil

- [ ] **TC-04-05:** Pagination katalog
  - Scroll ke bawah halaman katalog
  - Klik pagination
  - Expected: Halaman berikutnya tampil

---

### SRS-MartPlace-05: Pencarian Produk ✨ (Newly Implemented)

- [ ] **TC-05-01:** Search by product name
  - Di halaman katalog, isi field "Cari Produk"
  - Masukkan nama produk (partial match ok)
  - Klik "Cari"
  - Expected: Hanya produk yang sesuai yang tampil

- [ ] **TC-05-02:** Search by shop name
  - Isi field "Nama Toko"
  - Klik "Cari"
  - Expected: Produk dari toko tersebut tampil

- [ ] **TC-05-03:** Filter by category
  - Pilih kategori dari dropdown
  - Klik "Cari"
  - Expected: Hanya produk dari kategori tersebut tampil

- [ ] **TC-05-04:** Filter by province
  - Pilih provinsi dari dropdown
  - Klik "Cari"
  - Expected: Produk dari toko di provinsi tersebut tampil

- [ ] **TC-05-05:** Filter by city
  - Pilih kota/kabupaten dari dropdown
  - Klik "Cari"
  - Expected: Produk dari toko di kota tersebut tampil

- [ ] **TC-05-06:** Combined filters
  - Gunakan multiple filters sekaligus (nama produk + kategori + lokasi)
  - Expected: Hasil sesuai dengan semua filter

- [ ] **TC-05-07:** Sort by price (ascending)
  - Pilih "Harga Terendah" dari dropdown sort
  - Klik "Cari"
  - Expected: Produk diurutkan dari harga terendah

- [ ] **TC-05-08:** Sort by price (descending)
  - Pilih "Harga Tertinggi"
  - Expected: Produk diurutkan dari harga tertinggi

- [ ] **TC-05-09:** Sort by rating
  - Pilih "Rating Tertinggi"
  - Expected: Produk diurutkan dari rating tertinggi

- [ ] **TC-05-10:** Sort by name
  - Pilih "Nama A-Z" atau "Nama Z-A"
  - Expected: Produk diurutkan sesuai abjad

- [ ] **TC-05-11:** Reset filters
  - Setelah apply filter, klik tombol "Reset"
  - Expected: Semua filter dikosongkan, tampil semua produk

- [ ] **TC-05-12:** No results found
  - Search dengan keyword yang tidak ada
  - Expected: Tampil pesan "Produk tidak ditemukan"

---

### SRS-MartPlace-06: Rating dan Komentar ✨ (Newly Implemented)

- [ ] **TC-06-01:** Tampilkan form rating di detail produk
  - Buka halaman detail produk
  - Scroll ke bagian "Beri Rating & Komentar"
  - Expected: Form dengan field: Nama, HP, Email, Rating (1-5), Komentar

- [ ] **TC-06-02:** Submit rating tanpa komentar
  - Isi: Nama, HP, Email valid
  - Pilih rating (klik bintang)
  - Submit tanpa isi komentar
  - Expected:
    - Success message muncul
    - Rating tersimpan
    - Email terima kasih terkirim

- [ ] **TC-06-03:** Submit rating dengan komentar
  - Isi semua field termasuk komentar
  - Submit
  - Expected:
    - Success message muncul
    - Rating dan komentar tersimpan
    - Email terima kasih terkirim (dengan komentar di email)

- [ ] **TC-06-04:** Validasi field wajib
  - Submit tanpa isi Nama/HP/Email
  - Expected: Error validation muncul

- [ ] **TC-06-05:** Validasi format email
  - Isi email tidak valid
  - Expected: Error "format email tidak valid"

- [ ] **TC-06-06:** Validasi rating range
  - Rating harus 1-5 (test via manual API call jika perlu)
  - Expected: Reject rating di luar range

- [ ] **TC-06-07:** Rating langsung muncul di list
  - Setelah submit, scroll ke bagian komentar
  - Expected: Rating dan komentar yang baru submit muncul di list

- [ ] **TC-06-08:** Average rating terupdate
  - Setelah submit rating baru
  - Expected: Rata-rata rating di atas terupdate

- [ ] **TC-06-09:** Email notification content
  - Cek email yang diterima
  - Expected: Email berisi:
    - Nama visitor
    - Nama produk
    - Rating (bintang)
    - Komentar (jika ada)
    - Link ke produk
    - Ucapan terima kasih

- [ ] **TC-06-10:** Multiple ratings dari visitor berbeda
  - Submit rating dengan email berbeda
  - Expected: Semua rating tersimpan

---

### SRS-MartPlace-07: Dashboard Admin ✨ (Newly Implemented)

#### Statistics Cards
- [ ] **TC-07-01:** View basic statistics
  - Login sebagai admin
  - URL: `/admin/dashboard`
  - Expected: Cards menampilkan:
    - Total sellers
    - Sellers pending
    - Total products
    - Total categories

#### Sebaran Produk per Kategori
- [ ] **TC-07-02:** Chart produk per kategori
  - Expected: Chart/table menampilkan jumlah produk untuk setiap kategori
  - Data akurat sesuai database

#### Sebaran Toko per Provinsi
- [ ] **TC-07-03:** Chart toko per provinsi
  - Expected: Chart/table menampilkan jumlah toko untuk setiap provinsi
  - Hanya toko yang approved

#### Status Seller (Active/Inactive)
- [ ] **TC-07-04:** Chart status seller
  - Expected: Chart menampilkan:
    - Jumlah seller active (approved)
    - Jumlah seller pending
    - Jumlah seller rejected

#### Rating & Komentar Statistics
- [ ] **TC-07-05:** Rating statistics
  - Expected: Menampilkan:
    - Total rating/komentar
    - Jumlah unique visitors (berdasarkan email)
    - Jumlah rating dengan komentar
    - Jumlah rating tanpa komentar

- [ ] **TC-07-06:** Rating distribution (1-5 stars)
  - Expected: Chart/table menampilkan jumlah rating untuk setiap bintang (1-5)

#### Additional Dashboard Data
- [ ] **TC-07-07:** Recent ratings
  - Expected: List 5 rating terbaru dengan nama visitor dan produk

- [ ] **TC-07-08:** Recent products
  - Expected: List 5 produk terbaru yang diupload

- [ ] **TC-07-09:** Top rated products
  - Expected: List 5 produk dengan rating tertinggi

- [ ] **TC-07-10:** Monthly trends
  - Expected: Chart trend 6 bulan terakhir (produk, rating, seller baru)

---

### SRS-MartPlace-08: Dashboard Seller ✨ (Newly Implemented)

#### Basic Statistics
- [ ] **TC-08-01:** View statistics
  - Login sebagai seller (approved)
  - URL: `/seller/dashboard`
  - Expected: Cards menampilkan:
    - Total produk
    - Total stok
    - Produk low stock
    - Total rating diterima

#### Sebaran Stok per Produk
- [ ] **TC-08-02:** Chart/table stok per produk
  - Expected: Menampilkan setiap produk dengan jumlah stoknya
  - Diurutkan dari stok terbesar

#### Sebaran Rating per Produk
- [ ] **TC-08-03:** Chart/table rating per produk
  - Expected: Menampilkan setiap produk dengan:
    - Rata-rata rating
    - Jumlah rating
    - Diurutkan dari rating tertinggi

#### Sebaran Pemberi Rating (by Location)
- [ ] **TC-08-04:** Chart pemberi rating
  - Expected: Menampilkan sebaran pemberi rating
  - Note: Karena visitor tidak login, lokasi diambil dari email domain

#### Additional Data
- [ ] **TC-08-05:** Rating distribution untuk produk seller
  - Expected: Chart distribusi rating 1-5 stars

- [ ] **TC-08-06:** Stock by category
  - Expected: Total stok per kategori produk

- [ ] **TC-08-07:** Recent ratings
  - Expected: 5 rating terbaru untuk produk seller

- [ ] **TC-08-08:** Low stock alert
  - Expected: List produk dengan stok < 2

- [ ] **TC-08-09:** Monthly trends
  - Expected: Chart 6 bulan terakhir (produk ditambah, rating diterima)

- [ ] **TC-08-10:** Top rated products
  - Expected: 5 produk seller dengan rating tertinggi

---

### SRS-MartPlace-09: Laporan Akun Penjual ✨ (Newly Implemented)

- [ ] **TC-09-01:** View report
  - Login sebagai admin
  - URL: `/admin/reports/seller-accounts`
  - Expected: Table dengan kolom:
    - No, Nama, Email, Nama Toko, No HP, Status, Tanggal Registrasi, Aksi

- [ ] **TC-09-02:** Statistics cards
  - Expected: Cards menampilkan:
    - Total penjual
    - Aktif (approved)
    - Pending
    - Ditolak (rejected)

- [ ] **TC-09-03:** Filter by status
  - Pilih filter "Aktif"
  - Expected: Hanya seller approved yang tampil
  - Ulangi untuk Pending dan Rejected

- [ ] **TC-09-04:** View all sellers
  - Pilih "Semua Status"
  - Expected: Semua seller tampil

- [ ] **TC-09-05:** Export to CSV
  - Klik tombol "Export CSV"
  - Expected: File CSV terdownload dengan data:
    - No, Nama, Email, Nama Toko, Status, Tanggal Registrasi

- [ ] **TC-09-06:** CSV content validation
  - Buka file CSV
  - Expected: Data sesuai dengan yang ditampilkan di web

- [ ] **TC-09-07:** Link to seller detail
  - Klik link "Detail" di kolom Aksi
  - Expected: Redirect ke halaman detail seller

---

### SRS-MartPlace-10: Laporan Toko per Provinsi ✨ (Newly Implemented)

- [ ] **TC-10-01:** View report
  - Login sebagai admin
  - URL: `/admin/reports/sellers-by-province`
  - Expected: Table dengan kolom:
    - No, Nama Toko, PIC, Email, Telepon, Provinsi, Kota, Alamat

- [ ] **TC-10-02:** Filter by province
  - Pilih provinsi dari dropdown
  - Expected: Hanya toko dari provinsi tersebut tampil

- [ ] **TC-10-03:** Statistics by province
  - Expected: Table/chart statistik jumlah toko per provinsi

- [ ] **TC-10-04:** View all provinces
  - Pilih "Semua Provinsi"
  - Expected: Semua toko tampil, grouped/ordered by province

- [ ] **TC-10-05:** Export to CSV
  - Klik tombol "Export CSV"
  - Expected: File CSV terdownload dengan data lengkap

- [ ] **TC-10-06:** Complete address in report
  - Expected: Alamat lengkap tampil (jalan, RT/RW, kelurahan, kota, provinsi)

---

### SRS-MartPlace-11: Laporan Produk by Rating ✨ (Newly Implemented)

- [ ] **TC-11-01:** View report
  - Login sebagai admin
  - URL: `/admin/reports/products-by-rating`
  - Expected: Table dengan kolom:
    - No, Nama Produk, Nama Toko, Kategori, Harga, Rating, Jumlah Rating, Provinsi

- [ ] **TC-11-02:** Sort by rating (descending)
  - Expected: Produk dengan rating tertinggi di urutan pertama

- [ ] **TC-11-03:** Filter by category
  - Pilih kategori
  - Expected: Hanya produk dari kategori tersebut tampil

- [ ] **TC-11-04:** Filter by province
  - Pilih provinsi
  - Expected: Hanya produk dari toko di provinsi tersebut tampil

- [ ] **TC-11-05:** Combined filters
  - Filter kategori + provinsi
  - Expected: Hasil sesuai dengan kedua filter

- [ ] **TC-11-06:** Products with no ratings
  - Expected: Produk tanpa rating ditampilkan dengan rating 0

- [ ] **TC-11-07:** Export to CSV
  - Klik tombol "Export CSV"
  - Expected: File CSV terdownload dengan data lengkap

---

### SRS-MartPlace-12: Laporan Stock (by Stock) ✨ (Newly Implemented)

- [ ] **TC-12-01:** View report
  - Login sebagai seller
  - URL: `/seller/reports/stock`
  - Expected: Table dengan kolom:
    - No, Nama Produk, Kategori, Harga, Stock, Rating, Jumlah Rating

- [ ] **TC-12-02:** Sort by stock (descending)
  - Expected: Produk dengan stok terbanyak di urutan pertama

- [ ] **TC-12-03:** Statistics cards
  - Expected: Cards menampilkan:
    - Total produk
    - Total stok
    - Produk low stock (< 2)
    - Produk out of stock (0)

- [ ] **TC-12-04:** Filter by category
  - Pilih kategori
  - Expected: Hanya produk dari kategori tersebut tampil

- [ ] **TC-12-05:** Export to CSV
  - Klik tombol "Export CSV"
  - Expected: File CSV terdownload

---

### SRS-MartPlace-13: Laporan Stock (by Rating) ✨ (Newly Implemented)

- [ ] **TC-13-01:** View report
  - Login sebagai seller
  - URL: `/seller/reports/rating`
  - Expected: Table dengan kolom:
    - No, Nama Produk, Kategori, Harga, Stock, Rating, Jumlah Rating

- [ ] **TC-13-02:** Sort by rating (descending)
  - Expected: Produk dengan rating tertinggi di urutan pertama

- [ ] **TC-13-03:** Statistics cards
  - Expected: Cards menampilkan:
    - Total produk
    - Rata-rata rating
    - Total rating diterima
    - Produk dengan rating

- [ ] **TC-13-04:** Filter by category
  - Pilih kategori
  - Expected: Hanya produk dari kategori tersebut tampil

- [ ] **TC-13-05:** Export to CSV
  - Klik tombol "Export CSV"
  - Expected: File CSV terdownload

---

### SRS-MartPlace-14: Laporan Low Stock ✨ (Newly Implemented)

- [ ] **TC-14-01:** View report
  - Login sebagai seller
  - URL: `/seller/reports/low-stock`
  - Expected: Table dengan kolom:
    - No, Nama Produk, Kategori, Harga, Stock, Rating, Jumlah Rating, Status

- [ ] **TC-14-02:** Only products with stock < 2
  - Expected: Hanya produk dengan stok < 2 yang tampil

- [ ] **TC-14-03:** Sort by stock (ascending)
  - Expected: Produk dengan stok terendah (0) di urutan pertama

- [ ] **TC-14-04:** Status badge
  - Expected: 
    - "Habis" untuk stock = 0
    - "Segera Habis" untuk stock = 1

- [ ] **TC-14-05:** Statistics cards
  - Expected: Cards menampilkan:
    - Total produk low stock
    - Produk out of stock (0)
    - Produk dengan stock 1
    - Total nilai produk low stock

- [ ] **TC-14-06:** Alert/warning styling
  - Expected: Visual warning (warna merah/orange) untuk produk habis

- [ ] **TC-14-07:** Filter by category
  - Pilih kategori
  - Expected: Hanya produk low stock dari kategori tersebut tampil

- [ ] **TC-14-08:** Export to CSV
  - Klik tombol "Export CSV"
  - Expected: File CSV terdownload dengan kolom Status

- [ ] **TC-14-09:** Empty state
  - Jika seller tidak punya produk low stock
  - Expected: Tampil pesan "Tidak ada produk yang perlu direstock"

---

## 🔍 Additional Testing

### Security Testing
- [ ] **SEC-01:** Akses admin page sebagai guest
  - Logout, akses `/admin/dashboard`
  - Expected: Redirect ke login

- [ ] **SEC-02:** Akses seller page sebagai guest
  - Logout, akses `/seller/dashboard`
  - Expected: Redirect ke login

- [ ] **SEC-03:** Akses admin page sebagai seller
  - Login sebagai seller, akses `/admin/dashboard`
  - Expected: Access denied (403)

- [ ] **SEC-04:** Akses seller page sebagai admin
  - Login sebagai admin, akses `/seller/dashboard`
  - Expected: Access denied (403) atau redirect

- [ ] **SEC-05:** Edit/delete produk milik seller lain
  - Coba akses URL edit produk seller lain
  - Expected: Access denied atau 404

### Performance Testing
- [ ] **PERF-01:** Catalog dengan banyak produk
  - Seed database dengan 100+ produk
  - Expected: Halaman load dalam waktu wajar (< 3 detik)

- [ ] **PERF-02:** Search dengan banyak filter
  - Apply multiple filters
  - Expected: Query execute dengan cepat

- [ ] **PERF-03:** Dashboard dengan banyak data
  - Expected: Dashboard load dengan smooth

### UI/UX Testing
- [ ] **UX-01:** Mobile responsive - Catalog
  - Buka katalog di mobile device atau resize browser
  - Expected: Layout responsive, mobile-friendly

- [ ] **UX-02:** Mobile responsive - Dashboard
  - Buka dashboard di mobile
  - Expected: Charts dan tables responsive

- [ ] **UX-03:** Form validation messages clear
  - Submit form dengan error
  - Expected: Error message jelas dan helpful

- [ ] **UX-04:** Success messages visible
  - Setelah action berhasil
  - Expected: Success message terlihat jelas

- [ ] **UX-05:** Loading states
  - Saat submit form atau load data
  - Expected: Loading indicator muncul (jika implemented)

---

## 📊 Test Report Template

Setelah testing, buat laporan dengan format:

```
# Test Report - SRS MartPlace
Tanggal: [DD/MM/YYYY]
Tester: [Nama]

## Summary
- Total Test Cases: [X]
- Passed: [X]
- Failed: [X]
- Skipped: [X]

## Failed Test Cases
TC-XX-XX: [Test Case Name]
- Expected: [Expected behavior]
- Actual: [Actual behavior]
- Screenshot: [Link jika ada]
- Notes: [Additional notes]

## Known Issues
1. [Issue description]
2. [Issue description]

## Recommendations
1. [Recommendation]
2. [Recommendation]
```

---

## 🐛 Bug Report Template

Jika menemukan bug, laporkan dengan format:

```
**Bug ID:** BUG-XXX
**SRS:** SRS-MartPlace-XX
**Severity:** Critical / High / Medium / Low
**Status:** Open / In Progress / Fixed

**Description:**
[Deskripsi singkat bug]

**Steps to Reproduce:**
1. Step 1
2. Step 2
3. Step 3

**Expected Result:**
[Apa yang seharusnya terjadi]

**Actual Result:**
[Apa yang sebenarnya terjadi]

**Screenshot/Video:**
[Attach jika ada]

**Environment:**
- Browser: [Chrome/Firefox/Safari]
- OS: [Windows/Mac/Linux]
- Laravel Version: [X.X.X]
```

---

## ✅ Sign Off

Setelah semua test case passed:

```
Testing completed by: __________________
Date: __________________
Signature: __________________

Approved by: __________________
Date: __________________
Signature: __________________
```

---

**Note:** Checklist ini comprehensive untuk memastikan semua requirement SRS terpenuhi. Prioritaskan testing pada fitur yang baru diimplementasikan (marked with ✨).