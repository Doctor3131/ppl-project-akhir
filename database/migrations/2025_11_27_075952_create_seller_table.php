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
        Schema::create("seller", function (Blueprint $table) {
            $table->id();
            $table->foreignId("user_id")->constrained()->onDelete("cascade");
            $table->string("ktp_number")->unique();
            $table->string("face_photo_path")->nullable();
            $table->string("ktp_photo_path")->nullable();
            $table->text("address");
            $table
                ->enum("status", ["pending", "approved", "rejected"])
                ->default("pending");
            $table->text("rejection_reason")->nullable();
            $table->timestamp("verified_at")->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists("seller");
    }
};
