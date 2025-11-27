<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                "name" => "Electronics",
                "description" => "Electronic devices, gadgets, and accessories",
            ],
            [
                "name" => "Fashion",
                "description" => "Clothing, shoes, and fashion accessories",
            ],
            [
                "name" => "Home & Living",
                "description" => "Furniture, home decor, and household items",
            ],
            [
                "name" => "Books",
                "description" => "Physical and digital books across all genres",
            ],
            [
                "name" => "Sports & Outdoors",
                "description" => "Sports equipment and outdoor gear",
            ],
            [
                "name" => "Beauty & Health",
                "description" => "Beauty products, skincare, and health items",
            ],
            [
                "name" => "Toys & Games",
                "description" => "Toys, games, and entertainment products",
            ],
            [
                "name" => "Food & Beverages",
                "description" => "Food products, snacks, and beverages",
            ],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}
