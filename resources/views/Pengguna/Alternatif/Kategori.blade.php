@extends('Pengguna.layouts.main')

@section('title', 'Kategori Alternatif')

@section('content')
<!-- Ambil Data CSS untuk Tabel -->
<link href="{{ asset('assets/vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">

<div class="container-fluid">
    <div class="col-xl-4 col-md-6 mb-4">
        <h1 class="mb-5 text-dark">Kategori Alternatif</h1>
    </div>

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <!-- gunakan d-flex justify-content-center untuk membuat text menjadi ditengah -->
        <div class="card-header py-3 d-flex justify-content-center">
            <h6 class="m-0  text-primary">Daftar Kategori Alternatif</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th style="max-width: 16em;">Nama Kriteria Alternatif</th>
                            <th style="max-width: 16em;">Keterangan</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($kategoriAlternatif as $alternatif)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td style="resize: none max-width: 16em">{{ $alternatif->nama }}</td>
                            <td style="resize: none max-width: 16em">{{ $alternatif->keterangan }}</td>
                            <!-- Button -->
                            <td>
                                <a href="{{ route('pengguna.alternatif.index', ['kategori_id' => $alternatif->id]) }}"
                                    class="btn btn-light btn-sm shadow-sm text-info">
                                    <i class="fas fa-list mr-1"></i> Alternatif
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>


@endsection

<!-- All Scripts -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
<script src="{{ asset('assets/vendor/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('assets/vendor/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('assets/vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>

<script>
$(document).ready(function() {
    $('#dataTable').DataTable({
        info: false,
        paging: true, // Menampilkan navigasi halaman
        lengthChange: true, // Menampilkan form select jumlah baris per halaman
        searching: true, // Menampilkan input pencarian
        ordering: true, // Menampilkan kolom dapat diurutkan
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
            emptyTable: 'Tidak ada data tersedia', // Mengubah "No data available"
            zeroRecords: 'Tidak ada data yang cocok ditemukan', // Mengubah "No matching records found"
            search: 'Cari:', // Mengubah teks label pencarian
            lengthMenu: 'Tampilkan _MENU_ entri', // Mengubah teks dropdown jumlah entri per halaman
            infoEmpty: 'Menampilkan 0 hingga 0 dari 0 entri', // Mengubah teks info saat tabel kosong
            infoFiltered: '(difilter dari _MAX_ total entri)', // Mengubah teks info setelah filter
        }
    });
});
</script>
