<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Product;
use App\Models\ProductRating;
use App\Models\SellerVerification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;

class ReportController extends Controller
{
    /**
     * Index - Halaman utama laporan admin dengan opsi export
     */
    public function index()
    {
        return view('admin.reports.index');
    }

    /**
     * SRS-MartPlace-09: Laporan daftar akun penjual aktif dan tidak aktif
     * Format: No, Nama User, Nama PIC, Nama Toko, Status
     * Sorting: Status (aktif dulu baru tidak aktif)
     */
    public function sellerAccounts(Request $request)
    {
        $query = User::where("role", "seller")
            ->where("status", "approved") // Only approved sellers for SRS-09
            ->with("seller")
            ->orderBy("is_active", "desc") // Aktif first
            ->orderBy("name");

        // Filter by activity status (is_active)
        if ($request->filled("is_active")) {
            $query->where("is_active", $request->is_active === "1");
        }

        $sellers = $query->get();

        // Statistics
        $stats = [
            "total" => User::where("role", "seller")->where("status", "approved")->count(),
            "active" => User::where("role", "seller")
                ->where("status", "approved")
                ->where("is_active", true)
                ->count(),
            "inactive" => User::where("role", "seller")
                ->where("status", "approved")
                ->where("is_active", false)
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
     * Format: No, Produk, Kategori, Harga, Rating, Nama Toko, Propinsi (pemberi rating)
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

        // Filter by province (rater's province)
        if ($request->filled("province")) {
            $query->whereHas("ratings", function ($q) use ($request) {
                $q->where("province", $request->province);
            });
        }

        // Get products with average rating and rater provinces
        $products = $query
            ->get()
            ->map(function ($product) {
                $product->average_rating = $product->averageRating();
                $product->rating_count = $product->ratingCount();
                
                // Get all rater provinces with counts
                $raterProvinces = $product->ratings()
                    ->whereNotNull('province')
                    ->select('province', DB::raw('count(*) as count'))
                    ->groupBy('province')
                    ->orderByDesc('count')
                    ->get();
                
                $product->rater_provinces = $raterProvinces;
                $product->primary_rater_province = $raterProvinces->first()?->province ?? '-';
                
                return $product;
            })
            ->sortByDesc("average_rating")
            ->values();

        // Get categories for filter
        $categories = \App\Models\Category::orderBy("name")->get();

        // Get provinces for filter (from ratings)
        $provinces = ProductRating::distinct()
            ->whereNotNull('province')
            ->pluck("province")
            ->sort()
            ->values();

        return view(
            "admin.reports.products-by-rating",
            compact("products", "categories", "provinces"),
        );
    }

    /**
     * Export report to PDF (SRS-MartPlace-09)
     */
    public function exportSellerAccounts()
    {
        $sellers = User::where("role", "seller")
            ->where("status", "approved")
            ->with("seller")
            ->orderBy("is_active", "desc")
            ->orderBy("name")
            ->get();

        // Statistics
        $stats = [
            "total" => User::where("role", "seller")->where("status", "approved")->count(),
            "active" => User::where("role", "seller")
                ->where("status", "approved")
                ->where("is_active", true)
                ->count(),
            "inactive" => User::where("role", "seller")
                ->where("status", "approved")
                ->where("is_active", false)
                ->count(),
        ];

        $adminName = Auth::user()->name;

        $pdf = Pdf::loadView('admin.reports.pdf.seller-accounts', compact('sellers', 'stats', 'adminName'));
        $pdf->setPaper('A4', 'portrait');
        
        return $pdf->download('laporan-akun-penjual-' . date('Y-m-d') . '.pdf');
    }

    /**
     * Export sellers by province to PDF (SRS-MartPlace-10)
     */
    public function exportSellersByProvince()
    {
        $sellers = SellerVerification::where("status", "approved")
            ->with("user")
            ->orderBy("province")
            ->orderBy("shop_name")
            ->get();

        // Statistics by province
        $statsByProvince = SellerVerification::where("status", "approved")
            ->select("province", DB::raw("count(*) as total"))
            ->groupBy("province")
            ->orderBy("total", "desc")
            ->get();

        $adminName = Auth::user()->name;

        $pdf = Pdf::loadView('admin.reports.pdf.sellers-by-province', compact('sellers', 'statsByProvince', 'adminName'));
        $pdf->setPaper('A4', 'portrait');
        
        return $pdf->download('laporan-penjual-per-provinsi-' . date('Y-m-d') . '.pdf');
    }

    /**
     * Export products by rating to PDF (SRS-MartPlace-11)
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
                
                // Get all rater provinces
                $raterProvinces = $product->ratings()
                    ->whereNotNull('province')
                    ->select('province', DB::raw('count(*) as count'))
                    ->groupBy('province')
                    ->orderByDesc('count')
                    ->get();
                
                $product->rater_provinces = $raterProvinces;
                $product->primary_rater_province = $raterProvinces->first()?->province ?? '-';
                
                return $product;
            })
            ->sortByDesc("average_rating");

        $adminName = Auth::user()->name;

        $pdf = Pdf::loadView('admin.reports.pdf.products-by-rating', compact('products', 'adminName'));
        $pdf->setPaper('A4', 'portrait');
        
        return $pdf->download('laporan-produk-rating-' . date('Y-m-d') . '.pdf');
    }
}
