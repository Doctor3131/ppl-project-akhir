<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\SellerVerification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class RegisterController extends Controller
{
    /**
     * Show the registration form
     */
    public function showRegistrationForm()
    {
        return view("auth.register");
    }

    /**
     * Handle registration request
     */
    public function register(Request $request)
    {
        // Validate input with custom error messages
        $validated = $request->validate(
            [
                // Data Akun
                "name" => ["required", "string", "max:255"],
                "email" => [
                    "required",
                    "string",
                    "email",
                    "max:255",
                    "unique:users",
                ],
                "password" => ["required", "string", "min:8", "confirmed"],

                // Data Toko
                "shop_name" => ["required", "string", "max:255"],
                "shop_description" => ["nullable", "string", "max:1000"],

                // Data PIC (Person In Charge)
                "pic_name" => ["required", "string", "max:255"],
                "pic_phone" => ["required", "string", "max:20"],
                "pic_email" => ["required", "string", "email", "max:255"],
                "pic_ktp_number" => [
                    "required",
                    "string",
                    "size:16",
                    "unique:seller,pic_ktp_number",
                ],

                // Alamat
                "street_address" => ["required", "string", "max:500"],
                "rt" => ["required", "string", "max:5"],
                "rw" => ["required", "string", "max:5"],
                "kelurahan" => ["required", "string", "max:255"],
                "kota_kabupaten" => ["required", "string", "max:255"],
                "province" => ["required", "string", "max:255"],

                // File Upload
                "pic_photo" => [
                    "required",
                    "image",
                    "mimes:jpeg,jpg,png",
                    "max:2048",
                ], // Max 2MB
                "ktp_file" => [
                    "required",
                    "file",
                    "mimes:jpeg,jpg,png,pdf",
                    "max:5120",
                ], // Max 5MB
            ],
            [
                // Custom error messages
                "name.required" => "Nama lengkap wajib diisi",
                "email.required" => "Email wajib diisi",
                "email.email" => "Format email tidak valid",
                "email.unique" => "Email sudah terdaftar",
                "password.required" => "Password wajib diisi",
                "password.min" => "Password minimal 8 karakter",
                "password.confirmed" => "Konfirmasi password tidak sesuai",
                "shop_name.required" => "Nama toko wajib diisi",
                "pic_name.required" => "Nama PIC wajib diisi",
                "pic_phone.required" => "No HP PIC wajib diisi",
                "pic_email.required" => "Email PIC wajib diisi",
                "pic_email.email" => "Format email PIC tidak valid",
                "pic_ktp_number.required" => "Nomor KTP wajib diisi",
                "pic_ktp_number.size" => "Nomor KTP harus 16 digit",
                "pic_ktp_number.unique" => "Nomor KTP sudah terdaftar",
                "street_address.required" => "Alamat jalan wajib diisi",
                "rt.required" => "RT wajib diisi",
                "rw.required" => "RW wajib diisi",
                "kelurahan.required" => "Kelurahan/Desa wajib diisi",
                "kota_kabupaten.required" => "Kota/Kabupaten wajib diisi",
                "province.required" => "Provinsi wajib diisi",
                "pic_photo.required" => "Foto PIC wajib diupload",
                "pic_photo.image" => "File foto PIC harus berupa gambar",
                "pic_photo.mimes" =>
                    "Format foto PIC harus JPG, JPEG, atau PNG",
                "pic_photo.max" => "Ukuran foto PIC maksimal 2MB",
                "ktp_file.required" => "File KTP wajib diupload",
                "ktp_file.mimes" =>
                    "Format file KTP harus JPG, JPEG, PNG, atau PDF",
                "ktp_file.max" => "Ukuran file KTP maksimal 5MB",
            ],
        );

        DB::beginTransaction();

        try {
            // Create user
            $user = User::create([
                "name" => $request->name,
                "email" => $request->email,
                "password" => Hash::make($request->password),
                "role" => "seller",
                "status" => "pending",
            ]);

            // Handle file uploads
            $picPhotoPath = null;
            $ktpFilePath = null;

            if ($request->hasFile("pic_photo")) {
                $picPhotoPath = $request
                    ->file("pic_photo")
                    ->store("seller/pic_photos", "public");
            }

            if ($request->hasFile("ktp_file")) {
                $ktpFilePath = $request
                    ->file("ktp_file")
                    ->store("seller/ktp_files", "public");
            }

            // Create seller verification record
            SellerVerification::create([
                "user_id" => $user->id,
                "shop_name" => $request->shop_name,
                "shop_description" => $request->shop_description,
                "pic_name" => $request->pic_name,
                "pic_phone" => $request->pic_phone,
                "pic_email" => $request->pic_email,
                "pic_ktp_number" => $request->pic_ktp_number,
                "street_address" => $request->street_address,
                "rt" => $request->rt,
                "rw" => $request->rw,
                "kelurahan" => $request->kelurahan,
                "kota_kabupaten" => $request->kota_kabupaten,
                "province" => $request->province,
                "pic_photo_path" => $picPhotoPath,
                "ktp_file_path" => $ktpFilePath,
                "status" => "pending",
            ]);

            DB::commit();

            return redirect()
                ->route("login")
                ->with(
                    "success",
                    "Registrasi berhasil! Silakan tunggu persetujuan admin untuk dapat login.",
                );
        } catch (\Exception $e) {
            DB::rollBack();

            // Delete uploaded files if transaction fails
            if (
                isset($picPhotoPath) &&
                Storage::disk("public")->exists($picPhotoPath)
            ) {
                Storage::disk("public")->delete($picPhotoPath);
            }
            if (
                isset($ktpFilePath) &&
                Storage::disk("public")->exists($ktpFilePath)
            ) {
                Storage::disk("public")->delete($ktpFilePath);
            }

            return redirect()
                ->back()
                ->withInput()
                ->withErrors([
                    "error" =>
                        "Terjadi kesalahan saat registrasi. Silakan coba lagi.",
                ]);
        }
    }
}
