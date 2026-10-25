<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Syarat extends Model
{
    use HasFactory;
    protected $table = 'syarats';

    protected $fillable = [
        'name_syarat',
        'kebutuhan',
    ];
}
