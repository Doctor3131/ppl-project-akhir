@extends('layouts.app')

@section('title', 'Lengkapi Profil')

@section('content')
<div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="bg-white rounded-lg shadow-lg overflow-hidden">
        <div class="px-8 py-10">
            <!-- Header -->
            <div class="text-center mb-8">
                <h2 class="text-3xl font-bold text-gray-900">Lengkapi Profil Anda</h2>
                <p class="mt-2 text-gray-600">Langkah 2 dari 2: Data Lengkap</p>
            </div>

            <!-- Progress Bar -->
            <div class="mb-8">
                <div class="flex items-center justify-center">
                    <div class="flex items-center">
                        <div class="flex items-center justify-center w-10 h-10 bg-green-500 text-white rounded-full font-bold">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                        </div>
                        <span class="ml-2 text-sm font-medium text-green-600">Data Dasar</span>
                    </div>
                    <div class="w-16 h-1 bg-indigo-600 mx-4"></div>
                    <div class="flex items-center">
                        <div class="flex items-center justify-center w-10 h-10 bg-indigo-600 text-white rounded-full font-bold">
                            2
                        </div>
                        <span class="ml-2 text-sm font-medium text-indigo-600">Lengkapi Profil</span>
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
            @if($errors->any())
                <div class="mb-6 bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-lg">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-red-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 9.586 8.707 8.293z" clip-rule="evenodd"></path>
                            </svg>
                        </div>
                        <div class="ml-3">
                            <h3 class="text-sm font-medium text-red-800">Terdapat kesalahan:</h3>
                            <ul class="mt-2 text-sm text-red-700 list-disc list-inside">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Complete Profile Form -->
            <form method="POST" action="{{ route('complete-profile.store') }}" enctype="multipart/form-data" class="space-y-8">
                @csrf

                <!-- Section: Data dari Registrasi (Readonly) -->
                <div class="bg-gray-50 rounded-lg p-6 border border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                        <svg class="w-5 h-5 mr-2 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        Data Registrasi (Terverifikasi)
                    </h3>
                    <p class="text-sm text-gray-500 mb-4">Data ini sudah tersimpan dari langkah sebelumnya dan tidak dapat diubah.</p>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <!-- Name (Readonly) -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Nama Lengkap</label>
                            <input type="text" value="{{ $user->name }}" readonly
                                class="w-full px-4 py-3 border border-gray-200 rounded-lg bg-gray-100 text-gray-600 cursor-not-allowed">
                        </div>

                        <!-- Email (Readonly) -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                            <div class="relative">
                                <input type="text" value="{{ $user->email }}" readonly
                                    class="w-full px-4 py-3 border border-gray-200 rounded-lg bg-gray-100 text-gray-600 cursor-not-allowed pr-10">
                                <span class="absolute right-3 top-1/2 -translate-y-1/2">
                                    <svg class="w-5 h-5 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                    </svg>
                                </span>
                            </div>
                            <p class="mt-1 text-xs text-green-600">✓ Email terverifikasi</p>
                        </div>

                        <!-- Phone (Readonly) -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Nomor HP</label>
                            <input type="text" value="{{ $user->phone }}" readonly
                                class="w-full px-4 py-3 border border-gray-200 rounded-lg bg-gray-100 text-gray-600 cursor-not-allowed">
                        </div>

                        <!-- Shop Name (Readonly) -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Nama Toko</label>
                            <input type="text" value="{{ $user->shop_name }}" readonly
                                class="w-full px-4 py-3 border border-gray-200 rounded-lg bg-gray-100 text-gray-600 cursor-not-allowed">
                        </div>
                    </div>
                </div>

                <!-- Section: Data KTP -->
                <div>
                    <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                        <svg class="w-5 h-5 mr-2 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2"></path>
                        </svg>
                        Identitas (KTP)
                    </h3>
                    
                    <div class="space-y-4">
                        <!-- KTP Number -->
                        <div>
                            <label for="ktp_number" class="block text-sm font-medium text-gray-700 mb-2">
                                Nomor KTP <span class="text-red-500">*</span>
                            </label>
                            <input id="ktp_number" type="text" name="ktp_number" 
                                value="{{ old('ktp_number', $seller->pic_ktp_number ?? '') }}" 
                                required maxlength="16"
                                placeholder="16 digit nomor KTP"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 @error('ktp_number') border-red-500 @enderror">
                            @error('ktp_number')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                            <p class="mt-1 text-xs text-gray-500">Masukkan 16 digit nomor KTP tanpa spasi</p>
                        </div>

                        <!-- KTP File Upload -->
                        <div>
                            <label for="ktp_file" class="block text-sm font-medium text-gray-700 mb-2">
                                Upload Foto/Scan KTP <span class="text-red-500">*</span>
                            </label>
                            <input type="file" id="ktp_file" name="ktp_file" 
                                accept=".jpg,.jpeg,.png,.pdf" required
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 @error('ktp_file') border-red-500 @enderror
                                file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
                            @error('ktp_file')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                            <p class="mt-1 text-xs text-gray-500">Format: JPG, PNG, atau PDF. Maksimal 5MB</p>
                        </div>
                    </div>
                </div>

                <!-- Section: Alamat -->
                <div>
                    <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                        <svg class="w-5 h-5 mr-2 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                        Alamat Lengkap
                    </h3>
                    
                    <div class="space-y-4">
                        <!-- Province -->
                        <div>
                            <label for="province_id" class="block text-sm font-medium text-gray-700 mb-2">
                                Provinsi <span class="text-red-500">*</span>
                            </label>
                            <select id="province_id" name="province_id" required
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 @error('province_id') border-red-500 @enderror">
                                <option value="">Pilih Provinsi</option>
                                @php
                                    $provinces = \Indonesia::allProvinces();
                                @endphp
                                @foreach($provinces as $province)
                                    <option value="{{ $province->id }}" data-name="{{ $province->name }}"
                                        {{ old('province_id') == $province->id ? 'selected' : '' }}>
                                        {{ $province->name }}
                                    </option>
                                @endforeach
                            </select>
                            <input type="hidden" name="province" id="province_name" value="{{ old('province') }}">
                            @error('province_id')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                            @error('province')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Kota/Kabupaten -->
                        <div>
                            <label for="city_id" class="block text-sm font-medium text-gray-700 mb-2">
                                Kota/Kabupaten <span class="text-red-500">*</span>
                            </label>
                            <select id="city_id" name="city_id" required disabled
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 @error('city_id') border-red-500 @enderror disabled:bg-gray-100">
                                <option value="">Pilih Provinsi terlebih dahulu</option>
                            </select>
                            <input type="hidden" name="kota_kabupaten" id="city_name" value="{{ old('kota_kabupaten') }}">
                            @error('city_id')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                            @error('kota_kabupaten')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Kecamatan -->
                        <div>
                            <label for="district_id" class="block text-sm font-medium text-gray-700 mb-2">
                                Kecamatan <span class="text-red-500">*</span>
                            </label>
                            <select id="district_id" name="district_id" required disabled
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 @error('district_id') border-red-500 @enderror disabled:bg-gray-100">
                                <option value="">Pilih Kota/Kabupaten terlebih dahulu</option>
                            </select>
                            <input type="hidden" name="kecamatan" id="district_name" value="{{ old('kecamatan') }}">
                            @error('district_id')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Kelurahan -->
                        <div>
                            <label for="village_id" class="block text-sm font-medium text-gray-700 mb-2">
                                Kelurahan/Desa <span class="text-red-500">*</span>
                            </label>
                            <select id="village_id" name="village_id" required disabled
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 @error('village_id') border-red-500 @enderror disabled:bg-gray-100">
                                <option value="">Pilih Kecamatan terlebih dahulu</option>
                            </select>
                            <input type="hidden" name="kelurahan" id="village_name" value="{{ old('kelurahan') }}">
                            @error('village_id')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                            @error('kelurahan')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- RT/RW -->
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label for="rt" class="block text-sm font-medium text-gray-700 mb-2">
                                    RT <span class="text-red-500">*</span>
                                </label>
                                <input id="rt" type="text" name="rt" value="{{ old('rt', $seller->rt ?? '') }}" required
                                    placeholder="001" maxlength="5"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 @error('rt') border-red-500 @enderror">
                                @error('rt')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label for="rw" class="block text-sm font-medium text-gray-700 mb-2">
                                    RW <span class="text-red-500">*</span>
                                </label>
                                <input id="rw" type="text" name="rw" value="{{ old('rw', $seller->rw ?? '') }}" required
                                    placeholder="001" maxlength="5"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 @error('rw') border-red-500 @enderror">
                                @error('rw')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Street Address -->
                        <div>
                            <label for="street_address" class="block text-sm font-medium text-gray-700 mb-2">
                                Alamat Jalan <span class="text-red-500">*</span>
                            </label>
                            <textarea id="street_address" name="street_address" rows="2" required
                                placeholder="Nama jalan, nomor rumah, blok, gang, dll"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 @error('street_address') border-red-500 @enderror">{{ old('street_address', $seller->street_address ?? '') }}</textarea>
                            @error('street_address')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Section: Foto Diri & Deskripsi -->
                <div>
                    <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                        <svg class="w-5 h-5 mr-2 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                        Foto Diri & Informasi Tambahan
                    </h3>
                    
                    <div class="space-y-4">
                        <!-- Photo Upload -->
                        <div>
                            <label for="photo" class="block text-sm font-medium text-gray-700 mb-2">
                                Foto Diri <span class="text-red-500">*</span>
                            </label>
                            <input type="file" id="photo" name="photo" 
                                accept=".jpg,.jpeg,.png" required
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 @error('photo') border-red-500 @enderror
                                file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
                            @error('photo')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                            <p class="mt-1 text-xs text-gray-500">Format: JPG, JPEG, atau PNG. Maksimal 2MB. Foto harus jelas menampilkan wajah.</p>
                        </div>

                        <!-- Shop Description -->
                        <div>
                            <label for="shop_description" class="block text-sm font-medium text-gray-700 mb-2">
                                Deskripsi Toko <span class="text-gray-400">(Opsional)</span>
                            </label>
                            <textarea id="shop_description" name="shop_description" rows="3"
                                placeholder="Ceritakan tentang toko Anda, produk yang dijual, dll"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 @error('shop_description') border-red-500 @enderror">{{ old('shop_description', $seller->shop_description ?? '') }}</textarea>
                            @error('shop_description')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                            <p class="mt-1 text-xs text-gray-500">Maksimal 1000 karakter</p>
                        </div>
                    </div>
                </div>

                <!-- Info Box -->
                <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-blue-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                            </svg>
                        </div>
                        <div class="ml-3">
                            <h3 class="text-sm font-medium text-blue-800">Informasi Penting</h3>
                            <div class="mt-2 text-sm text-blue-700">
                                <ul class="list-disc list-inside space-y-1">
                                    <li>Pastikan foto KTP jelas dan terbaca</li>
                                    <li>Foto diri harus jelas menampilkan wajah Anda</li>
                                    <li>Setelah submit, akun akan diverifikasi oleh admin (1-2 hari kerja)</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="pt-4">
                    <button type="submit"
                        class="w-full flex justify-center py-3 px-4 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors duration-200">
                        <svg class="mr-2 w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        Kirim & Tunggu Persetujuan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
    // KTP number input - only allow numbers
    document.getElementById('ktp_number').addEventListener('input', function(e) {
        this.value = this.value.replace(/[^0-9]/g, '').slice(0, 16);
    });

    // Province change - load cities
    document.getElementById('province_id').addEventListener('change', function() {
        const provinceId = this.value;
        const provinceName = this.options[this.selectedIndex].dataset.name || '';
        document.getElementById('province_name').value = provinceName;
        
        const citySelect = document.getElementById('city_id');
        const districtSelect = document.getElementById('district_id');
        const villageSelect = document.getElementById('village_id');
        
        // Reset dependent dropdowns
        citySelect.innerHTML = '<option value="">Memuat data...</option>';
        citySelect.disabled = true;
        districtSelect.innerHTML = '<option value="">Pilih Kota/Kabupaten terlebih dahulu</option>';
        districtSelect.disabled = true;
        villageSelect.innerHTML = '<option value="">Pilih Kecamatan terlebih dahulu</option>';
        villageSelect.disabled = true;
        
        // Reset hidden fields
        document.getElementById('city_name').value = '';
        document.getElementById('district_name').value = '';
        document.getElementById('village_name').value = '';
        
        if (provinceId) {
            fetch(`/api/location/cities/${provinceId}`)
                .then(response => response.json())
                .then(data => {
                    citySelect.innerHTML = '<option value="">Pilih Kota/Kabupaten</option>';
                    data.forEach(city => {
                        citySelect.innerHTML += `<option value="${city.id}" data-name="${city.name}">${city.name}</option>`;
                    });
                    citySelect.disabled = false;
                })
                .catch(error => {
                    console.error('Error loading cities:', error);
                    citySelect.innerHTML = '<option value="">Gagal memuat data</option>';
                });
        } else {
            citySelect.innerHTML = '<option value="">Pilih Provinsi terlebih dahulu</option>';
        }
    });

    // City change - load districts
    document.getElementById('city_id').addEventListener('change', function() {
        const cityId = this.value;
        const cityName = this.options[this.selectedIndex].dataset.name || '';
        document.getElementById('city_name').value = cityName;
        
        const districtSelect = document.getElementById('district_id');
        const villageSelect = document.getElementById('village_id');
        
        // Reset dependent dropdowns
        districtSelect.innerHTML = '<option value="">Memuat data...</option>';
        districtSelect.disabled = true;
        villageSelect.innerHTML = '<option value="">Pilih Kecamatan terlebih dahulu</option>';
        villageSelect.disabled = true;
        
        // Reset hidden fields
        document.getElementById('district_name').value = '';
        document.getElementById('village_name').value = '';
        
        if (cityId) {
            fetch(`/api/location/districts/${cityId}`)
                .then(response => response.json())
                .then(data => {
                    districtSelect.innerHTML = '<option value="">Pilih Kecamatan</option>';
                    data.forEach(district => {
                        districtSelect.innerHTML += `<option value="${district.id}" data-name="${district.name}">${district.name}</option>`;
                    });
                    districtSelect.disabled = false;
                })
                .catch(error => {
                    console.error('Error loading districts:', error);
                    districtSelect.innerHTML = '<option value="">Gagal memuat data</option>';
                });
        } else {
            districtSelect.innerHTML = '<option value="">Pilih Kota/Kabupaten terlebih dahulu</option>';
        }
    });

    // District change - load villages
    document.getElementById('district_id').addEventListener('change', function() {
        const districtId = this.value;
        const districtName = this.options[this.selectedIndex].dataset.name || '';
        document.getElementById('district_name').value = districtName;
        
        const villageSelect = document.getElementById('village_id');
        
        // Reset village dropdown
        villageSelect.innerHTML = '<option value="">Memuat data...</option>';
        villageSelect.disabled = true;
        document.getElementById('village_name').value = '';
        
        if (districtId) {
            fetch(`/api/location/villages/${districtId}`)
                .then(response => response.json())
                .then(data => {
                    villageSelect.innerHTML = '<option value="">Pilih Kelurahan/Desa</option>';
                    data.forEach(village => {
                        villageSelect.innerHTML += `<option value="${village.id}" data-name="${village.name}">${village.name}</option>`;
                    });
                    villageSelect.disabled = false;
                })
                .catch(error => {
                    console.error('Error loading villages:', error);
                    villageSelect.innerHTML = '<option value="">Gagal memuat data</option>';
                });
        } else {
            villageSelect.innerHTML = '<option value="">Pilih Kecamatan terlebih dahulu</option>';
        }
    });

    // Village change - update hidden field
    document.getElementById('village_id').addEventListener('change', function() {
        const villageName = this.options[this.selectedIndex].dataset.name || '';
        document.getElementById('village_name').value = villageName;
    });
</script>
@endpush
@endsection
