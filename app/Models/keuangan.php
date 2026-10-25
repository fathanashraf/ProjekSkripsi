<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class keuangan extends Model
{
    use HasFactory;

    protected $table = 'keuangans';

    protected $fillable = [
        'user_id',
        'acara_id',
        'biaya_id',
        'pendaftaran_id',
        'pembayarans_id',
        'pembayaran_id',
        'jenis',
        'kategori',
        'nominal',
        'bulan',
        'total',
        'keterangan',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function acara()
    {
        return $this->belongsTo(Acara::class);
    }

    public function pembayaran()
    {
        return $this->belongsTo(Pembayaran::class);
    }

    public function pendaftaran()
    {
        return $this->belongsTo(Pendaftaran::class);
    }

    public function biaya()
    {
        return $this->belongsTo(Biaya::class);
    }
}
