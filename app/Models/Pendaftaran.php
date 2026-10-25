<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Pendaftaran extends Model
{

    use HasFactory;
    protected $table = 'pendaftarans';

    protected $fillable = [
        'nama_pendaftar',
        'user_id',
        'acaras_id',
        'status',
        'keterangan',
        'file',
        'NO_HP'
    ];

    /** Status pendaftaran */
    public const STATUS_DIAJUKAN = 'diajukan';
    public const STATUS_DITERIMA = 'diterima';
    public const STATUS_DIBAYAR = 'dibayar';
    public const STATUS_DITOLAK = 'ditolak';

    /**
     * Pendaftaran hanya bisa dibayar setelah disetujui admin.
     * Status 'dibayar' juga sudah melewati tahap persetujuan.
     */
    public function isDisetujui(): bool
    {
        return in_array($this->status, [self::STATUS_DITERIMA, self::STATUS_DIBAYAR], true);
    }

    /**
     * Pendaftaran yang pembayarannya sudah lunas.
     */
    public function isLunas(): bool
    {
        return $this->status === self::STATUS_DIBAYAR;
    }

    public function scopeDisetujui($query)
    {
        return $query->whereIn('status', [self::STATUS_DITERIMA, self::STATUS_DIBAYAR]);
    }

    public function scopeLunas($query)
    {
        return $query->where('status', self::STATUS_DIBAYAR);
    }

    public function acaras()
    {
        return $this->belongsTo(Acara::class, 'acaras_id');
    }

    public function users()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function pembayaran()
    {
        return $this->hasOne(Pembayaran::class, 'pendaftaran_id');
    }
}
