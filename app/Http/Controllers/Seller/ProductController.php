<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    /**
     * Display a listing of the products
     */
    public function index()
    {
        $products = Auth::user()
            ->products()
            ->with("category")
            ->latest()
            ->paginate(10);

        return view("seller.products.index", compact("products"));
    }

    /**
     * Show the form for creating a new product
     */
    public function create()
    {
        $categories = Category::all();
        return view("seller.products.create", compact("categories"));
    }

    /**
     * Store a newly created product in storage
     */
    public function store(Request $request)
    {
        $request->validate([
            "name" => ["required", "string", "max:255"],
            "description" => ["nullable", "string"],
            "price" => ["required", "numeric", "min:0"],
            "stock" => ["required", "integer", "min:0"],
            "category_id" => ["required", "exists:categories,id"],
            "image" => [
                "nullable",
                "image",
                "mimes:jpeg,png,jpg,gif",
                "max:2048",
            ],
        ]);

        $data = $request->only([
            "name",
            "description",
            "price",
            "stock",
            "category_id",
        ]);
        $data["user_id"] = Auth::id();

        // Handle image upload
        if ($request->hasFile("image")) {
            $imagePath = $request->file("image")->store("products", "public");
            $data["image"] = $imagePath;
        }

        Product::create($data);

        return redirect()
            ->route("seller.products.index")
            ->with("success", "Product created successfully!");
    }

    /**
     * Show the form for editing the specified product
     */
    public function edit($id)
    {
        $product = Auth::user()->products()->findOrFail($id);
        $categories = Category::all();

        return view("seller.products.edit", compact("product", "categories"));
    }

    /**
     * Update the specified product in storage
     */
    public function update(Request $request, $id)
    {
        $product = Auth::user()->products()->findOrFail($id);

        $request->validate([
            "name" => ["required", "string", "max:255"],
            "description" => ["nullable", "string"],
            "price" => ["required", "numeric", "min:0"],
            "stock" => ["required", "integer", "min:0"],
            "category_id" => ["required", "exists:categories,id"],
            "image" => [
                "nullable",
                "image",
                "mimes:jpeg,png,jpg,gif",
                "max:2048",
            ],
        ]);

        $data = $request->only([
            "name",
            "description",
            "price",
            "stock",
            "category_id",
        ]);

        // Handle image upload
        if ($request->hasFile("image")) {
            // Delete old image if exists
            if ($product->image) {
                Storage::disk("public")->delete($product->image);
            }

            $imagePath = $request->file("image")->store("products", "public");
            $data["image"] = $imagePath;
        }

        $product->update($data);

        return redirect()
            ->route("seller.products.index")
            ->with("success", "Product updated successfully!");
    }

    /**
     * Remove the specified product from storage
     */
    public function destroy($id)
    {
        $product = Auth::user()->products()->findOrFail($id);

        // Delete image if exists
        if ($product->image) {
            Storage::disk("public")->delete($product->image);
        }

        $product->delete();

        return redirect()
            ->route("seller.products.index")
            ->with("success", "Product deleted successfully!");
    }
}
