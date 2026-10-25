<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Profil extends Model
{
    protected $table = 'profils';

    protected $fillable = [
        'name_instansi',
        'singkatan',
        'sejarah',
        'alamat',
        'logo',
        'logo_univ',
        'tahun_berdiri',
        'visi',
        'misi',
        'tujuan',
        'fungsi',
        'ad_art',
        'hymne_teknik',
        'mars_mahasiswa',
    ];


    public function misi()
    {
        return $this->belongsTo(Misi::class);
    }
}
