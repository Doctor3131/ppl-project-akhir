<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Display seller dashboard
     */
    public function index()
    {
        $seller = Auth::user();
        $products = $seller
            ->products()
            ->with("category")
            ->latest()
            ->paginate(10);

        return view("seller.dashboard", compact("products"));
    }
}
