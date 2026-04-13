<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Alternatif extends Model
{
    use HasFactory;

    protected $table = 'alternatif';

    protected $fillable = [
        'id_kategori_alternatif',
        'nama',
        'keterangan',
        'status',
    ];

    public function kategori()
    {
        return $this->belongsTo(KategoriAlternatif::class, 'id_kategori_alternatif');
    }

    public function scopeAktif($query)
    {
        return $query->where('status', 'aktif');
    }

    public function scopeNonaktif($query)
    {
        return $query->where('status', 'nonaktif');
    }
}