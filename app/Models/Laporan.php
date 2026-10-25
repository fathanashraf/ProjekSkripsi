<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Laporan extends Model
{
    use HasFactory;

    protected $table = 'laporans';

    protected $fillable = [
        'acaras_id',
        'jenis',
        'nama_laporan',
        'tanggal',
        'status',
        'catatan',
        'file',
    ];

    protected $casts = [
        'tanggal' => 'date',
    ];

    public function acara()
    {
        return $this->belongsTo(Acara::class, 'acaras_id');
    }
}
