<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Display catalog page with products
     */
    public function index(Request $request)
    {
        $query = Product::with(["category", "user"]);

        // Search functionality
        if ($request->has("search") && $request->search != "") {
            $query
                ->where("name", "ILIKE", "%" . $request->search . "%")
                ->orWhere("description", "ILIKE", "%" . $request->search . "%");
        }

        // Filter by category
        if ($request->has("category") && $request->category != "") {
            $query->where("category_id", $request->category);
        }

        $products = $query->latest()->paginate(12);
        $categories = Category::all();

        return view("home", compact("products", "categories"));
    }

    /**
     * Display product detail
     */
    public function show($id)
    {
        $product = Product::with(["category", "user"])->findOrFail($id);

        return view("product-detail", compact("product"));
    }
}
