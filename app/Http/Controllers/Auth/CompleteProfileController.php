<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\SellerVerification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class CompleteProfileController extends Controller
{
    /**
     * Show the complete profile form (Step 2)
     */
    public function show()
    {
        $user = auth()->user();

        // If profile already completed, redirect to appropriate page
        if ($user->hasCompletedProfile()) {
            if ($user->isApproved()) {
                return redirect()->route('seller.dashboard');
            }
            return redirect()->route('seller.pending');
        }

        // Get existing seller data if any
        $seller = $user->seller;

        return view('auth.complete-profile', compact('user', 'seller'));
    }

    /**
     * Handle the complete profile submission
     */
    public function store(Request $request)
    {
        $user = auth()->user();

        // Validate input
        $validated = $request->validate(
            [
                // KTP
                "ktp_number" => [
                    "required",
                    "string",
                    "size:16",
                    "unique:seller,pic_ktp_number," . ($user->seller?->id ?? 'NULL'),
                ],

                // Alamat
                "province" => ["required", "string", "max:255"],
                "kota_kabupaten" => ["required", "string", "max:255"],
                "kecamatan" => ["required", "string", "max:255"],
                "kelurahan" => ["required", "string", "max:255"],
                "rt" => ["required", "string", "max:5"],
                "rw" => ["required", "string", "max:5"],
                "street_address" => ["required", "string", "max:500"],

                // Deskripsi Toko (optional)
                "shop_description" => ["nullable", "string", "max:1000"],

                // File Upload
                "photo" => [
                    "required",
                    "image",
                    "mimes:jpeg,jpg,png",
                    "max:2048",
                ],
                "ktp_file" => [
                    "required",
                    "file",
                    "mimes:jpeg,jpg,png,pdf",
                    "max:5120",
                ],
            ],
            [
                "ktp_number.required" => "Nomor KTP wajib diisi",
                "ktp_number.size" => "Nomor KTP harus 16 digit",
                "ktp_number.unique" => "Nomor KTP sudah terdaftar",
                "province.required" => "Provinsi wajib dipilih",
                "kota_kabupaten.required" => "Kota/Kabupaten wajib dipilih",
                "kecamatan.required" => "Kecamatan wajib dipilih",
                "kelurahan.required" => "Kelurahan/Desa wajib dipilih",
                "rt.required" => "RT wajib diisi",
                "rw.required" => "RW wajib diisi",
                "street_address.required" => "Alamat jalan wajib diisi",
                "photo.required" => "Foto diri wajib diupload",
                "photo.image" => "File foto harus berupa gambar",
                "photo.mimes" => "Format foto harus JPG, JPEG, atau PNG",
                "photo.max" => "Ukuran foto maksimal 2MB",
                "ktp_file.required" => "File KTP wajib diupload",
                "ktp_file.mimes" => "Format file KTP harus JPG, JPEG, PNG, atau PDF",
                "ktp_file.max" => "Ukuran file KTP maksimal 5MB",
            ]
        );

        DB::beginTransaction();

        try {
            // Handle file uploads
            $photoPath = null;
            $ktpFilePath = null;

            if ($request->hasFile("photo")) {
                $photoPath = $request
                    ->file("photo")
                    ->store("seller/photos", "public");
            }

            if ($request->hasFile("ktp_file")) {
                $ktpFilePath = $request
                    ->file("ktp_file")
                    ->store("seller/ktp_files", "public");
            }

            // Create or update seller verification record
            SellerVerification::updateOrCreate(
                ["user_id" => $user->id],
                [
                    "shop_name" => $user->shop_name,
                    "shop_description" => $request->shop_description,
                    "pic_name" => $user->name,
                    "pic_phone" => $user->phone,
                    "pic_email" => $user->email,
                    "pic_ktp_number" => $request->ktp_number,
                    "province" => $request->province,
                    "kota_kabupaten" => $request->kota_kabupaten,
                    "kecamatan" => $request->kecamatan,
                    "kelurahan" => $request->kelurahan,
                    "rt" => $request->rt,
                    "rw" => $request->rw,
                    "street_address" => $request->street_address,
                    "pic_photo_path" => $photoPath,
                    "ktp_file_path" => $ktpFilePath,
                    "status" => "pending",
                ]
            );

            // Mark profile as completed
            $user->update(['profile_completed' => true]);

            DB::commit();

            return redirect()
                ->route('seller.pending')
                ->with('success', 'Profil berhasil dilengkapi! Silakan tunggu persetujuan admin.');

        } catch (\Exception $e) {
            DB::rollBack();

            // Delete uploaded files if transaction fails
            if ($photoPath && Storage::disk("public")->exists($photoPath)) {
                Storage::disk("public")->delete($photoPath);
            }
            if ($ktpFilePath && Storage::disk("public")->exists($ktpFilePath)) {
                Storage::disk("public")->delete($ktpFilePath);
            }

            return redirect()
                ->back()
                ->withInput()
                ->withErrors([
                    "error" => "Terjadi kesalahan. Silakan coba lagi.",
                ]);
        }
    }
}
