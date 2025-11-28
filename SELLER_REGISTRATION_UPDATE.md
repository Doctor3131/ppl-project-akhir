# Update Registrasi Penjual - Dokumentasi

## Ringkasan Perubahan

Form registrasi penjual telah diupdate dengan menambahkan field-field lengkap untuk informasi toko, penanggung jawab (PIC), alamat detail, dan upload dokumen.

## Field Baru yang Ditambahkan

### 1. Data Toko
- **Nama Toko** (shop_name) - Required, string, max 255
- **Deskripsi Singkat** (shop_description) - Optional, text, max 1000 karakter

### 2. Data PIC (Person In Charge)
- **Nama PIC** (pic_name) - Required, string, max 255
- **No HP PIC** (pic_phone) - Required, string, max 20
- **Email PIC** (pic_email) - Required, email
- **No KTP PIC** (pic_ktp_number) - Required, 16 digit, unique

### 3. Alamat Lengkap
- **Jalan** (street_address) - Required, text, max 500
- **RT** (rt) - Required, string, max 5
- **RW** (rw) - Required, string, max 5
- **Kelurahan/Desa** (kelurahan) - Required, string, max 255
- **Kota/Kabupaten** (kota_kabupaten) - Required, string, max 255
- **Provinsi** (province) - Required, string, max 255

### 4. Upload Dokumen
- **Foto PIC** (pic_photo) - Required, image (JPG/JPEG/PNG), max 2MB
- **File KTP** (ktp_file) - Required, image/PDF (JPG/JPEG/PNG/PDF), max 5MB

## File yang Diubah/Ditambahkan

### Database
1. **Migration**: `2025_11_28_044740_add_seller_details_to_seller_table.php`
   - Menambahkan kolom-kolom baru ke tabel `seller`
   - Menghapus kolom lama yang tidak relevan (ktp_number, face_photo_path, ktp_photo_path, address)

### Models
1. **SellerVerification.php** (`app/Models/SellerVerification.php`)
   - Update fillable dengan field baru
   - Tambah method `getFullAddressAttribute()` untuk generate alamat lengkap

2. **User.php** (`app/Models/User.php`)
   - Tambah relasi `seller()` ke SellerVerification

### Controllers
1. **RegisterController.php** (`app/Http/Controllers/Auth/RegisterController.php`)
   - Update validasi dengan semua field baru
   - Handle file upload untuk foto PIC dan KTP
   - Implementasi transaction untuk data consistency
   - Error handling dan rollback jika gagal

2. **SellerController.php** (`app/Http/Controllers/Admin/SellerController.php`)
   - Tambah method `show()` untuk detail seller
   - Update method `approve()` dan `reject()` untuk update seller verification status
   - Load relasi seller di index

### Views
1. **register.blade.php** (`resources/views/auth/register.blade.php`)
   - Update form dengan 4 section: Data Akun, Data Toko, Data PIC, Alamat Lengkap
   - Tambah form upload file dengan preview
   - JavaScript untuk preview image/file
   - Validasi client-side

2. **admin/sellers/index.blade.php** (`resources/views/admin/sellers/index.blade.php`)
   - Tambah kolom Shop Name
   - Tambah button "View Detail" untuk setiap seller

3. **admin/sellers/show.blade.php** (NEW)
   - Halaman detail seller dengan layout 2 kolom
   - Menampilkan semua informasi lengkap
   - Preview foto PIC dan file KTP
   - Action buttons untuk approve/reject

### Routes
1. **web.php** (`routes/web.php`)
   - Tambah route `admin.sellers.show` untuk detail seller

## Database Schema

### Tabel: seller

```sql
- id (bigint, primary key)
- user_id (bigint, foreign key)
- shop_name (varchar 255)
- shop_description (text, nullable)
- pic_name (varchar 255)
- pic_phone (varchar 20)
- pic_email (varchar 255)
- pic_ktp_number (varchar 20)
- street_address (varchar 500)
- rt (varchar 5)
- rw (varchar 5)
- kelurahan (varchar 255)
- kota_kabupaten (varchar 255)
- province (varchar 255)
- pic_photo_path (varchar 255, nullable)
- ktp_file_path (varchar 255, nullable)
- status (enum: pending, approved, rejected)
- rejection_reason (text, nullable)
- verified_at (timestamp, nullable)
- created_at (timestamp)
- updated_at (timestamp)
```

## Cara Migrasi Database

Jika database sudah ada data sebelumnya:

```bash
# Run migration
php artisan migrate

# Jika ada error karena data existing, bisa rollback dulu
php artisan migrate:rollback --step=1

# Kemudian migrate ulang
php artisan migrate
```

## Testing

### 1. Test Form Registrasi
1. Akses `/register`
2. Isi semua field yang required
3. Upload foto PIC (max 2MB)
4. Upload file KTP (max 5MB)
5. Submit form
6. Pastikan redirect ke login dengan success message

### 2. Test Admin View Detail
1. Login sebagai admin
2. Akses `admin/sellers`
3. Klik "View Detail" pada salah satu seller
4. Pastikan semua informasi tampil lengkap
5. Pastikan foto dan file KTP bisa dipreview

### 3. Test Approve/Reject
1. Di halaman detail seller
2. Klik "Setujui Seller" atau "Tolak Seller"
3. Pastikan status berubah
4. Cek juga status di tabel `users` dan `seller` berubah

## File Upload Storage

File diupload ke:
- Foto PIC: `storage/app/public/seller/pic_photos/`
- File KTP: `storage/app/public/seller/ktp_files/`

Pastikan symbolic link sudah dibuat:
```bash
php artisan storage:link
```

## Validasi Form

### Client-Side
- Nomor KTP harus 16 digit (maxlength attribute)
- File size validation via JavaScript
- Preview image sebelum upload

### Server-Side
- Required fields validation
- Email format validation
- File type validation (MIME type)
- File size validation (2MB untuk foto, 5MB untuk KTP)
- Unique validation untuk nomor KTP
- String length validation

## Security Considerations

1. **File Upload Security**
   - Validasi MIME type
   - Validasi file size
   - File disimpan dengan nama random (Laravel default)
   - File di-store di storage/app/public (tidak di public root)

2. **Database Transaction**
   - Menggunakan DB transaction untuk ensure data consistency
   - Rollback jika ada error
   - Delete uploaded files jika transaction gagal

3. **Input Sanitization**
   - Laravel otomatis sanitize input
   - Mass assignment protection via $fillable

## UI/UX Improvements

1. **Form Organization**
   - Form dibagi menjadi 4 section yang jelas
   - Setiap section memiliki border dan spacing yang baik
   - Required fields ditandai dengan asterisk merah

2. **File Upload**
   - Preview image sebelum submit
   - Informasi file size setelah select
   - Clear visual feedback

3. **Admin Detail Page**
   - Layout 2 kolom responsif
   - Card-based design untuk setiap section
   - Preview dokumen langsung di halaman
   - Action buttons yang jelas

4. **Responsive Design**
   - Grid layout responsif
   - Mobile-friendly form
   - Tailwind CSS utilities

## Future Enhancements (Optional)

1. **Email Notification**
   - Kirim email ke seller saat approved/rejected
   - Email reminder untuk admin jika ada pending seller

2. **File Compression**
   - Compress image sebelum save
   - Generate thumbnail untuk preview

3. **Address Autocomplete**
   - Integrasi dengan API address (e.g., Google Places)
   - Dropdown provinsi, kota, kelurahan dari database

4. **Document Verification**
   - OCR untuk validasi nomor KTP dari foto
   - Face matching antara foto PIC dengan foto di KTP

5. **Multi-step Form**
   - Bagi form menjadi beberapa step
   - Progress indicator
   - Save draft functionality

## Troubleshooting

### Error: "The link already exists"
```bash
# Hapus symbolic link lama
rm public/storage
# Buat ulang
php artisan storage:link
```

### Error: "SQLSTATE[42S21]: Column already exists"
```bash
# Rollback migration
php artisan migrate:rollback --step=1
# Migrate ulang
php artisan migrate
```

### Error: "File too large"
- Cek php.ini: `upload_max_filesize` dan `post_max_size`
- Restart web server setelah mengubah php.ini

### Preview image tidak muncul
- Pastikan `storage:link` sudah dibuat
- Cek permission folder `storage/app/public`
- Cek permission folder `public/storage`

## Changelog

### Version 1.1.0 (2025-11-28)
- ✅ Tambah 14 field baru untuk registrasi seller
- ✅ Implementasi file upload untuk foto PIC dan KTP
- ✅ Halaman detail seller untuk admin
- ✅ Update validasi form
- ✅ UI/UX improvements
- ✅ Database migration
- ✅ Transaction handling untuk data consistency

## Contact

Jika ada pertanyaan atau issue, silakan hubungi tim development.