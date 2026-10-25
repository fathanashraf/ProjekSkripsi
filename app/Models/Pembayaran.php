<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pembayaran extends Model
{
    use HasFactory;

    protected $table = 'pembayarans';

    protected $fillable = [
        'pendaftaran_id',
        'acara_id',
        'user_id',
        'bukti_pembayaran',
        'status',
        'jenis',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function acara()
    {
        return $this->belongsTo(Acara::class, 'acara_id');
    }

    public function pendaftaran()
    {
        return $this->belongsTo(Pendaftaran::class);
    }

    public function keuangan()
    {
        return $this->belongsTo(Keuangan::class);
    }

    public function biaya()
    {
        return $this->belongsTo(Biaya::class);
    }
}
