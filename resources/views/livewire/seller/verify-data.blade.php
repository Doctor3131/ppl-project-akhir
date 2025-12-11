<?php

use App\Models\SellerVerification;
use Livewire\Attributes\Validate;
use Livewire\Volt\Component;
use Livewire\WithFileUploads;

new class extends Component {
    use WithFileUploads;

    #[Validate('required|string|min:16|max:16')]
    public string $ktp_number = '';

    #[Validate('required|image|max:2048')]
    public $face_photo;

    #[Validate('required|image|max:2048')]
    public $ktp_photo;

    #[Validate('required|string|min:10')]
    public string $address = '';

    public function submit(): void
    {
        $this->validate();

        // Check if user already has pending or approved verification
        $existingVerification = auth()->user()->sellerVerification;

        if ($existingVerification && $existingVerification->isPending()) {
            session()->flash('error', 'Anda sudah memiliki verifikasi yang sedang diproses.');
            return;
        }

        if ($existingVerification && $existingVerification->isApproved()) {
            session()->flash('error', 'Akun Anda sudah terverifikasi sebagai penjual.');
            return;
        }

        // Store photos
        $facePhotoPath = $this->face_photo->store('seller-verifications/faces', 'public');
        $ktpPhotoPath = $this->ktp_photo->store('seller-verifications/ktp', 'public');

        // Create verification request
        SellerVerification::create([
            'user_id' => auth()->id(),
            'ktp_number' => $this->ktp_number,
            'face_photo_path' => $facePhotoPath,
            'ktp_photo_path' => $ktpPhotoPath,
            'address' => $this->address,
            'status' => 'pending',
        ]);

        session()->flash('success', 'Data verifikasi berhasil dikirim. Mohon tunggu proses verifikasi.');

        $this->redirect(route('dashboard'), navigate: true);
    }
}; ?>

<x-layouts.auth>
    <div class="flex flex-col gap-6">
        <!-- Logo -->
        <div class="flex flex-col items-center gap-4 mb-2">
            <div class="flex items-center gap-3">
                <x-app-logo-icon class="size-10 fill-current text-black dark:text-white" />
                <flux:heading size="2xl" class="font-bold tracking-tight">
                    CHROMARKET
                </flux:heading>
            </div>
        </div>

        <!-- Card Container -->
        <div class="rounded-2xl border border-zinc-200 dark:border-zinc-700 bg-white dark:bg-zinc-900 shadow-lg p-8">
            <div class="space-y-6">
                <!-- Header -->
                <div class="text-center space-y-2">
                    <flux:heading size="xl" class="font-bold">
                        VERIFIKASI DATA PENJUAL
                    </flux:heading>
                    <flux:subheading class="text-zinc-500">
                        Data Penjual
                    </flux:subheading>
                </div>

                <!-- Messages -->
                @if (session('success'))
                    <flux:callout variant="success" icon="check-circle">
                        {{ session('success') }}
                    </flux:callout>
                @endif

                @if (session('error'))
                    <flux:callout variant="danger" icon="x-circle">
                        {{ session('error') }}
                    </flux:callout>
                @endif

                <!-- Form -->
                <form wire:submit="submit" class="space-y-5">
                    <!-- KTP Number -->
                    <flux:input
                        wire:model="ktp_number"
                        label="No. KTP"
                        placeholder="No. KTP"
                        type="text"
                        inputmode="numeric"
                        maxlength="16"
                        required
                    />

                    <!-- Face Photo Upload -->
                    <div class="space-y-2">
                        <flux:label>Upload Foto Wajah</flux:label>
                        <div class="relative">
                            <input
                                type="file"
                                wire:model="face_photo"
                                accept="image/*"
                                class="hidden"
                                id="face_photo"
                            />
                            <label
                                for="face_photo"
                                class="flex items-center justify-between w-full px-4 py-3 border border-zinc-300 dark:border-zinc-600 rounded-lg cursor-pointer hover:bg-zinc-50 dark:hover:bg-zinc-800 transition-colors"
                            >
                                <span class="text-zinc-500 dark:text-zinc-400">
                                    @if ($face_photo)
                                        {{ $face_photo->getClientOriginalName() }}
                                    @else
                                        Upload Foto Wajah
                                    @endif
                                </span>
                                <div class="flex items-center justify-center w-8 h-8 bg-sky-500 rounded-full">
                                    <flux:icon.plus class="size-5 text-white" variant="micro" />
                                </div>
                            </label>
                        </div>
                        @error('face_photo')
                            <flux:error>{{ $message }}</flux:error>
                        @enderror

                        @if ($face_photo)
                            <div class="mt-2">
                                <img src="{{ $face_photo->temporaryUrl() }}" class="w-32 h-32 object-cover rounded-lg" />
                            </div>
                        @endif
                    </div>

                    <!-- KTP Photo Upload -->
                    <div class="space-y-2">
                        <flux:label>Upload Foto KTP</flux:label>
                        <div class="relative">
                            <input
                                type="file"
                                wire:model="ktp_photo"
                                accept="image/*"
                                class="hidden"
                                id="ktp_photo"
                            />
                            <label
                                for="ktp_photo"
                                class="flex items-center justify-between w-full px-4 py-3 border border-zinc-300 dark:border-zinc-600 rounded-lg cursor-pointer hover:bg-zinc-50 dark:hover:bg-zinc-800 transition-colors"
                            >
                                <span class="text-zinc-500 dark:text-zinc-400">
                                    @if ($ktp_photo)
                                        {{ $ktp_photo->getClientOriginalName() }}
                                    @else
                                        Upload Foto KTP
                                    @endif
                                </span>
                                <div class="flex items-center justify-center w-8 h-8 bg-sky-500 rounded-full">
                                    <flux:icon.plus class="size-5 text-white" variant="micro" />
                                </div>
                            </label>
                        </div>
                        @error('ktp_photo')
                            <flux:error>{{ $message }}</flux:error>
                        @enderror

                        @if ($ktp_photo)
                            <div class="mt-2">
                                <img src="{{ $ktp_photo->temporaryUrl() }}" class="w-full max-w-md object-cover rounded-lg" />
                            </div>
                        @endif
                    </div>

                    <!-- Address -->
                    <flux:textarea
                        wire:model="address"
                        label="Alamat (nama jalan)"
                        placeholder="Alamat (nama jalan)"
                        rows="3"
                        required
                    />

                    <!-- Submit Button -->
                    <div class="pt-2">
                        <flux:button
                            type="submit"
                            variant="primary"
                            class="w-full bg-green-600 hover:bg-green-700 text-white font-semibold py-3 rounded-full"
                            wire:loading.attr="disabled"
                        >
                            <span wire:loading.remove>SUBMIT</span>
                            <span wire:loading>
                                <flux:icon.loading class="size-5" />
                                Mengunggah...
                            </span>
                        </flux:button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Back to Home -->
        <div class="text-center">
            <flux:link :href="route('dashboard')" wire:navigate class="text-sm text-zinc-600 dark:text-zinc-400">
                ← Kembali ke Dashboard
            </flux:link>
        </div>
    </div>
</x-layouts.auth>
