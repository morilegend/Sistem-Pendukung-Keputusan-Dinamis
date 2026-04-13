<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KategoriHasil extends Model
{
    use HasFactory;
    protected $table = 'kategori_hasil';
    protected $fillable = ['id_kategori_penilaian', 'users_id', 'nama'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function kategoriPenilaian()
    {
        return $this->belongsTo(KategoriPenilaian::class, 'id_kategori_penilaian');
    }
}