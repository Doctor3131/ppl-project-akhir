<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SellerMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!auth()->check()) {
            return redirect()->route("login");
        }

        if (!auth()->user()->isSeller()) {
            abort(403, "Unauthorized access");
        }

        if (!auth()->user()->isApproved()) {
            auth()->logout();
            return redirect()
                ->route("login")
                ->withErrors([
                    "email" =>
                        "Your account is pending approval. Please wait for admin approval.",
                ]);
        }

        return $next($request);
    }
}
