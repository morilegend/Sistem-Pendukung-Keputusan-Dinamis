@extends('Pengguna Utama.layouts.main')

@section('title', 'Kategori Kriteria')

@section('content')

<div class="container-fluid animate-fade-in">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800 ">Pengaturan Kategori Kriteria</h1>
        <button type="button" class="btn btn-primary shadow-sm" data-toggle="modal" data-target="#kategoriCreateModal">
            <i class="fas fa-plus fa-sm text-white-50 mr-2"></i> Tambah Kategori
        </button>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0  text-primary">Daftar Kategori Kriteria</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th width="50">No</th>
                            <th>Nama Kategori</th>
                            <th>Keterangan</th>
                            <th width="200" class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($kategoriKriteria as $kategori)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td class=" text-dark">{{ $kategori->nama }}</td>
                            <td class="text-muted small">{{ \Illuminate\Support\Str::limit($kategori->keterangan, 100) }}</td>
                            <td class="text-center">
                                <div class="d-flex justify-content-center gap-2">
                                    <button type="button" class="btn btn-light btn-sm shadow-sm btn-edit text-warning"
                                        data-id="{{ $kategori->id }}" data-nama="{{ $kategori->nama }}"
                                        data-keterangan="{{ $kategori->keterangan }}" data-toggle="modal"
                                        data-target="#kategoriEditModal" title="Ubah">
                                        <i class="fas fa-edit mr-2"></i> Ubah
                                    </button>

                                    <form action="{{ route('pengguna_utama.kategori_kriteria.destroy', $kategori->id) }}"
                                        method="POST" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        @if(!$kategori->digunakanDalamPenilaian)
                                        <button type="submit" class="btn btn-light btn-sm shadow-sm text-danger" title="Hapus"
                                            onclick="return confirm('Apakah Anda yakin ingin menghapus kategori ini?')">
                                            <i class="fas fa-trash mr-2"></i> Hapus
                                        </button>
                                        @else
                                        <button class="btn btn-light btn-sm shadow-sm" disabled title="Sedang digunakan">
                                            <i class="fas fa-trash text-gray-300"></i>
                                        </button>
                                        @endif
                                    </form>

                                    <a href="{{ route('pengguna_utama.kriteria.index', ['kategori_id' => $kategori->id]) }}"
                                        class="btn btn-light btn-sm shadow-sm text-info" title="Lihat Kriteria">
                                        <i class="fas fa-list mr-2"></i> Kriteria
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@include('Pengguna Utama.kriteria.Kategori_create')
@include('Pengguna Utama.kriteria.Kategori_update')

@endsection

<script>
document.addEventListener('DOMContentLoaded', function() {
    $('#dataTable').DataTable({
        language: {
            url: "//cdn.datatables.net/plug-ins/1.10.24/i18n/Indonesian.json"
        }
    });

    $('.btn-edit').on('click', function() {
        const id = $(this).data('id');
        const nama = $(this).data('nama');
        const keterangan = $(this).data('keterangan');

        $('#kategoriEditModal form').attr('action', `{{ url('pengguna_utama/kategori_kriteria') }}/${id}`);
        $('#editNamaKategori').val(nama);
        $('#editKeterangan').val(keterangan);
    });
});
</script>

