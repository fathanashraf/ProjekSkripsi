<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Struktur extends Model
{
    use HasFactory;

    protected $table = 'strukturs';

    protected $fillable = [
        'user_id',
        'devisi_id',
        'jabatan_id',
        'masa_jabatan',
        'foto',
        'posisi',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function devisi()
    {
        return $this->belongsTo(Devisi::class, 'devisi_id');
    }

    public function jabatan()
    {
        return $this->belongsTo(Jabatan::class, 'jabatan_id');
    }

    protected function casts(): array
{
    return [
        'foto' => 'string',
    ];
}
}
