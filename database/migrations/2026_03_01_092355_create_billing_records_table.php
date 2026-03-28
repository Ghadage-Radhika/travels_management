<?php
// database/migrations/2024_01_01_000001_create_billing_records_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('billing_records', function (Blueprint $table) {
            $table->id();

            // Link to the source booking
            $table->foreignId('bus_booking_id')
                  ->constrained('bus_bookings')
                  ->onDelete('cascade');

            // Trip cost breakdown
            $table->decimal('rate_per_km',    10, 2)->nullable();
            $table->decimal('diesel_amount',  10, 2)->nullable()->default(0);
            $table->decimal('toll_parking',   10, 2)->nullable()->default(0);
            $table->decimal('online_permit',  10, 2)->nullable()->default(0);
            $table->decimal('driver_amount',  10, 2)->nullable()->default(0);
            $table->decimal('other_expenses', 10, 2)->nullable()->default(0);

            // Driver info
            $table->string('driver_name',   100)->nullable();
            $table->string('driver_mobile',  20)->nullable();

            // Extra description / notes
            $table->text('description')->nullable();

            // Computed totals (stored for quick reporting)
            $table->decimal('total_expenses', 10, 2)->nullable()->default(0);
            $table->decimal('net_profit',     10, 2)->nullable()->default(0);

            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('billing_records');
    }
};