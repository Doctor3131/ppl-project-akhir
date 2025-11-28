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
            // Informasi Toko
            $table->string("shop_name")->after("user_id");
            $table->text("shop_description")->nullable()->after("shop_name");

            // Informasi PIC (Person In Charge)
            $table->string("pic_name")->after("shop_description");
            $table->string("pic_phone", 20)->after("pic_name");
            $table->string("pic_email")->after("pic_phone");
            $table->string("pic_ktp_number", 20)->after("pic_email");

            // Alamat Lengkap
            $table->string("street_address")->after("pic_ktp_number");
            $table->string("rt", 5)->after("street_address");
            $table->string("rw", 5)->after("rt");
            $table->string("kelurahan")->after("rw");
            $table->string("kota_kabupaten")->after("kelurahan");
            $table->string("province")->after("kota_kabupaten");

            // File uploads
            $table->string("pic_photo_path")->nullable()->after("province");
            $table
                ->string("ktp_file_path")
                ->nullable()
                ->after("pic_photo_path");

            // Rename kolom lama jika masih ada
            // Kita akan drop kolom lama yang tidak diperlukan
        });

        // Drop kolom lama yang sudah tidak relevan
        Schema::table("seller", function (Blueprint $table) {
            if (Schema::hasColumn("seller", "ktp_number")) {
                $table->dropColumn("ktp_number");
            }
            if (Schema::hasColumn("seller", "face_photo_path")) {
                $table->dropColumn("face_photo_path");
            }
            if (Schema::hasColumn("seller", "ktp_photo_path")) {
                $table->dropColumn("ktp_photo_path");
            }
            if (Schema::hasColumn("seller", "address")) {
                $table->dropColumn("address");
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table("seller", function (Blueprint $table) {
            // Kembalikan kolom lama
            $table->string("ktp_number")->unique();
            $table->string("face_photo_path")->nullable();
            $table->string("ktp_photo_path")->nullable();
            $table->text("address");

            // Drop kolom baru
            $table->dropColumn([
                "shop_name",
                "shop_description",
                "pic_name",
                "pic_phone",
                "pic_email",
                "pic_ktp_number",
                "street_address",
                "rt",
                "rw",
                "kelurahan",
                "kota_kabupaten",
                "province",
                "pic_photo_path",
                "ktp_file_path",
            ]);
        });
    }
};
