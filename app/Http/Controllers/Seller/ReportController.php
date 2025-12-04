<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;

class ReportController extends Controller
{
    /**
     * Index - Halaman utama laporan dengan opsi export
     */
    public function index()
    {
        return view('seller.reports.index');
    }

    /**
     * SRS-MartPlace-12: Laporan daftar stock produk yang diurutkan berdasarkan stock secara menurun
     * Format: No, Produk, Kategori, Harga, Rating, Stock
     */
    public function stockReport(Request $request)
    {
        $query = Product::where("user_id", Auth::id())
            ->with(["category", "ratings"])
            ->orderBy("stock", "desc");

        // Filter by category
        if ($request->filled("category_id")) {
            $query->where("category_id", $request->category_id);
        }

        // Get products with ratings
        $products = $query->get()->map(function ($product) {
            $product->average_rating = $product->averageRating();
            $product->rating_count = $product->ratingCount();
            return $product;
        });

        // Get categories for filter
        $categories = Category::orderBy("name")->get();

        // Statistics
        $stats = [
            "total_products" => Product::where("user_id", Auth::id())->count(),
            "total_stock" => Product::where("user_id", Auth::id())->sum("stock"),
            "low_stock" => Product::where("user_id", Auth::id())
                ->where("stock", "<", 2)
                ->count(),
            "out_of_stock" => Product::where("user_id", Auth::id())
                ->where("stock", 0)
                ->count(),
        ];

        return view(
            "seller.reports.stock",
            compact("products", "categories", "stats"),
        );
    }

    /**
     * SRS-MartPlace-13: Laporan daftar stock produk yang diurutkan berdasarkan rating secara menurun
     * Format: No, Produk, Kategori, Harga, Stock, Rating
     */
    public function ratingReport(Request $request)
    {
        $query = Product::where("user_id", Auth::id())->with([
            "category",
            "ratings",
        ]);

        // Filter by category
        if ($request->filled("category_id")) {
            $query->where("category_id", $request->category_id);
        }

        // Get products with ratings
        $products = $query
            ->get()
            ->map(function ($product) {
                $product->average_rating = $product->averageRating();
                $product->rating_count = $product->ratingCount();
                return $product;
            })
            ->sortByDesc("average_rating")
            ->values();

        // Get categories for filter
        $categories = Category::orderBy("name")->get();

        // Statistics
        $stats = [
            "total_products" => Product::where("user_id", Auth::id())->count(),
            "average_rating" => $products->avg("average_rating")
                ? round($products->avg("average_rating"), 1)
                : 0,
            "total_ratings" => $products->sum("rating_count"),
            "products_with_ratings" => $products
                ->where("rating_count", ">", 0)
                ->count(),
        ];

        return view(
            "seller.reports.rating",
            compact("products", "categories", "stats"),
        );
    }

    /**
     * SRS-MartPlace-14: Laporan daftar stock barang yang harus segera di pesan (stock < 2)
     * Format: No, Produk, Kategori, Harga, Stock
     * Sorting: berdasarkan kategori dan produk
     */
    public function lowStockReport(Request $request)
    {
        $query = Product::where("user_id", Auth::id())
            ->where("stock", "<", 2)
            ->with(["category", "ratings"])
            ->join('categories', 'products.category_id', '=', 'categories.id')
            ->orderBy('categories.name', 'asc')
            ->orderBy('products.name', 'asc')
            ->select('products.*');

        // Filter by category
        if ($request->filled("category_id")) {
            $query->where("products.category_id", $request->category_id);
        }

        // Get products
        $products = $query->get()->map(function ($product) {
            $product->average_rating = $product->averageRating();
            $product->rating_count = $product->ratingCount();
            return $product;
        });

        // Get categories for filter
        $categories = Category::orderBy("name")->get();

        // Statistics
        $stats = [
            "low_stock_count" => $products->count(),
            "out_of_stock" => $products->where("stock", 0)->count(),
            "stock_1" => $products->where("stock", 1)->count(),
            "total_value" => $products->sum(function ($product) {
                return $product->price * $product->stock;
            }),
        ];

        return view(
            "seller.reports.low-stock",
            compact("products", "categories", "stats"),
        );
    }

    /**
     * Export stock report to PDF (SRS-MartPlace-12)
     */
    public function exportStockReport()
    {
        $products = Product::where("user_id", Auth::id())
            ->with(["category", "ratings"])
            ->orderBy("stock", "desc")
            ->get()
            ->map(function ($product) {
                $product->average_rating = $product->averageRating();
                $product->rating_count = $product->ratingCount();
                return $product;
            });

        // Statistics
        $stats = [
            "total_products" => Product::where("user_id", Auth::id())->count(),
            "total_stock" => Product::where("user_id", Auth::id())->sum("stock"),
            "low_stock" => Product::where("user_id", Auth::id())->where("stock", "<", 2)->count(),
            "out_of_stock" => Product::where("user_id", Auth::id())->where("stock", 0)->count(),
        ];

        // Get shop name and seller name
        $shopName = Auth::user()->seller->shop_name ?? Auth::user()->name;
        $sellerName = Auth::user()->name;

        $pdf = Pdf::loadView('seller.reports.pdf.stock', compact('products', 'stats', 'shopName', 'sellerName'));
        $pdf->setPaper('A4', 'portrait');
        
        return $pdf->download('laporan-stok-produk-' . date('Y-m-d') . '.pdf');
    }

    /**
     * Export rating report to PDF (SRS-MartPlace-13)
     */
    public function exportRatingReport()
    {
        $products = Product::where("user_id", Auth::id())
            ->with(["category", "ratings"])
            ->get()
            ->map(function ($product) {
                $product->average_rating = $product->averageRating();
                $product->rating_count = $product->ratingCount();
                return $product;
            })
            ->sortByDesc("average_rating");

        // Statistics
        $stats = [
            "total_products" => Product::where("user_id", Auth::id())->count(),
            "average_rating" => $products->avg("average_rating") ? round($products->avg("average_rating"), 1) : 0,
            "total_ratings" => $products->sum("rating_count"),
            "products_with_ratings" => $products->where("rating_count", ">", 0)->count(),
        ];

        // Get shop name and seller name
        $shopName = Auth::user()->seller->shop_name ?? Auth::user()->name;
        $sellerName = Auth::user()->name;

        $pdf = Pdf::loadView('seller.reports.pdf.rating', compact('products', 'stats', 'shopName', 'sellerName'));
        $pdf->setPaper('A4', 'portrait');
        
        return $pdf->download('laporan-rating-produk-' . date('Y-m-d') . '.pdf');
    }

    /**
     * Export low stock report to PDF (SRS-MartPlace-14)
     */
    public function exportLowStockReport()
    {
        $products = Product::where("user_id", Auth::id())
            ->where("stock", "<", 2)
            ->with(["category", "ratings"])
            ->join('categories', 'products.category_id', '=', 'categories.id')
            ->orderBy('categories.name', 'asc')
            ->orderBy('products.name', 'asc')
            ->select('products.*')
            ->get()
            ->map(function ($product) {
                $product->average_rating = $product->averageRating();
                $product->rating_count = $product->ratingCount();
                return $product;
            });

        // Statistics
        $stats = [
            "low_stock_count" => $products->count(),
            "out_of_stock" => $products->where("stock", 0)->count(),
            "stock_1" => $products->where("stock", 1)->count(),
            "total_value" => $products->sum(function ($product) {
                return $product->price * $product->stock;
            }),
        ];

        // Get shop name and seller name
        $shopName = Auth::user()->seller->shop_name ?? Auth::user()->name;
        $sellerName = Auth::user()->name;

        $pdf = Pdf::loadView('seller.reports.pdf.low-stock', compact('products', 'stats', 'shopName', 'sellerName'));
        $pdf->setPaper('A4', 'portrait');
        
        return $pdf->download('laporan-stok-rendah-' . date('Y-m-d') . '.pdf');
    }
}
