<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailPenilaian extends Model
{
    use HasFactory;

    protected $table = 'detail_penilaian';

    protected $fillable = [
        'id_kategori_penilaian',
        'id_kriteria',
        'id_alternatif',
        'id_sub_kriteria',
        'nilai'
    ];

    // Relasi ke Kategori Penilaian
    public function kategoriPenilaian()
    {
        return $this->belongsTo(KategoriPenilaian::class, 'id_kategori_penilaian');
    }

    // Relasi ke Kriteria
    public function kriteria()
    {
        return $this->belongsTo(Kriteria::class, 'id_kriteria');
    }

    // Relasi ke Alternatif
    public function alternatif()
    {
        return $this->belongsTo(Alternatif::class, 'id_alternatif');
    }

    // Relasi ke Sub Kriteria (Opsional)
    public function subKriteria()
    {
        return $this->belongsTo(SubKriteria::class, 'id_sub_kriteria');
    }
}