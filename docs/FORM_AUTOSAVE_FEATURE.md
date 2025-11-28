# Fitur Auto-Save Form Registrasi

## 📋 Deskripsi

Fitur ini memastikan bahwa data yang telah diinputkan oleh user dalam form registrasi **tidak akan hilang** ketika terjadi kegagalan validasi atau error pada proses registrasi.

## ✨ Fitur Utama

### 1. **Server-Side Data Persistence (Laravel)**
- Menggunakan helper `old()` Laravel untuk mempertahankan semua input text, email, dan textarea
- Ketika validasi gagal, Laravel akan otomatis mengembalikan semua data yang telah diinput menggunakan `withInput()`
- User tidak perlu mengisi ulang field yang sudah benar

### 2. **Client-Side Auto-Save (JavaScript + localStorage)**
- Data form disimpan secara otomatis ke localStorage browser
- Penyimpanan dilakukan dengan debouncing (500ms) untuk efisiensi
- Indikator visual "Data tersimpan otomatis" muncul setelah data disimpan
- Data akan di-restore otomatis jika user merefresh halaman

### 3. **Enhanced Error Display**
- Error summary box yang menampilkan semua kesalahan validasi
- Setiap field menampilkan error message spesifik
- Pesan custom untuk setiap jenis error validasi
- Visual feedback dengan border merah pada field yang error

### 4. **File Upload Handling**
- Notifikasi khusus bahwa file perlu dipilih ulang karena keterbatasan browser
- Preview image untuk file yang diupload
- Informasi ukuran file yang dipilih
- Validasi format dan ukuran file di client dan server side

## 🔧 Implementasi Teknis

### Controller (RegisterController.php)

```php
// Validasi dengan custom error messages yang informatif
$validated = $request->validate([...], [
    "name.required" => "Nama lengkap wajib diisi",
    "email.unique" => "Email sudah terdaftar",
    // ... dll
]);

// Ketika terjadi error dalam transaction
return redirect()
    ->back()
    ->withInput()  // <-- Mempertahankan input user
    ->withErrors([
        "error" => "Terjadi kesalahan saat registrasi. Silakan coba lagi.",
    ]);
```

### View (register.blade.php)

#### Error Display
```blade
@if($errors->any() && !$errors->has('error'))
    <div class="mb-6 bg-red-50 border border-red-200">
        <!-- Menampilkan semua error dengan daftar -->
        <ul class="list-disc list-inside space-y-1">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
```

#### Input Fields dengan old()
```blade
<input type="text" name="name" value="{{ old('name') }}" 
    class="@error('name') border-red-500 @enderror">
@error('name')
    <p class="text-red-600">{{ $message }}</p>
@enderror
```

#### JavaScript Auto-Save
```javascript
// Simpan data ke localStorage setiap kali user mengetik
field.addEventListener('input', function() {
    clearTimeout(saveTimeout);
    saveTimeout = setTimeout(function() {
        saveFormData();
        showSaveIndicator();
    }, 500);
});

// Restore data saat halaman dimuat
const savedData = localStorage.getItem(storageKey);
if (savedData && !hasServerErrors()) {
    const data = JSON.parse(savedData);
    formFields.forEach(field => {
        if (data[field.name] && !field.value) {
            field.value = data[field.name];
        }
    });
}
```

## 🎯 Cara Kerja

### Skenario 1: Validasi Gagal (Server-Side)

1. User mengisi form registrasi
2. User submit form
3. Server melakukan validasi
4. Validasi gagal (misalnya: email sudah terdaftar)
5. **Server mengembalikan response dengan `withInput()`**
6. **Semua field text/email/textarea otomatis terisi kembali dengan `old()` helper**
7. User hanya perlu memperbaiki field yang error dan upload ulang file

### Skenario 2: Browser Refresh/Crash (Client-Side)

1. User mengisi form registrasi
2. Setiap input disimpan ke localStorage (auto-save)
3. Browser di-refresh atau crash
4. **Halaman dimuat ulang**
5. **JavaScript otomatis restore data dari localStorage**
6. User dapat melanjutkan dari terakhir kali mengetik

### Skenario 3: Transaction Failure

1. User submit form dengan data valid
2. File berhasil diupload
3. Database transaction gagal (network error, dll)
4. **File yang diupload otomatis dihapus**
5. **User diredirect ke form dengan data tetap terisi**
6. Error message informatif ditampilkan
7. User hanya perlu upload ulang file dan submit kembali

## 📊 Data yang Dipersist

### ✅ Data yang Tersimpan Otomatis:
- ✅ Nama Lengkap
- ✅ Email
- ✅ Nama Toko
- ✅ Deskripsi Toko
- ✅ Data PIC (Nama, HP, Email, No KTP)
- ✅ Alamat Lengkap (Jalan, RT, RW, Kelurahan, Kota, Provinsi)

### ⚠️ Data yang Perlu Input Ulang:
- ⚠️ Password & Konfirmasi Password (security reason)
- ⚠️ Foto PIC (keterbatasan browser)
- ⚠️ File KTP (keterbatasan browser)

## 🎨 User Experience

### Visual Feedback
1. **Info Box Biru**: Memberitahu user bahwa data akan tersimpan otomatis
2. **Error Box Merah**: Menampilkan semua error validasi dengan jelas
3. **Field Border Merah**: Highlight field yang memiliki error
4. **Save Indicator**: Animasi "Data tersimpan otomatis" setiap kali user mengetik
5. **File Preview**: Preview gambar yang diupload beserta ukuran file
6. **Warning File Upload**: Peringatan bahwa file perlu dipilih ulang jika ada error

### Informational Messages
- "💾 Data Anda Aman" - Info box di awal form
- "⚠️ File perlu dipilih ulang karena ada kesalahan pada form" - Warning pada file input
- "Terdapat kesalahan pada form: Mohon periksa kembali data yang Anda masukkan" - Error summary

## 🔒 Security & Privacy

### Browser Storage
- Data disimpan di localStorage browser user (client-side)
- Data hanya dapat diakses dari domain yang sama
- Data tidak dikirim ke server sampai user submit
- Password TIDAK disimpan di localStorage

### Server-Side
- Validasi tetap dilakukan di server untuk security
- File upload divalidasi format dan ukuran
- Database transaction untuk data consistency
- File dihapus otomatis jika transaction gagal

## 🧪 Testing

### Test Case 1: Email Sudah Terdaftar
1. Isi semua field form
2. Gunakan email yang sudah terdaftar
3. Submit form
4. **Expected**: Error "Email sudah terdaftar", semua field lain tetap terisi

### Test Case 2: Password Tidak Sesuai
1. Isi semua field form
2. Password dan konfirmasi password tidak sama
3. Submit form
4. **Expected**: Error "Konfirmasi password tidak sesuai", semua field lain tetap terisi kecuali password

### Test Case 3: File Terlalu Besar
1. Isi semua field form
2. Upload foto PIC > 2MB
3. Submit form
4. **Expected**: Error "Ukuran foto PIC maksimal 2MB", semua field tetap terisi, file perlu upload ulang

### Test Case 4: Browser Refresh
1. Isi beberapa field form
2. Tunggu indikator "Data tersimpan otomatis"
3. Refresh browser
4. **Expected**: Semua field yang sudah diisi kembali muncul

### Test Case 5: Multiple Errors
1. Isi beberapa field dengan data invalid
2. Submit form
3. **Expected**: Summary box menampilkan semua error, field yang sudah benar tetap terisi

## 🚀 Manfaat

1. **User Experience Lebih Baik**: User tidak frustasi harus mengisi ulang form panjang
2. **Mengurangi Bounce Rate**: User lebih mungkin menyelesaikan registrasi
3. **Error Recovery**: User dapat dengan mudah memperbaiki error tanpa kehilangan progress
4. **Accessibility**: Membantu user dengan koneksi tidak stabil atau device dengan performa rendah
5. **Professional**: Menunjukkan aplikasi yang well-designed dan user-centric

## 📝 Notes

- localStorage memiliki limit ~5-10MB per domain (cukup untuk form data)
- Data di localStorage tidak expire secara otomatis, akan dihapus setelah submit sukses
- User dapat manual clear data dengan tombol "Hapus data tersimpan otomatis" (jika ada data tersimpan)
- Fitur ini kompatibel dengan semua browser modern (IE11+, Chrome, Firefox, Safari, Edge)

## 🔄 Future Improvements

1. **Auto-save ke Server**: Opsi untuk save draft di server untuk persistence lintas device
2. **Progress Bar**: Visual indicator seberapa banyak field yang sudah diisi
3. **Field Validation on Blur**: Real-time validation sebelum submit
4. **Smart File Resume**: Teknologi untuk resume file upload yang terputus
5. **Multi-step Form**: Pecah form panjang menjadi beberapa step dengan progress save