<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReactivationController extends Controller
{
    /**
     * Show the reactivation request page.
     */
    public function show()
    {
        $user = Auth::user();
        
        // Only show to deactivated sellers
        if (!$user->isSeller() || !$user->isApproved() || $user->isActive()) {
            return redirect()->route('seller.dashboard');
        }
        
        return view('seller.reactivation-request', [
            'user' => $user,
            'hasRequestedReactivation' => $user->hasRequestedReactivation(),
        ]);
    }

    /**
     * Submit a reactivation request.
     */
    public function store(Request $request)
    {
        $user = Auth::user();
        
        // Only allow deactivated sellers to request
        if (!$user->isSeller() || !$user->isApproved() || $user->isActive()) {
            return redirect()->route('seller.dashboard');
        }
        
        // Check if already requested
        if ($user->hasRequestedReactivation()) {
            return back()->with('info', 'Permohonan aktivasi ulang Anda sudah diajukan dan sedang dalam proses review.');
        }
        
        // Update reactivation request timestamp
        $user->update([
            'reactivation_requested_at' => now(),
        ]);
        
        return back()->with('success', 'Permohonan aktivasi ulang berhasil diajukan. Admin akan meninjau permintaan Anda.');
    }
}
