@extends('Pengguna Utama.layouts.main')

@section('title', 'Kriteria')

@section('content')

<div class="container-fluid animate-fade-in">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800 ">Kriteria: {{ $kategori ? $kategori->nama : 'Umum' }}</h1>
        @if(!$isKategoriDigunakan)
        <button type="button" class="btn btn-primary shadow-sm" data-toggle="modal" data-target="#kriteriaCreateModal">
            <i class="fas fa-plus fa-sm text-white-50 mr-2"></i> Tambah Kriteria
        </button>
        @endif
    </div>

    @if($isKategoriDigunakan)
    <div class="alert alert-warning shadow-sm mb-4" role="alert">
        <i class="fas fa-exclamation-triangle mr-2"></i> Kategori sedang digunakan dalam penilaian. Tidak dapat menambah atau menghapus kriteria.
    </div>
    @endif

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0  text-primary">Daftar Kriteria Pelanggan</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th width="50">No</th>
                            <th>Nama Kriteria</th>
                            <th>Bobot</th>
                            <th>Jenis</th>
                            <th>Persentase</th>
                            <th width="180" class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($kriteria as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td class=" text-dark">{{ $item->nama }}</td>
                            <td>{{ $item->bobot }}</td>
                            <td>
                                <span class="badge {{ $item->jenis == 'benefit' ? 'badge-success' : 'badge-warning' }} px-3 py-2">
                                    {{ ucfirst($item->jenis) }}
                                </span>
                            </td>
                            <td>
                                <div class="row no-gutters align-items-center">
                                    <div class="col-auto mr-2 small  text-gray-800">{{ number_format($item->bobot_decimal * 100) }}%</div>
                                    <div class="col">
                                        <div class="progress progress-sm mr-2">
                                            <div class="progress-bar bg-info" role="progressbar" style="width: {{ $item->bobot_decimal * 100 }}%"></div>
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td class="text-center">
                                <div class="d-flex justify-content-center gap-1">
                                    <button type="button" class="btn btn-light btn-sm shadow-sm btn-edit text-warning" 
                                        data-id="{{ $item->id }}" data-nama="{{ $item->nama }}" 
                                        data-bobot="{{ $item->bobot }}" data-jenis="{{ $item->jenis }}" 
                                        data-kategori-id="{{ $item->kategori_id }}"
                                        data-toggle="modal" data-target="#kriteriaEditModal" title="Ubah">
                                        <i class="fas fa-edit mr-2"></i> Ubah
                                    </button>

                                    @if(DB::table('penilaian')->where('id_kriteria', $item->id)->exists())
                                    <button class="btn btn-light btn-sm shadow-sm" disabled title="Tidak dapat dihapus">
                                        <i class="fas fa-trash text-gray-300"></i>
                                    </button>
                                    @else
                                    <form action="{{ route('pengguna_utama.kriteria.destroy', $item->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-light btn-sm shadow-sm text-danger" title="Hapus"
                                            onclick="return confirm('Apakah Anda yakin ingin menghapus kriteria ini?')">
                                            <i class="fas fa-trash mr-2"></i> Hapus
                                        </button>
                                    </form>
                                    @endif

                                    <a href="{{ route('pengguna_utama.sub_kriteria.index', ['kriteria_id' => $item->id]) }}"
                                        class="btn btn-light btn-sm shadow-sm text-info" title="Sub Kriteria">
                                        <i class="fas fa-list mr-2"></i> Sub
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

@include('Pengguna Utama.kriteria.Kriteria_create')
@include('Pengguna Utama.kriteria.Kriteria_update')

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
        const bobot = $(this).data('bobot');
        const jenis = $(this).data('jenis');
        const kategoriId = $(this).data('kategori-id');

        $('#kriteriaEditModal form').attr('action', `{{ route('pengguna_utama.kriteria.update', '') }}/${id}`);
        $('#editNamaKriteria').val(nama);
        $('#editBobotKriteria').val(bobot);
        $('#editJenisKriteria').val(jenis);
        $('#editKategoriId').val(kategoriId);
    });
});
</script>

