<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Jabatan extends Model
{
    protected $table = 'jabatans';

    protected $fillable = [
        'name_jabatan',
        'keterangan',
    ];

    public function struktur()
    {
        return $this->hasMany(Acara::class);
    }
}
