@extends('layouts.app')

@section('title', 'Menunggu Persetujuan')

@section('content')
<div class="max-w-lg mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="bg-white rounded-lg shadow-lg overflow-hidden">
        <div class="px-8 py-10">
            <!-- Header with Icon -->
            <div class="text-center mb-8">
                <div class="mx-auto flex items-center justify-center h-20 w-20 rounded-full bg-yellow-100 mb-4">
                    <svg class="h-12 w-12 text-yellow-500 animate-pulse" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <h2 class="text-2xl font-bold text-gray-900">Pendaftaran Dalam Proses</h2>
                <p class="mt-2 text-gray-600">
                    Terima kasih telah mendaftar sebagai penjual di marketplace kami!
                </p>
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

            <!-- Status Card -->
            <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-6 mb-6">
                <div class="flex items-start">
                    <div class="flex-shrink-0">
                        <svg class="h-6 w-6 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                        </svg>
                    </div>
                    <div class="ml-3">
                        <h3 class="text-sm font-medium text-yellow-800">Status: Menunggu Verifikasi Admin</h3>
                        <div class="mt-2 text-sm text-yellow-700">
                            <p>Data Anda sedang diverifikasi oleh tim kami. Proses ini biasanya memakan waktu 1-2 hari kerja.</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Timeline Progress -->
            <div class="mb-8">
                <h4 class="text-sm font-medium text-gray-700 mb-4">Progress Pendaftaran:</h4>
                <div class="relative">
                    <div class="absolute left-4 top-0 h-full w-0.5 bg-gray-200"></div>
                    
                    <!-- Step 1: Completed -->
                    <div class="relative flex items-center mb-6">
                        <div class="flex items-center justify-center w-8 h-8 bg-green-500 text-white rounded-full z-10">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-900">Registrasi Data Dasar</p>
                            <p class="text-xs text-gray-500">Selesai</p>
                        </div>
                    </div>

                    <!-- Step 2: Completed -->
                    <div class="relative flex items-center mb-6">
                        <div class="flex items-center justify-center w-8 h-8 bg-green-500 text-white rounded-full z-10">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-900">Verifikasi Email</p>
                            <p class="text-xs text-gray-500">Selesai</p>
                        </div>
                    </div>

                    <!-- Step 3: Completed -->
                    <div class="relative flex items-center mb-6">
                        <div class="flex items-center justify-center w-8 h-8 bg-green-500 text-white rounded-full z-10">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-900">Lengkapi Profil & Upload KTP</p>
                            <p class="text-xs text-gray-500">Selesai</p>
                        </div>
                    </div>

                    <!-- Step 4: In Progress -->
                    <div class="relative flex items-center">
                        <div class="flex items-center justify-center w-8 h-8 bg-yellow-400 text-white rounded-full z-10 animate-pulse">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-yellow-600">Verifikasi Admin</p>
                            <p class="text-xs text-gray-500">Dalam proses (1-2 hari kerja)</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Info Box -->
            <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-6">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-blue-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                        </svg>
                    </div>
                    <div class="ml-3">
                        <h3 class="text-sm font-medium text-blue-800">Apa yang terjadi selanjutnya?</h3>
                        <div class="mt-2 text-sm text-blue-700">
                            <ul class="list-disc list-inside space-y-1">
                                <li>Admin akan memverifikasi data dan dokumen Anda</li>
                                <li>Anda akan menerima email notifikasi hasil verifikasi</li>
                                <li>Setelah disetujui, Anda dapat langsung mulai berjualan</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Contact Support -->
            <div class="text-center">
                <p class="text-sm text-gray-500 mb-2">
                    Ada pertanyaan tentang proses verifikasi?
                </p>
                <a href="mailto:support@marketplace.com" 
                    class="text-sm text-indigo-600 hover:text-indigo-500 font-medium">
                    Hubungi Customer Support
                </a>
            </div>

            <!-- Divider -->
            <div class="my-6 border-t border-gray-200"></div>

            <!-- Action Buttons -->
            <div class="flex flex-col space-y-3">
                <a href="{{ route('home') }}"
                    class="w-full flex justify-center py-3 px-4 border border-gray-300 rounded-lg shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors duration-200">
                    <svg class="mr-2 w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                    </svg>
                    Kembali ke Beranda
                </a>
                
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"
                        class="w-full flex justify-center py-3 px-4 border border-transparent rounded-lg text-sm font-medium text-gray-500 hover:text-gray-700 transition-colors duration-200">
                        Logout
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
