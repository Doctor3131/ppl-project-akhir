<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class TestDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create sample sellers
        $seller1 = User::create([
            "name" => "John's Electronics",
            "email" => "john@electronics.com",
            "password" => Hash::make("password"),
            "role" => "seller",
            "status" => "approved",
            "email_verified_at" => now(),
        ]);

        $seller2 = User::create([
            "name" => "Sarah's Fashion",
            "email" => "sarah@fashion.com",
            "password" => Hash::make("password"),
            "role" => "seller",
            "status" => "approved",
            "email_verified_at" => now(),
        ]);

        $seller3 = User::create([
            "name" => "Mike's Books",
            "email" => "mike@books.com",
            "password" => Hash::make("password"),
            "role" => "seller",
            "status" => "pending",
            "email_verified_at" => now(),
        ]);

        // Get categories
        $electronics = Category::where("name", "Electronics")->first();
        $fashion = Category::where("name", "Fashion")->first();
        $books = Category::where("name", "Books")->first();

        // Create sample products for seller 1 (Electronics)
        if ($electronics) {
            Product::create([
                "user_id" => $seller1->id,
                "category_id" => $electronics->id,
                "name" => "Wireless Bluetooth Headphones",
                "description" =>
                    "High-quality wireless headphones with noise cancellation and 30-hour battery life.",
                "price" => 899000,
                "stock" => 50,
            ]);

            Product::create([
                "user_id" => $seller1->id,
                "category_id" => $electronics->id,
                "name" => "Smart Watch Pro",
                "description" =>
                    "Advanced smartwatch with health tracking, GPS, and waterproof design.",
                "price" => 2499000,
                "stock" => 30,
            ]);

            Product::create([
                "user_id" => $seller1->id,
                "category_id" => $electronics->id,
                "name" => "Portable Power Bank 20000mAh",
                "description" =>
                    "High-capacity power bank with fast charging for all your devices.",
                "price" => 299000,
                "stock" => 100,
            ]);
        }

        // Create sample products for seller 2 (Fashion)
        if ($fashion) {
            Product::create([
                "user_id" => $seller2->id,
                "category_id" => $fashion->id,
                "name" => "Classic Denim Jacket",
                "description" =>
                    "Timeless denim jacket perfect for casual wear. Available in multiple sizes.",
                "price" => 450000,
                "stock" => 25,
            ]);

            Product::create([
                "user_id" => $seller2->id,
                "category_id" => $fashion->id,
                "name" => "Premium Leather Sneakers",
                "description" =>
                    "Comfortable leather sneakers with modern design. Perfect for everyday use.",
                "price" => 799000,
                "stock" => 40,
            ]);

            Product::create([
                "user_id" => $seller2->id,
                "category_id" => $fashion->id,
                "name" => "Elegant Silk Scarf",
                "description" =>
                    "Luxurious silk scarf with beautiful patterns. Great accessory for any outfit.",
                "price" => 199000,
                "stock" => 60,
            ]);

            Product::create([
                "user_id" => $seller2->id,
                "category_id" => $fashion->id,
                "name" => "Designer Sunglasses",
                "description" =>
                    "Stylish sunglasses with UV protection. Perfect for sunny days.",
                "price" => 550000,
                "stock" => 35,
            ]);
        }

        // Create sample products for books category (different seller)
        if ($books) {
            Product::create([
                "user_id" => $seller1->id,
                "category_id" => $books->id,
                "name" => "The Art of Programming",
                "description" =>
                    "Comprehensive guide to programming best practices and design patterns.",
                "price" => 350000,
                "stock" => 20,
            ]);
        }
    }
}
