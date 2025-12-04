<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Product;
use App\Models\Category;
use App\Models\ProductRating;
use App\Models\SellerVerification;
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
        // Create sample sellers from different provinces (for SRS-10 testing)
        
        // Seller 1 - DKI Jakarta
        $seller1 = User::create([
            "name" => "John's Electronics",
            "email" => "john@electronics.com",
            "password" => Hash::make("password"),
            "role" => "seller",
            "status" => "approved",
            "email_verified_at" => now(),
            "is_active" => true,
            "last_login_at" => now(),
        ]);

        SellerVerification::create([
            "user_id" => $seller1->id,
            "shop_name" => "John's Electronics Store",
            "shop_description" =>
                "Your one-stop shop for all electronic gadgets and accessories. We offer the latest technology products with competitive prices.",
            "pic_name" => "John Anderson",
            "pic_phone" => "081234567890",
            "pic_email" => "john@electronics.com",
            "pic_ktp_number" => "3201012345670001",
            "street_address" => "Jl. Sudirman No. 123",
            "rt" => "01",
            "rw" => "05",
            "kelurahan" => "Menteng",
            "kota_kabupaten" => "Jakarta Pusat",
            "province" => "DKI Jakarta",
            "pic_photo_path" => "sellers/john_photo.jpg",
            "ktp_file_path" => "sellers/john_ktp.jpg",
            "status" => "approved",
            "verified_at" => now(),
        ]);

        // Seller 2 - Jawa Barat
        $seller2 = User::create([
            "name" => "Sarah's Fashion",
            "email" => "sarah@fashion.com",
            "password" => Hash::make("password"),
            "role" => "seller",
            "status" => "approved",
            "email_verified_at" => now(),
            "is_active" => true,
            "last_login_at" => now(),
        ]);

        SellerVerification::create([
            "user_id" => $seller2->id,
            "shop_name" => "Sarah's Fashion Boutique",
            "shop_description" =>
                "Trendy fashion items for modern lifestyle. From casual wear to elegant outfits, we have everything you need to look stylish.",
            "pic_name" => "Sarah Williams",
            "pic_phone" => "081234567891",
            "pic_email" => "sarah@fashion.com",
            "pic_ktp_number" => "3273012345670002",
            "street_address" => "Jl. Merdeka No. 45",
            "rt" => "03",
            "rw" => "08",
            "kelurahan" => "Braga",
            "kota_kabupaten" => "Bandung",
            "province" => "Jawa Barat",
            "pic_photo_path" => "sellers/sarah_photo.jpg",
            "ktp_file_path" => "sellers/sarah_ktp.jpg",
            "status" => "approved",
            "verified_at" => now(),
        ]);

        // Seller 3 - Jawa Timur (pending)
        $seller3 = User::create([
            "name" => "Mike's Books",
            "email" => "mike@books.com",
            "password" => Hash::make("password"),
            "role" => "seller",
            "status" => "pending",
            "email_verified_at" => now(),
            "is_active" => true,
        ]);

        SellerVerification::create([
            "user_id" => $seller3->id,
            "shop_name" => "Mike's Book Corner",
            "shop_description" =>
                "A paradise for book lovers. Wide collection of books from various genres including fiction, non-fiction, educational, and more.",
            "pic_name" => "Michael Brown",
            "pic_phone" => "081234567892",
            "pic_email" => "mike@books.com",
            "pic_ktp_number" => "3578012345670003",
            "street_address" => "Jl. Tunjungan No. 78",
            "rt" => "02",
            "rw" => "04",
            "kelurahan" => "Genteng",
            "kota_kabupaten" => "Surabaya",
            "province" => "Jawa Timur",
            "pic_photo_path" => "sellers/mike_photo.jpg",
            "ktp_file_path" => "sellers/mike_ktp.jpg",
            "status" => "pending",
            "verified_at" => null,
        ]);

        // Seller 4 - Bali (for more province variation - SRS-10)
        $seller4 = User::create([
            "name" => "Bali Handicrafts",
            "email" => "bali@handicrafts.com",
            "password" => Hash::make("password"),
            "role" => "seller",
            "status" => "approved",
            "email_verified_at" => now(),
            "is_active" => true,
            "last_login_at" => now()->subDays(5),
        ]);

        SellerVerification::create([
            "user_id" => $seller4->id,
            "shop_name" => "Bali Handicrafts Gallery",
            "shop_description" =>
                "Authentic Balinese handicrafts and traditional art pieces. Direct from local artisans.",
            "pic_name" => "Made Wirawan",
            "pic_phone" => "081234567893",
            "pic_email" => "bali@handicrafts.com",
            "pic_ktp_number" => "5171012345670004",
            "street_address" => "Jl. Ubud Raya No. 88",
            "rt" => "01",
            "rw" => "02",
            "kelurahan" => "Ubud",
            "kota_kabupaten" => "Gianyar",
            "province" => "Bali",
            "pic_photo_path" => "sellers/bali_photo.jpg",
            "ktp_file_path" => "sellers/bali_ktp.jpg",
            "status" => "approved",
            "verified_at" => now(),
        ]);

        // Seller 5 - Sulawesi Selatan (another province - SRS-10)
        $seller5 = User::create([
            "name" => "Makassar Seafood",
            "email" => "makassar@seafood.com",
            "password" => Hash::make("password"),
            "role" => "seller",
            "status" => "approved",
            "email_verified_at" => now(),
            "is_active" => true,
            "last_login_at" => now()->subDays(2),
        ]);

        SellerVerification::create([
            "user_id" => $seller5->id,
            "shop_name" => "Makassar Seafood Market",
            "shop_description" =>
                "Fresh seafood products from Sulawesi waters. Best quality fish and sea products.",
            "pic_name" => "Daeng Rahman",
            "pic_phone" => "081234567894",
            "pic_email" => "makassar@seafood.com",
            "pic_ktp_number" => "7371012345670005",
            "street_address" => "Jl. Somba Opu No. 55",
            "rt" => "04",
            "rw" => "03",
            "kelurahan" => "Losari",
            "kota_kabupaten" => "Makassar",
            "province" => "Sulawesi Selatan",
            "pic_photo_path" => "sellers/makassar_photo.jpg",
            "ktp_file_path" => "sellers/makassar_ktp.jpg",
            "status" => "approved",
            "verified_at" => now(),
        ]);

        // Seller 6 - DKI Jakarta (second seller in same province - SRS-10)
        $seller6 = User::create([
            "name" => "Jakarta Tech Hub",
            "email" => "jakarta@techhub.com",
            "password" => Hash::make("password"),
            "role" => "seller",
            "status" => "approved",
            "email_verified_at" => now(),
            "is_active" => true,
            "last_login_at" => now()->subDays(1),
        ]);

        SellerVerification::create([
            "user_id" => $seller6->id,
            "shop_name" => "Jakarta Tech Hub Store",
            "shop_description" =>
                "Premium technology products and gadgets. Authorized reseller for major brands.",
            "pic_name" => "Budi Santoso",
            "pic_phone" => "081234567895",
            "pic_email" => "jakarta@techhub.com",
            "pic_ktp_number" => "3171012345670006",
            "street_address" => "Jl. Thamrin No. 100",
            "rt" => "02",
            "rw" => "01",
            "kelurahan" => "Gondangdia",
            "kota_kabupaten" => "Jakarta Pusat",
            "province" => "DKI Jakarta",
            "pic_photo_path" => "sellers/jaktech_photo.jpg",
            "ktp_file_path" => "sellers/jaktech_ktp.jpg",
            "status" => "approved",
            "verified_at" => now(),
        ]);

        // Get categories
        $electronics = Category::where("name", "Electronics")->first();
        $fashion = Category::where("name", "Fashion")->first();
        $books = Category::where("name", "Books")->first();

        // Store products for rating assignment later
        $products = [];

        // Create sample products for seller 1 (Electronics) - including LOW STOCK items for SRS-14
        if ($electronics) {
            $products[] = Product::create([
                "user_id" => $seller1->id,
                "category_id" => $electronics->id,
                "name" => "Wireless Bluetooth Headphones",
                "description" =>
                    "High-quality wireless headphones with noise cancellation and 30-hour battery life.",
                "price" => 899000,
                "stock" => 50,
            ]);

            $products[] = Product::create([
                "user_id" => $seller1->id,
                "category_id" => $electronics->id,
                "name" => "Smart Watch Pro",
                "description" =>
                    "Advanced smartwatch with health tracking, GPS, and waterproof design.",
                "price" => 2499000,
                "stock" => 30,
            ]);

            $products[] = Product::create([
                "user_id" => $seller1->id,
                "category_id" => $electronics->id,
                "name" => "Portable Power Bank 20000mAh",
                "description" =>
                    "High-capacity power bank with fast charging for all your devices.",
                "price" => 299000,
                "stock" => 100,
            ]);

            // LOW STOCK products for SRS-14 testing
            $products[] = Product::create([
                "user_id" => $seller1->id,
                "category_id" => $electronics->id,
                "name" => "USB-C Fast Charger",
                "description" =>
                    "65W USB-C charger with GaN technology. Compact and powerful.",
                "price" => 450000,
                "stock" => 1, // LOW STOCK
            ]);

            $products[] = Product::create([
                "user_id" => $seller1->id,
                "category_id" => $electronics->id,
                "name" => "Wireless Mouse Gaming",
                "description" =>
                    "High-precision gaming mouse with RGB lighting and 16000 DPI.",
                "price" => 750000,
                "stock" => 0, // OUT OF STOCK
            ]);

            $products[] = Product::create([
                "user_id" => $seller1->id,
                "category_id" => $electronics->id,
                "name" => "Mechanical Keyboard RGB",
                "description" =>
                    "Premium mechanical keyboard with hot-swappable switches.",
                "price" => 1250000,
                "stock" => 1, // LOW STOCK
            ]);
        }

        // Create sample products for seller 2 (Fashion)
        if ($fashion) {
            $products[] = Product::create([
                "user_id" => $seller2->id,
                "category_id" => $fashion->id,
                "name" => "Classic Denim Jacket",
                "description" =>
                    "Timeless denim jacket perfect for casual wear. Available in multiple sizes.",
                "price" => 450000,
                "stock" => 25,
            ]);

            $products[] = Product::create([
                "user_id" => $seller2->id,
                "category_id" => $fashion->id,
                "name" => "Premium Leather Sneakers",
                "description" =>
                    "Comfortable leather sneakers with modern design. Perfect for everyday use.",
                "price" => 799000,
                "stock" => 40,
            ]);

            $products[] = Product::create([
                "user_id" => $seller2->id,
                "category_id" => $fashion->id,
                "name" => "Elegant Silk Scarf",
                "description" =>
                    "Luxurious silk scarf with beautiful patterns. Great accessory for any outfit.",
                "price" => 199000,
                "stock" => 60,
            ]);

            $products[] = Product::create([
                "user_id" => $seller2->id,
                "category_id" => $fashion->id,
                "name" => "Designer Sunglasses",
                "description" =>
                    "Stylish sunglasses with UV protection. Perfect for sunny days.",
                "price" => 550000,
                "stock" => 35,
            ]);

            // LOW STOCK fashion items for SRS-14
            $products[] = Product::create([
                "user_id" => $seller2->id,
                "category_id" => $fashion->id,
                "name" => "Limited Edition Handbag",
                "description" =>
                    "Exclusive designer handbag. Only few pieces available.",
                "price" => 2500000,
                "stock" => 0, // OUT OF STOCK
            ]);

            $products[] = Product::create([
                "user_id" => $seller2->id,
                "category_id" => $fashion->id,
                "name" => "Vintage Leather Belt",
                "description" =>
                    "Handcrafted vintage leather belt with brass buckle.",
                "price" => 350000,
                "stock" => 1, // LOW STOCK
            ]);
        }

        // Create sample products for books category
        if ($books) {
            $products[] = Product::create([
                "user_id" => $seller1->id,
                "category_id" => $books->id,
                "name" => "The Art of Programming",
                "description" =>
                    "Comprehensive guide to programming best practices and design patterns.",
                "price" => 350000,
                "stock" => 20,
            ]);

            $products[] = Product::create([
                "user_id" => $seller1->id,
                "category_id" => $books->id,
                "name" => "Data Science Handbook",
                "description" =>
                    "Complete reference for data science and machine learning.",
                "price" => 425000,
                "stock" => 15,
            ]);

            // LOW STOCK book for SRS-14
            $products[] = Product::create([
                "user_id" => $seller1->id,
                "category_id" => $books->id,
                "name" => "Rare Vintage Computing Book",
                "description" =>
                    "Collector's edition book on early computing history.",
                "price" => 1500000,
                "stock" => 1, // LOW STOCK
            ]);
        }

        // Products for seller 4 (Bali Handicrafts)
        if ($fashion) {
            $products[] = Product::create([
                "user_id" => $seller4->id,
                "category_id" => $fashion->id,
                "name" => "Balinese Batik Shirt",
                "description" =>
                    "Traditional Balinese batik with modern cut. Hand-painted by local artisans.",
                "price" => 650000,
                "stock" => 20,
            ]);

            $products[] = Product::create([
                "user_id" => $seller4->id,
                "category_id" => $fashion->id,
                "name" => "Handwoven Rattan Bag",
                "description" =>
                    "Eco-friendly rattan bag handwoven by Balinese craftsmen.",
                "price" => 450000,
                "stock" => 30,
            ]);
        }

        // Products for seller 6 (Jakarta Tech Hub)
        if ($electronics) {
            $products[] = Product::create([
                "user_id" => $seller6->id,
                "category_id" => $electronics->id,
                "name" => "4K Ultra HD Monitor",
                "description" =>
                    "32-inch 4K monitor with HDR support. Perfect for professionals.",
                "price" => 5500000,
                "stock" => 10,
            ]);

            $products[] = Product::create([
                "user_id" => $seller6->id,
                "category_id" => $electronics->id,
                "name" => "Noise Cancelling Earbuds",
                "description" =>
                    "Premium wireless earbuds with active noise cancellation.",
                "price" => 1800000,
                "stock" => 25,
            ]);

            // LOW STOCK for SRS-14
            $products[] = Product::create([
                "user_id" => $seller6->id,
                "category_id" => $electronics->id,
                "name" => "Limited Gaming Console",
                "description" =>
                    "Special edition gaming console. Limited stock available.",
                "price" => 8500000,
                "stock" => 0, // OUT OF STOCK
            ]);
        }

        // ========================================
        // Create Product Ratings for SRS-11 & SRS-13 testing
        // ========================================
        
        $provinces = ["DKI Jakarta", "Jawa Barat", "Jawa Timur", "Bali", "Sulawesi Selatan", "Jawa Tengah"];
        $visitorNames = ["Andi", "Budi", "Citra", "Dewi", "Eko", "Fitri", "Galih", "Hana", "Irwan", "Joko"];
        
        foreach ($products as $product) {
            // Each product gets 3-8 random ratings
            $numRatings = rand(3, 8);
            
            for ($i = 0; $i < $numRatings; $i++) {
                $visitorName = $visitorNames[array_rand($visitorNames)];
                $province = $provinces[array_rand($provinces)];
                
                // Create varied ratings (1-5) with weighted distribution
                // More 4s and 5s, fewer 1s and 2s
                $ratingWeights = [1 => 5, 2 => 10, 3 => 20, 4 => 35, 5 => 30];
                $rating = $this->weightedRandom($ratingWeights);
                
                $comments = [
                    1 => ["Produk tidak sesuai ekspektasi.", "Kualitas sangat mengecewakan.", "Tidak recommend."],
                    2 => ["Kurang bagus.", "Biasa saja, kurang memuaskan.", "Perlu perbaikan."],
                    3 => ["Cukup bagus.", "Standar lah.", "Lumayan untuk harganya."],
                    4 => ["Bagus! Sesuai deskripsi.", "Recommended seller.", "Pengiriman cepat, produk oke."],
                    5 => ["Sangat puas!", "Excellent product!", "Pasti beli lagi. Top!", "Best seller ever!"],
                ];
                
                ProductRating::create([
                    "product_id" => $product->id,
                    "visitor_name" => $visitorName . " " . chr(rand(65, 90)) . ".",
                    "visitor_phone" => "08" . rand(1000000000, 9999999999),
                    "visitor_email" => strtolower($visitorName) . rand(1, 999) . "@email.com",
                    "province" => $province,
                    "rating" => $rating,
                    "comment" => $comments[$rating][array_rand($comments[$rating])],
                    "created_at" => now()->subDays(rand(1, 60)),
                ]);
            }
        }
    }

    /**
     * Generate weighted random number
     */
    private function weightedRandom(array $weights): int
    {
        $sum = array_sum($weights);
        $rand = rand(1, $sum);
        
        foreach ($weights as $value => $weight) {
            $rand -= $weight;
            if ($rand <= 0) {
                return $value;
            }
        }
        
        return array_key_first($weights);
    }
}
