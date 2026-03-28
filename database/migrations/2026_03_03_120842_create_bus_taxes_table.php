<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('bus_taxes', function (Blueprint $table) {
            $table->id();
            $table->date('tax_date');                          // Date of payment
            $table->string('bus_number', 30);                 // Bus registration number
            $table->date('tax_from');                         // Tax valid from
            $table->date('tax_to');                           // Tax valid to
            $table->decimal('amount', 10, 2);                 // Amount paid
            $table->string('tax_image')->nullable();          // Receipt / document image path
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bus_taxes');
    }
};