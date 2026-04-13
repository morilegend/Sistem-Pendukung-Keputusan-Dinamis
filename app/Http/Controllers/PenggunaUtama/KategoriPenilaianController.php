<?php

namespace App\Http\Controllers\PenggunaUtama;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\KategoriPenilaian;
use App\Models\KategoriKriteria;
use App\Models\KategoriAlternatif;
use Illuminate\Support\Facades\Auth;

class KategoriPenilaianController extends Controller
{

    public function index()
    {
        $userId = Auth::id(); 
    
        // Ambil semua kategori penilaian milik pengguna
        $kategoriPenilaian = KategoriPenilaian::with(['kategoriKriteria', 'kategoriAlternatif'])
            ->where('users_id', $userId)
            ->get()
            ->groupBy('nama');
            
        $usedAlternatifIds = KategoriPenilaian::where('users_id', $userId)->pluck('id_kategori_alternatif');
        $kategoriKriteria = KategoriKriteria::where('users_id', $userId)->get();
    
        $kategoriAlternatif = KategoriAlternatif::where('users_id', $userId)
            ->whereNotIn('id', $usedAlternatifIds)
            ->get();
    
        return view('Pengguna Utama.Penilaian.Kategori', [
            'kategoriPenilaian' => $kategoriPenilaian,
            'kategoriKriteria' => $kategoriKriteria,
            'kategoriAlternatif' => $kategoriAlternatif,
        ]);
    }


    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'id_kategori_kriteria' => 'required|exists:kategori_kriteria,id',
            'id_kategori_alternatif' => 'required|exists:kategori_alternatif,id',
        ]);

        $userId = Auth::id(); 
        KategoriPenilaian::create([
            'nama' => $validated['nama'],
            'id_kategori_kriteria' => $validated['id_kategori_kriteria'],
            'id_kategori_alternatif' => $validated['id_kategori_alternatif'],
            'users_id' => $userId,
        ]);

        return redirect()->route('pengguna_utama.kategori_penilaian.index')
            ->with('success', 'Kategori Penilaian berhasil ditambahkan.');
    }


    public function destroy($id)
    {
        $userId = Auth::id();
        $kategoriPenilaian = KategoriPenilaian::where('id', $id)
            ->where('users_id', $userId)
            ->firstOrFail();
        KategoriPenilaian::where('nama', $kategoriPenilaian->nama)
            ->where('users_id', $userId)
            ->delete();
    
        return redirect()->route('pengguna_utama.kategori_penilaian.index')
            ->with('success', 'Seluruh kategori penilaian dengan nama "' . $kategoriPenilaian->nama . '" berhasil dihapus.');
    }
}