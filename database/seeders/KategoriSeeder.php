<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class KategoriSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
{
    $data = [
        ['nama_kategori' => 'Infrastruktur', 'deskripsi' => 'Kerusakan jalan, jembatan, atau drainase.'],
        ['nama_kategori' => 'Kesehatan', 'deskripsi' => 'Layanan RSUD, Puskesmas, dan wabah penyakit.'],
        ['nama_kategori' => 'Pendidikan', 'deskripsi' => 'Gedung sekolah, beasiswa, dan seragam.'],
        ['nama_kategori' => 'Kebersihan', 'deskripsi' => 'Sampah menumpuk dan limbah lingkungan.'],
        ['nama_kategori' => 'Keamanan', 'deskripsi' => 'Pencurian, konflik warga, dan ketertiban umum.'],
        ['nama_kategori' => 'Sosial', 'deskripsi' => 'Bantuan sosial dan masalah kesejahteraan.'],
    ];

    foreach ($data as $k) {
        \App\Models\KategoriLaporan::create($k);
    }
}
}
