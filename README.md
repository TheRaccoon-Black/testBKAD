kuti langkah-langkah di bawah ini untuk menjalankan proyek di lingkungan lokal (Localhost):

1. Persiapan

Pastikan Anda sudah menginstal PHP >= 8.1, Composer, dan Laragon/XAMPP.

2. Clone & Install Dependency

git clone [https://github.com/TheRaccoon-Black/testBKAD](https://github.com/TheRaccoon-Black/testBKAD)
cd BKAD
composer install


3. Konfigurasi Database

Salin file .env.example menjadi .env dan sesuaikan pengaturan database Anda:

cp .env.example .env
php artisan key:generate


4. Database Seeding

Proyek ini menggunakan seeder untuk mempermudah pengujian data awal (Kategori, User, Laporan, dan Tanggapan):

php artisan migrate:fresh --seed


Catatan: Pastikan kolom telp pada tabel users memiliki panjang minimal 20 karakter.

5. Jalankan Aplikasi

php artisan serve


Akses aplikasi di: http://localhost:8000
