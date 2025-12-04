@extends('layouts.app')

@section('title', 'Aktivasi Ulang Akun')

@section('content')
<div class="min-h-screen bg-gray-50 py-12">
    <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Alert Messages -->
        @if (session('success'))
            <div class="mb-6 bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-lg flex items-center">
                <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                </svg>
                {{ session('success') }}
            </div>
        @endif

        @if (session('info'))
            <div class="mb-6 bg-blue-50 border border-blue-200 text-blue-800 px-4 py-3 rounded-lg flex items-center">
                <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                </svg>
                {{ session('info') }}
            </div>
        @endif

        @if (session('warning'))
            <div class="mb-6 bg-yellow-50 border border-yellow-200 text-yellow-800 px-4 py-3 rounded-lg flex items-center">
                <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                </svg>
                {{ session('warning') }}
            </div>
        @endif

        <!-- Main Card -->
        <div class="bg-white rounded-lg shadow-sm overflow-hidden">
            <!-- Header -->
            <div class="bg-red-600 px-6 py-8 text-center">
                <div class="w-20 h-20 bg-white/20 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                    </svg>
                </div>
                <h1 class="text-2xl font-bold text-white">Akun Anda Tidak Aktif</h1>
                <p class="text-red-100 mt-2">Akun toko Anda saat ini dalam status tidak aktif</p>
            </div>

            <!-- Content -->
            <div class="p-6">
                <!-- Account Info -->
                <div class="mb-6 bg-gray-50 rounded-lg p-4">
                    <h3 class="font-semibold text-gray-900 mb-3">Informasi Akun</h3>
                    <div class="space-y-2 text-sm">
                        <div class="flex justify-between">
                            <span class="text-gray-600">Nama:</span>
                            <span class="font-medium text-gray-900">{{ $user->name }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Email:</span>
                            <span class="font-medium text-gray-900">{{ $user->email }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Nama Toko:</span>
                            <span class="font-medium text-gray-900">{{ $user->seller->shop_name ?? '-' }}</span>
                        </div>
                        @if ($user->deactivated_at)
                        <div class="flex justify-between">
                            <span class="text-gray-600">Dinonaktifkan pada:</span>
                            <span class="font-medium text-red-600">{{ $user->deactivated_at->format('d M Y, H:i') }}</span>
                        </div>
                        @endif
                        @if ($user->deactivation_reason)
                        <div class="flex justify-between">
                            <span class="text-gray-600">Alasan:</span>
                            <span class="font-medium text-gray-900">{{ $user->deactivation_reason }}</span>
                        </div>
                        @endif
                    </div>
                </div>

                <!-- Reason -->
                <div class="mb-6">
                    <h3 class="font-semibold text-gray-900 mb-2">Mengapa akun Anda tidak aktif?</h3>
                    <p class="text-gray-600 text-sm leading-relaxed">
                        Akun penjual dapat dinonaktifkan karena beberapa alasan:
                    </p>
                    <ul class="mt-3 space-y-2 text-sm text-gray-600">
                        <li class="flex items-start">
                            <svg class="w-5 h-5 text-gray-400 mr-2 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                            </svg>
                            <span>Tidak ada aktivitas login selama 30 hari (deaktivasi otomatis)</span>
                        </li>
                        <li class="flex items-start">
                            <svg class="w-5 h-5 text-gray-400 mr-2 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                            </svg>
                            <span>Dinonaktifkan oleh Admin karena alasan tertentu</span>
                        </li>
                    </ul>
                </div>

                <!-- Request Status or Form -->
                @if ($hasRequestedReactivation)
                    <!-- Already Requested -->
                    <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-6">
                        <div class="flex items-start">
                            <svg class="w-6 h-6 text-blue-600 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <div>
                                <h4 class="font-semibold text-blue-900">Permohonan Sedang Diproses</h4>
                                <p class="text-sm text-blue-800 mt-1">
                                    Permohonan aktivasi ulang Anda sudah diajukan pada 
                                    <strong>{{ $user->reactivation_requested_at->format('d M Y, H:i') }}</strong>.
                                    <br>Admin akan meninjau permintaan Anda dalam waktu 1-3 hari kerja.
                                </p>
                            </div>
                        </div>
                    </div>
                @else
                    <!-- Request Form -->
                    <div class="bg-green-50 border border-green-200 rounded-lg p-4 mb-6">
                        <div class="flex items-start">
                            <svg class="w-6 h-6 text-green-600 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <div>
                                <h4 class="font-semibold text-green-900">Ajukan Aktivasi Ulang</h4>
                                <p class="text-sm text-green-800 mt-1">
                                    Anda dapat mengajukan permohonan untuk mengaktifkan kembali akun toko Anda.
                                    Admin akan meninjau permintaan Anda.
                                </p>
                            </div>
                        </div>
                    </div>

                    <form action="{{ route('seller.reactivation.store') }}" method="POST">
                        @csrf
                        <button type="submit"
                                class="w-full py-3 px-4 bg-indigo-600 hover:bg-indigo-700 text-white font-medium rounded-lg transition duration-200 flex items-center justify-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                            </svg>
                            Ajukan Aktivasi Ulang
                        </button>
                    </form>
                @endif

                <!-- Logout Button -->
                <div class="mt-6 pt-6 border-t border-gray-200">
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit"
                                class="w-full py-3 px-4 bg-gray-100 hover:bg-gray-200 text-gray-700 font-medium rounded-lg transition duration-200 flex items-center justify-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                            </svg>
                            Logout
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Help Section -->
        <div class="mt-6 text-center text-sm text-gray-600">
            <p>Butuh bantuan? Hubungi tim support kami:</p>
            <a href="mailto:support@campusmarket.com" class="text-indigo-600 hover:text-indigo-800 font-medium">
                support@campusmarket.com
            </a>
        </div>
    </div>
</div>
@endsection
