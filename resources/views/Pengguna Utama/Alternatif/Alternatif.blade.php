@extends('Pengguna Utama.layouts.main')

@section('title', 'Daftar Alternatif')

@section('content')

<div class="container-fluid animate-fade-in">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800 ">
            Alternatif: {{ $kategori ? $kategori->nama : 'Semua' }}
        </h1>
        <button type="button" class="btn btn-primary shadow-sm" data-toggle="modal" data-target="#alternatifCreateModal">
            <i class="fas fa-plus fa-sm text-white-50 mr-2"></i> Tambah Alternatif
        </button>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0  text-primary">Daftar Alternatif Terdaftar</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th width="50">No</th>
                            <th>Nama Alternatif</th>
                            <th>Keterangan</th>
                            <th width="150" class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($alternatif as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td class=" text-dark">{{ $item->nama }}</td>
                            <td class="text-muted small">{{ $item->keterangan }}</td>
                            <td class="text-center">
                                <div class="d-flex justify-content-center gap-2">
                                    <button type="button" class="btn btn-light btn-sm shadow-sm btn-edit text-warning" 
                                        data-id="{{ $item->id }}" data-nama="{{ $item->nama }}" 
                                        data-keterangan="{{ $item->keterangan }}" data-status="{{ $item->status }}"
                                        data-id_kategori="{{ $item->id_kategori_alternatif }}" 
                                        data-toggle="modal" data-target="#alternatifEditModal" title="Ubah">
                                        <i class="fas fa-edit mr-2"></i> Ubah
                                    </button>

                                    @if($item->digunakanDalamPenilaian)
                                    <button class="btn btn-light btn-sm shadow-sm" disabled title="Sedang digunakan">
                                        <i class="fas fa-trash text-gray-300"></i>
                                    </button>
                                    @else
                                    <form action="{{ route('pengguna_utama.alternatif.destroy', $item->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-light btn-sm shadow-sm text-danger" title="Hapus"
                                            onclick="return confirm('Apakah Anda yakin ingin menghapus alternatif ini?')">
                                            <i class="fas fa-trash mr-2"></i> Hapus
                                        </button>
                                    </form>
                                    @endif
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

@include('Pengguna Utama.alternatif.Alternatif_create')
@include('Pengguna Utama.alternatif.Alternatif_update')

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

        $('#alternatifEditModal form').attr('action', `{{ route('pengguna_utama.alternatif.update', '') }}/${id}`);
        $('#editNamaAlternatif').val(nama);
        $('#editKeterangan').val(keterangan);
    });
});
</script>

