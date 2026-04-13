<?php
namespace App\Http\Controllers\PenggunaUtama;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\KategoriAlternatif;

class KategoriAlternatifController extends Controller
{
    public function index()
    {
        $kategoriAlternatif = KategoriAlternatif::where('users_id', auth()->user()->id)
            ->get()
            ->map(function ($item) {
                $item->digunakanDalamPenilaian = \DB::table('kategori_penilaian')
                    ->where('id_kategori_alternatif', $item->id)
                    ->exists();
                return $item;
            });

        return view('Pengguna Utama.alternatif.Kategori', compact('kategoriAlternatif'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'keterangan' => 'nullable|string',
        ]);

        KategoriAlternatif::create([            
        'users_id' => auth()->id(),
        'nama' => $request->nama,
        'keterangan' => $request->keterangan,]);
        return redirect()->route('pengguna_utama.kategori_alternatif.index')->with('success', 'Kategori Alternatif berhasil ditambahkan.');
    }
    

    public function edit($id)
    {
        $alternatif = KategoriAlternatif::findOrFail($id);
        return view('Pengguna Utama.alternatif.update', compact('kategoriAlternatif'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'keterangan' => 'nullable|string',
        ]);

        $alternatif = KategoriAlternatif::findOrFail($id);
        $alternatif->update($request->all());
        return redirect()->route('pengguna_utama.kategori_alternatif.index')->with('success', 'Kategori Alternatif berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $alternatif = KategoriAlternatif::findOrFail($id);
        $alternatif->delete();
        return redirect()->route('pengguna_utama.kategori_alternatif.index')->with('success', 'Kategori Alternatif berhasil dihapus.');
    }
}