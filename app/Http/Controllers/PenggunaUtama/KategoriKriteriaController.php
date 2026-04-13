<?php

namespace App\Http\Controllers\PenggunaUtama;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\KategoriKriteria;

class KategoriKriteriaController extends Controller
{

    public function index()
    {
        $kategoriKriteria = KategoriKriteria::where('users_id', auth()->id())
            ->get()
            ->map(function ($item) {
                $item->digunakanDalamPenilaian = \DB::table('kategori_penilaian')
                    ->where('id_kategori_kriteria', $item->id)
                    ->exists();
                return $item;
            });
    
        return view('Pengguna Utama.kriteria.Kategori', compact('kategoriKriteria'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'keterangan' => 'nullable|string',
        ]);

        KategoriKriteria::create([
            'users_id' => auth()->id(),
            'nama' => $request->nama,
            'keterangan' => $request->keterangan,
        ]);

        return redirect()->route('pengguna_utama.kategori_kriteria.index')
                         ->with('success', 'Kategori Kriteria berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $kategoriKriteria = KategoriKriteria::where('id', $id)
            ->where('users_id', auth()->id())
            ->firstOrFail();

        return view('Pengguna Utama.kriteria.Kategori_update', compact('kategoriKriteria'));
    }

    /**
     * Perbarui kategori kriteria di database.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'keterangan' => 'nullable|string',
        ]);

        $kategori = KategoriKriteria::where('id', $id)
            ->where('users_id', auth()->id())
            ->firstOrFail();

        $kategori->update([
            'nama' => $request->nama,
            'keterangan' => $request->keterangan,
        ]);

        return redirect()->route('pengguna_utama.kategori_kriteria.index')
                         ->with('success', 'Kategori Kriteria berhasil diperbarui!');
    }

    /**
     * Hapus kategori kriteria dari database.
     */
    public function destroy($id)
    {
        $kategoriKriteria = KategoriKriteria::where('id', $id)
            ->where('users_id', auth()->id())
            ->firstOrFail();

        $kategoriKriteria->delete();

        return redirect()->route('pengguna_utama.kategori_kriteria.index')
                         ->with('success', 'Kategori Kriteria berhasil dihapus!');
    }
}