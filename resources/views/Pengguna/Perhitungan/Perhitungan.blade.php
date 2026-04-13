@extends('Pengguna.layouts.main')

@section('title', 'Perhitungan')

@section('content')

<div class="container-fluid animate-fade-in">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800 ">Proses Perhitungan</h1>
    </div>

    <div class="card shadow mb-5">
        <div class="card-header py-3">
            <h6 class="m-0  text-primary"><i class="fas fa-calculator mr-2"></i> Konfigurasi Perhitungan</h6>
        </div>
        <div class="card-body">
            <form action="{{ route('pengguna.perhitungan.proses') }}" method="POST">
                @csrf
                <div class="row align-items-end">
                    <div class="col-lg-8 mb-3 mb-lg-0">
                        <label for="kategori_penilaian" class="form-label text-dark ">Pilih Pengambilan Keputusan Yang Akan Dihitung</label>
                        <select name="kategori_penilaian" id="kategori_penilaian" class="form-select form-control" required>
                            <option value="" disabled selected>Pilih Kategori Penilaian...</option>
                            @foreach ($kategori_penilaian as $kategori)
                            <option value="{{ $kategori->id }}" {{ session('kategoriId') == $kategori->id ? 'selected' : '' }}>
                                {{ $kategori->nama }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-lg-4">
                        <button type="submit" class="btn btn-primary btn-block shadow-sm py-3">
                            <i class="fas fa-sync-alt mr-2"></i> Mulai Proses Perhitungan
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    @if (session('hasil'))
    @php
    $hasil = session('hasil');
    $kriteria = $hasil->first() ? $hasil->first()['nilai']->keys() : [];
    @endphp

    <div class="d-flex flex-wrap justify-content-center gap-2 mb-5">
        <button class="btn btn-outline-info active shadow-sm mb-2" onclick="showTable('Data-Keputusan', this)">
            <i class="fas fa-database mr-2"></i> Data Keputusan
        </button>
        <button class="btn btn-outline-success shadow-sm mb-2" onclick="showTable('Matriks-Keputusan', this)">
            <i class="fas fa-table mr-2"></i> Matriks Keputusan
        </button>
        <button class="btn btn-outline-danger shadow-sm mb-2" onclick="showTable('Perhitungan-Normalisasi', this)">
            <i class="fas fa-percentage mr-2"></i> Normalisasi
        </button>
        <button class="btn btn-outline-secondary shadow-sm mb-2" onclick="showTable('Tampil-Bobot', this)">
            <i class="fas fa-weight-hanging mr-2"></i> Bobot
        </button>
        <button class="btn btn-outline-warning shadow-sm mb-2" onclick="showTable('Nilai-Preferensi', this)">
            <i class="fas fa-star mr-2"></i> Preferensi
        </button>
        <button class="btn btn-outline-primary shadow-sm mb-2" onclick="showTable('Perankingan', this)">
            <i class="fas fa-trophy mr-2"></i> Perankingan
        </button>
    </div>

    <!-- Data Keputusan -->
    <div id="Data-Keputusan" class="calc-section animate-fade-in">
        <div class="card shadow mb-4">
            <div class="card-header border-bottom-primary">
                <h6 class="m-0  text-primary">Data Keputusan: {{ session('kategoriNama') }}</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Alternatif</th>
                                @foreach ($kriteria as $k)
                                <th>{{ $k }}</th>
                                @endforeach
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($hasil as $data)
                            <tr>
                                <td class=" text-dark">{{ $data['alternatif'] }}</td>
                                @foreach ($kriteria as $k)
                                <td>{{ $data['nilai'][$k]['subkriteria'] ?? '-' }}</td>
                                @endforeach
                            </tr>
                            @endforeach
                            <tr class="bg-light ">
                                <td>Tipe Kriteria</td>
                                @foreach ($kriteria as $k)
                                <td>
                                    <span class="badge {{ $data['nilai'][$k]['jenis'] == 'benefit' ? 'badge-success' : 'badge-warning' }}">
                                        {{ ucfirst($data['nilai'][$k]['jenis'] ?? '-') }}
                                    </span>
                                </td>
                                @endforeach
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Matriks Keputusan (Hidden by default) -->
    <div id="Matriks-Keputusan" class="calc-section animate-fade-in" style="display: none;">
        <div class="card shadow mb-4">
            <div class="card-header border-bottom-success">
                <h6 class="m-0  text-success">Matriks Keputusan (Crisp & Fuzzy)</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr class="bg-light">
                                <th>Alternatif</th>
                                @foreach ($kriteria as $k)
                                <th>{{ $k }}</th>
                                @endforeach
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($hasil as $data)
                            <tr>
                                <td class=" text-dark">{{ $data['alternatif'] }}</td>
                                @foreach ($kriteria as $k)
                                <td>
                                    <div class="text-primary ">{{ $data['nilai'][$k]['nilai_crisp'] ?? '-' }}</div>
                                    <small class="text-muted">Fuzzy: {{ $data['nilai'][$k]['nilai_fuzzy'] ?? '-' }}</small>
                                </td>
                                @endforeach
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Perhitungan Normalisasi -->
    <div id="Perhitungan-Normalisasi" class="calc-section animate-fade-in" style="display: none;">
        <div class="card shadow mb-4">
            <div class="card-header border-bottom-danger">
                <h6 class="m-0  text-danger">Hasil Normalisasi Matriks Ridwan</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Alternatif</th>
                                @foreach ($kriteria as $k)
                                <th>{{ $k }}</th>
                                @endforeach
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($hasil as $data)
                            <tr>
                                <td class=" text-dark">{{ $data['alternatif'] }}</td>
                                @foreach ($kriteria as $k)
                                @php
                                $nilaiCrisp = $data['nilai'][$k]['nilai_crisp'] ?? '-';
                                $type = $data['nilai'][$k]['jenis'] ?? '-';
                                $optimalCrisp = session('optimalValues')[$k]['crisp'] ?? '-';
                                $hasilNormalisasi = $type === 'cost'
                                ? ($nilaiCrisp > 0 ? round($optimalCrisp / $nilaiCrisp, 3) : 0)
                                : ($optimalCrisp > 0 ? round($nilaiCrisp / $optimalCrisp, 3) : 0);
                                @endphp
                                <td>
                                    <div class="h5 mb-0  text-danger">{{ $hasilNormalisasi }}</div>
                                </td>
                                @endforeach
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Tampil Bobot -->
    <div id="Tampil-Bobot" class="calc-section animate-fade-in" style="display: none;">
        <div class="card shadow mb-4 col-lg-6 mx-auto">
            <div class="card-header">
                <h6 class="m-0  text-secondary">Nilai Bobot Kriteria</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr class="bg-light">
                                <th>Kriteria</th>
                                <th class="text-right">Bobot</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($bobotKriteria as $kriteria_nama => $bobot)
                            <tr>
                                <td class="">{{ $kriteria_nama }}</td>
                                <td class="text-right">
                                    <span class="badge badge-secondary px-3 py-2">{{ number_format($bobot, 3) }}</span>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Nilai Preferensi -->
    <div id="Nilai-Preferensi" class="calc-section animate-fade-in" style="display: none;">
        <div class="card shadow mb-4">
            <div class="card-header border-bottom-warning">
                <h6 class="m-0  text-warning">Perhitungan Nilai Preferensi</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Alternatif</th>
                                <th>Proses Perhitungan (Crisp)</th>
                                <th class="text-center">Total Akhir</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach (session('calculate', []) as $item)
                            <tr>
                                <td class=" text-dark">{{ $item['alternatif'] }}</td>
                                <td class="small text-muted">{{ $item['detail_crisp'] }}</td>
                                <td class="text-center">
                                    <div class="badge badge-warning px-4 py-2 h5 mb-0">{{ $item['total_crisp'] }}</div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Perankingan -->
    <div id="Perankingan" class="calc-section animate-fade-in" style="display: none;">
        <div class="d-flex justify-content-end mb-4">
            @if(Auth::user()->akses_simpan_perhitungan)
            <button type="button" class="btn btn-success shadow-sm" data-toggle="modal" data-target="#simpanRankingModal">
                <i class="fas fa-save mr-2"></i> Simpan Hasil Perankingan
            </button>
            @endif
        </div>

        <div class="row">
            <div class="col-lg-12">
                <div class="card shadow mb-4">
                    <div class="card-header border-bottom-primary">
                        <h6 class="m-0  text-primary">Hasil Akhir Perankingan (SAW)</h6>
                    </div>
                    <div class="card-body">
                        @php
                        $ranking = session('ranking', collect([]))->sortBy('rank_crisp');
                        @endphp
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr class="bg-light">
                                        <th width="100">Rank</th>
                                        <th>Alternatif</th>
                                        <th class="text-center">Skor Akhir</th>
                                    </tr>
                                </thead>
                                tbody>
                                    @foreach ($ranking as $item)
                                    <tr>
                                        <td>
                                            @if($item['rank_crisp'] <= 3)
                                            <span class="badge badge-primary rounded-circle p-3" style="width: 40px; height: 40px; display: flex; align-items: center; justify-content: center;">{{ $item['rank_crisp'] }}</span>
                                            @else
                                            <span class="text-muted ml-3 ">{{ $item['rank_crisp'] }}</span>
                                            @endif
                                        </td>
                                        <td class=" text-dark">{{ $item['alternatif'] }}</td>
                                        <td class="text-center">
                                            <span class="h5  text-primary">{{ $item['total_crisp'] }}</span>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @else
    <div class="text-center py-5">
        <img src="https://illustrations.popsy.co/amber/waiting-for-customer.svg" style="max-width: 300px;" class="mb-4">
        <h4 class="text-muted">Belum ada perhitungan yang diproses</h4>
        <p class="text-muted small">Silakan pilih kategori keputusan di atas untuk memulai.</p>
    </div>
    @endif
</div>

@include('Pengguna.perhitungan.perhitungan_create_ranking')

@endsection

<script>
function showTable(sectionId, element) {
    // Hide all sections
    document.querySelectorAll('.calc-section').forEach(section => {
        section.style.display = 'none';
    });
    
    // Show selected section
    document.getElementById(sectionId).style.display = 'block';
    
    // Update active button state
    document.querySelectorAll('.btn-outline-info, .btn-outline-success, .btn-outline-danger, .btn-outline-secondary, .btn-outline-warning, .btn-outline-primary').forEach(btn => {
        btn.classList.remove('active');
    });
    element.classList.add('active');
}
</script>
