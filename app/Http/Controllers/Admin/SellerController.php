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
        $query = User::where("role", "seller");

        // Filter by status
        if ($request->has("status") && $request->status != "") {
            $query->where("status", $request->status);
        }

        $sellers = $query->latest()->paginate(10);

        return view("admin.sellers.index", compact("sellers"));
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

        return redirect()
            ->route("admin.sellers.index")
            ->with("success", "Seller rejected!");
    }
}
