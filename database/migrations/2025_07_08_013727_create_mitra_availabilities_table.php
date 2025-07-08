<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('mitra_availabilities', function (Blueprint $table) {
            $table->id();
            $table->foreignId('mitra_profile_id')->constrained()->onDelete('cascade');
            // 1 = Senin, 2 = Selasa, ..., 7 = Minggu
            $table->tinyInteger('day_of_week');
            $table->time('start_time')->nullable();
            $table->time('end_time')->nullable();
            $table->boolean('is_active')->default(false);
            $table->timestamps();

            // Pastikan setiap mitra hanya punya satu jadwal per hari
            $table->unique(['mitra_profile_id', 'day_of_week']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('mitra_availabilities');
    }
};
