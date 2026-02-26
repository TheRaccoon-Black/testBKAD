<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Tanggapan extends Model
{
    protected $table = 'tanggapan';
    protected $fillable = ['laporan_id', 'tgl_tanggapan', 'tanggapan', 'user_id'];

    protected $casts = [
        'tgl_tanggapan' => 'datetime',
    ];

    public function laporan(): BelongsTo
    {
        return $this->belongsTo(Laporan::class, 'laporan_id');
    }

    public function petugas(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
