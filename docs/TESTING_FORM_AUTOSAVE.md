# Testing Guide - Form Auto-Save Feature

## 📋 Overview
Panduan ini menjelaskan cara testing fitur auto-save pada form registrasi penjual untuk memastikan data user tidak hilang saat terjadi error validasi.

## 🎯 Prerequisites
- Aplikasi Laravel sudah running
- Browser dengan Developer Tools (Chrome/Firefox recommended)
- Database sudah di-setup dan migrate

## 🧪 Test Scenarios

### Test 1: Email Sudah Terdaftar (Validasi Gagal)

**Tujuan**: Memastikan data tidak hilang saat email sudah terdaftar

**Langkah-langkah**:
1. Buka halaman registrasi: `http://localhost:8000/register`
2. Isi semua field dengan data berikut:
   - **Nama Lengkap**: John Doe
   - **Email**: email_yang_sudah_ada@example.com (gunakan email yang sudah ada di database)
   - **Password**: password123
   - **Konfirmasi Password**: password123
   - **Nama Toko**: Toko Elektronik Jaya
   - **Deskripsi Toko**: Menjual berbagai elektronik berkualitas
   - **Nama PIC**: John Doe
   - **No HP PIC**: 081234567890
   - **Email PIC**: john.pic@example.com
   - **No KTP PIC**: 1234567890123456
   - **Jalan**: Jl. Sudirman No. 123
   - **RT**: 001
   - **RW**: 002
   - **Kelurahan**: Kebayoran Baru
   - **Kota/Kabupaten**: Jakarta Selatan
   - **Provinsi**: DKI Jakarta
   - Upload foto dan KTP

3. Klik "Daftar Sebagai Penjual"

**Expected Result**:
- ✅ Muncul error: "Email sudah terdaftar"
- ✅ Semua field text tetap terisi dengan data yang sama
- ✅ Password field kosong (security)
- ✅ File upload perlu dipilih ulang
- ✅ Muncul peringatan di file upload: "File perlu dipilih ulang"

---

### Test 2: Password Tidak Sesuai

**Tujuan**: Memastikan data tidak hilang saat konfirmasi password salah

**Langkah-langkah**:
1. Buka halaman registrasi
2. Isi semua field dengan benar
3. Isi Password: `password123`
4. Isi Konfirmasi Password: `password456` (berbeda)
5. Upload foto dan KTP
6. Klik "Daftar Sebagai Penjual"

**Expected Result**:
- ✅ Muncul error: "Konfirmasi password tidak sesuai"
- ✅ Semua field tetap terisi KECUALI password fields
- ✅ File upload perlu dipilih ulang

---

### Test 3: Nomor KTP Tidak Valid

**Tujuan**: Memastikan validasi KTP dan data persistence

**Langkah-langkah**:
1. Buka halaman registrasi
2. Isi semua field
3. Isi No KTP dengan 10 digit saja: `1234567890`
4. Upload foto dan KTP
5. Klik submit

**Expected Result**:
- ✅ Muncul error: "Nomor KTP harus 16 digit"
- ✅ Semua field lain tetap terisi
- ✅ No KTP yang salah masih muncul di field
- ✅ File perlu upload ulang

---

### Test 4: File Upload Terlalu Besar

**Tujuan**: Memastikan validasi ukuran file

**Langkah-langkah**:
1. Buka halaman registrasi
2. Isi semua field dengan benar
3. Upload Foto PIC > 2MB
4. Upload KTP dengan ukuran normal
5. Klik submit

**Expected Result**:
- ✅ Muncul error: "Ukuran foto PIC maksimal 2MB"
- ✅ Semua field text tetap terisi
- ✅ Kedua file perlu upload ulang

---

### Test 5: Multiple Errors

**Tujuan**: Testing dengan banyak error sekaligus

**Langkah-langkah**:
1. Buka halaman registrasi
2. Isi beberapa field dengan data INVALID:
   - Email: format salah `emailsalah`
   - Password: kurang dari 8 karakter `pass`
   - No KTP: 10 digit saja
3. Isi field lain dengan BENAR
4. Upload file yang terlalu besar
5. Klik submit

**Expected Result**:
- ✅ Muncul error summary box dengan daftar semua error
- ✅ Field yang VALID tetap terisi
- ✅ Field yang INVALID tetap terisi (untuk diperbaiki)
- ✅ Visual highlight (border merah) pada field yang error

---

### Test 6: Browser Refresh (localStorage)

**Tujuan**: Memastikan localStorage auto-save bekerja

**Langkah-langkah**:
1. Buka halaman registrasi
2. Isi beberapa field (3-5 field saja):
   - Nama Lengkap: John Doe
   - Email: test@example.com
   - Nama Toko: Toko ABC
3. Tunggu 1 detik sampai muncul indikator "Data tersimpan otomatis"
4. **Refresh browser** (F5 atau Ctrl+R)
5. Lihat form yang baru dimuat

**Expected Result**:
- ✅ Field yang sudah diisi sebelumnya tetap muncul
- ✅ Data di-restore dari localStorage
- ✅ User dapat melanjutkan mengisi field yang kosong

**Note**: Test ini untuk fitur client-side auto-save, bukan server-side

---

### Test 7: Clear localStorage

**Tujuan**: Memastikan tombol clear localStorage bekerja

**Langkah-langkah**:
1. Buka halaman registrasi
2. Isi beberapa field
3. Tunggu sampai data tersimpan (indikator muncul)
4. Refresh browser
5. Lihat ada tombol "Hapus data tersimpan otomatis" di atas form
6. Klik tombol tersebut
7. Refresh browser lagi

**Expected Result**:
- ✅ Alert "Data form yang tersimpan otomatis telah dihapus"
- ✅ Setelah refresh, field kosong lagi
- ✅ Tombol clear tidak muncul lagi

---

### Test 8: File Preview

**Tujuan**: Memastikan preview file bekerja

**Langkah-langkah**:
1. Buka halaman registrasi
2. Pilih file foto PIC (format JPG/PNG)
3. Lihat preview yang muncul

**Expected Result**:
- ✅ Muncul teks: "File terpilih: [nama_file] ([ukuran] MB)"
- ✅ Muncul preview gambar di bawah input
- ✅ Green checkmark icon muncul

**Langkah tambahan untuk PDF**:
4. Pilih file KTP (format PDF)
5. Lihat preview

**Expected Result**:
- ✅ Muncul teks dengan nama file dan ukuran
- ✅ Tidak ada preview gambar (karena PDF)

---

### Test 9: Auto-save Indicator

**Tujuan**: Memastikan visual feedback auto-save

**Langkah-langkah**:
1. Buka halaman registrasi
2. Ketik di field "Nama Lengkap"
3. Stop mengetik dan tunggu 500ms
4. Lihat area bawah tombol submit

**Expected Result**:
- ✅ Muncul indikator "Data tersimpan otomatis" dengan icon checkmark hijau
- ✅ Indikator fade in (opacity dari 0 ke 1)
- ✅ Setelah 2 detik, indikator fade out

---

### Test 10: Successful Registration + localStorage Clear

**Tujuan**: Memastikan localStorage dibersihkan setelah sukses

**Langkah-langkah**:
1. Buka halaman registrasi
2. Isi SEMUA field dengan data VALID dan BARU
3. Upload foto dan KTP dengan ukuran valid
4. Klik submit
5. Setelah redirect ke login page
6. Kembali ke halaman register

**Expected Result**:
- ✅ Registrasi berhasil
- ✅ Redirect ke login dengan pesan sukses
- ✅ localStorage untuk form register sudah kosong
- ✅ Form kosong lagi (tidak ada data lama)

---

## 🔍 Browser Developer Tools Testing

### Check localStorage

**Chrome DevTools**:
1. Buka DevTools (F12)
2. Tab: Application
3. Storage > Local Storage > http://localhost:8000
4. Cari key: `register_form_data`
5. Lihat isi value (JSON format)

**Expected**: 
```json
{
  "name": "John Doe",
  "email": "test@example.com",
  "shop_name": "Toko ABC",
  ...
}
```

### Network Tab - Check POST Request

**Langkah**:
1. Buka DevTools > Network tab
2. Submit form (dengan error atau sukses)
3. Lihat POST request ke `/register`
4. Tab: Payload/Form Data

**Expected**: Semua field terkirim dengan benar

---

## 🐛 Bug Testing

### Edge Case 1: XSS Injection
**Test**: Masukkan `<script>alert('xss')</script>` di field nama
**Expected**: Text akan di-escape, tidak execute sebagai script

### Edge Case 2: Very Long Text
**Test**: Masukkan text 1000+ karakter di field yang ada max limit
**Expected**: Validasi gagal dengan pesan yang jelas

### Edge Case 3: Special Characters
**Test**: Masukkan emoji atau special characters di field text
**Expected**: Tersimpan dan di-restore dengan benar

---

## ✅ Checklist Testing

Gunakan checklist ini untuk memastikan semua aspek sudah di-test:

- [ ] Error validasi email sudah terdaftar
- [ ] Error validasi password tidak sesuai
- [ ] Error validasi nomor KTP invalid
- [ ] Error validasi file terlalu besar
- [ ] Multiple errors sekaligus
- [ ] Browser refresh - data restore dari localStorage
- [ ] Clear localStorage button
- [ ] File preview (image & PDF)
- [ ] Auto-save indicator animation
- [ ] Successful registration clear localStorage
- [ ] Field highlighting (border merah) pada error
- [ ] Error messages yang jelas dan informatif
- [ ] Info box "Data Anda Aman" muncul
- [ ] Warning file upload muncul saat ada error
- [ ] Password tidak tersimpan di localStorage
- [ ] old() helper Laravel bekerja dengan baik

---

## 📊 Test Report Template

```
TEST REPORT - Form Auto-Save Feature
Date: [tanggal]
Tester: [nama]
Environment: [local/staging/production]
Browser: [Chrome/Firefox/Safari] version [x.x]

Test Results:
1. Test Email Sudah Terdaftar: [✅ PASS / ❌ FAIL]
   Notes: ...

2. Test Password Tidak Sesuai: [✅ PASS / ❌ FAIL]
   Notes: ...

3. Test Nomor KTP Invalid: [✅ PASS / ❌ FAIL]
   Notes: ...

... (lanjutkan untuk semua test)

Issues Found:
- [Issue 1 description]
- [Issue 2 description]

Overall: [PASS / FAIL with issues / FAIL]
```

---

## 🚨 Known Limitations

1. **File Upload**: Browser tidak bisa mempertahankan file input untuk security. User HARUS upload ulang file setiap kali ada error.
2. **Password**: Tidak disimpan di localStorage untuk security. User perlu input ulang password jika ada error.
3. **localStorage Limit**: Maksimal ~5-10MB per domain. Cukup untuk form data text, tapi perhatikan jika ada enhancement di masa depan.
4. **Browser Support**: Fitur localStorage tidak work di browser sangat lama (IE < 8). Tapi aplikasi tetap berfungsi, hanya tanpa auto-save.

---

## 💡 Tips Testing

1. **Gunakan Incognito Mode**: Untuk test fresh tanpa cache atau localStorage lama
2. **Clear Browser Cache**: Antara test untuk hasil yang konsisten
3. **Check Console**: Pastikan tidak ada JavaScript error di console
4. **Test di Multiple Browser**: Chrome, Firefox, Safari, Edge
5. **Test di Mobile**: Pastikan responsive dan auto-save tetap work
6. **Network Throttling**: Simulate slow connection di DevTools

---

## 📞 Support

Jika menemukan bug atau issue saat testing:
1. Catat browser dan version
2. Screenshot error message
3. Langkah-langkah reproduce
4. Data yang diinput
5. Expected vs Actual result

Report ke team untuk diperbaiki.