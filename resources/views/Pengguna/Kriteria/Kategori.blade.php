@extends('Pengguna.layouts.main')

@section('title', 'Kategori Kriteria')

@section('content')
<div class="container-fluid animate-fade-in">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800 ">Kategori Kriteria</h1>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0  text-primary">Daftar Kategori Utama</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th width="50">No</th>
                            <th>Nama Kategori</th>
                            <th>Keterangan</th>
                            <th width="150" class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($kategoriKriteria as $kategori)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td class=" text-dark">{{ $kategori->nama }}</td>
                            <td class="text-muted small">{{ $kategori->keterangan }}</td>
                            <td class="text-center">
                                <a href="{{ route('pengguna.kriteria.index', ['kategori_id' => $kategori->id]) }}"
                                    class="btn btn-primary btn-sm shadow-sm rounded-pill px-3">
                                    <i class="fas fa-eye fa-sm mr-1"></i> Lihat Detail
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

<script>
document.addEventListener('DOMContentLoaded', function() {
    $('#dataTable').DataTable({
        language: {
            url: "//cdn.datatables.net/plug-ins/1.10.24/i18n/Indonesian.json"
        }
    });
});
</script>
