<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Model;

class Anggota extends Model
{
    use HasFactory;

    protected $table = 'anggota';
    protected $fillable = [
        'users_id',
        'nama',
        'email',
        'password',
        'jabatan',
        'jenis_kelamin',
        'akses_kriteria',
        'akses_alternatif',
        'akses_penilaian',
        'akses_simpan_perhitungan',
        'akses_anggota',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];
    
    protected $casts = [
        'akses_kriteria' => 'boolean',
        'akses_alternatif' => 'boolean',
        'akses_penilaian' => 'boolean',
        'akses_simpan_perhitungan' => 'boolean',
        'akses_anggota' => 'boolean',
        
    ];
    
    public function user()
    {
        return $this->belongsTo(User::class, 'users_id');
    }



}