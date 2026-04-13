<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class KategoriAlternatif extends Model
{
    use HasFactory;
    protected $table = 'kategori_alternatif';


    protected $fillable = [
        'users_id',
        'keterangan',
        'nama',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'users_id');
    }
}