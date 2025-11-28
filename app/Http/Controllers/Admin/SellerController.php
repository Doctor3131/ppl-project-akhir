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

        // Filter by status
        if ($request->has("status") && $request->status != "") {
            $query->where("status", $request->status);
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
}
