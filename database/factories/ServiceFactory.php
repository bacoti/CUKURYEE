<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Service>
 */
class ServiceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            // Data spesifik akan di-override saat dipanggil
            'name' => 'Layanan Default',
            'description' => 'Deskripsi layanan default.',
            'price' => 50000,
            'duration_minutes' => 30,
        ];
    }
}
