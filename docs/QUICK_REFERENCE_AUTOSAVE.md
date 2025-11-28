# Quick Reference - Form Auto-Save Implementation

## 🚀 Quick Start (5 Minutes)

### Sudah Implemented di:
- ✅ Form Registrasi Seller (`resources/views/auth/register.blade.php`)

### Cara Apply ke Form Lain:

#### Step 1: Controller - Pastikan withInput() Ada
```php
// Di method yang handle POST form
public function store(Request $request)
{
    $validated = $request->validate([
        'field1' => 'required',
        'field2' => 'required|email',
        // ... rules lainnya
    ], [
        // Custom error messages (OPTIONAL tapi recommended)
        'field1.required' => 'Field 1 wajib diisi',
        'field2.email' => 'Format email tidak valid',
    ]);

    try {
        // Your business logic here
        
        return redirect()->route('success')->with('success', 'Berhasil!');
    } catch (\Exception $e) {
        return redirect()
            ->back()
            ->withInput()  // ⬅️ INI PENTING!
            ->withErrors(['error' => 'Terjadi kesalahan']);
    }
}
```

#### Step 2: View - Gunakan old() Helper
```blade
<!-- Text Input -->
<input type="text" name="field_name" value="{{ old('field_name') }}">

<!-- Email Input -->
<input type="email" name="email" value="{{ old('email') }}">

<!-- Textarea -->
<textarea name="description">{{ old('description') }}</textarea>

<!-- Select -->
<select name="category">
    <option value="1" {{ old('category') == '1' ? 'selected' : '' }}>Option 1</option>
</select>

<!-- Checkbox -->
<input type="checkbox" name="agree" {{ old('agree') ? 'checked' : '' }}>

<!-- Radio -->
<input type="radio" name="gender" value="male" {{ old('gender') == 'male' ? 'checked' : '' }}>
```

#### Step 3: View - Error Display
```blade
<!-- Error Summary (Optional) -->
@if($errors->any())
    <div class="bg-red-50 border border-red-200 p-4 rounded">
        <h3 class="font-bold text-red-800">Terdapat kesalahan:</h3>
        <ul class="list-disc list-inside mt-2">
            @foreach($errors->all() as $error)
                <li class="text-red-700">{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<!-- Per-Field Error -->
<input type="text" name="email" value="{{ old('email') }}"
    class="@error('email') border-red-500 @enderror">
@error('email')
    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
@enderror
```

#### Step 4: JavaScript - localStorage Auto-Save (OPTIONAL)
```blade
<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.querySelector('form');
    const formFields = form.querySelectorAll('input[type="text"], input[type="email"], textarea');
    const storageKey = 'my_form_data'; // ⬅️ GANTI ini sesuai form Anda

    // Restore dari localStorage
    const savedData = localStorage.getItem(storageKey);
    if (savedData) {
        try {
            const data = JSON.parse(savedData);
            formFields.forEach(field => {
                if (data[field.name] && !field.value) {
                    field.value = data[field.name];
                }
            });
        } catch (e) {
            console.error('Error restoring data:', e);
        }
    }

    // Save on input
    let saveTimeout;
    formFields.forEach(field => {
        field.addEventListener('input', function() {
            clearTimeout(saveTimeout);
            saveTimeout = setTimeout(function() {
                const data = {};
                formFields.forEach(f => {
                    data[f.name] = f.value;
                });
                localStorage.setItem(storageKey, JSON.stringify(data));
            }, 500);
        });
    });

    // Clear on success submit
    form.addEventListener('submit', function() {
        setTimeout(() => localStorage.removeItem(storageKey), 1000);
    });
});
</script>
```

---

## 📋 Checklist Implementation

### Minimum (HARUS Ada)
- [ ] Controller menggunakan `->withInput()` pada error response
- [ ] View menggunakan `{{ old('field_name') }}` di semua input
- [ ] Validation rules sudah benar
- [ ] Error display per-field dengan `@error('field_name')`

### Recommended (Sangat Disarankan)
- [ ] Custom validation error messages dalam Bahasa Indonesia
- [ ] Error summary box di atas form
- [ ] Visual highlight (border merah) pada field error
- [ ] Info box untuk memberitahu user bahwa data tidak hilang

### Advanced (Optional)
- [ ] localStorage auto-save dengan JavaScript
- [ ] Auto-save indicator animation
- [ ] Debouncing untuk performance
- [ ] Clear localStorage button
- [ ] Progress indicator (% form completed)

---

## 🎯 Example: Simple Form

### Controller
```php
public function store(Request $request)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users',
        'message' => 'required|min:10',
    ], [
        'name.required' => 'Nama wajib diisi',
        'email.unique' => 'Email sudah terdaftar',
        'message.min' => 'Pesan minimal 10 karakter',
    ]);

    // Process...

    return redirect()->route('success');
}
```

### View
```blade
@if($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form method="POST" action="{{ route('contact.store') }}">
    @csrf
    
    <div>
        <label>Nama</label>
        <input type="text" name="name" value="{{ old('name') }}" 
            class="@error('name') is-invalid @enderror">
        @error('name')
            <span class="error">{{ $message }}</span>
        @enderror
    </div>

    <div>
        <label>Email</label>
        <input type="email" name="email" value="{{ old('email') }}"
            class="@error('email') is-invalid @enderror">
        @error('email')
            <span class="error">{{ $message }}</span>
        @enderror
    </div>

    <div>
        <label>Pesan</label>
        <textarea name="message" class="@error('message') is-invalid @enderror">{{ old('message') }}</textarea>
        @error('message')
            <span class="error">{{ $message }}</span>
        @enderror
    </div>

    <button type="submit">Kirim</button>
</form>
```

---

## 🔍 Debugging Tips

### Data Tidak Tersimpan?
1. ✅ Cek controller ada `->withInput()`
2. ✅ Cek view ada `{{ old('field_name') }}`
3. ✅ Pastikan name attribute di input sama dengan key validation
4. ✅ Cek Laravel log: `storage/logs/laravel.log`

### localStorage Tidak Bekerja?
1. ✅ Cek console browser untuk JavaScript error
2. ✅ Cek localStorage di DevTools > Application tab
3. ✅ Pastikan storageKey unique per form
4. ✅ Test di Incognito mode (bersih dari data lama)

### Validation Error Tidak Muncul?
1. ✅ Pastikan `@error('field_name')` menggunakan nama yang benar
2. ✅ Cek ada `@csrf` di form
3. ✅ Cek method form adalah POST
4. ✅ Cek route exist dan benar

---

## 💡 Best Practices

### DO ✅
- Selalu gunakan `old()` untuk semua input field
- Berikan custom error messages yang jelas
- Tampilkan error summary DAN per-field error
- Test dengan berbagai jenis error
- Document storageKey untuk localStorage

### DON'T ❌
- Jangan simpan password di localStorage
- Jangan simpan sensitive data di localStorage
- Jangan lupa clear localStorage setelah sukses
- Jangan hardcode error messages di view
- Jangan lupa validation di server-side

---

## 📊 Common Validation Rules

```php
'field' => 'required',              // Wajib diisi
'field' => 'required|string',       // Wajib, tipe string
'field' => 'required|email',        // Wajib, format email
'field' => 'required|unique:users', // Wajib, unique di table users
'field' => 'required|min:8',        // Wajib, minimal 8 karakter
'field' => 'required|max:255',      // Wajib, maksimal 255 karakter
'field' => 'required|confirmed',    // Wajib, harus match dengan field_confirmation
'field' => 'required|numeric',      // Wajib, angka
'field' => 'required|integer',      // Wajib, integer
'field' => 'required|in:a,b,c',     // Wajib, nilai harus a/b/c
'field' => 'nullable|email',        // Optional, tapi jika ada harus email
'field' => 'required|size:16',      // Wajib, panjang tepat 16
'field' => 'required|between:5,10', // Wajib, panjang antara 5-10
```

---

## 🎨 Tailwind CSS Classes (Quick Copy)

```html
<!-- Error Box -->
<div class="bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-lg">
    {{ $message }}
</div>

<!-- Success Box -->
<div class="bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-lg">
    {{ $message }}
</div>

<!-- Info Box -->
<div class="bg-blue-50 border border-blue-200 text-blue-800 px-4 py-3 rounded-lg">
    {{ $message }}
</div>

<!-- Warning Box -->
<div class="bg-yellow-50 border border-yellow-200 text-yellow-800 px-4 py-3 rounded-lg">
    {{ $message }}
</div>

<!-- Input with Error -->
<input class="border-red-500 focus:ring-red-500">

<!-- Input Normal -->
<input class="border-gray-300 focus:ring-indigo-500">
```

---

## 📱 Responsive Considerations

```blade
<!-- Desktop & Mobile Friendly -->
<div class="grid grid-cols-1 md:grid-cols-2 gap-4">
    <div>
        <label class="block text-sm font-medium mb-2">Field 1</label>
        <input type="text" name="field1" value="{{ old('field1') }}"
            class="w-full px-4 py-2 border rounded-lg">
    </div>
    <div>
        <label class="block text-sm font-medium mb-2">Field 2</label>
        <input type="text" name="field2" value="{{ old('field2') }}"
            class="w-full px-4 py-2 border rounded-lg">
    </div>
</div>
```

---

## 🧪 Quick Test

### Manual Test (1 minute)
1. Isi form dengan data invalid
2. Submit form
3. ✅ Cek semua field tetap terisi (kecuali password)
4. ✅ Cek error messages muncul
5. ✅ Cek field error ada highlight

### Browser Test (30 seconds)
1. Isi beberapa field
2. Refresh browser (F5)
3. ✅ Jika localStorage implemented: Field tetap terisi
4. ✅ Jika tidak: Normal behavior

---

## 📞 Need Help?

### Resources
- **Laravel Docs**: https://laravel.com/docs/validation
- **Old Input**: https://laravel.com/docs/requests#old-input
- **Error Display**: https://laravel.com/docs/validation#quick-displaying-the-validation-errors
- **localStorage**: https://developer.mozilla.org/en-US/docs/Web/API/Window/localStorage

### Common Issues
- Issue: "old() tidak ada data"
  → Solution: Pastikan controller return `->withInput()`

- Issue: "localStorage error di console"
  → Solution: Check syntax JavaScript, pastikan form exist

- Issue: "Validation tidak jalan"
  → Solution: Pastikan ada @csrf dan method POST

---

## ✨ Advanced: Copy-Paste Complete Solution

### Controller Template
```php
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class YourController extends Controller
{
    public function create()
    {
        return view('your-form');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'unique:users'],
        ], [
            'name.required' => 'Nama wajib diisi',
            'email.required' => 'Email wajib diisi',
            'email.unique' => 'Email sudah terdaftar',
        ]);

        try {
            // Your logic here
            
            return redirect()
                ->route('success')
                ->with('success', 'Data berhasil disimpan!');
                
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->withInput()
                ->withErrors(['error' => 'Terjadi kesalahan: ' . $e->getMessage()]);
        }
    }
}
```

### View Template (Complete with localStorage)
```blade
@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto p-6">
    <h1 class="text-2xl font-bold mb-6">Form Title</h1>

    <!-- Error Summary -->
    @if($errors->any())
        <div class="bg-red-50 border border-red-200 rounded-lg p-4 mb-6">
            <h3 class="font-bold text-red-800 mb-2">Terdapat kesalahan:</h3>
            <ul class="list-disc list-inside text-red-700">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Success Message -->
    @if(session('success'))
        <div class="bg-green-50 border border-green-200 rounded-lg p-4 mb-6 text-green-800">
            {{ session('success') }}
        </div>
    @endif

    <form method="POST" action="{{ route('your.route') }}" id="mainForm">
        @csrf

        <!-- Field 1 -->
        <div class="mb-4">
            <label class="block text-sm font-medium mb-2">Nama</label>
            <input type="text" name="name" value="{{ old('name') }}"
                class="w-full px-4 py-2 border rounded-lg @error('name') border-red-500 @enderror">
            @error('name')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Field 2 -->
        <div class="mb-4">
            <label class="block text-sm font-medium mb-2">Email</label>
            <input type="email" name="email" value="{{ old('email') }}"
                class="w-full px-4 py-2 border rounded-lg @error('email') border-red-500 @enderror">
            @error('email')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <button type="submit" class="w-full bg-blue-600 text-white py-3 rounded-lg hover:bg-blue-700">
            Submit
        </button>
    </form>
</div>

<script>
// localStorage Auto-Save
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('mainForm');
    const fields = form.querySelectorAll('input[type="text"], input[type="email"], textarea');
    const storageKey = 'your_form_data';

    // Restore
    const saved = localStorage.getItem(storageKey);
    if (saved) {
        const data = JSON.parse(saved);
        fields.forEach(field => {
            if (data[field.name] && !field.value) {
                field.value = data[field.name];
            }
        });
    }

    // Save
    let timeout;
    fields.forEach(field => {
        field.addEventListener('input', () => {
            clearTimeout(timeout);
            timeout = setTimeout(() => {
                const data = {};
                fields.forEach(f => data[f.name] = f.value);
                localStorage.setItem(storageKey, JSON.stringify(data));
            }, 500);
        });
    });

    // Clear on submit
    form.addEventListener('submit', () => {
        setTimeout(() => localStorage.removeItem(storageKey), 1000);
    });
});
</script>
@endsection
```

---

**Last Updated**: 2024  
**Version**: 1.0  
**Maintained by**: Development Team