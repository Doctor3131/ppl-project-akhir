@extends('layouts.app')

@section('title', 'Verifikasi Email')

@section('content')
<div class="max-w-lg mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="bg-white rounded-lg shadow-lg overflow-hidden">
        <div class="px-8 py-10">
            <!-- Header -->
            <div class="text-center mb-8">
                <div class="mx-auto flex items-center justify-center h-16 w-16 rounded-full bg-indigo-100 mb-4">
                    <svg class="h-8 w-8 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 19v-8.93a2 2 0 01.89-1.664l7-4.666a2 2 0 012.22 0l7 4.666A2 2 0 0121 10.07V19M3 19a2 2 0 002 2h14a2 2 0 002-2M3 19l6.75-4.5M21 19l-6.75-4.5M3 10l6.75 4.5M21 10l-6.75 4.5m0 0l-1.14.76a2 2 0 01-2.22 0l-1.14-.76"></path>
                    </svg>
                </div>
                <h2 class="text-2xl font-bold text-gray-900">Verifikasi Email Anda</h2>
                <p class="mt-2 text-gray-600">
                    Kami telah mengirim link verifikasi ke:<br>
                    <span class="font-semibold text-indigo-600">{{ auth()->user()->email }}</span>
                </p>
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
                    <div class="w-16 h-1 bg-yellow-400 mx-4"></div>
                    <div class="flex items-center">
                        <div class="flex items-center justify-center w-10 h-10 bg-yellow-400 text-white rounded-full font-bold animate-pulse">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                        <span class="ml-2 text-sm font-medium text-yellow-600">Verifikasi</span>
                    </div>
                    <div class="w-16 h-1 bg-gray-300 mx-4"></div>
                    <div class="flex items-center">
                        <div class="flex items-center justify-center w-10 h-10 bg-gray-300 text-gray-500 rounded-full font-bold">
                            2
                        </div>
                        <span class="ml-2 text-sm font-medium text-gray-500">Lengkapi Profil</span>
                    </div>
                </div>
            </div>

            <!-- Success Message -->
            @if(session('success'))
                <div class="mb-6 bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-lg">
                    <div class="flex">
                        <svg class="h-5 w-5 text-green-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                        </svg>
                        <span class="ml-2">{{ session('success') }}</span>
                    </div>
                </div>
            @endif

            <!-- Info Box -->
            <div class="bg-blue-50 border border-blue-200 rounded-lg p-6 mb-6">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-6 w-6 text-blue-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                        </svg>
                    </div>
                    <div class="ml-3">
                        <h3 class="text-sm font-medium text-blue-800">Langkah selanjutnya:</h3>
                        <div class="mt-2 text-sm text-blue-700">
                            <ol class="list-decimal list-inside space-y-1">
                                <li>Buka email Anda (cek juga folder spam)</li>
                                <li>Klik link verifikasi di email</li>
                                <li>Anda akan diarahkan untuk melengkapi profil</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Resend Email Form -->
            <div class="text-center">
                <p class="text-sm text-gray-600 mb-4">
                    Tidak menerima email?
                </p>
                <form method="POST" action="{{ route('verification.send') }}">
                    @csrf
                    <button type="submit"
                        class="inline-flex items-center px-4 py-2 border border-indigo-600 rounded-lg text-sm font-medium text-indigo-600 bg-white hover:bg-indigo-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors duration-200">
                        <svg class="mr-2 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                        </svg>
                        Kirim Ulang Email Verifikasi
                    </button>
                </form>
            </div>

            <!-- Divider -->
            <div class="my-8 border-t border-gray-200"></div>

            <!-- Data Summary -->
            <div class="bg-gray-50 rounded-lg p-4">
                <h4 class="text-sm font-medium text-gray-700 mb-3">Data yang sudah tersimpan:</h4>
                <dl class="space-y-2 text-sm">
                    <div class="flex justify-between">
                        <dt class="text-gray-500">Nama:</dt>
                        <dd class="text-gray-900 font-medium">{{ auth()->user()->name }}</dd>
                    </div>
                    <div class="flex justify-between">
                        <dt class="text-gray-500">Email:</dt>
                        <dd class="text-gray-900 font-medium">{{ auth()->user()->email }}</dd>
                    </div>
                    <div class="flex justify-between">
                        <dt class="text-gray-500">No. HP:</dt>
                        <dd class="text-gray-900 font-medium">{{ auth()->user()->phone }}</dd>
                    </div>
                    <div class="flex justify-between">
                        <dt class="text-gray-500">Nama Toko:</dt>
                        <dd class="text-gray-900 font-medium">{{ auth()->user()->shop_name }}</dd>
                    </div>
                </dl>
            </div>

            <!-- Logout Link -->
            <div class="mt-6 text-center">
                <form method="POST" action="{{ route('logout') }}" class="inline">
                    @csrf
                    <button type="submit" class="text-sm text-gray-500 hover:text-gray-700 underline">
                        Logout dan gunakan akun lain
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
