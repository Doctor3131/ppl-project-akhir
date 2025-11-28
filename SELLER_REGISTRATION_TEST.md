# Quick Test Guide - Registrasi Seller Baru

## Prerequisites
1. Aplikasi sudah running
2. Database sudah di-migrate
3. Storage link sudah dibuat (`php artisan storage:link`)

## Test Data untuk Registrasi

### Data Akun
- **Nama Lengkap**: John Doe
- **Email**: john.seller@example.com
- **Password**: password123
- **Confirm Password**: password123

### Data Toko
- **Nama Toko**: Toko Elektronik Maju Jaya
- **Deskripsi Singkat**: Menjual berbagai macam elektronik berkualitas dengan harga terjangkau. Melayani pengiriman ke seluruh Indonesia.

### Data PIC (Person In Charge)
- **Nama PIC**: John Doe
- **No HP PIC**: 081234567890
- **Email PIC**: john.pic@example.com
- **No KTP PIC**: 3275010101990001

### Alamat Lengkap
- **Jalan**: Jl. Sudirman No. 123, Senayan
- **RT**: 001
- **RW**: 005
- **Kelurahan**: Senayan
- **Kota/Kabupaten**: Jakarta Selatan
- **Provinsi**: DKI Jakarta

### Upload Dokumen
- **Foto PIC**: Upload foto selfie (JPG/PNG, max 2MB)
- **File KTP**: Upload scan/foto KTP (JPG/PNG/PDF, max 5MB)

---

## Langkah Testing

### 1. Test Registrasi Seller Baru

```bash
# Akses halaman registrasi
http://localhost:8000/register
```

**Steps:**
1. Isi semua field data akun
2. Isi data toko (nama toko wajib, deskripsi optional)
3. Isi data PIC lengkap
4. Isi alamat lengkap dengan detail
5. Upload foto PIC (gunakan foto dummy < 2MB)
6. Upload file KTP (gunakan file dummy < 5MB)
7. Klik tombol "Daftar Sebagai Penjual"
8. **Expected**: Redirect ke halaman login dengan pesan sukses

### 2. Test Validasi Form

**Test Case 1: Email Duplikat**
- Gunakan email yang sudah terdaftar
- **Expected**: Error "The email has already been taken"

**Test Case 2: Nomor KTP Duplikat**
- Gunakan nomor KTP yang sudah terdaftar
- **Expected**: Error "Nomor KTP sudah terdaftar"

**Test Case 3: Nomor KTP Tidak Valid**
- Input nomor KTP kurang dari 16 digit
- **Expected**: Error "Nomor KTP harus 16 digit"

**Test Case 4: File Terlalu Besar**
- Upload foto > 2MB atau KTP > 5MB
- **Expected**: Error tentang ukuran file

**Test Case 5: Format File Salah**
- Upload file .doc atau .txt untuk foto
- **Expected**: Error tentang format file

**Test Case 6: Field Kosong**
- Kosongkan field required
- **Expected**: Error validation untuk field yang kosong

### 3. Test Login Seller Pending

```bash
# Coba login dengan akun seller yang baru didaftar
http://localhost:8000/login
```

**Steps:**
1. Input email dan password seller yang baru didaftar
2. Klik Login
3. **Expected**: Error "Your account is pending approval"

### 4. Test Admin View Sellers

```bash
# Login sebagai admin terlebih dahulu
Email: admin@example.com
Password: password

# Akses halaman manage sellers
http://localhost:8000/admin/sellers
```

**Steps:**
1. Lihat daftar seller
2. Seller baru harus muncul dengan status "Pending"
3. Cek kolom Shop Name terisi dengan benar
4. Klik "View Detail" pada seller baru
5. **Expected**: Tampil halaman detail lengkap seller

### 5. Test Admin View Detail Seller

**Verifikasi Data:**
- [ ] Data Akun tampil lengkap
- [ ] Data Toko tampil (nama toko dan deskripsi)
- [ ] Data PIC tampil lengkap (nama, HP, email, no KTP)
- [ ] Alamat lengkap tampil detail (jalan, RT/RW, kelurahan, kota, provinsi)
- [ ] Alamat lengkap terformat dengan baik
- [ ] Foto PIC tampil dan bisa diklik untuk view full
- [ ] File KTP tampil (preview jika image, link download jika PDF)
- [ ] Status "Pending" tampil di header
- [ ] Button "Setujui Seller" dan "Tolak Seller" tersedia

### 6. Test Admin Approve Seller

**Steps:**
1. Di halaman detail seller, klik "Setujui Seller"
2. Konfirmasi approval
3. **Expected**: Redirect ke daftar seller dengan success message
4. Status seller berubah menjadi "Approved"
5. Verified date tercatat

**Verifikasi Database:**
```sql
SELECT * FROM users WHERE email = 'john.seller@example.com';
-- status harus 'approved'

SELECT * FROM seller WHERE user_id = [id dari query atas];
-- status harus 'approved'
-- verified_at harus terisi
```

### 7. Test Seller Login After Approval

```bash
# Logout dari admin
# Login sebagai seller yang sudah approved
Email: john.seller@example.com
Password: password123
```

**Steps:**
1. Input credentials
2. Klik Login
3. **Expected**: 
   - Login berhasil
   - Redirect ke seller dashboard
   - Bisa akses menu seller

### 8. Test Admin Reject Seller

**Setup:**
1. Daftarkan seller baru (gunakan email berbeda)
2. Login sebagai admin
3. Buka detail seller baru

**Steps:**
1. Klik "Tolak Seller"
2. Konfirmasi rejection
3. **Expected**: 
   - Redirect ke daftar seller
   - Status berubah jadi "Rejected"
   - Button berubah jadi "Approve" saja

### 9. Test File Upload

**Test Preview Image:**
1. Saat register, pilih file foto
2. **Expected**: Preview image muncul di bawah input
3. **Expected**: Nama file dan size ditampilkan

**Test Storage:**
1. Setelah registrasi berhasil
2. Cek folder `storage/app/public/seller/pic_photos/`
3. **Expected**: File foto PIC tersimpan
4. Cek folder `storage/app/public/seller/ktp_files/`
5. **Expected**: File KTP tersimpan

**Test Public Access:**
1. Buka URL foto: `http://localhost:8000/storage/seller/pic_photos/[filename]`
2. **Expected**: Foto bisa diakses

### 10. Test Rollback Transaction

**Simulasi Error:**
Untuk test ini, buat kondisi error (misalnya database connection loss) saat proses registrasi:

**Expected Behavior:**
- Jika terjadi error, uploaded files harus terhapus
- Data user dan seller tidak masuk ke database
- User melihat error message yang informatif

---

## Checklist Testing

### Functionality
- [ ] Form registrasi bisa diakses
- [ ] Semua field bisa diisi
- [ ] File upload berfungsi
- [ ] Preview image berfungsi
- [ ] Form validation bekerja (client & server side)
- [ ] Registrasi berhasil simpan data
- [ ] Redirect ke login dengan success message
- [ ] Seller pending tidak bisa login
- [ ] Admin bisa lihat list seller
- [ ] Admin bisa lihat detail seller
- [ ] Admin bisa approve seller
- [ ] Admin bisa reject seller
- [ ] Seller approved bisa login
- [ ] Files tersimpan di storage
- [ ] Files bisa diakses via URL

### UI/UX
- [ ] Form layout rapi dan terorganisir
- [ ] Required fields ditandai dengan jelas
- [ ] Error messages informatif
- [ ] Success messages tampil
- [ ] Responsive di mobile
- [ ] Loading state saat submit
- [ ] Preview dokumen di admin detail
- [ ] Action buttons jelas dan accessible

### Security
- [ ] Password di-hash
- [ ] File upload tervalidasi (type & size)
- [ ] SQL injection protected
- [ ] XSS protected
- [ ] CSRF token ada di form
- [ ] Uploaded files tidak executable

### Data Integrity
- [ ] Transaction rollback berfungsi
- [ ] Unique constraint berfungsi (email, KTP)
- [ ] Foreign key relationships benar
- [ ] Status sinkron antara users dan seller table
- [ ] Timestamps tercatat dengan benar

---

## Common Issues & Solutions

### Issue: Upload file gagal
**Solution:**
- Cek permission folder `storage/app/public`
- Pastikan `storage:link` sudah dibuat
- Cek php.ini: `upload_max_filesize` dan `post_max_size`

### Issue: Preview image tidak muncul
**Solution:**
- Cek JavaScript console untuk error
- Pastikan file yang diupload adalah image
- Cek browser compatibility

### Issue: Validation error tidak jelas
**Solution:**
- Cek di console Laravel log: `storage/logs/laravel.log`
- Enable debug mode di `.env`: `APP_DEBUG=true`

### Issue: Status tidak berubah setelah approve
**Solution:**
- Cek kedua tabel (users dan seller)
- Refresh halaman
- Clear cache: `php artisan cache:clear`

---

## Sample cURL Commands

### Register Seller
```bash
curl -X POST http://localhost:8000/register \
  -H "Content-Type: multipart/form-data" \
  -F "name=John Doe" \
  -F "email=john.seller@example.com" \
  -F "password=password123" \
  -F "password_confirmation=password123" \
  -F "shop_name=Toko Elektronik Maju Jaya" \
  -F "shop_description=Menjual elektronik berkualitas" \
  -F "pic_name=John Doe" \
  -F "pic_phone=081234567890" \
  -F "pic_email=john.pic@example.com" \
  -F "pic_ktp_number=3275010101990001" \
  -F "street_address=Jl. Sudirman No. 123" \
  -F "rt=001" \
  -F "rw=005" \
  -F "kelurahan=Senayan" \
  -F "kota_kabupaten=Jakarta Selatan" \
  -F "province=DKI Jakarta" \
  -F "pic_photo=@/path/to/photo.jpg" \
  -F "ktp_file=@/path/to/ktp.jpg"
```

---

## Performance Testing

### Load Testing Registration
1. Register 10 sellers simultaneously
2. Check response time
3. Verify all data saved correctly
4. Check server load

### File Upload Performance
1. Upload maximum size files (2MB + 5MB)
2. Measure upload time
3. Check server memory usage

---

## Regression Testing

After any code changes, retest:
1. Basic registration flow
2. Admin approval flow
3. File upload functionality
4. All validations
5. Login functionality

---

## Notes

- Gunakan dummy images dari https://picsum.photos/ untuk testing
- Gunakan PDF dummy dari https://www.w3.org/WAI/ER/tests/xhtml/testfiles/resources/pdf/dummy.pdf
- Simpan screenshot untuk dokumentasi
- Report semua bugs yang ditemukan