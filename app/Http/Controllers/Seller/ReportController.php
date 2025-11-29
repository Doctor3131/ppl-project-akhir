<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReportController extends Controller
{
    /**
     * SRS-MartPlace-12: Laporan daftar stock produk yang diurutkan berdasarkan stock secara menurun
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
        $categories = \App\Models\Category::orderBy("name")->get();

        // Statistics
        $stats = [
            "total_products" => Product::where("user_id", Auth::id())->count(),
            "total_stock" => Product::where("user_id", Auth::id())->sum(
                "stock",
            ),
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
        $categories = \App\Models\Category::orderBy("name")->get();

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
     */
    public function lowStockReport(Request $request)
    {
        $query = Product::where("user_id", Auth::id())
            ->where("stock", "<", 2)
            ->with(["category", "ratings"])
            ->orderBy("stock", "asc");

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
        $categories = \App\Models\Category::orderBy("name")->get();

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
     * Export stock report to CSV
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

        $filename = "stock-report-" . date("Y-m-d") . ".csv";

        $headers = [
            "Content-Type" => "text/csv",
            "Content-Disposition" => 'attachment; filename="' . $filename . '"',
        ];

        $callback = function () use ($products) {
            $file = fopen("php://output", "w");

            // Header
            fputcsv($file, [
                "No",
                "Nama Produk",
                "Kategori",
                "Harga",
                "Stock",
                "Rating",
                "Jumlah Rating",
            ]);

            // Data
            $no = 1;
            foreach ($products as $product) {
                fputcsv($file, [
                    $no++,
                    $product->name,
                    $product->category->name ?? "-",
                    "Rp " . number_format($product->price, 0, ",", "."),
                    $product->stock,
                    number_format($product->average_rating, 1),
                    $product->rating_count,
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * Export rating report to CSV
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

        $filename = "rating-report-" . date("Y-m-d") . ".csv";

        $headers = [
            "Content-Type" => "text/csv",
            "Content-Disposition" => 'attachment; filename="' . $filename . '"',
        ];

        $callback = function () use ($products) {
            $file = fopen("php://output", "w");

            // Header
            fputcsv($file, [
                "No",
                "Nama Produk",
                "Kategori",
                "Harga",
                "Stock",
                "Rating",
                "Jumlah Rating",
            ]);

            // Data
            $no = 1;
            foreach ($products as $product) {
                fputcsv($file, [
                    $no++,
                    $product->name,
                    $product->category->name ?? "-",
                    "Rp " . number_format($product->price, 0, ",", "."),
                    $product->stock,
                    number_format($product->average_rating, 1),
                    $product->rating_count,
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * Export low stock report to CSV
     */
    public function exportLowStockReport()
    {
        $products = Product::where("user_id", Auth::id())
            ->where("stock", "<", 2)
            ->with(["category", "ratings"])
            ->orderBy("stock", "asc")
            ->get()
            ->map(function ($product) {
                $product->average_rating = $product->averageRating();
                $product->rating_count = $product->ratingCount();
                return $product;
            });

        $filename = "low-stock-report-" . date("Y-m-d") . ".csv";

        $headers = [
            "Content-Type" => "text/csv",
            "Content-Disposition" => 'attachment; filename="' . $filename . '"',
        ];

        $callback = function () use ($products) {
            $file = fopen("php://output", "w");

            // Header
            fputcsv($file, [
                "No",
                "Nama Produk",
                "Kategori",
                "Harga",
                "Stock",
                "Rating",
                "Jumlah Rating",
                "Status",
            ]);

            // Data
            $no = 1;
            foreach ($products as $product) {
                $status = $product->stock == 0 ? "Habis" : "Segera Habis";

                fputcsv($file, [
                    $no++,
                    $product->name,
                    $product->category->name ?? "-",
                    "Rp " . number_format($product->price, 0, ",", "."),
                    $product->stock,
                    number_format($product->average_rating, 1),
                    $product->rating_count,
                    $status,
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
