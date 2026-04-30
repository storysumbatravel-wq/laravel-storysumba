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
        Schema::create('rental_transactions', function (Blueprint $table) {
            $table->id();
            $table->string('item')->default('Sewa Hice');
            $table->enum('month', ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December']);
            $table->date('rental_start_date');
            $table->date('rental_end_date');
            // Hanya menyimpan data input dasar
            $table->decimal('rental_price', 15, 2)->default(0); // Harga sewa per hari
            $table->decimal('expense_bbm', 15, 2)->default(0);
            $table->decimal('expense_operational', 15, 2)->default(0);
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->index('month');
            $table->index(['rental_start_date', 'rental_end_date']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rental_transactions');
    }
};
