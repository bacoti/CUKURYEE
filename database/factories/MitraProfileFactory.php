<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Service; // <-- TAMBAHKAN INI
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\MitraProfile>
 */
class MitraProfileFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $barberNames = ['The Dapper Cut', 'Klimis & Co.', 'Gentlemen\'s Pride', 'Potong Rapi', 'Hairitage', 'Cukur Jenggot', 'Style Pria'];
        $cities = ['Jakarta', 'Bandung', 'Surabaya', 'Yogyakarta', 'Medan', 'Semarang', 'Makassar'];

        return [
            'user_id' => User::factory(['role' => 'mitra']),
            'barbershop_name' => fake()->randomElement($barberNames) . ' ' . fake()->lastName,
            'address' => fake()->streetAddress,
            'city' => fake()->randomElement($cities),
            'phone_number' => fake()->e164PhoneNumber,
            'description' => fake()->sentence(10),
            'is_verified' => true,
        ];
    }

    /**
     * Configure the model factory.
     *
     * @return $this
     */
    public function configure()
    {
        return $this->afterCreating(function (\App\Models\MitraProfile $mitraProfile) {
            // Daftar layanan yang mungkin
            $services = [
                ['name' => 'Potong Rambut Dewasa', 'price' => 50000, 'duration_minutes' => 30],
                ['name' => 'Potong Rambut Anak', 'price' => 35000, 'duration_minutes' => 25],
                ['name' => 'Creambath', 'price' => 80000, 'duration_minutes' => 60],
                ['name' => 'Hair Coloring', 'price' => 250000, 'duration_minutes' => 90],
                ['name' => 'Shaving & Trimming', 'price' => 40000, 'duration_minutes' => 20],
                ['name' => 'Hair Spa', 'price' => 120000, 'duration_minutes' => 75],
                ['name' => 'Paket Komplit (Potong + Cuci + Pijat)', 'price' => 90000, 'duration_minutes' => 50],
                ['name' => 'Black Mask', 'price' => 30000, 'duration_minutes' => 15],
            ];

            // Ambil 6 layanan secara acak dari daftar di atas
            $selectedServices = collect($services)->random(6);

            // Buat 6 layanan untuk profil mitra yang baru saja dibuat
            foreach ($selectedServices as $serviceData) {
                Service::factory()->create([
                    'mitra_profile_id' => $mitraProfile->id,
                    'name' => $serviceData['name'],
                    'price' => $serviceData['price'],
                    'duration_minutes' => $serviceData['duration_minutes'],
                    'description' => 'Layanan ' . strtolower($serviceData['name']) . ' berkualitas dari kami.',
                ]);
            }
        });
    }
}
