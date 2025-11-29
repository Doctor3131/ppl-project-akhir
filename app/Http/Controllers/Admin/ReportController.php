<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Product;
use App\Models\SellerVerification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    /**
     * SRS-MartPlace-09: Laporan daftar akun penjual aktif dan tidak aktif
     */
    public function sellerAccounts(Request $request)
    {
        $query = User::where("role", "seller")
            ->with("seller")
            ->orderBy("status")
            ->orderBy("name");

        // Filter by status
        if ($request->filled("status")) {
            $query->where("status", $request->status);
        }

        $sellers = $query->get();

        // Statistics
        $stats = [
            "total" => User::where("role", "seller")->count(),
            "active" => User::where("role", "seller")
                ->where("status", "approved")
                ->count(),
            "inactive" => User::where("role", "seller")
                ->where("status", "!=", "approved")
                ->count(),
            "pending" => User::where("role", "seller")
                ->where("status", "pending")
                ->count(),
            "rejected" => User::where("role", "seller")
                ->where("status", "rejected")
                ->count(),
        ];

        return view(
            "admin.reports.seller-accounts",
            compact("sellers", "stats"),
        );
    }

    /**
     * SRS-MartPlace-10: Laporan daftar penjual (toko) untuk setiap lokasi propinsi
     */
    public function sellersByProvince(Request $request)
    {
        $query = SellerVerification::where("status", "approved")
            ->with("user")
            ->orderBy("province")
            ->orderBy("shop_name");

        // Filter by province
        if ($request->filled("province")) {
            $query->where("province", $request->province);
        }

        $sellers = $query->get();

        // Get all provinces for filter
        $provinces = SellerVerification::where("status", "approved")
            ->distinct()
            ->pluck("province")
            ->sort()
            ->values();

        // Statistics by province
        $statsByProvince = SellerVerification::where("status", "approved")
            ->select("province", DB::raw("count(*) as total"))
            ->groupBy("province")
            ->orderBy("total", "desc")
            ->get();

        return view(
            "admin.reports.sellers-by-province",
            compact("sellers", "provinces", "statsByProvince"),
        );
    }

    /**
     * SRS-MartPlace-11: Laporan daftar produk dan ratingnya yang diurutkan berdasarkan rating secara menurun
     */
    public function productsByRating(Request $request)
    {
        $query = Product::with([
            "user.seller",
            "category",
            "ratings",
        ])->whereHas("user", function ($q) {
            $q->where("status", "approved")->where("role", "seller");
        });

        // Filter by category
        if ($request->filled("category_id")) {
            $query->where("category_id", $request->category_id);
        }

        // Filter by province
        if ($request->filled("province")) {
            $query->whereHas("user.seller", function ($q) use ($request) {
                $q->where("province", $request->province);
            });
        }

        // Get products with average rating
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

        // Get provinces for filter
        $provinces = SellerVerification::where("status", "approved")
            ->distinct()
            ->pluck("province")
            ->sort()
            ->values();

        return view(
            "admin.reports.products-by-rating",
            compact("products", "categories", "provinces"),
        );
    }

    /**
     * Export report to CSV
     */
    public function exportSellerAccounts()
    {
        $sellers = User::where("role", "seller")
            ->with("seller")
            ->orderBy("status")
            ->orderBy("name")
            ->get();

        $filename = "seller-accounts-" . date("Y-m-d") . ".csv";

        $headers = [
            "Content-Type" => "text/csv",
            "Content-Disposition" => 'attachment; filename="' . $filename . '"',
        ];

        $callback = function () use ($sellers) {
            $file = fopen("php://output", "w");

            // Header
            fputcsv($file, [
                "No",
                "Nama",
                "Email",
                "Nama Toko",
                "Status",
                "Tanggal Registrasi",
            ]);

            // Data
            $no = 1;
            foreach ($sellers as $seller) {
                fputcsv($file, [
                    $no++,
                    $seller->name,
                    $seller->email,
                    $seller->seller->shop_name ?? "-",
                    ucfirst($seller->status),
                    $seller->created_at->format("d/m/Y H:i"),
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * Export sellers by province to CSV
     */
    public function exportSellersByProvince()
    {
        $sellers = SellerVerification::where("status", "approved")
            ->with("user")
            ->orderBy("province")
            ->orderBy("shop_name")
            ->get();

        $filename = "sellers-by-province-" . date("Y-m-d") . ".csv";

        $headers = [
            "Content-Type" => "text/csv",
            "Content-Disposition" => 'attachment; filename="' . $filename . '"',
        ];

        $callback = function () use ($sellers) {
            $file = fopen("php://output", "w");

            // Header
            fputcsv($file, [
                "No",
                "Nama Toko",
                "PIC",
                "Email",
                "Telepon",
                "Provinsi",
                "Kota/Kabupaten",
                "Alamat",
            ]);

            // Data
            $no = 1;
            foreach ($sellers as $seller) {
                fputcsv($file, [
                    $no++,
                    $seller->shop_name,
                    $seller->pic_name,
                    $seller->pic_email,
                    $seller->pic_phone,
                    $seller->province,
                    $seller->kota_kabupaten,
                    $seller->street_address .
                    ", RT " .
                    $seller->rt .
                    "/RW " .
                    $seller->rw .
                    ", " .
                    $seller->kelurahan,
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * Export products by rating to CSV
     */
    public function exportProductsByRating()
    {
        $products = Product::with(["user.seller", "category", "ratings"])
            ->whereHas("user", function ($q) {
                $q->where("status", "approved")->where("role", "seller");
            })
            ->get()
            ->map(function ($product) {
                $product->average_rating = $product->averageRating();
                $product->rating_count = $product->ratingCount();
                return $product;
            })
            ->sortByDesc("average_rating");

        $filename = "products-by-rating-" . date("Y-m-d") . ".csv";

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
                "Nama Toko",
                "Kategori",
                "Harga",
                "Rating",
                "Jumlah Rating",
                "Provinsi",
            ]);

            // Data
            $no = 1;
            foreach ($products as $product) {
                fputcsv($file, [
                    $no++,
                    $product->name,
                    $product->user->seller->shop_name ?? "-",
                    $product->category->name ?? "-",
                    "Rp " . number_format($product->price, 0, ",", "."),
                    number_format($product->average_rating, 1),
                    $product->rating_count,
                    $product->user->seller->province ?? "-",
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
