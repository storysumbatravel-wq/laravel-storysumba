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
        Schema::table('packages', function (Blueprint $table) {

            // Cek dulu apakah kolom sudah ada, jika belum baru tambahkan
            // Ini mencegah error "Duplicate column"

            if (!Schema::hasColumn('packages', 'itinerary_en')) {
                $table->json('itinerary_en')->nullable()->after('destination_en');
            }
            if (!Schema::hasColumn('packages', 'itinerary_id')) {
                $table->json('itinerary_id')->nullable()->after('destination_id');
            }

            if (!Schema::hasColumn('packages', 'include_en')) {
                $table->json('include_en')->nullable()->after('itinerary_en');
            }
            if (!Schema::hasColumn('packages', 'include_id')) {
                $table->json('include_id')->nullable()->after('itinerary_id');
            }

            if (!Schema::hasColumn('packages', 'exclude_en')) {
                $table->json('exclude_en')->nullable()->after('include_en');
            }
            if (!Schema::hasColumn('packages', 'exclude_id')) {
                $table->json('exclude_id')->nullable()->after('include_id');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('packages', function (Blueprint $table) {
            // Hapus kolom hanya jika ada
            $columns = [
                'itinerary_en', 'itinerary_id',
                'include_en', 'include_id',
                'exclude_en', 'exclude_id'
            ];

            foreach ($columns as $col) {
                if (Schema::hasColumn('packages', $col)) {
                    $table->dropColumn($col);
                }
            }
        });
    }
};
