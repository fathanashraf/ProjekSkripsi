<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

use App\Models\User;
use App\Models\Syarat;
use App\Models\Biaya;
use App\Models\Aspirasi;
use App\Models\Pendaftaran;

class Acara extends Model
{
    use HasFactory;

    protected $table = 'acaras';

    protected $fillable = [
        'name_acara',
        'tanggal',
        'tempat',
        'keterangan',
        'thumnail',
        'user_id',
        'syarat_id',
        'biaya_id',
        'status',
        'tipe',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function syarat()
    {
        return $this->belongsTo(Syarat::class, 'syarat_id');
    }

    public function biaya()
    {
        return $this->belongsTo(Biaya::class, 'biaya_id');
    }

    public function aspirasi()
    {
        return $this->belongsTo(Aspirasi::class, 'acaras_id');
    }

    public function pendaftarans()
    {
        return $this->hasMany(Pendaftaran::class,'acaras_id');
    }

    public function dokumentasis()
    {
        return $this->hasMany(Dokumentasi::class, 'acara_id');
    }
}
