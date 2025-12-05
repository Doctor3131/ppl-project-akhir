<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\SellerVerification;
use Illuminate\Http\Request;

class CatalogController extends Controller
{
    /**
     * Display product catalog (public access, no auth required)
     */
    public function index(Request $request)
    {
        $query = Product::with(["user.seller", "category", "ratings"]);

        // Filter hanya dari seller yang sudah diapprove (check seller table status)
        $query->whereHas("user.seller", function ($q) {
            $q->where("status", "approved");
        });

        // Search by product name
        if ($request->filled("search")) {
            $query->where("name", "like", "%" . $request->search . "%");
        }

        // Filter by shop name
        if ($request->filled("shop_name")) {
            $query->whereHas("user.seller", function ($q) use ($request) {
                $q->where("shop_name", "like", "%" . $request->shop_name . "%");
            });
        }

        // Filter by category
        if ($request->filled("category_id")) {
            $query->where("category_id", $request->category_id);
        }

        // Filter by location (kota/kabupaten)
        if ($request->filled("kota_kabupaten")) {
            $query->whereHas("user.seller", function ($q) use ($request) {
                $q->where(
                    "kota_kabupaten",
                    "like",
                    "%" . $request->kota_kabupaten . "%",
                );
            });
        }

        // Filter by province
        if ($request->filled("province")) {
            $query->whereHas("user.seller", function ($q) use ($request) {
                $q->where("province", "like", "%" . $request->province . "%");
            });
        }

        // Sorting
        if ($request->filled("sort")) {
            switch ($request->sort) {
                case "price_asc":
                    $query->orderBy("price", "asc");
                    break;
                case "price_desc":
                    $query->orderBy("price", "desc");
                    break;
                case "name_asc":
                    $query->orderBy("name", "asc");
                    break;
                case "name_desc":
                    $query->orderBy("name", "desc");
                    break;
                case "rating_desc":
                    // Order by average rating
                    $query
                        ->withAvg("ratings as average_rating", "rating")
                        ->orderBy("average_rating", "desc");
                    break;
                default:
                    $query->latest();
            }
        } else {
            $query->latest();
        }

        $products = $query->paginate(12)->withQueryString();

        // Get categories for filter
        $categories = Category::orderBy("name")->get();

        // Get unique provinces for filter
        $provinces = SellerVerification::where("status", "approved")
            ->distinct()
            ->pluck("province")
            ->sort()
            ->values();

        // Get unique kota/kabupaten for filter
        $cities = SellerVerification::where("status", "approved")
            ->distinct()
            ->pluck("kota_kabupaten")
            ->sort()
            ->values();

        return view(
            "catalog.index",
            compact("products", "categories", "provinces", "cities"),
        );
    }

    /**
     * Show single product detail
     */
    public function show(Product $product)
    {
        // Load relations
        $product->load([
            "user.seller",
            "category",
            "ratings" => function ($query) {
                $query->latest();
            },
        ]);

        // Check if seller is approved
        if ($product->user->status !== "approved") {
            abort(404);
        }

        // Calculate average rating
        $averageRating = $product->averageRating();
        $ratingCount = $product->ratingCount();

        // Get rating distribution
        $ratingDistribution = [];
        for ($i = 5; $i >= 1; $i--) {
            $count = $product->ratings()->where("rating", $i)->count();
            $percentage = $ratingCount > 0 ? ($count / $ratingCount) * 100 : 0;
            $ratingDistribution[$i] = [
                "count" => $count,
                "percentage" => round($percentage, 1),
            ];
        }

        return view(
            "catalog.show",
            compact(
                "product",
                "averageRating",
                "ratingCount",
                "ratingDistribution",
            ),
        );
    }
}
