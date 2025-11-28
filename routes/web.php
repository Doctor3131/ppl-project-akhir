<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Seller\DashboardController as SellerDashboardController;
use App\Http\Controllers\Seller\ProductController as SellerProductController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\SellerController;

// Public routes
Route::get("/", [HomeController::class, "index"])->name("home");
Route::get("/products/{id}", [HomeController::class, "show"])->name(
    "products.show",
);

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

// Seller routes
Route::prefix("seller")
    ->name("seller.")
    ->middleware(["auth", \App\Http\Middleware\SellerMiddleware::class])
    ->group(function () {
        Route::get("/dashboard", [
            SellerDashboardController::class,
            "index",
        ])->name("dashboard");
        Route::resource("products", SellerProductController::class);
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
    });
