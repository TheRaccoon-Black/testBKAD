<?php

namespace App\Http\Controllers;

use App\Models\KategoriLaporan;
use Illuminate\Http\Request;

class KategoriLaporanController extends Controller
{
    public function index()
    {
        $categories = KategoriLaporan::latest()->get();
        return view('kategori.index', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_kategori' => 'required|unique:kategori_laporans,nama_kategori|max:255',
            'deskripsi' => 'nullable'
        ]);

        KategoriLaporan::create($request->all());
        return back()->with('success', 'Kategori baru berhasil ditambahkan!');
    }

    public function update(Request $request, $id)
    {
        $kategori = KategoriLaporan::findOrFail($id);
        $request->validate([
            'nama_kategori' => 'required|max:255|unique:kategori_laporans,nama_kategori,'.$id,
            'deskripsi' => 'nullable'
        ]);

        $kategori->update($request->all());
        return back()->with('success', 'Kategori berhasil diperbarui!');
    }

    public function destroy($id)
    {
        KategoriLaporan::findOrFail($id)->delete();
        return back()->with('success', 'Kategori telah dihapus.');
    }
}
