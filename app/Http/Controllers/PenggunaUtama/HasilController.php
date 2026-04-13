<?php

namespace App\Http\Controllers\PenggunaUtama;

use App\Models\Hasil;
use App\Models\KategoriHasil;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class HasilController extends Controller
{
    public function index()
    {
        $userId = auth()->id(); 
        if (!$userId) {
            return redirect()->route('login');
        }
        $hasil = Hasil::with('kategoriHasil')
            ->whereHas('kategoriHasil', function ($query) use ($userId) {
                $query->where('users_id', $userId);
            })
            ->get()
            ->unique('id_kategori_hasil');
        
        return view('Pengguna Utama.Hasil.Hasil', compact('hasil'));
    }

    public function show($id)
    {
        $hasil = Hasil::with('kategoriHasil')->findOrFail($id);
    
        $relatedHasil = Hasil::where('id_kategori_hasil', $hasil->id_kategori_hasil)->get();
    
        return view('Pengguna Utama.Hasil.show', compact('hasil', 'relatedHasil'));
    }

    public function destroy($id)
    {
        $hasil = Hasil::findOrFail($id);
        Hasil::where('id_kategori_hasil', $hasil->id_kategori_hasil)->delete();
        KategoriHasil::where('id', $hasil->id_kategori_hasil)->delete();
        return redirect()->route('pengguna_utama.hasil.index')->with('success', 'Data berhasil dihapus.');
    }
}