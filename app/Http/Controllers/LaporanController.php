<?php

namespace App\Http\Controllers;

use App\Models\Laporan;
use Illuminate\Http\Request;

class LaporanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $laporans = Laporan::with(['user', 'kategori'])->latest()->paginate(10);

        $rekapBulanan = Laporan::getRekapBulanan();

        return view('laporan.view_rekap_laporan_bulanan', compact('laporans', 'rekapBulanan'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Laporan $laporan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Laporan $laporan)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Laporan $laporan)
    {
        $request->validate([
            'status' => 'required|in:Diajukan,Diproses,Selesai,Ditolak',
        ]);

        $laporan->update(['status' => $request->status]);
        return redirect()->back()->with('success', 'Status laporan berhasil diubah ke ' . $request->status);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Laporan $laporan)
{
   

    $laporan->delete();

    return redirect()->back()->with('success', 'Laporan berhasil dihapus selamanya!');
}
}
