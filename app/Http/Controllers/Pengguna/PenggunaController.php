<?php

namespace App\Http\Controllers\Pengguna;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\KategoriKriteria;
use App\Models\KategoriAlternatif;
use App\Models\Anggota;
use Illuminate\Support\Facades\DB;



class PenggunaController extends Controller
{
    public function index()
    {
        $loggedInUserId = auth()->id();
        $usersId = DB::table('anggota')->where('id', $loggedInUserId)->value('users_id');
        $kategoriAlternatif = KategoriAlternatif::where('users_id', $usersId)->get();
        $kategoriKriteria = KategoriKriteria::where('users_id', $usersId)->get();
        $anggota = Anggota::where('users_id', $usersId)->get();


        return view('Pengguna.dashboard', compact('kategoriKriteria', 'kategoriAlternatif', 'anggota'));
    }
}