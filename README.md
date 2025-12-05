# PPL Project Akhir

Selamat datang di repositori proyek PPL. Dokumen ini berisi panduan lengkap untuk melakukan instalasi awal (fresh install) di komputer masing-masing anggota tim.

---

## 📋 Prasyarat (Prerequisites)

Sebelum memulai, pastikan komputer Anda sudah terinstall tools berikut via Terminal/Command Line.

### 1. PHP (Minimal versi 8.2)

**Cek versi:**
```bash
php -v
```

**Jika command tidak ditemukan:**

- **Windows:** Disarankan menggunakan [Scoop](https://scoop.sh/). Jalankan di PowerShell:
```powershell
  scoop install php
```

- **Mac:** Gunakan Homebrew:
```bash
  brew install php
```

- **Linux (Ubuntu/Debian):**
```bash
  sudo apt install php php-xml php-curl php-zip php-pgsql
```

### 2. Composer (Package Manager)

**Cek versi:**
```bash
composer -V
```

**Jika belum ada:**  
Ikuti panduan instalasi CLI resmi di [getcomposer.org/download](https://getcomposer.org/download).

### 3. Node.js & NPM

**Cek versi:**
```bash
node -v
npm -v
```

**Jika belum ada:**  
Windows/Mac/Linux: Download installer di [nodejs.org](https://nodejs.org) atau gunakan version manager seperti `nvm`.

### 4. PostgreSQL (Database)

**Cek versi:**
```bash
psql --version
```

**Jika belum ada:**

- **Windows:** Download installer [PostgreSQL](https://www.postgresql.org/download/) atau gunakan `scoop install postgresql`.
- **Mac:** `brew install postgresql`
- **Linux:** `sudo apt install postgresql`

---

## 🚀 Langkah Instalasi (Fresh Install)

Ikuti langkah-langkah ini secara berurutan di terminal Anda:

### 1. Clone Repositori

Clone project ini ke folder lokal Anda:
```bash
git clone https://github.com/Doctor3131/ppl-project-akhir.git
cd ppl-project-akhir
```

### 2. Install Dependencies

Install library PHP dan JavaScript yang dibutuhkan:
```bash
composer install
npm install
```

> **Note:** `npm install` sangat penting untuk menginstall tools agar aplikasi bisa dijalankan dengan satu perintah nanti.

### 3. Setup Database & Password (PENTING!)

Sebelum mengatur `.env`, kita harus membuat database dan memastikan password user `postgres` sudah ter-set.

#### Masuk ke PostgreSQL CLI:

- **Windows:** Buka aplikasi **SQL Shell (psql)** dari Start Menu, tekan Enter untuk semua pertanyaan default (Server, Database, Port, Username). Saat diminta Password, masukkan password instalasi Anda.

- **Mac/Linux:** Jalankan perintah berikut di terminal:
```bash
  sudo -u postgres psql
```

#### Atur Password Database (Jika lupa/ingin mengubah):

Di dalam prompt `postgres=#`, jalankan perintah SQL berikut untuk membuat/mengganti password user `postgres`. Ganti `'password_baru'` dengan password yang Anda inginkan (misal: `root` atau `123456`):
```sql
ALTER USER postgres WITH PASSWORD 'password_baru';
```

> **Simpan password ini, akan digunakan di langkah berikutnya**

#### Buat Database Aplikasi:

Jalankan perintah ini untuk membuat database kosong:
```sql
CREATE DATABASE ppl;
```

#### Keluar:

Ketik `\q` lalu Enter untuk keluar dari psql.

### 4. Konfigurasi Environment (`.env`)

Duplikat file konfigurasi contoh menjadi file konfigurasi aktif:

- **Windows (CMD):**
```cmd
  copy .env.example .env
```

- **Mac/Linux:**
```bash
  cp .env.example .env
```

Buka file `.env` yang baru dibuat dengan text editor. Cari bagian **Database** dan sesuaikan `DB_PASSWORD` dengan password yang Anda buat di **Langkah 3**:
```env
DB_CONNECTION=pgsql
DB_HOST=127.0.0.1
DB_PORT=5432
DB_DATABASE=ppl
DB_USERNAME=postgres
DB_PASSWORD=masukkan_password_dari_langkah_3_disini
```

Terakhir, generate key aplikasi Laravel yang secara otomatis membuat APP_KEY di .env:
```bash
php artisan key:generate
```

### 5. Migrasi & Seeding

Sekarang, masukkan tabel dan data awal ke database yang sudah dibuat:
```bash
php artisan migrate:fresh --seed
```

Jika langkah ini sukses (tidak ada error merah), berarti koneksi database Anda berhasil.

---

## 🖥️ Menjalankan Aplikasi

Sekarang Anda cukup menjalankan **satu perintah saja**. Perintah ini akan menjalankan Server Laravel dan Vite secara bersamaan dalam satu terminal.
```bash
composer run dev
```

(Atau `php artisan serve` dan `npm run dev`)

**Akses web di browser:**  
[http://127.0.0.1:8000](http://127.0.0.1:8000)

> Tekan `Ctrl + C` untuk mematikan server.

---

## 🔐 Akun Login (Seed Data)

Gunakan akun berikut untuk login:

| Nama      | Email             | Password   | Role   |
|-----------|-------------------|------------|--------|
| Taqi      | taqi@gmail.com    | 12345678   | Seller |
| Hidah     | hidah@gmail.com   | 12345678   | Seller |
| Raya      | raya@gmail.com    | 12345678   | Seller |
| Test User | test@example.com  | password   | Seller |
| Admin     | admin@example.com | password   | Admin  |

---

## 📧 Email Verification (Development)

Registrasi seller baru memerlukan **email verification**. Untuk development, email akan ditulis ke log file (tidak perlu setup SMTP).

**Cara melihat link verifikasi:**
```bash
# Buka file log terbaru
cat storage/logs/laravel.log | tail -100
```

Cari baris yang mengandung link verifikasi seperti:
```
http://127.0.0.1:8000/verify-email/...
```

> **Tip:** Jika ingin menggunakan email asli (Mailtrap), ubah konfigurasi `MAIL_*` di file `.env`

---

## 🔄 Setelah Git Pull (PENTING untuk Tim!)

Setiap kali melakukan `git pull` dari branch teman, jalankan perintah berikut untuk memastikan environment Anda sinkron:

```bash
# 1. Install dependency baru (jika ada perubahan composer.json/package.json)
composer install
npm install

# 2. Jalankan migration baru (jika ada perubahan database)
php artisan migrate

# 3. Publish vendor assets (untuk package indonesia - lokasi dropdown)
php artisan vendor:publish --provider="Laravolt\Indonesia\ServiceProvider"

# 4. Buat symbolic link untuk storage (WAJIB untuk upload gambar)
php artisan storage:link

# 5. Clear semua cache
php artisan view:clear
php artisan route:clear
php artisan config:clear
php artisan cache:clear
```

### ⚠️ Catatan Penting:
- **`php artisan storage:link`** - Wajib dijalankan sekali di setiap komputer. Symbolic link tidak ter-commit ke Git, jadi setiap developer harus membuatnya sendiri.
- **`php artisan vendor:publish`** - Wajib dijalankan sekali untuk publish config dan migration dari package `laravolt/indonesia` (dropdown provinsi/kota).
- Jika gambar produk tidak muncul, kemungkinan besar symbolic link belum dibuat.
- Jika ada error "View not found" atau "Route not found", jalankan perintah clear cache di atas.

---

## 🌿 Git Workflow (PENTING!)

Agar kode tidak bentrok, mohon ikuti aturan branch berikut:

⚠️ **JANGAN coding langsung di branch `main`.**

Setiap mengerjakan fitur baru, buat branch baru:
```bash
git checkout -b nama-fitur-kalian
# Contoh: git checkout -b fitur-login
```

Setelah selesai:
```bash
git add .
git commit -m "Menambahkan fitur X"
git push origin nama-fitur-kalian
```

Buat **Pull Request (PR)** di GitHub.

---

**Selamat coding, Tim! 🚀**
