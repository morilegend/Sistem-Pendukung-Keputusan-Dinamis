<?php

namespace App\Http\Controllers\Pengguna;

use App\Http\Controllers\Controller;
use App\Models\Alternatif;
use App\Models\KategoriAlternatif;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AlternatifPenggunaController extends Controller
{
    public function index(Request $request, $kategori_id)
    {
        $kategori = KategoriAlternatif::find($kategori_id);
        if (!$kategori) {
            return redirect()->route('pengguna.alternatif.index')
                ->with('error', 'Kategori Alternatif tidak ditemukan.');
        }
    
        return view('Pengguna.alternatif.alternatif', [
            'kategori_id' => $kategori_id,
            'alternatif' => Alternatif::where('id_kategori_alternatif', $kategori_id)->get(),
            'kategori' => $kategori,
        ]);
    }

    // Menyimpan alternatif baru
    public function store(Request $request)
    {
        $request->validate([
            'id_kategori_alternatif' => 'required|exists:kategori_alternatif,id',
            'nama' => 'required|string|max:255',
            'keterangan' => 'nullable|string',
        ]);

        Alternatif::create([
            'id_kategori_alternatif' => $request->id_kategori_alternatif,
            'nama' => $request->nama,
            'keterangan' => $request->keterangan,
            'status' => 'aktif',
        ]);

        // Redirect ke halaman alternatif dengan kategori_id
        return redirect()->route('pengguna.alternatif.index', ['kategori_id' => $request->id_kategori_alternatif])
            ->with('success', 'Alternatif berhasil ditambahkan.');
    }

    // Menampilkan form untuk mengedit alternatif
    public function edit($id)
    {
        $alternatif = Alternatif::findOrFail($id);
        $kategori = KategoriAlternatif::all();

        return view('Pengguna.alternatif.edit', compact('alternatif', 'kategori'));
    }

    // Mengupdate data alternatif
    public function update(Request $request, $id)
    {
        $request->validate([
            'id_kategori_alternatif' => 'required|exists:kategori_alternatif,id',
            'nama' => 'required|string|max:255',
            'keterangan' => 'nullable|string',
            'status' => 'required|in:aktif,nonaktif',
        ]);

        $alternatif = Alternatif::findOrFail($id);
        $alternatif->update($request->all());

        // Redirect ke halaman alternatif dengan kategori_id
        return redirect()->route('pengguna.alternatif.index', ['kategori_id' => $request->id_kategori_alternatif])
            ->with('success', 'Alternatif berhasil diperbarui.');
    }

    // Menghapus alternatif
    public function destroy($id)
    {
        $alternatif = Alternatif::findOrFail($id);

        $kategoriId = $alternatif->id_kategori_alternatif;
        $alternatif->delete();

        // Redirect ke halaman alternatif dengan kategori_id
        return redirect()->route('pengguna.alternatif.index', ['kategori_id' => $kategoriId])
            ->with('success', 'Alternatif berhasil dihapus.');
    }
}