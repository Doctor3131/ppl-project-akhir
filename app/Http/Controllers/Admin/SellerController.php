<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class SellerController extends Controller
{
    /**
     * Display a listing of sellers
     */
    public function index(Request $request)
    {
        $query = User::where("role", "seller")->with("seller");

        // Filter by approval status
        if ($request->has("status") && $request->status != "") {
            $query->where("status", $request->status);
        }

        // Filter by active/inactive status
        if ($request->has("is_active") && $request->is_active != "") {
            $query->where("is_active", $request->is_active === "1");
        }

        $sellers = $query->latest()->paginate(10);

        return view("admin.sellers.index", compact("sellers"));
    }

    /**
     * Display seller details
     */
    public function show($id)
    {
        $seller = User::where("role", "seller")
            ->with("seller")
            ->findOrFail($id);

        return view("admin.sellers.show", compact("seller"));
    }

    /**
     * Approve seller registration
     */
    public function approve($id)
    {
        $seller = User::where("role", "seller")->findOrFail($id);

        $seller->update([
            "status" => "approved",
        ]);

        // Update seller verification status if exists
        if ($seller->seller) {
            $seller->seller->update([
                "status" => "approved",
                "verified_at" => now(),
            ]);
        }

        return redirect()
            ->route("admin.sellers.index")
            ->with("success", "Seller approved successfully!");
    }

    /**
     * Reject seller registration
     */
    public function reject($id)
    {
        $seller = User::where("role", "seller")->findOrFail($id);

        $seller->update([
            "status" => "rejected",
        ]);

        // Update seller verification status if exists
        if ($seller->seller) {
            $seller->seller->update([
                "status" => "rejected",
            ]);
        }

        return redirect()
            ->route("admin.sellers.index")
            ->with("success", "Seller rejected!");
    }

    /**
     * Deactivate an approved seller
     */
    public function deactivate(Request $request, $id)
    {
        $seller = User::where("role", "seller")
            ->where("status", "approved")
            ->findOrFail($id);

        $seller->update([
            "is_active" => false,
            "deactivated_at" => now(),
            "deactivation_reason" => $request->input("reason", "Dinonaktifkan oleh Admin"),
            "reactivation_requested_at" => null, // Reset any previous request
        ]);

        return redirect()
            ->back()
            ->with("success", "Seller berhasil dinonaktifkan.");
    }

    /**
     * Activate/reactivate a deactivated seller
     */
    public function activate($id)
    {
        $seller = User::where("role", "seller")
            ->where("status", "approved")
            ->findOrFail($id);

        $seller->update([
            "is_active" => true,
            "deactivated_at" => null,
            "deactivation_reason" => null,
            "reactivation_requested_at" => null,
        ]);

        return redirect()
            ->back()
            ->with("success", "Seller berhasil diaktifkan kembali.");
    }

    /**
     * Show list of pending reactivation requests
     */
    public function pendingReactivations()
    {
        $requests = User::where("role", "seller")
            ->where("status", "approved")
            ->where("is_active", false)
            ->whereNotNull("reactivation_requested_at")
            ->with("seller")
            ->orderBy("reactivation_requested_at", "asc")
            ->paginate(10);

        return view("admin.sellers.reactivation-requests", compact("requests"));
    }

    /**
     * Approve a reactivation request
     */
    public function approveReactivation($id)
    {
        $seller = User::where("role", "seller")
            ->where("status", "approved")
            ->where("is_active", false)
            ->whereNotNull("reactivation_requested_at")
            ->findOrFail($id);

        $seller->update([
            "is_active" => true,
            "deactivated_at" => null,
            "deactivation_reason" => null,
            "reactivation_requested_at" => null,
        ]);

        return redirect()
            ->back()
            ->with("success", "Permohonan aktivasi ulang disetujui. Seller sudah aktif kembali.");
    }

    /**
     * Reject a reactivation request
     */
    public function rejectReactivation($id)
    {
        $seller = User::where("role", "seller")
            ->where("status", "approved")
            ->where("is_active", false)
            ->whereNotNull("reactivation_requested_at")
            ->findOrFail($id);

        $seller->update([
            "reactivation_requested_at" => null, // Clear the request but keep deactivated
        ]);

        return redirect()
            ->back()
            ->with("success", "Permohonan aktivasi ulang ditolak.");
    }
}
