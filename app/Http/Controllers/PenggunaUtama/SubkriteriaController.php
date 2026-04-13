<?php

namespace App\Http\Controllers\PenggunaUtama;

use App\Http\Controllers\Controller;
use App\Models\SubKriteria;
use App\Models\Kriteria;
use Illuminate\Http\Request;

class SubKriteriaController extends Controller
{
    // Menampilkan daftar subkriteria berdasarkan kriteria tertentu
    public function index($id_kriteria)
    {
        $kriteria = Kriteria::findOrFail($id_kriteria);
        $subKriteria = SubKriteria::where('id_kriteria', $id_kriteria)
            ->get()
            ->map(function ($item) {
                $item->digunakanDalamPenilaian = \DB::table('penilaian')
                    ->where('id_sub_kriteria', $item->id)
                    ->exists();
                return $item;
            });
    
        return view('Pengguna Utama.kriteria.subkriteria', [
            'kriteria' => $kriteria,
            'subKriteria' => $subKriteria,
            'maxFuzzy' => $maxFuzzy ?? 0,
        ]);
    }
    
    // Mengupdate data subkriteria
    public function update(Request $request, $id)
    {
        $subKriteria = SubKriteria::find($id);
    
        if (!$subKriteria) {
            return redirect()->back()->withErrors('Sub Kriteria tidak ditemukan.');
        }
    
        // Validate incoming data
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'nilai_crisp' => 'required|numeric|min:0|max:100',
            'nilai_fuzzy' => 'nullable|numeric|min:0|max:1',
        ]);
    
        // Cek apakah nilai_fuzzy baru lebih kecil dari nilai yang sudah ada
        if (isset($validated['nilai_fuzzy']) && $validated['nilai_fuzzy'] < $subKriteria->nilai_fuzzy) {
            return redirect()->back()->withErrors('Nilai fuzzy tidak boleh lebih kecil dari nilai yang sudah ada (' . $subKriteria->nilai_fuzzy . ').');
        }
    
        // Update the SubKriteria
        $subKriteria->update([
            'nama' => $validated['nama'],
            'nilai_crisp' => $validated['nilai_crisp'],
            'nilai_fuzzy' => isset($validated['nilai_fuzzy']) ? $validated['nilai_fuzzy'] : $subKriteria->nilai_fuzzy,
        ]);
    
        return redirect()->route('pengguna_utama.sub_kriteria.index', $subKriteria->id_kriteria)
            ->with('success', 'Sub Kriteria berhasil diperbarui.');
    }

    // Menyimpan data subkriteria baru
    public function store(Request $request)
    {
        $validated = $request->validate([
            'id_kriteria' => 'required|exists:kriteria,id',
            'nama' => 'required|string|max:255',
            'nilai_crisp' => 'required|numeric|min:0|max:100',
            'nilai_fuzzy' => 'required|numeric|min:0|max:1',
        ]);
    
        // Cek apakah ada nilai_fuzzy yang lebih besar pada kriteria terkait
        $existingMaxFuzzy = SubKriteria::where('id_kriteria', $validated['id_kriteria'])->max('nilai_fuzzy');
        if ($existingMaxFuzzy !== null && $validated['nilai_fuzzy'] < $existingMaxFuzzy) {
            return redirect()->back()->withErrors('Nilai fuzzy tidak boleh lebih kecil dari nilai fuzzy tertinggi yang ada (' . $existingMaxFuzzy . ').');
        }
    
        // Store the new subKriteria
        SubKriteria::create([
            'id_kriteria' => $validated['id_kriteria'],
            'nama' => $validated['nama'],
            'nilai_crisp' => $validated['nilai_crisp'],
            'nilai_fuzzy' => $validated['nilai_fuzzy'],
        ]);
    
        return redirect()->route('pengguna_utama.sub_kriteria.index', $validated['id_kriteria'])
            ->with('success', 'Sub Kriteria berhasil ditambahkan.');
    }
    
    public function destroy($id)
    {
        $subKriteria = SubKriteria::findOrFail($id);
        $id_kriteria = $subKriteria->id_kriteria;
        $isDigunakan = \DB::table('penilaian')
            ->where('id_sub_kriteria', $subKriteria->id)
            ->exists();
    
        if ($isDigunakan) {
            return redirect()->route('pengguna_utama.sub_kriteria.index', $id_kriteria)
                ->with('error', 'Sub Kriteria tidak dapat dihapus karena sedang digunakan dalam penilaian.');
        }
        $subKriteria->delete();
    
        return redirect()->route('pengguna_utama.sub_kriteria.index', $id_kriteria)
            ->with('success', 'Sub Kriteria berhasil dihapus.');
    }
}