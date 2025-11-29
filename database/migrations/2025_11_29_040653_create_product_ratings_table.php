<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create("product_ratings", function (Blueprint $table) {
            $table->id();
            $table->foreignId("product_id")->constrained()->onDelete("cascade");
            $table->string("visitor_name");
            $table->string("visitor_phone", 20);
            $table->string("visitor_email");
            $table->integer("rating")->unsigned()->default(5);
            $table->text("comment")->nullable();
            $table->timestamps();

            // Index untuk performa query
            $table->index("product_id");
            $table->index("rating");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists("product_ratings");
    }
};
