<?php

namespace App\Http\Controllers\Pengguna;

use App\Models\Hasil;
use App\Models\KategoriHasil;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; 

class HasilPenggunaController extends Controller
{
    public function index()
    {
        
        $loggedInUserId = auth()->id();
        $userId = DB::table('anggota')->where('id', $loggedInUserId)->value('users_id');

        
        if (!$userId) {
            return redirect()->route('login');
        }
        $hasil = Hasil::with('kategoriHasil')
            ->whereHas('kategoriHasil', function ($query) use ($userId) {
                $query->where('users_id', $userId);
            })
            ->get()
            ->unique('id_kategori_hasil');
        
        return view('Pengguna.Hasil.Hasil', compact('hasil'));
    }

    public function show($id)
    {
        $hasil = Hasil::with('kategoriHasil')->findOrFail($id);
    
        $relatedHasil = Hasil::where('id_kategori_hasil', $hasil->id_kategori_hasil)->get();
    
        return view('Pengguna.Hasil.show', compact('hasil', 'relatedHasil'));
    }

    public function destroy($id)
    {
        $hasil = Hasil::findOrFail($id);
        Hasil::where('id_kategori_hasil', $hasil->id_kategori_hasil)->delete();
        KategoriHasil::where('id', $hasil->id_kategori_hasil)->delete();
        return redirect()->route('pengguna.hasil.index')->with('success', 'Data berhasil dihapus.');
    }
}