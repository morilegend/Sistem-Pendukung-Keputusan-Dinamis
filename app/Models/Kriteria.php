<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class Kriteria extends Model
{
    use HasFactory;

    protected $table = 'kriteria';

    protected $fillable = [
        'id_kategori_kriteria',
        'nama',
        'bobot',
        'bobot_decimal',
        'jenis',
    ];

    public function kategoriKriteria()
    {
        return $this->belongsTo(KategoriKriteria::class, 'id_kategori_kriteria');
    }

    public function sub_kriteria()
    {
    return $this->hasMany(SubKriteria::class, 'id_kriteria');
    }
    
    
}