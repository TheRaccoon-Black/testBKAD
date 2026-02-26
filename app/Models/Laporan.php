<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Laporan extends Model
{
    protected $table = 'laporan';
    protected $fillable = ['tgl_laporan', 'pelapor_id', 'kategori_id', 'isi_laporan', 'foto', 'status'];

    protected $casts = [
        'tgl_laporan' => 'datetime',
    ];

    public function pelapor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function kategori(): BelongsTo
    {
        return $this->belongsTo(KategoriLaporan::class, 'kategori_id');
    }

    public function tanggapan(): HasMany
    {
        return $this->hasMany(Tanggapan::class, 'laporan_id');
    }
}
