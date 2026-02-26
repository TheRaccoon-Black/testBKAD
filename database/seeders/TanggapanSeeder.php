<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TanggapanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
{
    $faker = \Faker\Factory::create('id_ID');
    $laporanIds = \App\Models\Laporan::whereIn('status', ['Diproses', 'Selesai', 'Ditolak'])->pluck('id')->toArray();
    $petugasIds = \App\Models\User::whereIn('role', ['admin', 'petugas'])->pluck('id')->toArray();

    $contohTanggapan = [
        'Laporan diterima, tim teknis akan segera meluncur ke lokasi.',
        'Sedang dalam koordinasi dengan dinas terkait.',
        'Masalah telah berhasil diperbaiki, terima kasih atas laporannya.',
        'Laporan ditolak karena data lokasi kurang jelas.',
    ];

    foreach (array_slice($laporanIds, 0, 30) as $idLaporan) {
        \App\Models\Tanggapan::create([
            'laporan_id' => $idLaporan,
            'tgl_tanggapan' => now(),
            'tanggapan' => $faker->randomElement($contohTanggapan),
            'user_id' => $faker->randomElement($petugasIds),
        ]);
    }
}
}
