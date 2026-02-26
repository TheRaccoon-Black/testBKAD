<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\LaporanDetailResource;
use App\Http\Resources\LaporanResource;
use App\Models\Laporan;
use Illuminate\Http\Request;

class LaporanController extends Controller
{
    public function index()
    {
        $laporan = Laporan::with('kategori')->latest()->paginate(10);

        return LaporanResource::collection($laporan);
    }

    public function show($id)
    {
        $laporan = Laporan::with(['user', 'kategori', 'tanggapans.petugas'])
            ->findOrFail($id);

        return new LaporanDetailResource($laporan);
    }
}
