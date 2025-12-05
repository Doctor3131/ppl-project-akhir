<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureProfileIsComplete
{
    /**
     * Handle an incoming request.
     * Ensures that the authenticated user has completed their profile.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        $user = auth()->user();

        // Check if email is verified first
        if (!$user->hasVerifiedEmail()) {
            return redirect()->route('verification.notice');
        }

        // Check if profile is completed
        if (!$user->hasCompletedProfile()) {
            return redirect()->route('complete-profile.show')
                ->with('info', 'Silakan lengkapi profil Anda terlebih dahulu.');
        }

        return $next($request);
    }
}
