<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('customer_id')->references('id')->on('users')->onDelete('cascade'); // Relasi ke user (customer)
            $table->foreignId('mitra_profile_id')->constrained()->onDelete('cascade'); // Relasi ke barbershop yg di-book
            $table->foreignId('service_id')->constrained()->onDelete('cascade'); // Relasi ke layanan yg dipilih
            $table->dateTime('booking_time');
            $table->integer('total_price');
            $table->enum('status', ['pending', 'confirmed', 'completed', 'cancelled'])->default('pending');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
