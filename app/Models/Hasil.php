<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hasil extends Model
{
    use HasFactory;
    protected $table = 'hasil';

    protected $fillable = [
        'id_kategori_hasil',
        'alternatif',
        'ranking',
        'penilaian',
        'alternatif_fuzzy',
        'ranking_fuzzy',
        'penilaian_fuzzy'
    ];

    public function kategoriHasil()
    {
        return $this->belongsTo(KategoriHasil::class, 'id_kategori_hasil');
    }
}