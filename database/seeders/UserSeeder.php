<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;


class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
{
    $faker = \Faker\Factory::create('id_ID');

    //  Admin
    \App\Models\User::create([
        'nik' => $faker->numerify('################'),         'name' => 'Admin BKAD',
        'username' => 'admin',
        'password' => bcrypt('password'),
        'telp' => '08123456789',
        'role' => 'admin'
    ]);

    // Petugas
    for ($i = 1; $i <= 2; $i++) {
        \App\Models\User::create([
            'nik' => $faker->numerify('################'),
            'name' => "Petugas $i",
            'username' => "petugas$i",
            'password' => bcrypt('password'),
            'telp' => $faker->numerify('08##########'),
        ]);
    }

    // Masyarakat
    for ($i = 1; $i <= 20; $i++) {
        \App\Models\User::create([
            'nik' => $faker->numerify('################'),
            'name' => $faker->name,
            'username' => $faker->userName,
            'password' => bcrypt('password'),
            'telp' => $faker->numerify('08##########'),
            'role' => 'masyarakat'
        ]);
    }
}
}
