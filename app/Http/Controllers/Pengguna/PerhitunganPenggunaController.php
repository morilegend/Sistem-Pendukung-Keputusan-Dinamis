<?php

namespace App\Http\Controllers\Pengguna;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\KategoriPenilaian;
use App\Models\Kriteria;
use App\Models\KategoriHasil;
use App\Models\Hasil;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PerhitunganPenggunaController extends Controller
{
    public function index(Request $request)
    {
    
        $loggedInUserId = auth()->id();
        $userId = DB::table('anggota')->where('id', $loggedInUserId)->value('users_id');
        $kategori_penilaian = KategoriPenilaian::where('users_id', $userId)->get();
        $hasil = $request->session()->get('hasil', null);
        $normalisasiHasil = $request->session()->get('normalisasiHasil', null);
        $bobotKriteria = $request->session()->get('bobotKriteria', null);

        
        return view('Pengguna.perhitungan.perhitungan', compact('kategori_penilaian', 'hasil', 'normalisasiHasil', 'bobotKriteria'));
    }

    public function proses(Request $request)
    {
        
        try {
            $kategoriId = $request->input('kategori_penilaian');
            $kategori = $this->getKategori($kategoriId);
    
            $penilaian = $this->getPenilaian($kategori);
            $nilaiGrouped = $this->calculateOptimalValues($penilaian);
            $hasil = $this->groupAlternatif($penilaian);
            $normalisasiHasil = $this->normalisasiValue($penilaian, $nilaiGrouped);
    
            //Kategori Penialaian
            $kategoriPenilaian = KategoriPenilaian::where('id', $kategoriId)->first();
            $kategoriKriteria = $kategoriPenilaian->id_kategori_kriteria;


            $optimalValues = $this->mapOptimalValues($nilaiGrouped, $penilaian);
            $bobotKriteria = Kriteria::where('id_kategori_kriteria', $kategoriKriteria)
            ->get(['nama', 'bobot_decimal'])
            ->pluck('bobot_decimal', 'nama')
            ->toArray();
            
            $calculate = $this->calculateRankingWithoutSort($normalisasiHasil, $bobotKriteria);
            $ranking = $this->calculateRanking($normalisasiHasil, $bobotKriteria);
    
            $request->session()->put('kategori_penilaian', $kategoriId);
            $request->session()->put('ranking', $ranking);
            $request->session()->put('data_ranking_simpan', $ranking);
    
            return redirect()->route('pengguna.perhitungan.index')
                ->with('hasil', $hasil)
                ->with('normalisasiHasil', $normalisasiHasil)
                ->with('optimalValues', $optimalValues)
                ->with('ranking', $ranking)
                ->with('calculate', $calculate)
                ->with('bobotKriteria', $bobotKriteria)
                ->with('kategoriNama', $kategori->nama);
    
        } catch (\Exception $e) {
            return redirect()->route('pengguna.perhitungan.index')
                ->with('error', $e->getMessage());
        }
    }
    

    public function getKategori($kategoriId)
    {
        $kategori = KategoriPenilaian::find($kategoriId);
        if (!$kategori) {
            throw new \Exception('Kategori penilaian tidak ditemukan.');
        }
        return $kategori;
    }

    public function getPenilaian($kategori)
    {
        $penilaian = $kategori->penilaian()
            ->with(['alternatif', 'kriteria', 'subkriteria'])
            ->get();
    
        // Cek apakah subkriteria ada
        if ($penilaian->isEmpty() || $penilaian->pluck('subkriteria')->isEmpty()) {
            throw new \Exception('Data penilaian atau subkriteria tidak ditemukan.');
        }
    
        return $penilaian;
    }
    

    public function calculateOptimalValues($penilaian)
    {
        return $penilaian->groupBy('kriteria.id')->map(function ($group) {
            $type = $group->first()->kriteria->jenis ?? '-';
            $crispValues = $group->pluck('subkriteria.nilai_crisp')->filter()->toArray();
            $fuzzyValues = $group->pluck('subkriteria.nilai_fuzzy')->filter()->toArray();
            if (empty($crispValues) && empty($fuzzyValues)) {
                throw new \Exception('Subkriteria tidak memiliki nilai yang valid.');
            }
    
            return [
                'type' => $type,
                'optimalCrisp' => $type === 'cost' && !empty($crispValues) ? min($crispValues) : (!empty($crispValues) ? max($crispValues) : 0),
                'optimalFuzzy' => $type === 'cost' && !empty($fuzzyValues) ? min($fuzzyValues) : (!empty($fuzzyValues) ? max($fuzzyValues) : 0),
            ];
        });
        $request->session()->forget([
            'kategori_penilaian',
            'data_ranking_simpan',
            'ranking',
            'hasil',
            'normalisasiHasil',
            'bobotKriteria',
        ]);
    }
    

    public function groupAlternatif($penilaian)
    {
        return $penilaian->groupBy('alternatif.id')->map(function ($group) {
            $alternatif = $group->first()->alternatif;

            if (!$alternatif) {
                return ['alternatif' => 'Data alternatif tidak ditemukan', 'nilai' => []];
            }
            $nilaiKriteria = $group->mapWithKeys(function ($item) {
                $kriteriaName = $item->kriteria->nama;
                $type = $item->kriteria->jenis ?? '-';
                $crispValue = $item->subkriteria->nilai_crisp ?? 0;
                $fuzzyValue = $item->subkriteria->nilai_fuzzy ?? 0;

                return [
                    $kriteriaName => [
                        'jenis' => $type,
                        'subkriteria' => $item->subkriteria->nama ?? '-',
                        'nilai_crisp' => $crispValue,
                        'nilai_fuzzy' => $fuzzyValue,
                    ],
                ];
            });

            return [
                'alternatif' => $alternatif->nama,
                'nilai' => $nilaiKriteria,
            ];
        });
    }

    public function normalisasiValue($penilaian, $nilaiGrouped)
    {
        return $penilaian->groupBy('kriteria.id')->map(function ($group, $kriteriaId) use ($nilaiGrouped) {
            $kriteria = $group->first()->kriteria;
            $type = $kriteria->jenis ?? '-';
            $optimalCrisp = $nilaiGrouped[$kriteriaId]['optimalCrisp'] ?? 0;
            $optimalFuzzy = $nilaiGrouped[$kriteriaId]['optimalFuzzy'] ?? 0;
    
            // Cek apakah nilai crisp atau fuzzy kosong
            if ($optimalCrisp == 0 && $optimalFuzzy == 0) {
                throw new \Exception("Tidak ada nilai optimal untuk kriteria {$kriteria->nama}");
            }
    
            $normalisasi = $group->map(function ($item) use ($optimalCrisp, $optimalFuzzy, $type) {
                $alternatif = $item->alternatif->nama ?? '-';
                $crispValue = $item->subkriteria->nilai_crisp ?? 0;
                $fuzzyValue = $item->subkriteria->nilai_fuzzy ?? 0;
    
                if ($crispValue == 0 && $fuzzyValue == 0) {
                    throw new \Exception("Nilai subkriteria untuk alternatif {$alternatif} kosong.");
                }
    
                $normalizedCrisp = $type === 'cost'
                    ? ($crispValue > 0 ? $optimalCrisp / $crispValue : 0)
                    : ($optimalCrisp > 0 ? $crispValue / $optimalCrisp : 0);
    
                $normalizedFuzzy = $type === 'cost'
                    ? ($fuzzyValue > 0 ? $optimalFuzzy / $fuzzyValue : 0)
                    : ($optimalFuzzy > 0 ? $fuzzyValue / $optimalFuzzy : 0);
    
                return [
                    'alternatif' => $alternatif,
                    'normalized_crisp' => round($normalizedCrisp, 3),
                    'normalized_fuzzy' => round($normalizedFuzzy, 3),
                ];
            });
    
            return [
                'kriteria' => $kriteria->nama,
                'type' => $type,
                'optimal' => [
                    'crisp' => $optimalCrisp,
                    'fuzzy' => $optimalFuzzy,
                ],
                'normalisasi' => $normalisasi,
            ];
        });
    }
    

    public function mapOptimalValues($nilaiGrouped, $penilaian)
    {
        return $nilaiGrouped->mapWithKeys(function ($value, $key) use ($penilaian) {
            $kriteria = $penilaian->firstWhere('kriteria.id', $key)->kriteria->nama;
            return [
                $kriteria => [
                    'crisp' => $value['optimalCrisp'],
                    'fuzzy' => $value['optimalFuzzy'],
                ],
            ];
        });
    }

    public function calculateRanking($normalisasiHasil, $bobotKriteria)
    {
        // Hitung nilai SAW untuk setiap alternatif
        $ranking = collect($normalisasiHasil)->flatMap(function ($item) use ($bobotKriteria) {
            return $item['normalisasi']->map(function ($data) use ($item, $bobotKriteria) {
                $kriteriaName = $item['kriteria'];
                $bobot = $bobotKriteria[$kriteriaName] ?? 1; // Default bobot 1 jika tidak ada bobot
                $weightedCrisp = $data['normalized_crisp'] * $bobot;
                $weightedFuzzy = $data['normalized_fuzzy'] * $bobot;
    
                return [
                    'alternatif' => $data['alternatif'],
                    'kriteria' => $kriteriaName,
                    'normalized_crisp' => $data['normalized_crisp'],
                    'normalized_fuzzy' => $data['normalized_fuzzy'],
                    'bobot' => $bobot,
                    'weighted_crisp' => $weightedCrisp,
                    'weighted_fuzzy' => $weightedFuzzy,
                ];
            });
        });
    
        // Detail perhitungan untuk setiap alternatif
        $detailedRanking = $ranking->groupBy('alternatif')->map(function ($group, $alternatif) {
            $perhitunganCrisp = $group->map(function ($item) {
                return "({$item['normalized_crisp']} * {$item['bobot']})";
            })->join(' + ');
    
            $perhitunganFuzzy = $group->map(function ($item) {
                return "({$item['normalized_fuzzy']} * {$item['bobot']})";
            })->join(' + ');
    
            $totalCrisp = $group->sum('weighted_crisp');
            $totalFuzzy = $group->sum('weighted_fuzzy');
    
            return [
                'alternatif' => $alternatif,
                'total_crisp' => round($totalCrisp, 3),
                'total_fuzzy' => round($totalFuzzy, 3),
                'detail_crisp' => $perhitunganCrisp,
                'detail_fuzzy' => $perhitunganFuzzy,
            ];
        });
    
        // Ranking berdasarkan total nilai crisp dan fuzzy
        $rankedResult = $detailedRanking
            ->sortByDesc('total_fuzzy') 
            ->values()
            ->map(function ($item, $index) {
                $item['rank_fuzzy'] = $index + 1;
                return $item;
            })
            ->sortByDesc('total_crisp')
            ->values()
            ->map(function ($item, $index) {
                $item['rank_crisp'] = $index + 1;
                return $item;
            });
    
        return $rankedResult;

        $request->session()->forget([
            'kategori_penilaian',
            'data_ranking_simpan',
            'ranking',
            'hasil',
            'normalisasiHasil',
            'bobotKriteria',
        ]);
    }

    public function calculateRankingWithoutSort($normalisasiHasil, $bobotKriteria)
    {
        // Hitung nilai SAW untuk setiap alternatif
        $ranking = collect($normalisasiHasil)->flatMap(function ($item) use ($bobotKriteria) {
            return $item['normalisasi']->map(function ($data) use ($item, $bobotKriteria) {
                $kriteriaName = $item['kriteria'];
                $bobot = $bobotKriteria[$kriteriaName] ?? 1; // Default bobot 1 jika tidak ada bobot
                $weightedCrisp = $data['normalized_crisp'] * $bobot;
                $weightedFuzzy = $data['normalized_fuzzy'] * $bobot;

                return [
                    'alternatif' => $data['alternatif'],
                    'kriteria' => $kriteriaName,
                    'normalized_crisp' => $data['normalized_crisp'],
                    'normalized_fuzzy' => $data['normalized_fuzzy'],
                    'bobot' => $bobot,
                    'weighted_crisp' => $weightedCrisp,
                    'weighted_fuzzy' => $weightedFuzzy,
                ];
            });
        });

        // Detail perhitungan untuk setiap alternatif
        $detailedRanking = $ranking->groupBy('alternatif')->map(function ($group, $alternatif) {
            $perhitunganCrisp = $group->map(function ($item) {
                return "({$item['normalized_crisp']} * " . number_format($item['bobot'], 2) . ")";
            })->join(' + ');
            
            $perhitunganFuzzy = $group->map(function ($item) {
                return "({$item['normalized_fuzzy']} * " . number_format($item['bobot'], 2) . ")";
            })->join(' + ');

            $totalCrisp = $group->sum('weighted_crisp');
            $totalFuzzy = $group->sum('weighted_fuzzy');

            return [
                'alternatif' => $alternatif,
                'total_crisp' => round($totalCrisp, 3),
                'total_fuzzy' => round($totalFuzzy, 3),
                'detail_crisp' => $perhitunganCrisp,
                'detail_fuzzy' => $perhitunganFuzzy,
            ];
        });
        
        return $detailedRanking->values();

        $request->session()->forget([
            'kategori_penilaian',
            'data_ranking_simpan',
            'ranking',
            'hasil',
            'normalisasiHasil',
            'bobotKriteria',
        ]);
        
    }
    public function simpanRanking(Request $request)
    {

        $kategoriId = $request->session()->get('kategori_penilaian');
        $dataranking = $request->session()->get('data_ranking_simpan');
        $loggedInUserId = auth()->id();
        // Simpan Kategori Hasil
        $kategoriHasil = KategoriHasil::create([
            'id_kategori_penilaian' => $kategoriId,
            'users_id' => DB::table('anggota')->where('id', $loggedInUserId)->value('users_id'),
            'nama' => $request->kategori_nama,
            
        ]);

        foreach ($dataranking as $item) {
            Hasil::updateOrCreate(
                [
                    'alternatif' => $item['alternatif'],
                    'id_kategori_hasil' => $kategoriHasil->id,
                ],
                [
                    'ranking' => $item['rank_crisp'],
                    'penilaian' => $item['total_crisp'],
                    'alternatif_fuzzy' => $item['alternatif'],
                    'ranking_fuzzy' => $item['rank_fuzzy'],
                    'penilaian_fuzzy' => $item['total_fuzzy'],
                ]
            );
        }

        $request->session()->forget([
            'kategori_penilaian',
            'data_ranking_simpan',
            'ranking',
            'hasil',
            'normalisasiHasil',
            'bobotKriteria',
        ]);
    
        // Setelah data berhasil disimpan, bisa mengarahkan ke halaman tertentu dengan pesan sukses
        return redirect()->route('pengguna.perhitungan.index')
            ->with('success', 'Ranking berhasil disimpan');
    }
    
}