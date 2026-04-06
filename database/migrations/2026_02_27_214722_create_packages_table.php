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
        Schema::create('packages', function (Blueprint $table) {
            $table->id();
            $table->string('name_en');
            $table->string('name_id');
            $table->string('slug')->unique();

            $table->text('description_en')->nullable();
            $table->text('description_id')->nullable();

            $table->string('destination_en')->nullable();
            $table->string('destination_id')->nullable();

            $table->integer('duration_days')->nullable();
            $table->integer('duration_nights')->nullable();
            $table->integer('max_pax')->nullable(); // Ditambahkan

            $table->string('type')->nullable();

            // Kolom JSON untuk data dinamis
            $table->json('itinerary_en')->nullable(); // Ditambahkan
            $table->json('itinerary_id')->nullable(); // Ditambahkan
            $table->json('includes_en')->nullable();  // Ditambahkan
            $table->json('includes_id')->nullable();  // Ditambahkan
            $table->json('excludes_en')->nullable();  // Ditambahkan
            $table->json('excludes_id')->nullable();  // Ditambahkan
            $table->json('highlights_en')->nullable();
            $table->json('highlights_id')->nullable();

            $table->string('image')->nullable();

            $table->boolean('is_featured')->default(false);
            $table->boolean('is_active')->default(true);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('packages');
    }
};
