<?php

namespace App\Http\Controllers\Pengguna;

use App\Http\Controllers\Controller;
use App\Models\Kriteria;
use App\Models\KategoriKriteria;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class KriteriaPenggunaController extends Controller
{
    public function index(Request $request)
    {
        $kategoriId = $request->kategori_id;
        $isKategoriDigunakan = DB::table('penilaian')
        ->whereIn('id_kriteria', function ($query) use ($kategoriId) {
            $query->select('id')
                ->from('kriteria')
                ->where('id_kategori_kriteria', $kategoriId);
        })
        ->exists();
                
        return view('Pengguna.kriteria.Kriteria', [
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
        $existingTotalBobot = Kriteria::where('id_kategori_kriteria', $request->id_kategori_kriteria)->sum('bobot');
        $newTotalBobot = $existingTotalBobot + $request->bobot;
        $kriteria = Kriteria::create([
            'id_kategori_kriteria' => $request->id_kategori_kriteria,
            'nama' => $request->nama,
            'bobot' => $request->bobot,
            'jenis' => $request->jenis,
        ]);

        $this->updateBobotDecimal($request->id_kategori_kriteria, $newTotalBobot);

        return redirect()->route('pengguna.kriteria.index', ['kategori_id' => $request->id_kategori_kriteria])
            ->with('success', 'Kriteria berhasil ditambahkan.');
    }

    public function edit($id)
    {
        try {
            $kriteria = Kriteria::findOrFail($id);
            return view('Pengguna.kriteria.kriteria_update', compact('kriteria'));
        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage(),
            ], 500);
        }
    }
    
    public function update(Request $request, $id)
    {
        $kriteria = Kriteria::findOrFail($id);
    
        $request->validate([
            'id_kategori_kriteria' => 'required|exists:kategori_kriteria,id',
            'nama' => 'required|string|max:255',
            'bobot' => 'required|integer|min:1',
            'jenis' => 'required|in:benefit,cost',
        ]);
    
        $existingTotalBobot = Kriteria::where('id_kategori_kriteria', $request->id_kategori_kriteria)
            ->where('id', '!=', $id)
            ->sum('bobot');
        $newTotalBobot = $existingTotalBobot + $request->bobot;
        $kriteria->update([
            'id_kategori_kriteria' => $request->id_kategori_kriteria,
            'nama' => $request->nama,
            'bobot' => $request->bobot,
            'jenis' => $request->jenis,
        ]);
    
        $this->updateBobotDecimal($request->id_kategori_kriteria, $newTotalBobot);
    
        return redirect()->route('pengguna.kriteria.index', ['kategori_id' => $request->id_kategori_kriteria])
            ->with('success', 'Kriteria berhasil diubah.');
    }
    

    public function destroy($id)
    {
        $kriteria = Kriteria::findOrFail($id);
        $kategoriId = $kriteria->id_kategori_kriteria;
        $kriteria->delete();
        $totalBobot = Kriteria::where('id_kategori_kriteria', $kategoriId)->sum('bobot');
        $this->updateBobotDecimal($kategoriId, $totalBobot);

        return redirect()->route('pengguna.kriteria.index', ['kategori_id' => $kategoriId])
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
        }
    }
}