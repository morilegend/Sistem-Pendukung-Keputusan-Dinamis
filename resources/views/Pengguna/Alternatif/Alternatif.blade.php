@extends('Pengguna.layouts.main')

@section('title', 'Daftar Alternatif')

@section('content')
<!-- Ambil Data CSS untuk Tabel -->
<link href="{{ asset('assets/vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">

<div class="container-fluid">
    <div>
        @if(request()->kategori_id)
        <h1 class="mb-5 text-dark">Alternatif {{ $kategori ? $kategori->nama : 'Tidak Ada' }}</h1>
        @endif
    </div>


    <!-- Tambah Alternatif -->
    @if(Auth::user()->akses_alternatif)
    <div class="mb-4 d-flex justify-content-start">
        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#alternatifCreateModal">
            Tambah Alternatif
        </button>
    </div>
    @endif

    <!-- Tabel Alternatif -->
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-center">
            <h6 class="m-0  text-primary">Daftar Alternatif</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th style="none max-width: 16em">Nama</th>
                            <th style="none max-width: 16em">Keterangan</th>
                            @if(Auth::user()->akses_alternatif)
                            <th>Aksi</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($alternatif as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td style="resize: none max-width: 16em">{{ $item->nama }}</td>
                            <td style="resize: none max-width: 16em">{{ $item->keterangan }}</td>
                            @if(Auth::user()->akses_alternatif)
                            <td>
                                <button type="button" class="btn btn-light btn-sm shadow-sm btn-edit text-warning" data-id="{{ $item->id }}"
                                    data-nama="{{ $item->nama }}" data-keterangan="{{ $item->keterangan }}"
                                    data-status="{{ $item->status }}"
                                    data-id_kategori="{{ $item->id_kategori_alternatif }}" data-toggle="modal"
                                    data-target="#alternatifEditModal">
                                    <i class="fas fa-edit mr-1"></i> Ubah
                                </button>

                                <form action="{{ route('pengguna.alternatif.destroy', $item->id) }}" method="POST"
                                    style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-light btn-sm shadow-sm text-danger"
                                        onclick="return confirm('Yakin ingin menghapus?')">
                                        <i class="fas fa-trash mr-1"></i> Hapus
                                    </button>
                                </form>


                            </td>
                            @endif
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Include Modal Create -->
@if(Auth::user()->akses_alternatif)
@include('Pengguna.alternatif.Alternatif_create')
@include('Pengguna.alternatif.Alternatif_update')
@endif
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
        const status = $(this).data('status');
        const id_kategori = $(this).data('id_kategori');

        // Set action URL dynamically
        $('#alternatifEditModal form').attr('action',
            `{{ route('pengguna.alternatif.update', '') }}/${id}`);

        // Populate the input fields with data
        $('#editNamaAlternatif').val(nama);
        $('#editKeterangan').val(keterangan);
    });
});
</script>

