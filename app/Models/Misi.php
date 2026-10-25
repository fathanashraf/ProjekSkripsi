<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Misi extends Model
{
    use HasFactory;
    protected $table = 'misis';

    protected $fillable = [
        'name_misi',
        'keterangan',
    ];

    public function profil()
    {
        return $this->hasMany(Profil::class);
    }
}
