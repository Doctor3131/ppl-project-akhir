<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckSellerActive
{
    /**
     * Handle an incoming request.
     * Redirect inactive sellers to reactivation request page.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();
        
        // Only check for sellers
        if ($user && $user->isSeller() && $user->isApproved()) {
            // If seller is deactivated, redirect to reactivation page
            if ($user->isDeactivated()) {
                // Allow access to reactivation routes
                if ($request->routeIs('seller.reactivation.*') || $request->routeIs('logout')) {
                    return $next($request);
                }
                
                return redirect()->route('seller.reactivation.show')
                    ->with('warning', 'Akun Anda telah dinonaktifkan. Silakan ajukan permohonan aktivasi ulang.');
            }
        }
        
        return $next($request);
    }
}
