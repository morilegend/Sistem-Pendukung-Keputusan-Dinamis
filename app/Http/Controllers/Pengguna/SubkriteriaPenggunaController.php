<?php

namespace App\Http\Controllers\Pengguna;

use App\Http\Controllers\Controller;
use App\Models\SubKriteria;
use App\Models\Kriteria;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SubKriteriaPenggunaController extends Controller
{
    public function index($id_kriteria)
    {
        $user = Auth::user();
        $kriteria = Kriteria::findOrFail($id_kriteria);
        $subKriteria = SubKriteria::where('id_kriteria', $id_kriteria)
            ->get()
            ->map(function ($item) {
                $item->digunakanDalamPenilaian = \DB::table('penilaian')
                    ->where('id_sub_kriteria', $item->id)
                    ->exists();
                return $item;
            });
    
        return view('pengguna.kriteria.subkriteria', [
            'kriteria' => $kriteria,
            'subKriteria' => $subKriteria,
        ]);
    }
    
    public function update(Request $request, $id)
    {
        $subKriteria = SubKriteria::find($id);
    
        if (!$subKriteria) {
            return redirect()->back()->withErrors('Sub Kriteria tidak ditemukan.');
        }
    
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'nilai_crisp' => 'required|numeric|min:0|max:100',
            'nilai_fuzzy' => 'nullable|numeric|min:0|max:1',
        ]);
    
        $nilaiFuzzy = round($validated['nilai_crisp'] / 100, 4);
    
        $subKriteria->update([
            'nama' => $validated['nama'],
            'nilai_crisp' => $validated['nilai_crisp'],
            'nilai_fuzzy' => isset($validated['nilai_fuzzy']) ? $validated['nilai_fuzzy'] : null,
        ]);
    
        return redirect()->route('pengguna.sub_kriteria.index', $subKriteria->id_kriteria)
            ->with('success', 'Sub Kriteria berhasil diperbarui.');
    }

    // Menyimpan data subkriteria baru
    public function store(Request $request)
    {
        $request->validate([
            'id_kriteria' => 'required|exists:kriteria,id',
            'nama' => 'required|string|max:255',
            'nilai_crisp' => 'required|numeric|min:0|max:100',
            'nilai_fuzzy' => 'required|numeric|min:0|max:1',
        ]);

        $nilaiFuzzy = round($request->nilai_crisp / 100, 4);

        SubKriteria::create([
            'id_kriteria' => $request->id_kriteria,
            'nama' => $request->nama,
            'nilai_crisp' => $validated['nilai_crisp'],
            'nilai_fuzzy' => $validated['nilai_fuzzy'],
        ]);

        return redirect()->route('pengguna.sub_kriteria.index', $request->id_kriteria)
            ->with('success', 'Sub Kriteria berhasil ditambahkan.');
    }
    public function destroy($id)
    {
        $subKriteria = SubKriteria::findOrFail($id);
        $id_kriteria = $subKriteria->id_kriteria;
        $subKriteria->delete();

        return redirect()->route('pengguna.sub_kriteria.index', $id_kriteria)
            ->with('success', 'Sub Kriteria berhasil dihapus.');
    }
}