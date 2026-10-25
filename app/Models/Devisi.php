<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Devisi extends Model
{
    use HasFactory;
    protected $table = 'devisis';

    protected $fillable = [
        'name_devisi',
        'keterangan',
    ];

    public function struktur()
    {
        return $this->hasMany(Struktur::class);
    }
}
