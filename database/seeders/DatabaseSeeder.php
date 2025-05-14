<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory(10)->create();

        User::factory()->create([
            'name' => 'Sigit Putra Prabowo',
            'email' => 'bowor4751@gmail.com',
            'password' => Hash::make('qwerqwer'),
        ]);

        // data dumy for company
        \App\Models\Company::create([
            'name' => 'Koperasi Mitra Husada Mandiri',
            'email' => 'mitrahusada mandiri@gmail.com',
            'address' => 'Jl. Raya Cikarang - Cibarusah, Cikarang, Bekasi, Jawa Barat',
            'latitude' => '-6.2780',
            'longitude' => '107.3025',
            'radius_km' => '0.5',
            'time_in' => '08:00:00',
            'time_out' => '17:00:00',
        ]);

        $this->call([
            AttendanceSeeder::class,
            IzinSeeder::class,
        ]);
    }
}
