<?php

namespace App\Http\Controllers\Pengguna;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\KategoriPenilaian;
use App\Models\KategoriKriteria;
use App\Models\KategoriAlternatif;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class KategoriPenilaianPenggunaController extends Controller
{

    public function index()
    {

        $loggedInUserId = auth()->id();
        $userId = DB::table('anggota')->where('id', $loggedInUserId)->value('users_id');
        $kategoriPenilaian = KategoriPenilaian::with(['kategoriKriteria', 'kategoriAlternatif'])
            ->where('users_id', $userId)
            ->get()
            ->groupBy('nama');


        $kategoriKriteria = KategoriKriteria::where('users_id', $userId)->get();
        $kategoriAlternatif = KategoriAlternatif::where('users_id', $userId)->get();

        return view('Pengguna.Penilaian.Kategori', [
            'kategoriPenilaian' => $kategoriPenilaian,
            'kategoriKriteria' => $kategoriKriteria,
            'kategoriAlternatif' => $kategoriAlternatif,
        ]);
    }

}