<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class LaporanDetailResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */

    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'tgl_laporan' => $this->tgl_laporan->format('d-m-Y H:i'),
            'isi_laporan' => $this->isi_laporan,
            'status' => $this->status,
            'foto' => $this->foto ? asset('storage/' . $this->foto) : null,
            'kategori' => $this->kategori->nama_kategori,

            'pelapor' => [
                'nama' => $this->user->name,
            ],

            'daftar_tanggapan' => $this->tanggapans->map(function ($item) {
                return [
                    'tgl_tanggapan' => $item->tgl_tanggapan->format('d-m-Y H:i'),
                    'isi_tanggapan' => $item->tanggapan,
                    'petugas' => $item->petugas->name,
                ];
            }),
        ];
    }
}
