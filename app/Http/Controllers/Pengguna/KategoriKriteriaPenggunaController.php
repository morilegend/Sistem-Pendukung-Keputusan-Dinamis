<?php

namespace App\Http\Controllers\Pengguna;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\KategoriKriteria;
use Illuminate\Support\Facades\DB; 

class KategoriKriteriaPenggunaController extends Controller
{

    public function index()
    {
        $loggedInUserId = auth()->id();
        $usersId = DB::table('anggota')->where('id', $loggedInUserId)->value('users_id');
        $kategoriKriteria = KategoriKriteria::where('users_id', $usersId)->get();
        return view('Pengguna.kriteria.Kategori', compact('kategoriKriteria'));
    }
}