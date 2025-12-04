@extends('layouts.app')

@section('title', 'Admin Dashboard')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <!-- Page Header -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900">Admin Dashboard</h1>
        <p class="mt-2 text-gray-600">Welcome back, {{ auth()->user()->name }}!</p>
    </div>

    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <!-- Pending Sellers -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600 mb-1">Pending Sellers</p>
                    <p class="text-3xl font-bold text-yellow-600">{{ $pendingSellers }}</p>
                </div>
                <div class="p-3 bg-yellow-100 rounded-full">
                    <svg class="w-8 h-8 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
            </div>
            <div class="mt-4">
                <a href="{{ route('admin.sellers.index', ['status' => 'pending']) }}" class="text-sm text-yellow-600 hover:text-yellow-700 font-medium">
                    View pending requests →
                </a>
            </div>
        </div>

        <!-- Approved Sellers -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600 mb-1">Approved Sellers</p>
                    <p class="text-3xl font-bold text-green-600">{{ $approvedSellers }}</p>
                </div>
                <div class="p-3 bg-green-100 rounded-full">
                    <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
            </div>
            <div class="mt-4">
                <a href="{{ route('admin.sellers.index', ['status' => 'approved']) }}" class="text-sm text-green-600 hover:text-green-700 font-medium">
                    View all sellers →
                </a>
            </div>
        </div>

        <!-- Total Products -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600 mb-1">Total Products</p>
                    <p class="text-3xl font-bold text-blue-600">{{ $totalProducts }}</p>
                </div>
                <div class="p-3 bg-blue-100 rounded-full">
                    <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                    </svg>
                </div>
            </div>
            <div class="mt-4">
                <a href="{{ route('home') }}" class="text-sm text-blue-600 hover:text-blue-700 font-medium">
                    View catalog →
                </a>
            </div>
        </div>

        <!-- Total Categories -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600 mb-1">Total Categories</p>
                    <p class="text-3xl font-bold text-purple-600">{{ $totalCategories }}</p>
                </div>
                <div class="p-3 bg-purple-100 rounded-full">
                    <svg class="w-8 h-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                    </svg>
                </div>
            </div>
            <div class="mt-4">
                <a href="{{ route('admin.categories.index') }}" class="text-sm text-purple-600 hover:text-purple-700 font-medium">
                    Manage categories →
                </a>
            </div>
        </div>
    </div>

    <!-- Seller Activity Stats -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <!-- Active Sellers -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600 mb-1">Seller Aktif</p>
                    <p class="text-3xl font-bold text-emerald-600">{{ $sellerActivityData['active'] }}</p>
                </div>
                <div class="p-3 bg-emerald-100 rounded-full">
                    <svg class="w-8 h-8 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0zm6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
            </div>
            <div class="mt-4">
                <a href="{{ route('admin.sellers.index', ['is_active' => '1']) }}" class="text-sm text-emerald-600 hover:text-emerald-700 font-medium">
                    View active sellers →
                </a>
            </div>
        </div>

        <!-- Inactive Sellers -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600 mb-1">Seller Non-Aktif</p>
                    <p class="text-3xl font-bold text-gray-600">{{ $sellerActivityData['inactive'] }}</p>
                </div>
                <div class="p-3 bg-gray-100 rounded-full">
                    <svg class="w-8 h-8 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"></path>
                    </svg>
                </div>
            </div>
            <div class="mt-4">
                <a href="{{ route('admin.sellers.index', ['is_active' => '0']) }}" class="text-sm text-gray-600 hover:text-gray-700 font-medium">
                    View inactive sellers →
                </a>
            </div>
        </div>

        <!-- Pending Reactivation Requests -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600 mb-1">Permintaan Reaktivasi</p>
                    <p class="text-3xl font-bold text-orange-600">{{ $pendingReactivations }}</p>
                </div>
                <div class="p-3 bg-orange-100 rounded-full">
                    <svg class="w-8 h-8 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                    </svg>
                </div>
            </div>
            <div class="mt-4">
                <a href="{{ route('admin.sellers.reactivation-requests') }}" class="text-sm text-orange-600 hover:text-orange-700 font-medium">
                    Review requests →
                </a>
            </div>
        </div>
    </div>
    
    <!-- Quick Actions -->
    <div class="bg-white rounded-lg shadow-md p-6 mb-8">
        <h2 class="text-xl font-semibold text-gray-900 mb-4">Quick Actions</h2>
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <a href="{{ route('admin.categories.create') }}"
                class="flex items-center p-4 bg-indigo-50 hover:bg-indigo-100 rounded-lg transition-colors duration-200">
                <div class="p-2 bg-indigo-600 rounded-lg mr-4">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                </div>
                <div>
                    <p class="font-semibold text-gray-900">Add Category</p>
                    <p class="text-sm text-gray-600">Create new category</p>
                </div>
            </a>

            <a href="{{ route('admin.sellers.index') }}"
                class="flex items-center p-4 bg-yellow-50 hover:bg-yellow-100 rounded-lg transition-colors duration-200">
                <div class="p-2 bg-yellow-600 rounded-lg mr-4">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                    </svg>
                </div>
                <div>
                    <p class="font-semibold text-gray-900">Manage Sellers</p>
                    <p class="text-sm text-gray-600">Approve/reject sellers</p>
                </div>
            </a>

            <a href="{{ route('admin.reports.index') }}"
                class="flex items-center p-4 bg-green-50 hover:bg-green-100 rounded-lg transition-colors duration-200">
                <div class="p-2 bg-green-600 rounded-lg mr-4">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                </div>
                <div>
                    <p class="font-semibold text-gray-900">Laporan</p>
                    <p class="text-sm text-gray-600">Download PDF reports</p>
                </div>
            </a>

            <a href="{{ route('admin.categories.index') }}"
                class="flex items-center p-4 bg-purple-50 hover:bg-purple-100 rounded-lg transition-colors duration-200">
                <div class="p-2 bg-purple-600 rounded-lg mr-4">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                    </svg>
                </div>
                <div>
                    <p class="font-semibold text-gray-900">View Categories</p>
                    <p class="text-sm text-gray-600">Browse all categories</p>
                </div>
            </a>
        </div>
    </div>

    <!-- SRS-07: Grafik Section -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
        <!-- Produk per Kategori Chart -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Produk per Kategori</h3>
            <div class="h-64">
                <canvas id="productsByCategoryChart"></canvas>
            </div>
        </div>

        <!-- Toko per Provinsi Chart -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Toko per Provinsi</h3>
            <div class="h-64">
                <canvas id="sellersByProvinceChart"></canvas>
            </div>
        </div>

        <!-- Status Seller Chart (Approval Status) -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Status Persetujuan Penjual</h3>
            <div class="h-64">
                <canvas id="sellerApprovalChart"></canvas>
            </div>
        </div>

        <!-- Seller Activity Chart -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Status Aktivitas Penjual (SRS-07)</h3>
            <div class="h-64">
                <canvas id="sellerActivityChart"></canvas>
            </div>
        </div>

        <!-- Rating & Komentar Chart -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Pengunjung Memberi Rating & Komentar</h3>
            <div class="h-64">
                <canvas id="ratingsChart"></canvas>
            </div>
        </div>

        <!-- Rating Distribution Chart -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Distribusi Rating (1-5 ⭐)</h3>
            <div class="h-64">
                <canvas id="ratingDistributionChart"></canvas>
            </div>
        </div>
    </div>

    <!-- Monthly Trends Chart - Full Width -->
    <div class="bg-white rounded-lg shadow-md p-6 mb-8">
        <h3 class="text-lg font-semibold text-gray-900 mb-4">Tren Bulanan (6 Bulan Terakhir)</h3>
        <div class="h-72">
            <canvas id="monthlyTrendsChart"></canvas>
        </div>
    </div>


    <!-- Recent Activities Section -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
        <!-- Recent Ratings -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Rating Terbaru</h3>
            @if($recentRatings->count() > 0)
                <div class="space-y-4">
                    @foreach($recentRatings as $rating)
                        <div class="flex items-start space-x-3 pb-3 border-b border-gray-100 last:border-0">
                            <div class="flex-shrink-0 w-10 h-10 bg-indigo-100 rounded-full flex items-center justify-center">
                                <span class="text-indigo-600 font-semibold">{{ substr($rating->visitor_name, 0, 1) }}</span>
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-medium text-gray-900 truncate">{{ $rating->visitor_name }}</p>
                                <p class="text-sm text-gray-500 truncate">{{ $rating->product->name ?? 'N/A' }}</p>
                                <div class="flex items-center mt-1">
                                    @for($i = 1; $i <= 5; $i++)
                                        <svg class="w-4 h-4 {{ $i <= $rating->rating ? 'text-yellow-400' : 'text-gray-300' }}" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/>
                                        </svg>
                                    @endfor
                                    <span class="ml-2 text-xs text-gray-500">{{ $rating->created_at->diffForHumans() }}</span>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-gray-500 text-center py-4">Belum ada rating</p>
            @endif
        </div>

        <!-- Top Rated Products -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Produk Rating Tertinggi</h3>
            @if($topRatedProducts->count() > 0)
                <div class="space-y-4">
                    @foreach($topRatedProducts as $product)
                        <div class="flex items-center space-x-3 pb-3 border-b border-gray-100 last:border-0">
                            <div class="flex-shrink-0 w-12 h-12 bg-gray-100 rounded-lg overflow-hidden">
                                @if($product->image)
                                    <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="w-full h-full object-cover">
                                @else
                                    <div class="w-full h-full flex items-center justify-center text-gray-400">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                        </svg>
                                    </div>
                                @endif
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-medium text-gray-900 truncate">{{ $product->name }}</p>
                                <p class="text-xs text-gray-500">{{ $product->user->seller->shop_name ?? 'N/A' }}</p>
                                <div class="flex items-center mt-1">
                                    <span class="text-yellow-500 font-semibold">{{ number_format($product->average_rating, 1) }}</span>
                                    <svg class="w-4 h-4 text-yellow-400 ml-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/>
                                    </svg>
                                    <span class="ml-2 text-xs text-gray-500">({{ $product->rating_count }} reviews)</span>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-gray-500 text-center py-4">Belum ada produk dengan rating</p>
            @endif
        </div>
    </div>

    <!-- Alert for Pending Approvals -->
    @if($pendingSellers > 0)
        <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 rounded-lg">
            <div class="flex">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                    </svg>
                </div>
                <div class="ml-3">
                    <p class="text-sm text-yellow-700">
                        <span class="font-medium">{{ $pendingSellers }}</span> seller registration{{ $pendingSellers > 1 ? 's' : '' }} waiting for your approval.
                        <a href="{{ route('admin.sellers.index', ['status' => 'pending']) }}" class="font-semibold underline hover:text-yellow-600">
                            Review now
                        </a>
                    </p>
                </div>
            </div>
        </div>
    @endif
</div>

<!-- Chart.js CDN -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    // Color palette
    const colors = {
        primary: 'rgba(99, 102, 241, 0.8)',
        primaryBorder: 'rgba(99, 102, 241, 1)',
        success: 'rgba(34, 197, 94, 0.8)',
        successBorder: 'rgba(34, 197, 94, 1)',
        warning: 'rgba(234, 179, 8, 0.8)',
        warningBorder: 'rgba(234, 179, 8, 1)',
        danger: 'rgba(239, 68, 68, 0.8)',
        dangerBorder: 'rgba(239, 68, 68, 1)',
        info: 'rgba(59, 130, 246, 0.8)',
        infoBorder: 'rgba(59, 130, 246, 1)',
    };

    const chartColors = [
        'rgba(99, 102, 241, 0.8)',
        'rgba(34, 197, 94, 0.8)',
        'rgba(234, 179, 8, 0.8)',
        'rgba(239, 68, 68, 0.8)',
        'rgba(59, 130, 246, 0.8)',
        'rgba(168, 85, 247, 0.8)',
        'rgba(236, 72, 153, 0.8)',
        'rgba(20, 184, 166, 0.8)',
        'rgba(249, 115, 22, 0.8)',
        'rgba(107, 114, 128, 0.8)',
    ];

    // 1. Products by Category Chart
    const productsByCategoryCtx = document.getElementById('productsByCategoryChart').getContext('2d');
    new Chart(productsByCategoryCtx, {
        type: 'bar',
        data: {
            labels: @json($productsByCategory->pluck('category_name')),
            datasets: [{
                label: 'Jumlah Produk',
                data: @json($productsByCategory->pluck('total')),
                backgroundColor: chartColors,
                borderColor: chartColors.map(c => c.replace('0.8', '1')),
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false }
            },
            scales: {
                y: { beginAtZero: true, ticks: { stepSize: 1 } }
            }
        }
    });

    // 2. Sellers by Province Chart
    const sellersByProvinceCtx = document.getElementById('sellersByProvinceChart').getContext('2d');
    new Chart(sellersByProvinceCtx, {
        type: 'doughnut',
        data: {
            labels: @json($sellersByProvince->pluck('province')),
            datasets: [{
                data: @json($sellersByProvince->pluck('total')),
                backgroundColor: chartColors,
                borderWidth: 2
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { position: 'right', labels: { boxWidth: 12, font: { size: 11 } } }
            }
        }
    });

    // 3. Seller Approval Status Chart
    const sellerApprovalCtx = document.getElementById('sellerApprovalChart').getContext('2d');
    new Chart(sellerApprovalCtx, {
        type: 'pie',
        data: {
            labels: ['Disetujui', 'Pending', 'Ditolak'],
            datasets: [{
                data: [
                    {{ $sellerApprovalData['approved'] }},
                    {{ $sellerApprovalData['pending'] }},
                    {{ $sellerApprovalData['rejected'] }}
                ],
                backgroundColor: [colors.success, colors.warning, colors.danger],
                borderColor: [colors.successBorder, colors.warningBorder, colors.dangerBorder],
                borderWidth: 2
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { position: 'bottom' }
            }
        }
    });

    // 3b. Seller Activity Status Chart (SRS-07: Aktif vs Non-Aktif)
    const sellerActivityCtx = document.getElementById('sellerActivityChart').getContext('2d');
    new Chart(sellerActivityCtx, {
        type: 'doughnut',
        data: {
            labels: ['Aktif', 'Non-Aktif'],
            datasets: [{
                data: [
                    {{ $sellerActivityData['active'] }},
                    {{ $sellerActivityData['inactive'] }}
                ],
                backgroundColor: ['rgba(16, 185, 129, 0.8)', 'rgba(107, 114, 128, 0.8)'],
                borderColor: ['rgba(16, 185, 129, 1)', 'rgba(107, 114, 128, 1)'],
                borderWidth: 2
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { position: 'bottom' },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            let total = context.dataset.data.reduce((a, b) => a + b, 0);
                            let percentage = total > 0 ? ((context.raw / total) * 100).toFixed(1) : 0;
                            return context.label + ': ' + context.raw + ' (' + percentage + '%)';
                        }
                    }
                }
            }
        }
    });

    // 4. Ratings Chart (with/without comments)
    const ratingsCtx = document.getElementById('ratingsChart').getContext('2d');
    new Chart(ratingsCtx, {
        type: 'bar',
        data: {
            labels: ['Total Rating', 'Pengunjung Unik', 'Dengan Komentar', 'Tanpa Komentar'],
            datasets: [{
                label: 'Jumlah',
                data: [
                    {{ $ratingsData['total_ratings'] }},
                    {{ $ratingsData['unique_visitors'] }},
                    {{ $ratingsData['with_comment'] }},
                    {{ $ratingsData['without_comment'] }}
                ],
                backgroundColor: [colors.primary, colors.info, colors.success, colors.warning],
                borderColor: [colors.primaryBorder, colors.infoBorder, colors.successBorder, colors.warningBorder],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false }
            },
            scales: {
                y: { beginAtZero: true, ticks: { stepSize: 1 } }
            }
        }
    });

    // 5. Rating Distribution Chart
    const ratingDistributionCtx = document.getElementById('ratingDistributionChart').getContext('2d');
    new Chart(ratingDistributionCtx, {
        type: 'bar',
        data: {
            labels: ['1 ⭐', '2 ⭐', '3 ⭐', '4 ⭐', '5 ⭐'],
            datasets: [{
                label: 'Jumlah Rating',
                data: [
                    {{ $ratingDistribution[1] ?? 0 }},
                    {{ $ratingDistribution[2] ?? 0 }},
                    {{ $ratingDistribution[3] ?? 0 }},
                    {{ $ratingDistribution[4] ?? 0 }},
                    {{ $ratingDistribution[5] ?? 0 }}
                ],
                backgroundColor: [
                    'rgba(239, 68, 68, 0.8)',
                    'rgba(249, 115, 22, 0.8)',
                    'rgba(234, 179, 8, 0.8)',
                    'rgba(132, 204, 22, 0.8)',
                    'rgba(34, 197, 94, 0.8)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false }
            },
            scales: {
                y: { beginAtZero: true, ticks: { stepSize: 1 } }
            }
        }
    });

    // 6. Monthly Trends Chart
    const monthlyTrendsCtx = document.getElementById('monthlyTrendsChart').getContext('2d');
    const monthlyData = @json($monthlyData);
    new Chart(monthlyTrendsCtx, {
        type: 'line',
        data: {
            labels: monthlyData.map(d => d.month),
            datasets: [
                {
                    label: 'Produk Baru',
                    data: monthlyData.map(d => d.products),
                    borderColor: colors.primaryBorder,
                    backgroundColor: colors.primary,
                    tension: 0.3,
                    fill: false
                },
                {
                    label: 'Rating Baru',
                    data: monthlyData.map(d => d.ratings),
                    borderColor: colors.successBorder,
                    backgroundColor: colors.success,
                    tension: 0.3,
                    fill: false
                },
                {
                    label: 'Seller Baru',
                    data: monthlyData.map(d => d.sellers),
                    borderColor: colors.warningBorder,
                    backgroundColor: colors.warning,
                    tension: 0.3,
                    fill: false
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { position: 'bottom' }
            },
            scales: {
                y: { beginAtZero: true, ticks: { stepSize: 1 } }
            }
        }
    });
</script>
@endsection
