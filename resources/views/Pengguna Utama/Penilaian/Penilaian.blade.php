@extends('Pengguna Utama.layouts.main')

@section('title', 'Penilaian')

@section('content')

<div class="container-fluid animate-fade-in">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800 ">Data Penilaian Alternatif</h1>
        <button type="button" class="btn btn-primary shadow-sm" data-toggle="modal" data-target="#penilaianCreateModal">
            <i class="fas fa-plus-circle mr-2"></i> Lakukan Penilaian Baru
        </button>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0  text-primary">Daftar Hasil Penilaian</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th width="50">No</th>
                            <th>Nama Alternatif</th>
                            <th width="150" class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($penilaian as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td class=" text-dark">{{ $item->alternatif->nama }}</td>
                            <td class="text-center">
                                <div class="d-flex justify-content-center gap-2">
                                    <button class="btn btn-light btn-sm shadow-sm btn-detail text-info" data-id="{{ $item->id_alternatif }}" title="Lihat Detail">
                                        <i class="fas fa-eye mr-1"></i> Lihat
                                    </button>
                                    <button class="btn btn-light btn-sm shadow-sm btn-delete text-danger" data-id="{{ $item->id_alternatif }}"
                                        data-url="{{ route('pengguna_utama.penilaian.deleteByAlternatif', $item->id_alternatif) }}" title="Hapus Penilaian">
                                        <i class="fas fa-trash mr-1"></i> Hapus
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="3" class="text-center py-5">
                                <div class="text-muted">
                                    <i class="fas fa-clipboard-list fa-3x mb-3 opacity-25"></i>
                                    <p>Belum ada data penilaian yang tersedia.</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@include('Pengguna Utama.Penilaian.penilaian_create')
@include('Pengguna Utama.Penilaian.penilaian_show')

@endsection

<script>
document.addEventListener('DOMContentLoaded', function() {
    $('#dataTable').DataTable({
        language: {
            url: "//cdn.datatables.net/plug-ins/1.10.24/i18n/Indonesian.json"
        }
    });

    $(document).on('click', '.btn-delete', function() {
        const url = $(this).data('url');
        if (confirm('Apakah Anda yakin ingin menghapus penilaian untuk alternatif ini?')) {
            $.ajax({
                url: url,
                type: 'DELETE',
                data: { _token: '{{ csrf_token() }}' },
                success: function() { location.reload(); },
                error: function() { location.reload(); }
            });
        }
    });

    $(document).on('click', '.btn-detail', function() {
        let alternatifId = $(this).data('id');
        $.ajax({
            url: `/pengguna_utama/penilaian/${alternatifId}/show`,
            type: 'GET',
            success: function(response) {
                if (response.success) {
                    $('#alternatifName').text(response.alternatif.nama);
                    const tableBody = $('#kriteriaTableBody');
                    tableBody.empty();
                    response.kriteria.forEach(kriteria => {
                        const selectedSubKriteria = kriteria.sub_kriteria.filter(
                            sub => response.penilaian.some(p => p.id_sub_kriteria === sub.id)
                        );
                        if (selectedSubKriteria.length > 0) {
                            const subKriteriaList = selectedSubKriteria.map(sub => `<span>${sub.nama}</span>`).join('<br>');
                            tableBody.append(`<tr><td class="">${kriteria.nama}</td><td>${subKriteriaList}</td></tr>`);
                        }
                    });
                    $('#detailModal').modal('show');
                }
            }
        });
    });
});
</script>

