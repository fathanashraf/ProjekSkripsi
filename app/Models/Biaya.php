<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Biaya extends Model
{
    use HasFactory;

    protected $table = 'biayas';

    protected $fillable = [
        'name_biaya',
        'keterangan',
        'nominal',
    ];

    public function acara()
    {
        return $this->hasMany(Acara::class);
    }
}
