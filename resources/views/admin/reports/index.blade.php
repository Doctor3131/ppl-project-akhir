@extends('layouts.app')

@section('title', 'Laporan Platform')

@section('content')
<div class="container mx-auto px-4 py-8">
    <!-- Header -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900">Laporan Platform</h1>
        <p class="mt-2 text-gray-600">Pilih jenis laporan yang ingin Anda lihat atau export ke PDF</p>
    </div>

    <!-- Report Options Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <!-- SRS-09: Laporan Akun Penjual -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden hover:shadow-md transition-shadow duration-200">
            <div class="bg-gradient-to-r from-indigo-500 to-indigo-600 px-6 py-4">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-white/20 rounded-full flex items-center justify-center">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold text-white">Laporan Akun Penjual</h3>
                    </div>
                </div>
            </div>
            <div class="p-6">
                <p class="text-gray-600 text-sm mb-4">Daftar akun penjual berdasarkan status (aktif/tidak aktif)</p>
                <div class="text-xs text-gray-500 mb-4 bg-gray-50 p-3 rounded-lg font-mono">
                    No | Nama User | Nama PIC | Nama Toko | Status
                </div>
                <div class="flex gap-2">
                    <a href="{{ route('admin.reports.seller-accounts') }}"
                       class="flex-1 px-4 py-2 bg-indigo-100 text-indigo-700 rounded-lg hover:bg-indigo-200 transition duration-200 text-center text-sm font-medium">
                        Lihat Laporan
                    </a>
                    <a href="{{ route('admin.reports.seller-accounts.export') }}"
                       class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition duration-200 flex items-center gap-2 text-sm font-medium">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        PDF
                    </a>
                </div>
            </div>
        </div>

        <!-- SRS-10: Laporan Toko per Provinsi -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden hover:shadow-md transition-shadow duration-200 flex flex-col">
            <div class="bg-gradient-to-r from-green-500 to-green-600 px-6 py-4">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-white/20 rounded-full flex items-center justify-center">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold text-white">Laporan Toko per Provinsi</h3>
                    </div>
                </div>
            </div>
            <div class="p-6 flex flex-col flex-grow">
                <div class="flex-grow">
                    <p class="text-gray-600 text-sm mb-4">Daftar toko berdasarkan lokasi provinsi</p>
                    <div class="text-xs text-gray-500 mb-4 bg-gray-50 p-3 rounded-lg font-mono">
                        No | Nama Toko | Nama PIC | Provinsi
                    </div>
                </div>
                <div class="flex gap-2 mt-auto">
                    <a href="{{ route('admin.reports.sellers-by-province') }}"
                       class="flex-1 px-4 py-2 bg-green-100 text-green-700 rounded-lg hover:bg-green-200 transition duration-200 text-center text-sm font-medium">
                        Lihat Laporan
                    </a>
                    <a href="{{ route('admin.reports.sellers-by-province.export') }}"
                       class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition duration-200 flex items-center gap-2 text-sm font-medium">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        PDF
                    </a>
                </div>
            </div>
        </div>

        <!-- SRS-11: Laporan Produk per Rating -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden hover:shadow-md transition-shadow duration-200 flex flex-col">
            <div class="bg-gradient-to-r from-yellow-500 to-yellow-600 px-6 py-4">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-white/20 rounded-full flex items-center justify-center">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold text-white">Laporan Produk per Rating</h3>
                    </div>
                </div>
            </div>
            <div class="p-6 flex flex-col flex-grow">
                <div class="flex-grow">
                    <p class="text-gray-600 text-sm mb-4">Daftar produk berdasarkan rating (menurun)</p>
                    <div class="text-xs text-gray-500 mb-4 bg-gray-50 p-3 rounded-lg font-mono">
                        No | Produk | Kategori | Harga | Rating | Nama Toko | Provinsi
                    </div>
                </div>
                <div class="flex gap-2 mt-auto">
                    <a href="{{ route('admin.reports.products-by-rating') }}"
                       class="flex-1 px-4 py-2 bg-yellow-100 text-yellow-700 rounded-lg hover:bg-yellow-200 transition duration-200 text-center text-sm font-medium">
                        Lihat Laporan
                    </a>
                    <a href="{{ route('admin.reports.products-by-rating.export') }}"
                       class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition duration-200 flex items-center gap-2 text-sm font-medium">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        PDF
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
