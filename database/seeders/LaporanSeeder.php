<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LaporanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
{
    $faker = \Faker\Factory::create('id_ID');
    $masyarakatIds = \App\Models\User::where('role', 'masyarakat')->pluck('id')->toArray();
    $kategoriIds = \App\Models\KategoriLaporan::pluck('id')->toArray();

    $contohLaporan = [
        'Jalan berlubang di depan pasar sangat membahayakan pengendara.',
        'Lampu jalan mati sudah 3 hari di area perumahan.',
        'Sampah menumpuk di sungai desa sebelah.',
        'Pelayanan kesehatan di Puskesmas sangat lambat pagi ini.',
        'Gedung SD mengalami atap bocor parah saat hujan.',
    ];

    for ($i = 1; $i <= 50; $i++) {
        \App\Models\Laporan::create([
            'tgl_laporan' => $faker->dateTimeBetween('-1 year', 'now'),
            'user_id' => $faker->randomElement($masyarakatIds),
            'kategori_id' => $faker->randomElement($kategoriIds),
            'isi_laporan' => $faker->randomElement($contohLaporan) . " " . $faker->sentence(),
            'status' => $faker->randomElement(['Diajukan', 'Diproses', 'Selesai', 'Ditolak']),
        ]);
    }
}
}
