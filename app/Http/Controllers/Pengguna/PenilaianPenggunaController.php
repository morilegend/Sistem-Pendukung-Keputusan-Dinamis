<?php

namespace App\Http\Controllers\Pengguna;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Penilaian;
use App\Models\KategoriPenilaian;
use App\Models\Alternatif;
use App\Models\Kriteria;
use App\Models\SubKriteria;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PenilaianPenggunaController extends Controller
{
    public function index($kategoriPenilaianId)
    {
        try {
            // Validasi apakah Kategori Penilaian ada
            $kategoriPenilaian = KategoriPenilaian::findOrFail($kategoriPenilaianId);

            // Data penilaian, dikelompokkan berdasarkan alternatif
            $penilaian = Penilaian::where('id_kategori_penilaian', $kategoriPenilaianId)
                ->get()
                ->groupBy('id_alternatif')
                ->map(function ($group) {
                    return $group->first();
                });

            // Alternatif yang digunakan
            $usedAlternatives = Penilaian::where('id_kategori_penilaian', $kategoriPenilaianId)
                ->pluck('id_alternatif')
                ->toArray();

            // Alternatif dan kriteria terkait
            $alternatif = Alternatif::where('id_kategori_alternatif', $kategoriPenilaian->id_kategori_alternatif)->get();
            $kriteria = Kriteria::with('sub_kriteria')
                ->where('id_kategori_kriteria', $kategoriPenilaian->id_kategori_kriteria)
                ->get();

            return view('Pengguna.Penilaian.Penilaian', [
                'kategoriPenilaian' => $kategoriPenilaian,
                'penilaian' => $penilaian,
                'alternatif' => $alternatif,
                'kriteria' => $kriteria,
                'usedAlternatives' => $usedAlternatives,
            ]);
        } catch (\Exception $e) {
            return redirect()->route('dashboard')
                ->with('error', 'Data tidak ditemukan: ' . $e->getMessage());
        }
    }

    public function store(Request $request)
    {
        

        $request->validate([
            'penilaian_data' => 'required|array|min:1',
            'penilaian_data.*.alternatif_id' => 'required|exists:alternatif,id',
            'penilaian_data.*.id_kategori_penilaian' => 'required|exists:kategori_penilaian,id',
            'penilaian_data.*.id_kriteria' => 'required|exists:kriteria,id',
            'penilaian_data.*.id_sub_kriteria' => 'required|exists:sub_kriteria,id',
        ]);
        $penilaianData = $request->input('penilaian_data');
        

        try {
            foreach ($penilaianData as $data) {
                Penilaian::create([
                    'id_alternatif' => $data['alternatif_id'],
                    'id_kategori_penilaian' => $data['id_kategori_penilaian'],
                    'id_kriteria' => $data['id_kriteria'],
                    'id_sub_kriteria' => $data['id_sub_kriteria'],
                ]);
            }
            return redirect()->route('pengguna.penilaian.index', ['kategoriPenilaianId' => $penilaianData[0]['id_kategori_penilaian']])
                ->with('success', 'Penilaian berhasil disimpan!');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan saat menyimpan penilaian: ' . $e->getMessage());
        }
    }


    public function show($id)
    {
        try {
            // Ambil data Alternatif berdasarkan ID
            $alternatif = Alternatif::findOrFail($id);
            
            // Ambil Penilaian yang terkait dengan alternatif ini
            $penilaian = Penilaian::where('id_alternatif', $alternatif->id)->get();
            
            $kriteria = Kriteria::with(['sub_kriteria' => function ($query) use ($penilaian) {
                $query->whereIn('id', $penilaian->pluck('id_sub_kriteria'));
            }])
            ->whereIn('id', $penilaian->pluck('id_kriteria'))
            ->get();
    
            return response()->json([
                'success' => true,
                'alternatif' => $alternatif,
                'penilaian' => $penilaian,
                'kriteria' => $kriteria,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Data tidak ditemukan: ' . $e->getMessage(),
            ], 404);
        }
    }
    public function deleteByAlternatif($id_alternatif)
    {
        try {
            // Menghapus semua data dengan id_alternatif yang sama
            Penilaian::where('id_alternatif', $id_alternatif)->delete();
    
            return redirect()->back()->with('success', 'Semua penilaian untuk alternatif terkait berhasil dihapus!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menghapus penilaian: ' . $e->getMessage());
        }
    }

    public function getSubKriteriaByKriteria($id_kriteria)
    {
        $subKriteria = SubKriteria::where('id_kriteria', $id_kriteria)->get();
        return response()->json($subKriteria);
    }
}