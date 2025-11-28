@extends('layouts.app')

@section('title', 'Register Seller')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="bg-white rounded-lg shadow-lg overflow-hidden">
        <div class="px-8 py-10">
            <!-- Header -->
            <div class="text-center mb-8">
                <h2 class="text-3xl font-bold text-gray-900">Registrasi Penjual</h2>
                <p class="mt-2 text-gray-600">Daftarkan toko Anda dan mulai berjualan</p>
            </div>

            <!-- Auto-save Info -->
            <div class="mb-6 bg-blue-50 border border-blue-200 rounded-lg p-4">
                <div class="flex items-start">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-blue-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                        </svg>
                    </div>
                    <div class="ml-3">
                        <h3 class="text-sm font-medium text-blue-800">💾 Data Anda Aman</h3>
                        <div class="mt-1 text-sm text-blue-700">
                            <p>Data yang Anda masukkan akan tersimpan otomatis. Jika terjadi kesalahan validasi, Anda tidak perlu mengisi ulang semua field <span class="font-semibold">(kecuali file upload)</span>.</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Success Message -->
            @if(session('success'))
                <div class="mb-6 bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-lg">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Error Message -->
            @if($errors->has('error'))
                <div class="mb-6 bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-lg">
                    {{ $errors->first('error') }}
                </div>
            @endif

            <!-- General Validation Errors -->
            @if($errors->any() && !$errors->has('error'))
                <div class="mb-6 bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-lg">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-red-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 9.586 8.707 8.293z" clip-rule="evenodd"></path>
                            </svg>
                        </div>
                        <div class="ml-3">
                            <h3 class="text-sm font-medium text-red-800">Terdapat kesalahan pada form:</h3>
                            <div class="mt-2 text-sm text-red-700">
                                <p class="mb-2">Mohon periksa kembali data yang Anda masukkan. Data yang sudah diisi akan tetap tersimpan, kecuali file upload yang perlu dipilih ulang.</p>
                                <ul class="list-disc list-inside space-y-1">
                                    @foreach($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Registration Form -->
            <form method="POST" action="{{ route('register') }}" enctype="multipart/form-data" class="space-y-8">
                @csrf

                <!-- Section: Data Akun -->
                <div class="border-b border-gray-200 pb-8">
                    <h3 class="text-xl font-semibold text-gray-900 mb-6">Data Akun</h3>
                    <div class="grid grid-cols-1 gap-6">
                        <!-- Name -->
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                                Nama Lengkap <span class="text-red-500">*</span>
                            </label>
                            <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 @error('name') border-red-500 @enderror">
                            @error('name')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Email -->
                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                                Email <span class="text-red-500">*</span>
                            </label>
                            <input id="email" type="email" name="email" value="{{ old('email') }}" required
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 @error('email') border-red-500 @enderror">
                            @error('email')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Password -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
                                    Password <span class="text-red-500">*</span>
                                </label>
                                <input id="password" type="password" name="password" required
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 @error('password') border-red-500 @enderror">
                                @error('password')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                                <p class="mt-1 text-xs text-gray-500">Minimal 8 karakter</p>
                            </div>

                            <div>
                                <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-2">
                                    Konfirmasi Password <span class="text-red-500">*</span>
                                </label>
                                <input id="password_confirmation" type="password" name="password_confirmation" required
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Section: Data Toko -->
                <div class="border-b border-gray-200 pb-8">
                    <h3 class="text-xl font-semibold text-gray-900 mb-6">Data Toko</h3>
                    <div class="grid grid-cols-1 gap-6">
                        <!-- Shop Name -->
                        <div>
                            <label for="shop_name" class="block text-sm font-medium text-gray-700 mb-2">
                                Nama Toko <span class="text-red-500">*</span>
                            </label>
                            <input id="shop_name" type="text" name="shop_name" value="{{ old('shop_name') }}" required
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 @error('shop_name') border-red-500 @enderror">
                            @error('shop_name')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Shop Description -->
                        <div>
                            <label for="shop_description" class="block text-sm font-medium text-gray-700 mb-2">
                                Deskripsi Singkat Toko
                            </label>
                            <textarea id="shop_description" name="shop_description" rows="3"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 @error('shop_description') border-red-500 @enderror">{{ old('shop_description') }}</textarea>
                            @error('shop_description')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                            <p class="mt-1 text-xs text-gray-500">Maksimal 1000 karakter</p>
                        </div>
                    </div>
                </div>

                <!-- Section: Data PIC (Person In Charge) -->
                <div class="border-b border-gray-200 pb-8">
                    <h3 class="text-xl font-semibold text-gray-900 mb-6">Data Penanggung Jawab (PIC)</h3>
                    <div class="grid grid-cols-1 gap-6">
                        <!-- PIC Name -->
                        <div>
                            <label for="pic_name" class="block text-sm font-medium text-gray-700 mb-2">
                                Nama PIC <span class="text-red-500">*</span>
                            </label>
                            <input id="pic_name" type="text" name="pic_name" value="{{ old('pic_name') }}" required
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 @error('pic_name') border-red-500 @enderror">
                            @error('pic_name')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- PIC Phone -->
                            <div>
                                <label for="pic_phone" class="block text-sm font-medium text-gray-700 mb-2">
                                    No HP PIC <span class="text-red-500">*</span>
                                </label>
                                <input id="pic_phone" type="text" name="pic_phone" value="{{ old('pic_phone') }}" required
                                    placeholder="08xxxxxxxxxx"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 @error('pic_phone') border-red-500 @enderror">
                                @error('pic_phone')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- PIC Email -->
                            <div>
                                <label for="pic_email" class="block text-sm font-medium text-gray-700 mb-2">
                                    Email PIC <span class="text-red-500">*</span>
                                </label>
                                <input id="pic_email" type="email" name="pic_email" value="{{ old('pic_email') }}" required
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 @error('pic_email') border-red-500 @enderror">
                                @error('pic_email')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- PIC KTP Number -->
                        <div>
                            <label for="pic_ktp_number" class="block text-sm font-medium text-gray-700 mb-2">
                                No KTP PIC <span class="text-red-500">*</span>
                            </label>
                            <input id="pic_ktp_number" type="text" name="pic_ktp_number" value="{{ old('pic_ktp_number') }}"
                                required maxlength="16" placeholder="16 digit nomor KTP"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 @error('pic_ktp_number') border-red-500 @enderror">
                            @error('pic_ktp_number')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                            <p class="mt-1 text-xs text-gray-500">Masukkan 16 digit nomor KTP</p>
                        </div>
                    </div>
                </div>

                <!-- Section: Alamat -->
                <div class="border-b border-gray-200 pb-8">
                    <h3 class="text-xl font-semibold text-gray-900 mb-6">Alamat Lengkap</h3>
                    <div class="grid grid-cols-1 gap-6">
                        <!-- Street Address -->
                        <div>
                            <label for="street_address" class="block text-sm font-medium text-gray-700 mb-2">
                                Jalan <span class="text-red-500">*</span>
                            </label>
                            <textarea id="street_address" name="street_address" rows="2" required
                                placeholder="Contoh: Jl. Sudirman No. 123"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 @error('street_address') border-red-500 @enderror">{{ old('street_address') }}</textarea>
                            @error('street_address')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- RT -->
                            <div>
                                <label for="rt" class="block text-sm font-medium text-gray-700 mb-2">
                                    RT <span class="text-red-500">*</span>
                                </label>
                                <input id="rt" type="text" name="rt" value="{{ old('rt') }}" required
                                    placeholder="001"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 @error('rt') border-red-500 @enderror">
                                @error('rt')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- RW -->
                            <div>
                                <label for="rw" class="block text-sm font-medium text-gray-700 mb-2">
                                    RW <span class="text-red-500">*</span>
                                </label>
                                <input id="rw" type="text" name="rw" value="{{ old('rw') }}" required
                                    placeholder="002"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 @error('rw') border-red-500 @enderror">
                                @error('rw')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Kelurahan -->
                        <div>
                            <label for="kelurahan" class="block text-sm font-medium text-gray-700 mb-2">
                                Kelurahan/Desa <span class="text-red-500">*</span>
                            </label>
                            <input id="kelurahan" type="text" name="kelurahan" value="{{ old('kelurahan') }}" required
                                placeholder="Contoh: Kebayoran Baru"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 @error('kelurahan') border-red-500 @enderror">
                            @error('kelurahan')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Kota/Kabupaten -->
                            <div>
                                <label for="kota_kabupaten" class="block text-sm font-medium text-gray-700 mb-2">
                                    Kota/Kabupaten <span class="text-red-500">*</span>
                                </label>
                                <input id="kota_kabupaten" type="text" name="kota_kabupaten" value="{{ old('kota_kabupaten') }}" required
                                    placeholder="Contoh: Jakarta Selatan"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 @error('kota_kabupaten') border-red-500 @enderror">
                                @error('kota_kabupaten')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Province -->
                            <div>
                                <label for="province" class="block text-sm font-medium text-gray-700 mb-2">
                                    Provinsi <span class="text-red-500">*</span>
                                </label>
                                <input id="province" type="text" name="province" value="{{ old('province') }}" required
                                    placeholder="Contoh: DKI Jakarta"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 @error('province') border-red-500 @enderror">
                                @error('province')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Section: Upload Dokumen -->
                <div class="pb-8">
                    <h3 class="text-xl font-semibold text-gray-900 mb-6">Upload Dokumen</h3>
                    <div class="grid grid-cols-1 gap-6">
                        <!-- PIC Photo -->
                        <div>
                            <label for="pic_photo" class="block text-sm font-medium text-gray-700 mb-2">
                                Foto PIC <span class="text-red-500">*</span>
                            </label>
                            <input id="pic_photo" type="file" name="pic_photo" accept="image/jpeg,image/jpg,image/png" required
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 @error('pic_photo') border-red-500 @enderror"
                                onchange="previewImage(event, 'pic_photo_preview')">
                            @error('pic_photo')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                            <p class="mt-1 text-xs text-gray-500">Format: JPG, JPEG, PNG | Maksimal: 2MB</p>
                            @if($errors->any())
                                <p class="mt-1 text-xs text-orange-600 font-medium">⚠️ File perlu dipilih ulang karena ada kesalahan pada form</p>
                            @endif
                            <div id="pic_photo_preview" class="mt-3"></div>
                        </div>

                        <!-- KTP File -->
                        <div>
                            <label for="ktp_file" class="block text-sm font-medium text-gray-700 mb-2">
                                File KTP <span class="text-red-500">*</span>
                            </label>
                            <input id="ktp_file" type="file" name="ktp_file" accept="image/jpeg,image/jpg,image/png,application/pdf" required
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 @error('ktp_file') border-red-500 @enderror"
                                onchange="previewImage(event, 'ktp_file_preview')">
                            @error('ktp_file')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                            <p class="mt-1 text-xs text-gray-500">Format: JPG, JPEG, PNG, PDF | Maksimal: 5MB</p>
                            @if($errors->any())
                                <p class="mt-1 text-xs text-orange-600 font-medium">⚠️ File perlu dipilih ulang karena ada kesalahan pada form</p>
                            @endif
                            <div id="ktp_file_preview" class="mt-3"></div>
                        </div>
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="pt-6">
                    <button type="submit" id="submitBtn"
                        class="w-full flex justify-center py-3 px-4 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors duration-200">
                        Daftar Sebagai Penjual
                    </button>
                    <!-- Auto-save status indicator -->
                    <div id="autosaveStatus" class="mt-2 text-center text-xs text-gray-500 opacity-0 transition-opacity duration-300">
                        <span class="inline-flex items-center">
                            <svg class="h-3 w-3 mr-1 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                            </svg>
                            Data tersimpan otomatis
                        </span>
                    </div>
                </div>

                <!-- Login Link -->
                <div class="text-center">
                    <p class="text-sm text-gray-600">
                        Sudah punya akun?
                        <a href="{{ route('login') }}" class="font-medium text-indigo-600 hover:text-indigo-500">
                            Login
                        </a>
                    </p>
                </div>
            </form>
        </div>
    </div>

    <!-- Info Box -->
    <div class="mt-6 bg-yellow-50 border border-yellow-200 rounded-lg p-4">
        <div class="flex">
            <div class="flex-shrink-0">
                <svg class="h-5 w-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                </svg>
            </div>
            <div class="ml-3">
                <h3 class="text-sm font-medium text-yellow-800">Persetujuan Admin Diperlukan</h3>
                <div class="mt-2 text-sm text-yellow-700">
                    <p>Setelah registrasi, akun Anda akan menunggu persetujuan dari admin. Admin akan meninjau dan menyetujui akun Anda sebelum Anda dapat mulai berjualan.</p>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function previewImage(event, previewId) {
    const input = event.target;
    const preview = document.getElementById(previewId);
    const file = input.files[0];

    if (file) {
        const reader = new FileReader();
        const fileSize = (file.size / 1024 / 1024).toFixed(2); // Convert to MB

        preview.innerHTML = `
            <div class="flex items-center space-x-2 text-sm text-gray-600">
                <svg class="h-5 w-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
                <span>File terpilih: <strong>${file.name}</strong> (${fileSize} MB)</span>
            </div>
        `;

        // Preview image if it's an image file
        if (file.type.startsWith('image/')) {
            reader.onload = function(e) {
                preview.innerHTML += `
                    <img src="${e.target.result}" alt="Preview" class="mt-2 max-w-xs h-32 object-cover rounded-lg border border-gray-300">
                `;
            };
            reader.readAsDataURL(file);
        }
    }
}

// Auto-save form data to localStorage
document.addEventListener('DOMContentLoaded', function() {
    const form = document.querySelector('form');
    const formFields = form.querySelectorAll('input[type="text"], input[type="email"], textarea');
    const storageKey = 'register_form_data';

    // Restore saved data on page load (only if old() values are not present)
    const savedData = localStorage.getItem(storageKey);
    if (savedData && !hasServerErrors()) {
        try {
            const data = JSON.parse(savedData);
            formFields.forEach(field => {
                if (data[field.name] && !field.value) {
                    field.value = data[field.name];
                }
            });
        } catch (e) {
            console.error('Error restoring form data:', e);
        }
    }

    // Save form data on input change with debounce and visual feedback
    let saveTimeout;
    formFields.forEach(field => {
        field.addEventListener('input', function() {
            clearTimeout(saveTimeout);
            saveTimeout = setTimeout(function() {
                saveFormData();
                showSaveIndicator();
            }, 500); // Save after 500ms of no typing
        });
    });

    // Show save indicator
    function showSaveIndicator() {
        const indicator = document.getElementById('autosaveStatus');
        if (indicator) {
            indicator.style.opacity = '1';
            setTimeout(function() {
                indicator.style.opacity = '0';
            }, 2000); // Hide after 2 seconds
        }
    }

    // Save form data to localStorage
    function saveFormData() {
        const data = {};
        formFields.forEach(field => {
            data[field.name] = field.value;
        });
        localStorage.setItem(storageKey, JSON.stringify(data));
    }

    // Check if there are server-side errors (old() values present)
    function hasServerErrors() {
        return document.querySelector('.bg-red-50') !== null;
    }

    // Clear localStorage on successful form submission
    form.addEventListener('submit', function() {
        // Don't clear immediately - only clear if form validates client-side
        const requiredFields = form.querySelectorAll('[required]');
        let allValid = true;

        requiredFields.forEach(field => {
            if (!field.value) {
                allValid = false;
            }
        });

        // Only clear if all required fields are filled
        // Server will still validate, and data will persist if server returns errors
        if (allValid) {
            setTimeout(function() {
                localStorage.removeItem(storageKey);
            }, 1000);
        }
    });

    // Add clear button for localStorage (for testing/debugging)
    if (localStorage.getItem(storageKey)) {
        const clearBtn = document.createElement('button');
        clearBtn.type = 'button';
        clearBtn.className = 'text-xs text-gray-500 hover:text-gray-700 underline mb-2';
        clearBtn.textContent = 'Hapus data tersimpan otomatis';
        clearBtn.onclick = function() {
            localStorage.removeItem(storageKey);
            alert('Data form yang tersimpan otomatis telah dihapus');
            this.remove();
        };
        form.insertBefore(clearBtn, form.firstChild);
    }
});
</script>
@endsection
