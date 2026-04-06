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
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->string('booking_code')->unique();
            $table->string('type');
            $table->foreignId('package_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('rent_car_id')->nullable()->constrained()->nullOnDelete();
            $table->string('customer_name');
            $table->string('customer_email');
            $table->string('customer_phone');
            $table->date('start_date');
            $table->date('end_date');
            $table->integer('pax')->default(1);
            $table->decimal('subtotal',12,2)->default(0);
            $table->decimal('discount',12,2)->default(0);
            $table->decimal('tax',12,2)->default(0);
            $table->decimal('total',12,2)->default(0);
            $table->decimal('paid_amount',12,2)->default(0);
            $table->string('payment_status')->default('pending');
            $table->string('status')->default('pending');
            $table->bigInteger('cost')->default(0);
            $table->bigInteger('profit')->default(0);
            $table->timestamps();
        });

        // Tambahan kolom jika belum ada
        Schema::table('bookings', function (Blueprint $table) {

            if (!Schema::hasColumn('bookings', 'with_driver')) {
                $table->boolean('with_driver')->default(false)->after('end_date');
            }

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
