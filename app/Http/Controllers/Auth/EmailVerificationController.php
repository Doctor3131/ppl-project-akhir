<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;

class EmailVerificationController extends Controller
{
    /**
     * Display the email verification notice.
     */
    public function notice(Request $request)
    {
        // If already verified, redirect to complete profile or dashboard
        if ($request->user()->hasVerifiedEmail()) {
            if (!$request->user()->hasCompletedProfile()) {
                return redirect()->route('complete-profile.show');
            }
            return redirect()->route('seller.dashboard');
        }

        return view('auth.verify-email');
    }

    /**
     * Handle the email verification.
     */
    public function verify(EmailVerificationRequest $request)
    {
        $request->fulfill();

        // After verification, redirect to complete profile
        return redirect()
            ->route('complete-profile.show')
            ->with('success', 'Email berhasil diverifikasi! Silakan lengkapi profil Anda.');
    }

    /**
     * Resend the email verification notification.
     */
    public function resend(Request $request)
    {
        if ($request->user()->hasVerifiedEmail()) {
            return redirect()->route('complete-profile.show');
        }

        $request->user()->sendEmailVerificationNotification();

        return back()->with('success', 'Link verifikasi telah dikirim ulang ke email Anda.');
    }
}
