<?php

namespace App\Http\Controllers;

use App\Models\Laporan;
use App\Models\Tanggapan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TanggapanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
        $request->validate([
            'laporan_id' => 'required',
            'tanggapan' => 'required|min:5',
        ]);

        $userId = Auth::id() ?? 1;
        Tanggapan::create([
            'laporan_id' => $request->laporan_id,
            'tgl_tanggapan' => now(),
            'tanggapan' => $request->tanggapan,
            'user_id' => $userId,
        ]);

        Laporan::where('id', $request->laporan_id)->update(['status' => 'Diproses']);

        return back()->with('success', 'Tanggapan berhasil dikirim!');
    }

    public function destroy($id)
    {
        Tanggapan::findOrFail($id)->delete();
        return back()->with('success', 'Tanggapan telah dihapus.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Tanggapan $tanggapan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Tanggapan $tanggapan)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Tanggapan $tanggapan)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
}
