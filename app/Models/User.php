<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'users';

    protected $fillable = [
        'nama',
        'email',
        'password',
        'no_hp',
        'jenis_kelamin',
        'keperluan_spk',
        'role',
        'validasi',
        'domisili'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];
}