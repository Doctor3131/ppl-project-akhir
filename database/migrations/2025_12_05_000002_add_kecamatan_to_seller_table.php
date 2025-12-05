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
        Schema::table("seller", function (Blueprint $table) {
            // Add kecamatan column after kelurahan
            if (!Schema::hasColumn("seller", "kecamatan")) {
                $table->string("kecamatan")->nullable()->after("kelurahan");
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table("seller", function (Blueprint $table) {
            if (Schema::hasColumn("seller", "kecamatan")) {
                $table->dropColumn("kecamatan");
            }
        });
    }
};
