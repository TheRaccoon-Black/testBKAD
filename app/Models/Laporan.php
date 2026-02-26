<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Laporan extends Model
{
    protected $table = 'laporans';
    protected $fillable = ['tgl_laporan', 'pelapor_id', 'kategori_id', 'isi_laporan', 'foto', 'status'];

    protected $casts = [
        'tgl_laporan' => 'datetime',
    ];

    public static function getRekapBulanan()
    {
        return self::selectRaw("
                MONTH(tgl_laporan) as bulan,
                YEAR(tgl_laporan) as tahun,
                COUNT(*) as total_masuk,
                SUM(CASE WHEN status = 'Diproses' THEN 1 ELSE 0 END) as jumlah_diproses,
                SUM(CASE WHEN status = 'Selesai' THEN 1 ELSE 0 END) as jumlah_selesai,
                SUM(CASE WHEN status = 'Ditolak' THEN 1 ELSE 0 END) as jumlah_ditolak
            ")
            ->groupBy('tahun', 'bulan')
            ->orderBy('tahun', 'desc')
            ->orderBy('bulan', 'desc')
            ->get();
    }
    public function pelapor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function user(): BelongsTo
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
