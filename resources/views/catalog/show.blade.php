@extends('layouts.app')

@section('title', $product->name)

@section('content')
<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Breadcrumb -->
        <nav class="mb-6 text-sm">
            <ol class="flex items-center space-x-2 text-gray-600">
                <li><a href="{{ route('catalog.index') }}" class="hover:text-indigo-600">Katalog</a></li>
                <li><span class="mx-2">/</span></li>
                <li><a href="{{ route('catalog.index', ['category_id' => $product->category_id]) }}" class="hover:text-indigo-600">
                    {{ $product->category->name ?? 'Uncategorized' }}
                </a></li>
                <li><span class="mx-2">/</span></li>
                <li class="text-gray-900 font-medium">{{ $product->name }}</li>
            </ol>
        </nav>

        <!-- Success Message -->
        @if (session('success'))
            <div x-data="{ show: true }" x-show="show" class="mb-6 bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-lg flex items-center justify-between">
                <div class="flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                    </svg>
                    {{ session('success') }}
                </div>
                <button @click="show = false" class="text-green-600 hover:text-green-800">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-12">
            <!-- Product Image -->
            <div class="bg-white rounded-lg shadow-sm p-6">
                @if ($product->image)
                    <img src="{{ asset('storage/' . $product->image) }}"
                         alt="{{ $product->name }}"
                         class="w-full h-auto rounded-lg">
                @else
                    <div class="w-full h-96 flex items-center justify-center bg-gray-100 rounded-lg">
                        <svg class="w-32 h-32 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                    </div>
                @endif
            </div>

            <!-- Product Info -->
            <div class="space-y-6">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900 mb-2">{{ $product->name }}</h1>
                    <p class="text-sm text-gray-500">{{ $product->category->name ?? 'Uncategorized' }}</p>
                </div>

                <!-- Price -->
                <div class="border-t border-b py-4">
                    <p class="text-3xl font-bold text-indigo-600">
                        Rp {{ number_format($product->price, 0, ',', '.') }}
                    </p>
                </div>

                <!-- Rating Summary -->
                <div class="bg-gray-50 rounded-lg p-4">
                    <div class="flex items-center justify-between mb-4">
                        <div>
                            <div class="flex items-center gap-2">
                                <span class="text-4xl font-bold text-gray-900">{{ number_format($averageRating, 1) }}</span>
                                <div>
                                    <div class="flex text-yellow-400">
                                        @for ($i = 1; $i <= 5; $i++)
                                            @if ($i <= floor($averageRating))
                                                <svg class="w-5 h-5 fill-current" viewBox="0 0 20 20">
                                                    <path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/>
                                                </svg>
                                            @else
                                                <svg class="w-5 h-5 text-gray-300 fill-current" viewBox="0 0 20 20">
                                                    <path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/>
                                                </svg>
                                            @endif
                                        @endfor
                                    </div>
                                    <p class="text-sm text-gray-600">{{ $ratingCount }} penilaian</p>
                                </div>
                            </div>
                        </div>
                        <button onclick="document.getElementById('ratingForm').scrollIntoView({ behavior: 'smooth' })"
                                class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition duration-200">
                            Beri Rating
                        </button>
                    </div>

                    <!-- Rating Distribution -->
                    @if ($ratingCount > 0)
                        <div class="space-y-2">
                            @foreach ($ratingDistribution as $star => $data)
                                <div class="flex items-center gap-3">
                                    <span class="text-sm font-medium text-gray-700 w-12">{{ $star }} ⭐</span>
                                    <div class="flex-1 bg-gray-200 rounded-full h-2">
                                        <div class="bg-yellow-400 h-2 rounded-full" style="width: {{ $data['percentage'] }}%"></div>
                                    </div>
                                    <span class="text-sm text-gray-600 w-16 text-right">{{ $data['count'] }}</span>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>

                <!-- Stock -->
                <div>
                    <p class="text-sm text-gray-600 mb-2">Ketersediaan Stok:</p>
                    @if ($product->stock > 0)
                        <span class="inline-block px-3 py-1 text-sm font-semibold text-green-800 bg-green-100 rounded-full">
                            Tersedia ({{ $product->stock }} unit)
                        </span>
                    @else
                        <span class="inline-block px-3 py-1 text-sm font-semibold text-red-800 bg-red-100 rounded-full">
                            Stok Habis
                        </span>
                    @endif
                </div>

                <!-- Description -->
                @if ($product->description)
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900 mb-2">Deskripsi Produk</h3>
                        <p class="text-gray-700 leading-relaxed">{{ $product->description }}</p>
                    </div>
                @endif

                <!-- Seller Info -->
                <div class="border-t pt-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Informasi Toko</h3>
                    <div class="bg-white border border-gray-200 rounded-lg p-4">
                        <div class="flex items-start gap-4">
                            <div class="w-16 h-16 bg-indigo-100 rounded-full flex items-center justify-center text-indigo-600 font-bold text-xl">
                                {{ strtoupper(substr(optional($product->user->seller)->shop_name ?? 'T', 0, 2)) }}
                            </div>
                            <div class="flex-1">
                                <h4 class="font-semibold text-gray-900 text-lg">
                                    {{ optional($product->user->seller)->shop_name ?? 'Unknown Shop' }}
                                </h4>
                                @if (optional($product->user->seller)->shop_description)
                                    <p class="text-sm text-gray-600 mt-1">{{ optional($product->user->seller)->shop_description }}</p>
                                @endif
                                <div class="mt-3 space-y-1 text-sm text-gray-600">
                                    <p>
                                        <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                        </svg>
                                        {{ optional($product->user->seller)->kota_kabupaten ?? 'N/A' }}, {{ optional($product->user->seller)->province ?? 'N/A' }}
                                    </p>
                                    <p>
                                        <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                        </svg>
                                        {{ optional($product->user->seller)->pic_email ?? 'N/A' }}
                                    </p>
                                    <p>
                                        <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                        </svg>
                                        {{ optional($product->user->seller)->pic_phone ?? 'N/A' }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Rating Form Section -->
        <div id="ratingForm" class="bg-white rounded-lg shadow-sm p-6 mb-8">
            <h2 class="text-2xl font-bold text-gray-900 mb-6">Beri Rating & Komentar</h2>

            @if ($errors->any())
                <div x-data="{ show: true }" x-show="show" class="mb-6 bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-lg flex items-start justify-between">
                    <ul class="list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button @click="show = false" class="text-red-600 hover:text-red-800 ml-4">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>
            @endif

            <form action="{{ route('rating.store', $product->id) }}" method="POST" class="space-y-6">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="visitor_name" class="block text-sm font-medium text-gray-700 mb-2">
                            Nama Lengkap <span class="text-red-500">*</span>
                        </label>
                        <input type="text"
                               name="visitor_name"
                               id="visitor_name"
                               value="{{ old('visitor_name') }}"
                               required
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                               placeholder="Masukkan nama Anda">
                    </div>

                    <div>
                        <label for="visitor_phone" class="block text-sm font-medium text-gray-700 mb-2">
                            Nomor HP <span class="text-red-500">*</span>
                        </label>
                        <input type="tel"
                               name="visitor_phone"
                               id="visitor_phone"
                               value="{{ old('visitor_phone') }}"
                               required
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                               placeholder="08xxxxxxxxxx">
                    </div>

                    <div>
                        <label for="visitor_email" class="block text-sm font-medium text-gray-700 mb-2">
                            Email <span class="text-red-500">*</span>
                        </label>
                        <input type="email"
                               name="visitor_email"
                               id="visitor_email"
                               value="{{ old('visitor_email') }}"
                               required
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                               placeholder="email@example.com">
                    </div>

                    <div>
                        <label for="province" class="block text-sm font-medium text-gray-700 mb-2">
                            Provinsi <span class="text-red-500">*</span>
                        </label>
                        <select name="province"
                                id="province"
                                required
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                            <option value="">Pilih Provinsi</option>
                            @foreach (\Indonesia::allProvinces() as $prov)
                                <option value="{{ $prov->name }}" {{ old('province') == $prov->name ? 'selected' : '' }}>
                                    {{ $prov->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Rating <span class="text-red-500">*</span>
                    </label>
                    <div class="flex items-center gap-2">
                        <div class="flex gap-1" id="star-rating">
                            @for ($i = 1; $i <= 5; $i++)
                                <button type="button"
                                        onclick="setRating({{ $i }})"
                                        class="star-btn focus:outline-none transition duration-200"
                                        data-rating="{{ $i }}">
                                    <svg class="w-10 h-10 text-gray-300 hover:text-yellow-400 fill-current" viewBox="0 0 20 20">
                                        <path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/>
                                    </svg>
                                </button>
                            @endfor
                        </div>
                        <span id="rating-text" class="text-gray-600 font-medium ml-2"></span>
                    </div>
                    <input type="hidden" name="rating" id="rating-input" value="{{ old('rating', 5) }}" required>
                </div>

                <div>
                    <label for="comment" class="block text-sm font-medium text-gray-700 mb-2">
                        Komentar (Opsional)
                    </label>
                    <textarea name="comment"
                              id="comment"
                              rows="4"
                              class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                              placeholder="Bagikan pengalaman Anda dengan produk ini...">{{ old('comment') }}</textarea>
                    <p class="mt-1 text-sm text-gray-500">Komentar Anda akan membantu pembeli lain membuat keputusan yang lebih baik.</p>
                </div>

                <div class="flex items-center gap-4">
                    <button type="submit"
                            class="px-6 py-3 bg-indigo-600 text-white font-medium rounded-lg hover:bg-indigo-700 transition duration-200">
                        Kirim Rating & Komentar
                    </button>
                    <p class="text-sm text-gray-600">
                        <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        Anda akan menerima email konfirmasi setelah mengirim rating
                    </p>
                </div>
            </form>
        </div>

        <!-- Comments Section -->
        <div class="bg-white rounded-lg shadow-sm p-6">
            <h2 class="text-2xl font-bold text-gray-900 mb-6">
                Rating & Komentar ({{ $ratingCount }})
            </h2>

            @if ($product->ratings->count() > 0)
                <div class="space-y-6">
                    @foreach ($product->ratings as $rating)
                        <div class="border-b border-gray-200 pb-6 last:border-0">
                            <div class="flex items-start justify-between mb-3">
                                <div>
                                    <h4 class="font-semibold text-gray-900">{{ $rating->visitor_name }}</h4>
                                    <p class="text-sm text-gray-500">{{ $rating->created_at->format('d M Y, H:i') }}</p>
                                </div>
                                <div class="flex text-yellow-400">
                                    @for ($i = 1; $i <= 5; $i++)
                                        @if ($i <= $rating->rating)
                                            <svg class="w-5 h-5 fill-current" viewBox="0 0 20 20">
                                                <path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/>
                                            </svg>
                                        @else
                                            <svg class="w-5 h-5 text-gray-300 fill-current" viewBox="0 0 20 20">
                                                <path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/>
                                            </svg>
                                        @endif
                                    @endfor
                                </div>
                            </div>
                            @if ($rating->comment)
                                <p class="text-gray-700 leading-relaxed">{{ $rating->comment }}</p>
                            @endif
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-12">
                    <svg class="w-16 h-16 mx-auto text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                    </svg>
                    <p class="text-gray-600">Belum ada rating dan komentar untuk produk ini.</p>
                    <p class="text-sm text-gray-500 mt-2">Jadilah yang pertama memberikan rating!</p>
                </div>
            @endif
        </div>
    </div>
</div>

<script>
    // Star rating functionality
    let currentRating = {{ old('rating', 5) }};

    function setRating(rating) {
        currentRating = rating;
        document.getElementById('rating-input').value = rating;
        updateStars();
        updateRatingText();
    }

    function updateStars() {
        const stars = document.querySelectorAll('.star-btn svg');
        stars.forEach((star, index) => {
            if (index < currentRating) {
                star.classList.remove('text-gray-300');
                star.classList.add('text-yellow-400');
            } else {
                star.classList.remove('text-yellow-400');
                star.classList.add('text-gray-300');
            }
        });
    }

    function updateRatingText() {
        const texts = ['', 'Sangat Buruk', 'Buruk', 'Cukup', 'Baik', 'Sangat Baik'];
        document.getElementById('rating-text').textContent = texts[currentRating];
    }

    // Initialize on page load
    document.addEventListener('DOMContentLoaded', function() {
        updateStars();
        updateRatingText();
    });
</script>
@endsection
