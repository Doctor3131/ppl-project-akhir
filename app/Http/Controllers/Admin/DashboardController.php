<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Product;
use App\Models\Category;
use App\Models\SellerVerification;
use App\Models\ProductRating;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    /**
     * Display admin dashboard with graphical data
     * SRS-MartPlace-07: Dashboard dalam bentuk grafis untuk platform
     */
    public function index()
    {
        // Basic statistics
        $pendingSellers = User::where("role", "seller")
            ->where("status", "pending")
            ->count();

        $approvedSellers = User::where("role", "seller")
            ->where("status", "approved")
            ->count();

        $totalProducts = Product::count();
        $totalCategories = Category::count();

        // SRS-07: Sebaran jumlah produk berdasarkan kategori
        $productsByCategory = Product::select(
            "categories.name as category_name",
            DB::raw("count(products.id) as total"),
        )
            ->join("categories", "products.category_id", "=", "categories.id")
            ->whereHas("user", function ($q) {
                $q->where("status", "approved")->where("role", "seller");
            })
            ->groupBy("categories.id", "categories.name")
            ->orderBy("total", "desc")
            ->get();

        // SRS-07: Sebaran jumlah toko berdasarkan lokasi propinsi
        $sellersByProvince = SellerVerification::select(
            "province",
            DB::raw("count(*) as total"),
        )
            ->where("status", "approved")
            ->groupBy("province")
            ->orderBy("total", "desc")
            ->get();

        // SRS-07: Jumlah user penjual aktif dan tidak aktif
        $sellerStatusData = [
            "active" => User::where("role", "seller")
                ->where("status", "approved")
                ->count(),
            "pending" => User::where("role", "seller")
                ->where("status", "pending")
                ->count(),
            "rejected" => User::where("role", "seller")
                ->where("status", "rejected")
                ->count(),
        ];

        // SRS-07: Jumlah pengunjung yang memberikan komentar dan rating
        $ratingsData = [
            "total_ratings" => ProductRating::count(),
            "unique_visitors" => ProductRating::distinct(
                "visitor_email",
            )->count("visitor_email"),
            "with_comment" => ProductRating::whereNotNull("comment")
                ->where("comment", "!=", "")
                ->count(),
            "without_comment" => ProductRating::whereNull("comment")
                ->orWhere("comment", "=", "")
                ->count(),
        ];

        // Rating distribution (1-5 stars)
        $ratingDistribution = [];
        for ($i = 1; $i <= 5; $i++) {
            $ratingDistribution[$i] = ProductRating::where(
                "rating",
                $i,
            )->count();
        }

        // Recent activities
        $recentRatings = ProductRating::with("product")
            ->latest()
            ->take(5)
            ->get();

        $recentProducts = Product::with(["user", "category"])
            ->whereHas("user", function ($q) {
                $q->where("status", "approved")->where("role", "seller");
            })
            ->latest()
            ->take(5)
            ->get();

        // Top rated products
        $topRatedProducts = Product::with([
            "user.seller",
            "category",
            "ratings",
        ])
            ->whereHas("user", function ($q) {
                $q->where("status", "approved")->where("role", "seller");
            })
            ->whereHas("ratings")
            ->get()
            ->map(function ($product) {
                $product->average_rating = $product->averageRating();
                $product->rating_count = $product->ratingCount();
                return $product;
            })
            ->sortByDesc("average_rating")
            ->take(5)
            ->values();

        // Monthly trends (last 6 months)
        $monthlyData = [];
        for ($i = 5; $i >= 0; $i--) {
            $month = now()->subMonths($i);
            $monthlyData[] = [
                "month" => $month->format("M Y"),
                "products" => Product::whereYear("created_at", $month->year)
                    ->whereMonth("created_at", $month->month)
                    ->count(),
                "ratings" => ProductRating::whereYear(
                    "created_at",
                    $month->year,
                )
                    ->whereMonth("created_at", $month->month)
                    ->count(),
                "sellers" => User::where("role", "seller")
                    ->where("status", "approved")
                    ->whereYear("created_at", $month->year)
                    ->whereMonth("created_at", $month->month)
                    ->count(),
            ];
        }

        return view(
            "admin.dashboard",
            compact(
                "pendingSellers",
                "approvedSellers",
                "totalProducts",
                "totalCategories",
                "productsByCategory",
                "sellersByProvince",
                "sellerStatusData",
                "ratingsData",
                "ratingDistribution",
                "recentRatings",
                "recentProducts",
                "topRatedProducts",
                "monthlyData",
            ),
        );
    }
}
