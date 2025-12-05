<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\Events\Registered;

class RegisterController extends Controller
{
    /**
     * Show the registration form (Step 1)
     */
    public function showRegistrationForm()
    {
        return view("auth.register");
    }

    /**
     * Handle registration request (Step 1: Basic Info)
     * Creates user with basic info and sends email verification
     */
    public function register(Request $request)
    {
        // Validate input with custom error messages
        $validated = $request->validate(
            [
                "name" => ["required", "string", "max:255"],
                "email" => [
                    "required",
                    "string",
                    "email",
                    "max:255",
                    "unique:users",
                ],
                "phone" => [
                    "required",
                    "string",
                    "max:20",
                    "regex:/^(08|62)[0-9]{8,13}$/",
                ],
                "password" => ["required", "string", "min:8", "confirmed"],
                "shop_name" => ["required", "string", "max:255"],
            ],
            [
                // Custom error messages
                "name.required" => "Nama lengkap wajib diisi",
                "email.required" => "Email wajib diisi",
                "email.email" => "Format email tidak valid",
                "email.unique" => "Email sudah terdaftar",
                "phone.required" => "Nomor HP wajib diisi",
                "phone.regex" => "Format nomor HP tidak valid (contoh: 08123456789)",
                "password.required" => "Password wajib diisi",
                "password.min" => "Password minimal 8 karakter",
                "password.confirmed" => "Konfirmasi password tidak sesuai",
                "shop_name.required" => "Nama toko wajib diisi",
            ],
        );

        // Create user with basic info
        $user = User::create([
            "name" => $request->name,
            "email" => $request->email,
            "phone" => $request->phone,
            "shop_name" => $request->shop_name,
            "password" => Hash::make($request->password),
            "role" => "seller",
            "status" => "pending",
            "profile_completed" => false,
        ]);

        // Fire registered event (sends verification email)
        event(new Registered($user));

        // Login the user
        Auth::login($user);

        return redirect()
            ->route("verification.notice")
            ->with(
                "success",
                "Registrasi berhasil! Silakan cek email Anda untuk verifikasi.",
            );
    }
}
