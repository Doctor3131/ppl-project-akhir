@extends('layouts.app')

@section('title', 'Detail Seller')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <!-- Back Button -->
    <div class="mb-6">
        <a href="{{ route('admin.sellers.index') }}" class="inline-flex items-center text-sm text-gray-600 hover:text-gray-900">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
            </svg>
            Kembali ke Daftar Seller
        </a>
    </div>

    <!-- Page Header -->
    <div class="mb-8 flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Detail Seller</h1>
            <p class="mt-2 text-gray-600">Informasi lengkap registrasi seller</p>
        </div>
        <div class="flex items-center gap-2">
            @if($seller->status === 'pending')
                <span class="px-4 py-2 inline-flex text-sm leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                    Pending
                </span>
            @elseif($seller->status === 'approved')
                <span class="px-4 py-2 inline-flex text-sm leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                    Approved
                </span>
                @if($seller->is_active)
                    <span class="px-4 py-2 inline-flex text-sm leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">
                        Aktif
                    </span>
                @else
                    <span class="px-4 py-2 inline-flex text-sm leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                        Non-aktif
                    </span>
                @endif
            @else
                <span class="px-4 py-2 inline-flex text-sm leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                    Rejected
                </span>
            @endif
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Main Content -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Data Akun -->
            <div class="bg-white rounded-lg shadow overflow-hidden">
                <div class="px-6 py-4 bg-gray-50 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-900">Data Akun</h3>
                </div>
                <div class="px-6 py-4">
                    <dl class="grid grid-cols-1 gap-4">
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Nama Lengkap</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $seller->name }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Email</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $seller->email }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Tanggal Registrasi</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $seller->created_at->format('d F Y, H:i') }}</dd>
                        </div>
                    </dl>
                </div>
            </div>

            @if($seller->seller)
            <!-- Data Toko -->
            <div class="bg-white rounded-lg shadow overflow-hidden">
                <div class="px-6 py-4 bg-gray-50 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-900">Data Toko</h3>
                </div>
                <div class="px-6 py-4">
                    <dl class="grid grid-cols-1 gap-4">
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Nama Toko</dt>
                            <dd class="mt-1 text-sm text-gray-900 font-semibold">{{ $seller->seller->shop_name }}</dd>
                        </div>
                        @if($seller->seller->shop_description)
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Deskripsi Toko</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $seller->seller->shop_description }}</dd>
                        </div>
                        @endif
                    </dl>
                </div>
            </div>

            <!-- Data PIC (Person In Charge) -->
            <div class="bg-white rounded-lg shadow overflow-hidden">
                <div class="px-6 py-4 bg-gray-50 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-900">Data Penanggung Jawab (PIC)</h3>
                </div>
                <div class="px-6 py-4">
                    <dl class="grid grid-cols-1 gap-4">
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Nama PIC</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $seller->seller->pic_name }}</dd>
                        </div>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <dt class="text-sm font-medium text-gray-500">No HP PIC</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $seller->seller->pic_phone }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Email PIC</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $seller->seller->pic_email }}</dd>
                            </div>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">No KTP PIC</dt>
                            <dd class="mt-1 text-sm text-gray-900 font-mono">{{ $seller->seller->pic_ktp_number }}</dd>
                        </div>
                    </dl>
                </div>
            </div>

            <!-- Alamat Lengkap -->
            <div class="bg-white rounded-lg shadow overflow-hidden">
                <div class="px-6 py-4 bg-gray-50 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-900">Alamat Lengkap</h3>
                </div>
                <div class="px-6 py-4">
                    <dl class="grid grid-cols-1 gap-4">
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Jalan</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $seller->seller->street_address }}</dd>
                        </div>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <dt class="text-sm font-medium text-gray-500">RT</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $seller->seller->rt }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">RW</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $seller->seller->rw }}</dd>
                            </div>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Kelurahan/Desa</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $seller->seller->kelurahan }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Kota/Kabupaten</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $seller->seller->kota_kabupaten }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Provinsi</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $seller->seller->province }}</dd>
                        </div>
                        <div class="pt-2 border-t border-gray-200">
                            <dt class="text-sm font-medium text-gray-500 mb-2">Alamat Lengkap</dt>
                            <dd class="text-sm text-gray-900 bg-gray-50 p-3 rounded-lg">
                                {{ $seller->seller->full_address }}
                            </dd>
                        </div>
                    </dl>
                </div>
            </div>
            @endif
        </div>

        <!-- Sidebar -->
        <div class="lg:col-span-1 space-y-6">
            @if($seller->seller)
            <!-- Dokumen -->
            <div class="bg-white rounded-lg shadow overflow-hidden">
                <div class="px-6 py-4 bg-gray-50 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-900">Dokumen</h3>
                </div>
                <div class="px-6 py-4 space-y-4">
                    <!-- Foto PIC -->
                    <div>
                        <h4 class="text-sm font-medium text-gray-700 mb-2">Foto PIC</h4>
                        @if($seller->seller->pic_photo_path)
                            <div class="relative">
                                <img src="{{ asset('storage/' . $seller->seller->pic_photo_path) }}"
                                     alt="Foto PIC"
                                     class="w-full h-48 object-cover rounded-lg border border-gray-300">
                                <a href="{{ asset('storage/' . $seller->seller->pic_photo_path) }}"
                                   target="_blank"
                                   class="absolute top-2 right-2 bg-white rounded-full p-2 shadow-lg hover:bg-gray-100">
                                    <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
                                    </svg>
                                </a>
                            </div>
                        @else
                            <p class="text-sm text-gray-500 italic">Tidak ada foto</p>
                        @endif
                    </div>

                    <!-- File KTP -->
                    <div>
                        <h4 class="text-sm font-medium text-gray-700 mb-2">File KTP</h4>
                        @if($seller->seller->ktp_file_path)
                            @php
                                $ktpExtension = pathinfo($seller->seller->ktp_file_path, PATHINFO_EXTENSION);
                            @endphp

                            @if(in_array(strtolower($ktpExtension), ['jpg', 'jpeg', 'png']))
                                <div class="relative">
                                    <img src="{{ asset('storage/' . $seller->seller->ktp_file_path) }}"
                                         alt="KTP"
                                         class="w-full h-48 object-cover rounded-lg border border-gray-300">
                                    <a href="{{ asset('storage/' . $seller->seller->ktp_file_path) }}"
                                       target="_blank"
                                       class="absolute top-2 right-2 bg-white rounded-full p-2 shadow-lg hover:bg-gray-100">
                                        <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
                                        </svg>
                                    </a>
                                </div>
                            @else
                                <a href="{{ asset('storage/' . $seller->seller->ktp_file_path) }}"
                                   target="_blank"
                                   class="flex items-center justify-center p-4 border-2 border-dashed border-gray-300 rounded-lg hover:border-indigo-500 hover:bg-indigo-50 transition-colors">
                                    <div class="text-center">
                                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                                        </svg>
                                        <p class="mt-2 text-sm font-medium text-gray-900">File PDF</p>
                                        <p class="text-xs text-gray-500">Klik untuk membuka</p>
                                    </div>
                                </a>
                            @endif
                        @else
                            <p class="text-sm text-gray-500 italic">Tidak ada file</p>
                        @endif
                    </div>
                </div>
            </div>
            @endif

            <!-- Actions -->
            @if($seller->status === 'pending')
            <div class="bg-white rounded-lg shadow overflow-hidden">
                <div class="px-6 py-4 bg-gray-50 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-900">Aksi</h3>
                </div>
                <div class="px-6 py-4 space-y-3">
                    <form action="{{ route('admin.sellers.approve', $seller->id) }}" method="POST" class="w-full">
                        @csrf
                        <button type="submit"
                            onclick="return confirm('Apakah Anda yakin ingin menyetujui seller ini?');"
                            class="w-full flex justify-center items-center px-4 py-3 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-colors">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            Setujui Seller
                        </button>
                    </form>
                    <form action="{{ route('admin.sellers.reject', $seller->id) }}" method="POST" class="w-full">
                        @csrf
                        <button type="submit"
                            onclick="return confirm('Apakah Anda yakin ingin menolak seller ini?');"
                            class="w-full flex justify-center items-center px-4 py-3 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition-colors">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                            Tolak Seller
                        </button>
                    </form>
                </div>
            </div>
            @elseif($seller->status === 'rejected')
            <div class="bg-white rounded-lg shadow overflow-hidden">
                <div class="px-6 py-4 bg-gray-50 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-900">Aksi</h3>
                </div>
                <div class="px-6 py-4">
                    <form action="{{ route('admin.sellers.approve', $seller->id) }}" method="POST" class="w-full">
                        @csrf
                        <button type="submit"
                            onclick="return confirm('Apakah Anda yakin ingin menyetujui seller ini?');"
                            class="w-full flex justify-center items-center px-4 py-3 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-colors">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            Setujui Seller
                        </button>
                    </form>
                </div>
            </div>
            @else
            <div class="bg-green-50 border border-green-200 rounded-lg p-4">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-green-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                        </svg>
                    </div>
                    <div class="ml-3">
                        <h3 class="text-sm font-medium text-green-800">Seller Disetujui</h3>
                        <div class="mt-2 text-sm text-green-700">
                            <p>Seller ini sudah disetujui dan dapat login untuk mengelola produk.</p>
                        </div>
                        @if($seller->seller && $seller->seller->verified_at)
                        <p class="mt-2 text-xs text-green-600">
                            Disetujui pada: {{ $seller->seller->verified_at->format('d F Y, H:i') }}
                        </p>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Active Status & Actions -->
            <div class="bg-white rounded-lg shadow overflow-hidden">
                <div class="px-6 py-4 bg-gray-50 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-900">Status Aktif</h3>
                </div>
                <div class="px-6 py-4 space-y-4">
                    <!-- Current Status -->
                    <div class="flex items-center justify-between">
                        <span class="text-sm text-gray-600">Status Saat Ini:</span>
                        @if($seller->is_active)
                            <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                Aktif
                            </span>
                        @else
                            <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                Non-aktif
                            </span>
                        @endif
                    </div>

                    <!-- Last Login -->
                    <div class="flex items-center justify-between">
                        <span class="text-sm text-gray-600">Login Terakhir:</span>
                        <span class="text-sm text-gray-900">
                            @if($seller->last_login_at)
                                {{ $seller->last_login_at->format('d M Y, H:i') }}
                                <span class="text-gray-500">({{ $seller->last_login_at->diffForHumans() }})</span>
                            @else
                                <span class="text-gray-400">Belum pernah login</span>
                            @endif
                        </span>
                    </div>

                    @if(!$seller->is_active)
                        <!-- Deactivation Info -->
                        @if($seller->deactivated_at)
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-gray-600">Dinonaktifkan:</span>
                            <span class="text-sm text-red-600">{{ $seller->deactivated_at->format('d M Y, H:i') }}</span>
                        </div>
                        @endif
                        @if($seller->deactivation_reason)
                        <div>
                            <span class="text-sm text-gray-600">Alasan:</span>
                            <p class="text-sm text-gray-900 mt-1 bg-gray-50 p-2 rounded">{{ $seller->deactivation_reason }}</p>
                        </div>
                        @endif
                        @if($seller->hasRequestedReactivation())
                        <div class="bg-orange-50 border border-orange-200 rounded-lg p-3">
                            <p class="text-sm text-orange-800">
                                <strong>Request Aktivasi Ulang</strong><br>
                                Diajukan: {{ $seller->reactivation_requested_at->format('d M Y, H:i') }}
                            </p>
                        </div>
                        @endif
                    @endif

                    <!-- Action Buttons -->
                    <div class="pt-4 border-t border-gray-200">
                        @if($seller->is_active)
                            <form action="{{ route('admin.sellers.deactivate', $seller->id) }}" method="POST" class="w-full">
                                @csrf
                                <button type="submit"
                                    onclick="return confirm('Apakah Anda yakin ingin menonaktifkan seller ini?');"
                                    class="w-full flex justify-center items-center px-4 py-3 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition-colors">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"></path>
                                    </svg>
                                    Nonaktifkan Seller
                                </button>
                            </form>
                        @else
                            <form action="{{ route('admin.sellers.activate', $seller->id) }}" method="POST" class="w-full">
                                @csrf
                                <button type="submit"
                                    onclick="return confirm('Apakah Anda yakin ingin mengaktifkan kembali seller ini?');"
                                    class="w-full flex justify-center items-center px-4 py-3 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-colors">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                    Aktifkan Seller
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
            @endif

            <!-- Info -->
            <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-blue-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                        </svg>
                    </div>
                    <div class="ml-3">
                        <h3 class="text-sm font-medium text-blue-800">Informasi</h3>
                        <div class="mt-2 text-sm text-blue-700">
                            <p>Pastikan untuk memverifikasi semua informasi dan dokumen sebelum menyetujui seller.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
