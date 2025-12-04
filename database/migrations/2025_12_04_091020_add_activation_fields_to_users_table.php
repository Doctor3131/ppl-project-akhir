<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Status aktif/non-aktif (terpisah dari approval status)
            $table->boolean('is_active')->default(true)->after('status');
            
            // Tracking login terakhir untuk auto-deactivation
            $table->timestamp('last_login_at')->nullable()->after('is_active');
            
            // Tanggal saat seller di-nonaktifkan
            $table->timestamp('deactivated_at')->nullable()->after('last_login_at');
            
            // Tanggal saat seller request reactivation
            $table->timestamp('reactivation_requested_at')->nullable()->after('deactivated_at');
            
            // Alasan deaktivasi (opsional, untuk info ke seller)
            $table->string('deactivation_reason')->nullable()->after('reactivation_requested_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'is_active',
                'last_login_at',
                'deactivated_at',
                'reactivation_requested_at',
                'deactivation_reason',
            ]);
        });
    }
};
