<?php

namespace Database\Seeders;

use App\Models\Izin;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class IzinSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // auto-generated 10 izin
        Izin::factory()->count(10)->create();
    }
}
