<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dokumentasi extends Model
{
    use HasFactory;

    protected $table = 'dokumentasis';
    protected $fillable = [
        'acara_id',
        'name_dokumentasi',
        'file',
    ];

    public function acara()
    {
        return $this->belongsTo(Acara::class);
    }
}
