<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CatalogController;
use App\Http\Controllers\RatingController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Seller\DashboardController as SellerDashboardController;
use App\Http\Controllers\Seller\ProductController as SellerProductController;
use App\Http\Controllers\Seller\ReportController as SellerReportController;
use App\Http\Controllers\Seller\ReactivationController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\SellerController;
use App\Http\Controllers\Admin\ReportController as AdminReportController;

// Public routes
Route::get("/", [HomeController::class, "index"])->name("home");

// SRS-MartPlace-04: Katalog produk dapat dilihat oleh pengunjung umum
Route::get("/catalog", [CatalogController::class, "index"])->name(
    "catalog.index",
);
Route::get("/catalog/{product}", [CatalogController::class, "show"])->name(
    "catalog.show",
);

// SRS-MartPlace-06: Pemberian komentar dan rating
Route::post("/products/{product}/rating", [
    RatingController::class,
    "store",
])->name("rating.store");

// Legacy product routes (can be redirected to catalog)
Route::get("/products/{id}", function ($id) {
    return redirect()->route("catalog.show", $id);
})->name("products.show");

// Authentication routes
Route::middleware("guest")->group(function () {
    Route::get("/login", [LoginController::class, "showLoginForm"])->name(
        "login",
    );
    Route::post("/login", [LoginController::class, "login"]);
    Route::get("/register", [
        RegisterController::class,
        "showRegistrationForm",
    ])->name("register");
    Route::post("/register", [RegisterController::class, "register"]);
});

Route::post("/logout", [LoginController::class, "logout"])
    ->name("logout")
    ->middleware("auth");

// Seller reactivation routes (for deactivated sellers)
Route::prefix("seller")
    ->name("seller.")
    ->middleware(["auth", \App\Http\Middleware\SellerMiddleware::class])
    ->group(function () {
        // Reactivation request page (accessible even when deactivated)
        Route::get("/reactivation", [ReactivationController::class, "show"])->name("reactivation.show");
        Route::post("/reactivation", [ReactivationController::class, "store"])->name("reactivation.store");
    });

// Seller routes (require active status)
Route::prefix("seller")
    ->name("seller.")
    ->middleware(["auth", \App\Http\Middleware\SellerMiddleware::class, "seller.active"])
    ->group(function () {
        Route::get("/dashboard", [
            SellerDashboardController::class,
            "index",
        ])->name("dashboard");
        Route::resource("products", SellerProductController::class);

        // SRS-MartPlace-12, 13, 14: Laporan untuk Penjual
        Route::get("/reports", [
            SellerReportController::class,
            "index",
        ])->name("reports.index");
        Route::get("/reports/stock", [
            SellerReportController::class,
            "stockReport",
        ])->name("reports.stock");
        Route::get("/reports/rating", [
            SellerReportController::class,
            "ratingReport",
        ])->name("reports.rating");
        Route::get("/reports/low-stock", [
            SellerReportController::class,
            "lowStockReport",
        ])->name("reports.low-stock");

        // Export routes
        Route::get("/reports/stock/export", [
            SellerReportController::class,
            "exportStockReport",
        ])->name("reports.stock.export");
        Route::get("/reports/rating/export", [
            SellerReportController::class,
            "exportRatingReport",
        ])->name("reports.rating.export");
        Route::get("/reports/low-stock/export", [
            SellerReportController::class,
            "exportLowStockReport",
        ])->name("reports.low-stock.export");
    });

// Admin routes
Route::prefix("admin")
    ->name("admin.")
    ->middleware(["auth", \App\Http\Middleware\AdminMiddleware::class])
    ->group(function () {
        Route::get("/dashboard", [
            AdminDashboardController::class,
            "index",
        ])->name("dashboard");
        Route::resource("categories", CategoryController::class);
        Route::get("/sellers", [SellerController::class, "index"])->name(
            "sellers.index",
        );
        Route::get("/sellers/{id}", [SellerController::class, "show"])->name(
            "sellers.show",
        );
        Route::post("/sellers/{id}/approve", [
            SellerController::class,
            "approve",
        ])->name("sellers.approve");
        Route::post("/sellers/{id}/reject", [
            SellerController::class,
            "reject",
        ])->name("sellers.reject");

        // Seller activation/deactivation management
        Route::post("/sellers/{id}/deactivate", [
            SellerController::class,
            "deactivate",
        ])->name("sellers.deactivate");
        Route::post("/sellers/{id}/activate", [
            SellerController::class,
            "activate",
        ])->name("sellers.activate");
        
        // Reactivation requests management
        Route::get("/sellers/reactivation-requests", [
            SellerController::class,
            "pendingReactivations",
        ])->name("sellers.reactivation-requests");
        Route::post("/sellers/{id}/approve-reactivation", [
            SellerController::class,
            "approveReactivation",
        ])->name("sellers.approve-reactivation");
        Route::post("/sellers/{id}/reject-reactivation", [
            SellerController::class,
            "rejectReactivation",
        ])->name("sellers.reject-reactivation");

        // SRS-MartPlace-09, 10, 11: Laporan untuk Platform
        Route::get("/reports", [
            AdminReportController::class,
            "index",
        ])->name("reports.index");
        Route::get("/reports/seller-accounts", [
            AdminReportController::class,
            "sellerAccounts",
        ])->name("reports.seller-accounts");
        Route::get("/reports/sellers-by-province", [
            AdminReportController::class,
            "sellersByProvince",
        ])->name("reports.sellers-by-province");
        Route::get("/reports/products-by-rating", [
            AdminReportController::class,
            "productsByRating",
        ])->name("reports.products-by-rating");

        // Export routes
        Route::get("/reports/seller-accounts/export", [
            AdminReportController::class,
            "exportSellerAccounts",
        ])->name("reports.seller-accounts.export");
        Route::get("/reports/sellers-by-province/export", [
            AdminReportController::class,
            "exportSellersByProvince",
        ])->name("reports.sellers-by-province.export");
        Route::get("/reports/products-by-rating/export", [
            AdminReportController::class,
            "exportProductsByRating",
        ])->name("reports.products-by-rating.export");
    });
