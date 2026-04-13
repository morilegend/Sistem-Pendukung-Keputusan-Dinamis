<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubKriteria extends Model
{
    use HasFactory;
    protected $table = 'sub_kriteria';
    protected $fillable = [
        'id_kriteria',
        'nama',
        'nilai_crisp',
        'nilai_fuzzy',
    ];

    public function kriteria()
    {
        return $this->belongsTo(Kriteria::class, 'id_kriteria');
    }

    public function updateNilaiFuzzy()
    {
        $this->nilai_fuzzy = round($this->nilai_crisp / 100, 4);
        $this->save();
    }
}