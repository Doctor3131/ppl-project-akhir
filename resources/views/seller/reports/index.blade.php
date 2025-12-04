@extends('layouts.app')

@section('title', 'Laporan Produk')

@section('content')
<div class="container mx-auto px-4 py-8">
    <!-- Header -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900">Laporan Produk</h1>
        <p class="mt-2 text-gray-600">Pilih jenis laporan yang ingin Anda lihat atau export ke PDF</p>
    </div>

    <!-- Report Options Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <!-- SRS-12: Laporan Stock -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden hover:shadow-md transition-shadow duration-200">
            <div class="bg-gradient-to-r from-blue-500 to-blue-600 px-6 py-4">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-white/20 rounded-full flex items-center justify-center">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold text-white">Laporan Stock</h3>
                        <p class="text-blue-100 text-sm">SRS-12</p>
                    </div>
                </div>
            </div>
            <div class="p-6">
                <p class="text-gray-600 text-sm mb-4">Daftar produk diurutkan berdasarkan jumlah stock (menurun)</p>
                <div class="text-xs text-gray-500 mb-4 bg-gray-50 p-3 rounded-lg font-mono">
                    No | Produk | Kategori | Harga | Rating | Stock
                </div>
                <div class="flex gap-2">
                    <a href="{{ route('seller.reports.stock') }}"
                       class="flex-1 px-4 py-2 bg-blue-100 text-blue-700 rounded-lg hover:bg-blue-200 transition duration-200 text-center text-sm font-medium">
                        Lihat Laporan
                    </a>
                    <a href="{{ route('seller.reports.stock.export') }}"
                       class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition duration-200 flex items-center gap-2 text-sm font-medium">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        PDF
                    </a>
                </div>
            </div>
        </div>

        <!-- SRS-13: Laporan Rating -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden hover:shadow-md transition-shadow duration-200">
            <div class="bg-gradient-to-r from-yellow-500 to-yellow-600 px-6 py-4">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-white/20 rounded-full flex items-center justify-center">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold text-white">Laporan Rating</h3>
                        <p class="text-yellow-100 text-sm">SRS-13</p>
                    </div>
                </div>
            </div>
            <div class="p-6">
                <p class="text-gray-600 text-sm mb-4">Daftar produk diurutkan berdasarkan rating (menurun)</p>
                <div class="text-xs text-gray-500 mb-4 bg-gray-50 p-3 rounded-lg font-mono">
                    No | Produk | Kategori | Harga | Stock | Rating
                </div>
                <div class="flex gap-2">
                    <a href="{{ route('seller.reports.rating') }}"
                       class="flex-1 px-4 py-2 bg-yellow-100 text-yellow-700 rounded-lg hover:bg-yellow-200 transition duration-200 text-center text-sm font-medium">
                        Lihat Laporan
                    </a>
                    <a href="{{ route('seller.reports.rating.export') }}"
                       class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition duration-200 flex items-center gap-2 text-sm font-medium">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        PDF
                    </a>
                </div>
            </div>
        </div>

        <!-- SRS-14: Laporan Segera Dipesan -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden hover:shadow-md transition-shadow duration-200">
            <div class="bg-gradient-to-r from-red-500 to-red-600 px-6 py-4">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-white/20 rounded-full flex items-center justify-center">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold text-white">Produk Segera Dipesan</h3>
                        <p class="text-red-100 text-sm">SRS-14</p>
                    </div>
                </div>
            </div>
            <div class="p-6">
                <p class="text-gray-600 text-sm mb-4">Daftar produk dengan stock rendah (&lt; 2) yang perlu segera dipesan</p>
                <div class="text-xs text-gray-500 mb-4 bg-gray-50 p-3 rounded-lg font-mono">
                    No | Produk | Kategori | Harga | Stock
                </div>
                <div class="flex gap-2">
                    <a href="{{ route('seller.reports.low-stock') }}"
                       class="flex-1 px-4 py-2 bg-red-100 text-red-700 rounded-lg hover:bg-red-200 transition duration-200 text-center text-sm font-medium">
                        Lihat Laporan
                    </a>
                    <a href="{{ route('seller.reports.low-stock.export') }}"
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

    <!-- Quick Export Section -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        <h2 class="text-lg font-semibold text-gray-900 mb-4">Export Cepat - Download Semua Laporan PDF</h2>
        <p class="text-gray-600 text-sm mb-4">Klik tombol di bawah untuk langsung download laporan dalam format PDF</p>
        
        <div class="flex flex-wrap gap-3">
            <a href="{{ route('seller.reports.stock.export') }}"
               class="inline-flex items-center gap-2 px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition duration-200 text-sm font-medium">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
                Export PDF: Laporan Stock (SRS-12)
            </a>
            
            <a href="{{ route('seller.reports.rating.export') }}"
               class="inline-flex items-center gap-2 px-4 py-2 bg-yellow-600 text-white rounded-lg hover:bg-yellow-700 transition duration-200 text-sm font-medium">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
                Export PDF: Laporan Rating (SRS-13)
            </a>
            
            <a href="{{ route('seller.reports.low-stock.export') }}"
               class="inline-flex items-center gap-2 px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition duration-200 text-sm font-medium">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
                Export PDF: Produk Segera Dipesan (SRS-14)
            </a>
        </div>
    </div>

    <!-- Info Box -->
    <div class="mt-6 bg-blue-50 border border-blue-200 rounded-lg p-4">
        <div class="flex items-start">
            <svg class="w-5 h-5 text-blue-600 mt-0.5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <div>
                <h4 class="text-sm font-semibold text-blue-900">Informasi Laporan</h4>
                <ul class="text-sm text-blue-800 mt-1 list-disc list-inside space-y-1">
                    <li><strong>SRS-12:</strong> Laporan daftar produk berdasarkan stock - diurutkan dari stock terbanyak</li>
                    <li><strong>SRS-13:</strong> Laporan daftar produk berdasarkan rating - diurutkan dari rating tertinggi</li>
                    <li><strong>SRS-14:</strong> Laporan produk segera dipesan (stock &lt; 2) - diurutkan berdasarkan kategori dan nama produk</li>
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection
