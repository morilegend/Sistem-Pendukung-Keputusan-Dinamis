@extends('Pengguna Utama.layouts.main')

@section('title', 'Kategori Alternatif')

@section('content')
<!-- Ambil Data CSS untuk Tabel -->
<link href="{{ asset('assets/vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">

<div class="container-fluid">
    <div class="col-xl-4 col-md-6 mb-4">
        <h1 class="mb-5 text-dark">Kategori Alternatif</h1>
    </div>

    <!-- Tambahkan tombol untuk membuat kategori baru -->
    <div class="mb-4 d-flex justify-content-start">
        <button type="button" class="btn btn-primary shadow-sm" data-toggle="modal" data-target="#alternatifCreateModal">
            <i class="fas fa-plus fa-sm text-white-50 mr-2"></i> Tambah Kategori Alternatif
        </button>
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
                            <th style="max-width: 10em">Nama Kriteria Alternatif</th>
                            <th style="max-width: 16em">Keterangan</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($kategoriAlternatif as $alternatif)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td style="resize: none max-width: 10em;">{{ $alternatif->nama }}</td>
                            <td style="resize: none max-width: 16em;">{{ $alternatif->keterangan }}</td>
                            <!-- Button -->
                            <td>
                                <button type="button" class="btn btn-light btn-sm shadow-sm btn-edit text-warning"
                                    data-id="{{ $alternatif->id }}" data-nama="{{ $alternatif->nama }}"
                                    data-keterangan="{{ $alternatif->keterangan }}" data-toggle="modal"
                                    data-target="#alternatifEditModal">
                                    <i class="fas fa-edit mr-2"></i> Ubah
                                </button>
                                <form
                                    action="{{ route('pengguna_utama.kategori_alternatif.destroy', $alternatif->id) }}"
                                    method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    @if(!$alternatif->digunakanDalamPenilaian)
                                    <button type="submit" class="btn btn-light btn-sm shadow-sm text-danger"
                                        onclick="return confirm('Apakah Anda yakin ingin menghapus kategori ini?')">
                                        <i class="fas fa-trash mr-2"></i> Hapus
                                    </button>
                                    @else
                                    <button class="btn btn-light btn-sm shadow-sm" disabled>
                                        <i class="fas fa-trash text-gray-300"></i> Hapus
                                    </button>
                                    @endif
                                </form>
                                <a href="{{ route('pengguna_utama.alternatif.index', ['kategori_id' => $alternatif->id]) }}"
                                    class="btn btn-light btn-sm shadow-sm text-info">
                                    <i class="fas fa-list mr-2"></i> Alternatif
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


@include('Pengguna Utama.alternatif.Kategori_create')
@include('Pengguna Utama.alternatif.Kategori_update')

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

    // Handle Edit Button Click
    $('.btn-edit').on('click', function() {
        const id = $(this).data('id');
        const nama = $(this).data('nama');
        const keterangan = $(this).data('keterangan');

        // Set action URL dynamically
        $('#alternatifEditModal form').attr('action',
            `{{ url('pengguna_utama/kategori_alternatif') }}/${id}`);

        // Populate the input fields with data
        $('#editNamaAlternatif').val(nama);
        $('#editKeterangan').val(keterangan); // Populate keterangan field
    });
});
</script>

