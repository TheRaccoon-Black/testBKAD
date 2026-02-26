<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class LaporanResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        // return parent::toArray($request);
        return [
            'id' => $this->id,
            'judul_laporan' => str($this->isi_laporan)->limit(30),
            'isi_lengkap' => $this->isi_laporan,
            'kategori' => $this->kategori->nama_kategori,
            'tanggal' => $this->tgl_laporan->format('d-m-Y'),
            'status' => $this->status,
        ];
    }
}
