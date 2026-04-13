<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KategoriPenilaian extends Model
{
    use HasFactory;

    protected $table = 'kategori_penilaian'; // Nama tabel di database

    protected $fillable = [
        'nama',
        'id_kategori_kriteria',
        'id_kategori_alternatif',
        'users_id',
    ];

    public function kategoriKriteria()
    {
        return $this->belongsTo(KategoriKriteria::class, 'id_kategori_kriteria');
    }

    public function kategoriAlternatif()
    {
        return $this->belongsTo(KategoriAlternatif::class, 'id_kategori_alternatif');
    }

    public function penilaian()
    {
        return $this->hasMany(Penilaian::class, 'id_kategori_penilaian', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'users_id');
    }
}