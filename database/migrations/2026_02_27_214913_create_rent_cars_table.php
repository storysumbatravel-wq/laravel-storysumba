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
        Schema::create('rent_cars', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('brand')->nullable();
            $table->string('model')->nullable();
            $table->integer('year')->nullable();
            $table->string('transmission')->nullable();
            $table->string('fuel_type')->nullable();
            $table->integer('seats')->nullable();
            $table->decimal('price_per_day',12,2);
            $table->decimal('cost_price_per_day',12,2)->nullable();
            $table->decimal('price_per_week',12,2)->nullable();
            $table->string('plate_number')->unique();
            $table->string('status')->default('available');
            $table->text('description_en')->nullable();
            $table->text('description_id')->nullable();
            $table->json('features')->nullable();
            $table->boolean('with_driver')->default(false);
            $table->decimal('driver_price_per_day',12,2)->nullable();
            $table->string('image')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rent_cars');
    }
};
