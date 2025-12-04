<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductRating;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;

class RatingController extends Controller
{
    /**
     * Store a new rating and comment for a product
     */
    public function store(Request $request, Product $product)
    {
        // Validate request
        $validator = Validator::make($request->all(), [
            "visitor_name" => "required|string|max:255",
            "visitor_phone" => "required|string|max:20",
            "visitor_email" => "required|email|max:255",
            "province" => "required|string|max:100",
            "rating" => "required|integer|min:1|max:5",
            "comment" => "nullable|string|max:1000",
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Create rating
        $rating = ProductRating::create([
            "product_id" => $product->id,
            "visitor_name" => $request->visitor_name,
            "visitor_phone" => $request->visitor_phone,
            "visitor_email" => $request->visitor_email,
            "province" => $request->province,
            "rating" => $request->rating,
            "comment" => $request->comment,
        ]);

        // Send thank you email notification
        try {
            Mail::send(
                "emails.rating-thankyou",
                [
                    "name" => $request->visitor_name,
                    "product" => $product,
                    "rating" => $request->rating,
                    "comment" => $request->comment,
                ],
                function ($message) use ($request) {
                    $message
                        ->to($request->visitor_email)
                        ->subject("Terima Kasih atas Rating dan Komentar Anda");
                },
            );
        } catch (\Exception $e) {
            // Log error but don't fail the rating submission
            Log::error(
                "Failed to send rating thank you email: " . $e->getMessage(),
            );
        }

        return redirect()
            ->back()
            ->with(
                "success",
                "Terima kasih! Rating dan komentar Anda telah berhasil disimpan. Kami telah mengirimkan email konfirmasi ke " .
                    $request->visitor_email,
            );
    }
}
