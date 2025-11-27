<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Display admin dashboard
     */
    public function index()
    {
        $pendingSellers = User::where("role", "seller")
            ->where("status", "pending")
            ->count();

        $approvedSellers = User::where("role", "seller")
            ->where("status", "approved")
            ->count();

        $totalProducts = Product::count();
        $totalCategories = Category::count();

        return view(
            "admin.dashboard",
            compact(
                "pendingSellers",
                "approvedSellers",
                "totalProducts",
                "totalCategories",
            ),
        );
    }
}
