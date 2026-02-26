<?php

use App\Http\Controllers\KategoriLaporanController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\TanggapanController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/laporan', [App\Http\Controllers\LaporanController::class, 'index'])->name('laporan.index');
Route::get('/portal-publik', function () {
    return view('laporan.publik');
})->name('laporan.publik');
Route::resource('kategori', KategoriLaporanController::class);
Route::resource('laporan', LaporanController::class);
Route::resource('tanggapan', TanggapanController::class);
