<?php

namespace App\Http\Controllers\PenggunaUtama;

use App\Http\Controllers\Controller;
use App\Models\Kriteria;
use App\Models\KategoriKriteria;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class KriteriaController extends Controller
{
    public function index(Request $request)
    {
        $kategoriId = $request->kategori_id;

        // Cek apakah kategori sedang digunakan dalam penilaian
        $isKategoriDigunakan = DB::table('penilaian')
            ->whereIn('id_kriteria', function ($query) use ($kategoriId) {
                $query->select('id')
                    ->from('kriteria')
                    ->where('id_kategori_kriteria', $kategoriId);
            })
            ->exists();

        return view('Pengguna Utama.kriteria.Kriteria', [
            'kategori_id' => $kategoriId,
            'kriteria' => Kriteria::where('id_kategori_kriteria', $kategoriId)->get(),
            'kategori' => KategoriKriteria::find($kategoriId),
            'isKategoriDigunakan' => $isKategoriDigunakan,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_kategori_kriteria' => 'required|exists:kategori_kriteria,id',
            'nama' => 'required|string|max:255',
            'bobot' => 'required|integer|min:1',
            'jenis' => 'required|in:benefit,cost',
        ]);

        // Cek apakah kategori sedang digunakan dalam penilaian
        $isKategoriDigunakan = DB::table('penilaian')
            ->whereIn('id_kriteria', function ($query) use ($request) {
                $query->select('id')
                    ->from('kriteria')
                    ->where('id_kategori_kriteria', $request->id_kategori_kriteria);
            })
            ->exists();

        if ($isKategoriDigunakan) {
            return redirect()->back()->with('error', 'Tidak dapat menambahkan kriteria karena kategori sedang digunakan dalam penilaian.');
        }

        $existingTotalBobot = Kriteria::where('id_kategori_kriteria', $request->id_kategori_kriteria)->sum('bobot');
        $newTotalBobot = $existingTotalBobot + $request->bobot;

        Kriteria::create([
            'id_kategori_kriteria' => $request->id_kategori_kriteria,
            'nama' => $request->nama,
            'bobot' => $request->bobot,
            'jenis' => $request->jenis,
        ]);

        $this->updateBobotDecimal($request->id_kategori_kriteria, $newTotalBobot);

        return redirect()->route('pengguna_utama.kriteria.index', ['kategori_id' => $request->id_kategori_kriteria])
            ->with('success', 'Kriteria berhasil ditambahkan.');
    }

    public function destroy($id)
    {
        $kriteria = Kriteria::findOrFail($id);

        // Cek apakah kriteria sedang digunakan dalam penilaian
        $isKriteriaDigunakan = DB::table('penilaian')
            ->where('id_kriteria', $id)
            ->exists();

        if ($isKriteriaDigunakan) {
            return redirect()->back()->with('error', 'Kriteria sedang digunakan dalam penilaian dan tidak dapat dihapus.');
        }

        $kategoriId = $kriteria->id_kategori_kriteria;
        $kriteria->delete();

        $totalBobot = Kriteria::where('id_kategori_kriteria', $kategoriId)->sum('bobot');
        $this->updateBobotDecimal($kategoriId, $totalBobot);

        return redirect()->route('pengguna_utama.kriteria.index', ['kategori_id' => $kategoriId])
            ->with('success', 'Kriteria berhasil dihapus.');
    }

    private function updateBobotDecimal($kategoriId, $totalBobot)
    {
        if ($totalBobot > 0) {
            $kriteriaList = Kriteria::where('id_kategori_kriteria', $kategoriId)->get();
            foreach ($kriteriaList as $kriteria) {
                $kriteria->bobot_decimal = $kriteria->bobot / $totalBobot;
                $kriteria->save();
            }
        } else {
            Kriteria::where('id_kategori_kriteria', $kategoriId)->update(['bobot_decimal' => 0]);
        }
    }
}