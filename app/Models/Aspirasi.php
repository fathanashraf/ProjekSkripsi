<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Aspirasi extends Model
{
    use HasFactory;

    protected $table = 'aspirasis';

    protected $fillable = [
        'users_id',
        'acaras_id',
        'beritas_id',
        'like',
        'dislike',
        'Masukkan',
        'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'users_id');
    }

    public function acara()
    {
        return $this->belongsTo(Acara::class, 'acaras_id', 'id');
    }

    public function berita()
    {
        return $this->belongsTo(Berita::class, 'beritas_id');
    }
}
