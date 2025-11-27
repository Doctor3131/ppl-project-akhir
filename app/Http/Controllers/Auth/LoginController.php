<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /**
     * Show the login form
     */
    public function showLoginForm()
    {
        return view("auth.login");
    }

    /**
     * Handle login request
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            "email" => ["required", "email"],
            "password" => ["required"],
        ]);

        if (Auth::attempt($credentials, $request->filled("remember"))) {
            $request->session()->regenerate();

            $user = Auth::user();

            // Check if user is approved
            if (!$user->isApproved()) {
                Auth::logout();
                return back()->withErrors([
                    "email" =>
                        "Your account is pending approval. Please wait for admin approval.",
                ]);
            }

            // Redirect based on role
            if ($user->isAdmin()) {
                return redirect()->intended("/admin/dashboard");
            } else {
                return redirect()->intended("/seller/dashboard");
            }
        }

        return back()->withErrors([
            "email" => "The provided credentials do not match our records.",
        ]);
    }

    /**
     * Handle logout
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect("/");
    }
}
