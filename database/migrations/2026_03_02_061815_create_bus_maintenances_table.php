<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('bus_maintenances', function (Blueprint $table) {
            $table->id();
            $table->date('maintenance_date');
            $table->string('bus_number', 20);

            // ── Type columns ──────────────────────────────────────────────────
            $table->string('maintenance_type', 100);   // predefined OR "Other"
            $table->string('custom_type', 150)->nullable(); // free-text when type = "Other"

            // ── Details ───────────────────────────────────────────────────────
            $table->text('description')->nullable();
            $table->decimal('amount_paid', 10, 2);
            $table->string('vendor_name', 100)->nullable();

            // ── Image / attachment fields ─────────────────────────────────────
            $table->string('tier_image')->nullable();  // stored path in storage/app/public
            $table->string('bill_image')->nullable();  // stored path in storage/app/public

            $table->foreignId('created_by')->constrained('users')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bus_maintenances');
    }
};