<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductRating;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    /**
     * Display seller dashboard with graphical data
     * SRS-MartPlace-08: Dashboard dalam bentuk grafis untuk penjual
     */
    public function index()
    {
        $seller = Auth::user();

        // Basic statistics
        $totalProducts = $seller->products()->count();
        $totalStock = $seller->products()->sum("stock");
        $lowStockCount = $seller->products()->where("stock", "<", 2)->count();
        $totalRatings = ProductRating::whereHas("product", function ($q) use (
            $seller,
        ) {
            $q->where("user_id", $seller->id);
        })->count();

        // SRS-08: Sebaran jumlah stok setiap produk yang dimiliki penjual
        $stockByProduct = $seller
            ->products()
            ->select("id", "name", "stock", "price")
            ->with("category")
            ->orderBy("stock", "desc")
            ->get()
            ->map(function ($product) {
                return [
                    "id" => $product->id,
                    "name" => $product->name,
                    "stock" => $product->stock,
                    "price" => $product->price,
                    "category" => $product->category->name ?? "N/A",
                ];
            });

        // SRS-08: Sebaran nilai rating per produk
        $ratingByProduct = $seller
            ->products()
            ->with(["category", "ratings"])
            ->get()
            ->map(function ($product) {
                return [
                    "id" => $product->id,
                    "name" => $product->name,
                    "average_rating" => $product->averageRating(),
                    "rating_count" => $product->ratingCount(),
                    "category" => $product->category->name ?? "N/A",
                ];
            })
            ->sortByDesc("average_rating")
            ->values();

        // SRS-08: Sebaran pemberi rating berdasarkan lokasi propinsi
        $ratingsByProvince = ProductRating::select(
            DB::raw(
                'COALESCE(SUBSTRING_INDEX(visitor_email, "@", -1), "Unknown") as domain',
            ),
            DB::raw("count(*) as total"),
        )
            ->whereHas("product", function ($q) use ($seller) {
                $q->where("user_id", $seller->id);
            })
            ->groupBy("domain")
            ->orderBy("total", "desc")
            ->take(10)
            ->get();

        // Get rating distribution for seller's products (1-5 stars)
        $ratingDistribution = [];
        for ($i = 1; $i <= 5; $i++) {
            $ratingDistribution[$i] = ProductRating::where("rating", $i)
                ->whereHas("product", function ($q) use ($seller) {
                    $q->where("user_id", $seller->id);
                })
                ->count();
        }

        // Stock distribution by category
        $stockByCategory = $seller
            ->products()
            ->select(
                "categories.name as category_name",
                DB::raw("sum(products.stock) as total_stock"),
            )
            ->join("categories", "products.category_id", "=", "categories.id")
            ->groupBy("categories.id", "categories.name")
            ->orderBy("total_stock", "desc")
            ->get();

        // Recent ratings on seller's products
        $recentRatings = ProductRating::with("product")
            ->whereHas("product", function ($q) use ($seller) {
                $q->where("user_id", $seller->id);
            })
            ->latest()
            ->take(5)
            ->get();

        // Products needing restock (low stock alert)
        $lowStockProducts = $seller
            ->products()
            ->with(["category", "ratings"])
            ->where("stock", "<", 2)
            ->orderBy("stock", "asc")
            ->get()
            ->map(function ($product) {
                $product->average_rating = $product->averageRating();
                $product->rating_count = $product->ratingCount();
                return $product;
            });

        // Monthly trends (last 6 months) for seller's products
        $monthlyData = [];
        for ($i = 5; $i >= 0; $i--) {
            $month = now()->subMonths($i);
            $monthlyData[] = [
                "month" => $month->format("M Y"),
                "products_added" => $seller
                    ->products()
                    ->whereYear("created_at", $month->year)
                    ->whereMonth("created_at", $month->month)
                    ->count(),
                "ratings_received" => ProductRating::whereHas(
                    "product",
                    function ($q) use ($seller) {
                        $q->where("user_id", $seller->id);
                    },
                )
                    ->whereYear("created_at", $month->year)
                    ->whereMonth("created_at", $month->month)
                    ->count(),
            ];
        }

        // Average rating by month
        $averageRatingByMonth = [];
        for ($i = 5; $i >= 0; $i--) {
            $month = now()->subMonths($i);
            $avgRating = ProductRating::whereHas("product", function ($q) use (
                $seller,
            ) {
                $q->where("user_id", $seller->id);
            })
                ->whereYear("created_at", $month->year)
                ->whereMonth("created_at", $month->month)
                ->avg("rating");

            $averageRatingByMonth[] = [
                "month" => $month->format("M Y"),
                "average_rating" => $avgRating ? round($avgRating, 1) : 0,
            ];
        }

        // Top rated products
        $topRatedProducts = $seller
            ->products()
            ->with(["category", "ratings"])
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

        // Products list with pagination
        $products = $seller
            ->products()
            ->with(["category", "ratings"])
            ->latest()
            ->paginate(10);

        return view(
            "seller.dashboard",
            compact(
                "products",
                "totalProducts",
                "totalStock",
                "lowStockCount",
                "totalRatings",
                "stockByProduct",
                "ratingByProduct",
                "ratingsByProvince",
                "ratingDistribution",
                "stockByCategory",
                "recentRatings",
                "lowStockProducts",
                "monthlyData",
                "averageRatingByMonth",
                "topRatedProducts",
            ),
        );
    }
}
