<?php
namespace App\Http\Controllers\Pengguna;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\KategoriAlternatif;
use Illuminate\Support\Facades\DB; 

class KategoriAlternatifPenggunaController extends Controller
{
    public function index()
    {
        $loggedInUserId = auth()->id();
        $usersId = DB::table('anggota')->where('id', $loggedInUserId)->value('users_id');
        $kategoriAlternatif = KategoriAlternatif::where('users_id', $usersId)->get();
        return view('Pengguna.alternatif.Kategori', compact('kategoriAlternatif'));
    }

}