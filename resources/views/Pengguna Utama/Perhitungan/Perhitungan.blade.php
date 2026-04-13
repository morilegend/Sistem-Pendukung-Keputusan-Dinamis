@extends('Pengguna Utama.layouts.main')

@section('title', 'Perhitungan')

@section('content')

<link href="{{ asset('assets/vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">

<div class="container-fluid">
    <div class="col-xl-4 col-md-6 mb-4">
        <h1 class="mb-5 text-dark">Pilih Perhitungan</h1>
    </div>

    <script>
    @if(session('success'))
    alert("{{ session('success') }}");
    @endif

    @if(session('error'))
    alert("{{ session('error') }}");
    @endif
    </script>

    @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-center">
        </div>
        <div class="card-body">
            <form action="{{ route('pengguna_utama.perhitungan.proses') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="kategori_penilaian" class="form-label">Pilih Pengambilan Keputusan Yang Akan
                        Dihitung</label>
                    <select name="kategori_penilaian" id="kategori_penilaian" class="form-control" required>
                        <option value="" disabled selected>Pilih Penilaian</option>
                        @foreach ($kategori_penilaian as $kategori)
                        <option value="{{ $kategori->id }}">{{ $kategori->nama }}</option>
                        @endforeach
                    </select>
                </div>
                <button type="submit" class="btn btn-primary shadow-sm">
                    <i class="fas fa-sync-alt mr-1"></i> Proses
                </button>
            </form>
        </div>
        <!-- Merupakan Nama Kategori Yang DIpilih -->
    </div>

    @if (session('hasil'))
    @php
    $hasil = session('hasil');
    $kriteria = $hasil->first() ? $hasil->first()['nilai']->keys() : [];
    @endphp

    <div class="mt-5 mb-3 d-flex justify-content-center flex-wrap gap-2">
        <button class="btn btn-info shadow-sm" onclick="showTable('Data-Keputusan')">
            <i class="fas fa-table mr-1"></i> Data Keputusan
        </button>
        <button class="btn btn-success shadow-sm" onclick="showTable('Matriks-Keputusan')">
            <i class="fas fa-th mr-1"></i> Matriks Keputusan
        </button>
        <button class="btn btn-danger shadow-sm" onclick="showTable('Perhitungan-Normalisasi')">
            <i class="fas fa-calculator mr-1"></i> Perhitungan Normalisasi
        </button>
        <button class="btn btn-secondary shadow-sm" onclick="showTable('Tampil-Bobot')">
            <i class="fas fa-weight-hanging mr-1"></i> Tampil Bobot
        </button>
        <button class="btn btn-warning shadow-sm" onclick="showTable('Nilai-Preferensi')">
            <i class="fas fa-star mr-1"></i> Nilai Preferensi
        </button>
        <button class="btn btn-primary shadow-sm" onclick="showTable('Perankingan')">
            <i class="fas fa-trophy mr-1"></i> Perankingan
        </button>
    </div>

    <!-- Data Keputusan -->
    <div id="Data-Keputusan" class="card shadow mt-3 mb-4">
        <div class="card-header py-3 d-flex justify-content-center">
            <h2 class="text-dark ">Perhitungan
                {{ session('kategoriNama', 'Tidak ada kategori yang dipilih') }}</h2>
        </div>
        <div class="card-header py-3 d-flex justify-content-center">
            <h6 class="m-0  text-primary">SAW</h6>
        </div>
        <div class="card-body">
            <!-- SAW Tampil Penilaian Kriteria -->
            <table class="table table-bordered table-striped mt-3">
                <thead class="thead-light">
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
                        <td>{{ $data['alternatif'] }}</td>
                        @foreach ($kriteria as $k)
                        <td>{{ $data['nilai'][$k]['subkriteria'] ?? '-' }}</td>
                        @endforeach
                    </tr>
                    @endforeach
                    <tr class=" bg-info text-white">
                        <td>Tipe</td>
                        @foreach ($kriteria as $k)
                        <td>{{ $data['nilai'][$k]['jenis'] ?? '-' }}</td>
                        @endforeach
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="card-header py-3 d-flex justify-content-center">
            <h6 class="m-0  text-primary">Fuzzy SAW</h6>
        </div>
        <div class="card-body">
            <table class="table table-bordered table-striped mt-3">
                <thead class="thead-light">
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
                        <td>{{ $data['alternatif'] }}</td>
                        @foreach ($kriteria as $k)
                        <td>{{ $data['nilai'][$k]['subkriteria'] ?? '-' }}</td>
                        @endforeach
                    </tr>
                    @endforeach
                    <tr class=" bg-info text-white">
                        <td class="">Tipe</td>
                        @foreach ($kriteria as $k)
                        <td class="">{{ $data['nilai'][$k]['jenis'] ?? '-' }}</td>
                        @endforeach
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Matriks Keputusan -->
    <div id="Matriks-Keputusan" class="card shadow mt-3 mb-4" style="display: none;">
        <div class="card-header py-3 d-flex justify-content-center">
            <h2 class="text-dark ">Perhitungan
                {{ session('kategoriNama', 'Tidak ada kategori yang dipilih') }}</h2>
        </div>
        <div class="card-header py-3 d-flex justify-content-center">
            <h6 class="m-0  text-primary">SAW</h6>
        </div>
        <div class="card-body">
            <!-- SAW Tampil Penilaian Kriteria -->
            <table class="table table-bordered table-striped mt-3">
                <thead class="thead-light">
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
                        <td>{{ $data['alternatif'] }}</td>
                        @foreach ($kriteria as $k)
                        <td>{{ $data['nilai'][$k]['nilai_crisp'] ?? '-' }}</td>
                        @endforeach
                    </tr>
                    @endforeach
                    <tr class=" bg-success text-white">
                        <td>Nilai Cost/Benefit</td>
                        @foreach ($kriteria as $k)
                        @php
                        $optimalCrisp = session('optimalValues')[$k]['crisp'] ?? '-';
                        $type = session('hasil')->first()['nilai'][$k]['jenis'] ?? '-';
                        @endphp
                        <td>{{ $optimalCrisp }}</td>
                        @endforeach
                    </tr>
                </tbody>
            </table>
            <div class="card-header py-3 d-flex justify-content-center">
                <h6 class="m-0  text-primary">SAW Fuzzy</h6>
            </div>
            <table class="table table-bordered table-striped mt-3">
                <thead class="thead-light">
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
                        <td>{{ $data['alternatif'] }}</td>
                        @foreach ($kriteria as $k)
                        <td>{{ $data['nilai'][$k]['nilai_fuzzy'] ?? '-' }}</td>
                        @endforeach
                    </tr>
                    @endforeach
                    <tr class=" bg-success text-white">
                        <td class="">Nilai Cost/Benefit</td>
                        @foreach ($kriteria as $k)
                        @php
                        $optimalFuzzy = session('optimalValues')[$k]['fuzzy'] ?? '-';
                        $type = session('hasil')->first()['nilai'][$k]['jenis'] ?? '-';
                        @endphp
                        <td class="">
                            {{ $type === 'benefit' ? $optimalFuzzy : $optimalFuzzy }}
                        </td>
                        @endforeach
                    </tr>
                </tbody>

            </table>
        </div>
    </div>

    <!-- Perhitungan Normalisasi -->
    <div id="Perhitungan-Normalisasi" class="card shadow mt-3 mb-4" style="display: none;">
        <div class="card-header py-3 d-flex justify-content-center">
            <h2 class="text-dark ">Perhitungan
                {{ session('kategoriNama', 'Tidak ada kategori yang dipilih') }}</h2>
        </div>
        <div class="card-header py-3 d-flex justify-content-center">
            <h6 class="m-0  text-primary">SAW</h6>
        </div>
        <div class="card-body">
            <!-- SAW Tampil Normalisasi -->
            <table class="table table-bordered table-striped mt-3">
                <thead class="thead-light">
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
                        <td>{{ $data['alternatif'] }}</td>
                        @foreach ($kriteria as $k)
                        @php
                        $nilaiCrisp = $data['nilai'][$k]['nilai_crisp'] ?? '-';
                        $type = $data['nilai'][$k]['jenis'] ?? '-';
                        $optimalCrisp = session('optimalValues')[$k]['crisp'] ?? '-';
                        $rumus = $type === 'cost'
                        ? "$optimalCrisp / $nilaiCrisp"
                        : "$nilaiCrisp / $optimalCrisp";
                        $hasilNormalisasi = $type === 'cost'
                        ? ($nilaiCrisp > 0 ? round($optimalCrisp / $nilaiCrisp, 3) : 0)
                        : ($optimalCrisp > 0 ? round($nilaiCrisp / $optimalCrisp, 3) : 0);
                        @endphp
                        <td>
                            {{ $hasilNormalisasi }}
                            <br>
                            <small class="text-muted">({{ $rumus }})</small>
                        </td>
                        @endforeach
                    </tr>
                    @endforeach
                    <tr class=" bg-danger text-white">
                        <td>Nilai Cost/Benefit</td>
                        @foreach ($kriteria as $k)
                        @php
                        $optimalCrisp = session('optimalValues')[$k]['crisp'] ?? '-';
                        @endphp
                        <td>{{ $optimalCrisp }}</td>
                        @endforeach
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="card-header py-3 d-flex justify-content-center">
            <h6 class="m-0  text-primary">SAW Fuzzy</h6>
        </div>
        <div class="card-body">
            <!-- SAW Tampil Normalisasi -->
            <table class="table table-bordered table-striped mt-3">
                <thead class="thead-light">
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
                        <td>{{ $data['alternatif'] }}</td>
                        @foreach ($kriteria as $k)
                        @php
                        $nilaiFuzzy = $data['nilai'][$k]['nilai_fuzzy'] ?? '-';
                        $type = $data['nilai'][$k]['jenis'] ?? '-';
                        $optimalFuzzy = session('optimalValues')[$k]['fuzzy'] ?? '-';
                        $rumus = $type === 'cost'
                        ? "$optimalFuzzy / $nilaiFuzzy"
                        : "$nilaiFuzzy / $optimalFuzzy";
                        $hasilNormalisasi = $type === 'cost'
                        ? ($nilaiFuzzy > 0 ? round($optimalFuzzy / $nilaiFuzzy, 3) : 0)
                        : ($optimalFuzzy > 0 ? round($nilaiFuzzy / $optimalFuzzy, 3) : 0);
                        @endphp
                        <td>
                            {{ $hasilNormalisasi }}
                            <br>
                            <small class="text-muted">({{ $rumus }})</small>
                        </td>
                        @endforeach
                    </tr>
                    @endforeach
                    <tr class=" bg-danger text-white">
                        <td>Nilai Cost/Benefit</td>
                        @foreach ($kriteria as $k)
                        @php
                        $optimalFuzzy = session('optimalValues')[$k]['fuzzy'] ?? '-';
                        @endphp
                        <td>{{ $optimalFuzzy }}</td>
                        @endforeach
                    </tr>
                </tbody>
            </table>
        </div>
    </div>


    <!-- Tampil Bobot -->
    <div id="Tampil-Bobot" class="card shadow mt-3 mb-4" style="display: none;">
        <div class="card-header py-3 d-flex justify-content-center">
            <h2 class="text-dark ">Perhitungan
                {{ session('kategoriNama', 'Tidak ada kategori yang dipilih') }}</h2>
        </div>
        <div class="card-header py-3 d-flex justify-content-center">
            <h6 class="m-0  text-primary">SAW</h6>
        </div>
        <div class="card-body">
            <table class="table">
                <thead class="thead-light">
                    <tr>
                        <th>Kriteria</th>
                        <th>Bobot</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($bobotKriteria as $kriteria => $bobot)
                    <tr>
                        <td>{{ $kriteria }}</td>
                        <td>{{ number_format($bobot, 2) }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="card-header py-3 d-flex justify-content-center">
            <h6 class="m-0  text-primary">SAW Fuzzy</h6>
        </div>
        <div class="card-body">
            <table class="table">
                <thead class="thead-light">
                    <tr>
                        <th>Kriteria</th>
                        <th>Bobot</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($bobotKriteria as $kriteria => $bobot)
                    <tr>
                        <td>{{ $kriteria }}</td>
                        <td>{{ number_format($bobot, 2) }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>



    <!-- Perhitungan Perankingan -->
    <div id="Nilai-Preferensi" class="card shadow mt-3 mb-4" style="display: none;">
        <div class="card-header py-3 d-flex justify-content-center">
            <h6 class="m-0  text-primary">SAW</h6>
        </div>
        <div class="card-body">
            <!-- SAW Tampil Hasil -->
            <table class="table table-bordered table-striped mt-3">
                <thead class="thead-light">
                    <tr>
                        <th>Alternatif</th>
                        <th>Perhitungan</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach (session('calculate', []) as $item)
                    <tr>
                        <td>{{ $item['alternatif'] }}</td>
                        <td>{{ $item['detail_crisp'] }}</td>
                        <td>{{ $item['total_crisp'] }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="card-header py-3 d-flex justify-content-center">
            <h6 class="m-0  text-primary">SAW Fuzzy</h6>
        </div>
        <div class="card-body">
            <!-- SAW Tampil Hasil -->
            <table class="table table-bordered table-striped mt-3">
                <thead class="thead-light">
                    <tr>
                        <th>Alternatif</th>
                        <th>Perhitungan</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach (session('calculate', []) as $item)
                    <tr>
                        <td>{{ $item['alternatif'] }}</td>
                        <td>{{ $item['detail_fuzzy'] }}</td>
                        <td>{{ $item['total_fuzzy'] }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Perankingan -->
    <div id="Perankingan" class="card shadow mt-3 mb-4" style="display: none;">
        <!-- Save Button -->
        <button type="button" class="btn btn-primary btn-block shadow-sm" data-toggle="modal" data-target="#simpanRankingModal">
            <i class="fas fa-save mr-1"></i> Klik Disini Untuk Menyimpan Hasil Ranking
        </button>
        <div class="d-flex justify-content-center mt-4">

        </div>

        <div class="card-header py-3 d-flex justify-content-center">
            <h2 class="text-dark ">Perhitungan
                {{ session('kategoriNama', 'Tidak ada kategori yang dipilih') }}
            </h2>
        </div>
        <div class="card-header py-3 d-flex justify-content-center">
            <h6 class="m-0  text-primary">SAW</h6>
        </div>
        @php
        $ranking = session('ranking', collect([]));
        $ranking = $ranking->sortBy('rank_crisp');
        @endphp
        <div class="card-body">
            <!-- SAW Tampil Hasil -->
            <table class="table table-bordered table-striped mt-3">
                <thead class="thead-light">
                    <tr>
                        <th>Ranking</th>
                        <th>Alternatif</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($ranking as $item)
                    <tr>
                        <td>{{ $item['rank_crisp'] }}</td>
                        <td>{{ $item['alternatif'] }}</td>
                        <td>{{ $item['total_crisp'] }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="card-header py-3 d-flex justify-content-center">
            <h6 class="m-0  text-primary">SAW Fuzzy</h6>
        </div>
        @php
        $ranking = session('ranking', collect([]));
        $ranking = $ranking->sortBy('rank_fuzzy');
        @endphp
        <div class="card-body">
            <!-- SAW Tampil Hasil -->
            <table class="table table-bordered table-striped mt-3">
                <thead class="thead-light">
                    <tr>
                        <th>Ranking</th>
                        <th>Alternatif</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($ranking as $item)
                    <tr>
                        <td>{{ $item['rank_fuzzy'] }}</td>
                        <td>{{ $item['alternatif'] }}</td>
                        <td>{{ $item['total_fuzzy'] }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

@else
<div class="mt-5">
    <p class="text-center">Belum Ada Perhitungan</p>
</div>
@endif

@include('Pengguna Utama.perhitungan.perhitungan_create_ranking')

@endsection



<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
<script src="{{ asset('assets/vendor/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('assets/vendor/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('assets/vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>

<script>
$(document).ready(function() {
    $('#dataTable1, #dataTable2').DataTable({
        info: false,
        paging: false,
        lengthChange: true,
        searching: false,
        ordering: false,
        autoWidth: true,
        language: {
            paginate: {
                previous: 'Prev',
                next: 'Next'
            },
            info: 'Menampilkan _START_ hingga _END_ dari _TOTAL_ entri',
            emptyTable: 'Tidak ada data tersedia',
            zeroRecords: 'Tidak ada data yang cocok ditemukan',
            search: 'Cari:',
            lengthMenu: 'Tampilkan _MENU_ entri',
            infoEmpty: 'Menampilkan 0 hingga 0 dari 0 entri',
            infoFiltered: '(difilter dari _MAX_ total entri)',
        }
    });
});


function showTable(table) {
    if (table === 'Data-Keputusan') {
        $('#Data-Keputusan').show();
        $('#Matriks-Keputusan').hide();
        $('#Nilai-Preferensi').hide();
        $('#Perhitungan-Normalisasi').hide();
        $('#Tampil-Bobot').hide();
        $('#Perankingan').hide();
    } else if (table === 'Matriks-Keputusan') {
        $('#Data-Keputusan').hide();
        $('#Matriks-Keputusan').show();
        $('#Data-Hasi').hide();
        $('#Perhitungan-Normalisasi').hide();
        $('#Tampil-Bobot').hide();
        $('#Perankingan').hide();
    } else if (table === 'Nilai-Preferensi') {
        $('#Data-Keputusan').hide();
        $('#Matriks-Keputusan').hide();
        $('#Nilai-Preferensi').show();
        $('#Perhitungan-Normalisasi').hide();
        $('#Tampil-Bobot').hide();
        $('#Perankingan').hide();
    } else if (table === 'Perhitungan-Normalisasi') {
        $('#Data-Keputusan').hide();
        $('#Matriks-Keputusan').hide();
        $('#Nilai-Preferensi').hide();
        $('#Perhitungan-Normalisasi').show();
        $('#Tampil-Bobot').hide();
        $('#Perankingan').hide();
    } else if (table === 'Tampil-Bobot') {
        $('#Data-Keputusan').hide();
        $('#Matriks-Keputusan').hide();
        $('#Nilai-Preferensi').hide();
        $('#Perhitungan-Normalisasi').hide();
        $('#Tampil-Bobot').show();
        $('#Perankingan').hide();
    } else if (table === 'Perankingan') {
        $('#Data-Keputusan').hide();
        $('#Matriks-Keputusan').hide();
        $('#Nilai-Preferensi').hide();
        $('#Perhitungan-Normalisasi').hide();
        $('#Tampil-Bobot').hide();
        $('#Perankingan').show();
    }
}
</script>
