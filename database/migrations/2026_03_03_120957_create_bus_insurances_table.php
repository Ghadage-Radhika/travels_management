<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('bus_insurances', function (Blueprint $table) {
            $table->id();
            $table->date('insurance_date');                   // Date of insurance
            $table->string('bus_number', 30);                 // Bus registration number
            $table->decimal('amount', 10, 2);                 // Premium / amount paid
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bus_insurances');
    }
};