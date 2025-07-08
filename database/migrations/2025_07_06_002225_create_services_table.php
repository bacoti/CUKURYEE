<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('services', function (Blueprint $table) {
            $table->id();
            $table->foreignId('mitra_profile_id')->constrained()->onDelete('cascade'); // Relasi ke profil mitra
            $table->string('name');
            $table->text('description')->nullable();
            $table->integer('price');
            $table->integer('duration_minutes'); // Durasi layanan dalam menit
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('services');
    }
};
