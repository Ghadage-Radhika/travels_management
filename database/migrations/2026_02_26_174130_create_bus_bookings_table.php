<?php
// database/migrations/2026_02_26_174130_create_bus_bookings_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('bus_bookings', function (Blueprint $table) {
            $table->id();
            $table->date('booking_date');
            $table->string('route_from', 100);
            $table->string('route_to', 100);
            $table->decimal('kilometer', 8, 2);
            $table->string('bus_number', 20);
            $table->time('pickup_time');
            $table->decimal('booking_amount', 10, 2);
            $table->decimal('advance_amount', 10, 2);
            $table->decimal('remaining_amount', 10, 2);
            $table->text('note')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->foreign('created_by')->references('id')->on('users')->onDelete('set null');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bus_bookings');
    }
};