@extends('Pengguna Utama.layouts.main')

@section('title', 'Kategori Penilaian')

@section('content')


<link href="{{ asset('assets/vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">


<div class="container-fluid">
    <div class="col-xl-4 col-md-6 mb-4">
        <h1 class="mb-5 text-dark">Penilaian</h1>
    </div>

    <div class="mb-4 d-flex justify-content-start">
        <button type="button" class="btn btn-primary shadow-sm" data-toggle="modal" data-target="#kategoriCreateModal">
            <i class="fas fa-plus fa-sm text-white-50 mr-2"></i> Tambah Daftar Penilaian
        </button>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-center">
            <h6 class="m-0  text-primary">Daftar Penilaian</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th style="max-width: 16em;">Nama</th>
                            <th style="max-width: 16em;">Kategori Kriteria</th>
                            <th style="max-width: 16em;">Kategori Alternatif</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($kategoriPenilaian as $kategoriGroup)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td style="resize: none max-width: 16em;">{{ $kategoriGroup->first()->nama }}</td>
                            <td style="resize: none max-width: 16em;">
                                {{ $kategoriGroup->first()->kategoriKriteria->nama }}</td>
                            <td style="resize: none max-width: 16em;">
                                {{ $kategoriGroup->first()->kategoriAlternatif->nama }}</td>
                            <td>
                                <form
                                    action="{{ route('pengguna_utama.kategori_penilaian.destroy', $kategoriGroup->first()->id) }} "
                                    method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-light btn-sm shadow-sm text-danger"
                                        onclick="return confirm('Apakah Anda yakin ingin menghapus kategori penilaian ini?')">
                                        <i class="fas fa-trash mr-2"></i> Hapus
                                    </button>
                                </form>
                                @foreach ($kategoriGroup as $kategori)
                                <a href="{{ route('pengguna_utama.penilaian.index', ['kategoriPenilaianId' => $kategori->id]) }}"
                                    class="btn btn-light btn-sm shadow-sm text-info">
                                    <i class="fas fa-edit mr-2"></i> Penilaian
                                </a>
                                @endforeach
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@include('Pengguna Utama.Penilaian.kategori_create')

@endsection

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
<script src="{{ asset('assets/vendor/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('assets/vendor/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('assets/vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>

<script>
$(document).ready(function() {
    $('#dataTable').DataTable({
        info: false,
        paging: true,
        lengthChange: true,
        searching: true,
        ordering: true,
        autoWidth: true,
        columnDefs: [{
            targets: [0],
            orderable: false
        }],
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
</script>

