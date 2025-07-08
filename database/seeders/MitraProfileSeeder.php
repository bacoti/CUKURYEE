<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MitraProfileSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Panggil MitraProfileFactory untuk membuat 15 data
        \App\Models\MitraProfile::factory(15)->create();
    }
}
