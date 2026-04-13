@extends('Pengguna.layouts.main')

@section('title', 'Penilaian')

@section('content')

<link href="{{ asset('assets/vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">

<div class="container-fluid">
    <div class="col-xl-4 col-md-6 mb-4">
        <h1 class="mb-5 text-dark">Data Penilaian</h1>
    </div>

    @if(Auth::user()->akses_penilaian)
    <div class="mb-4 d-flex justify-content-start">
        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#penilaianCreateModal">
            Tambah Penilaian
        </button>
    </div>
    @endif

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
                            <th>Alternatif</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($penilaian as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $item->alternatif->nama }}</td>
                            <td>
                                @if(Auth::user()->akses_penilaian)
                                    <button class="btn btn-danger btn-sm btn-delete" data-id="{{ $item->id_alternatif }}"
                                        data-url="{{ route('pengguna.penilaian.deleteByAlternatif', $item->id_alternatif) }}">
                                        <i class="fas fa-trash mr-1"></i> Hapus
                                    </button>
                                @endif
                                <button class="btn btn-primary btn-sm btn-detail" data-id="{{ $item->id_alternatif }}">
                                    <i class="fas fa-eye mr-1"></i> Lihat
                                </button>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center">Tidak ada data penilaian yang tersedia.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>


@if(Auth::user()->akses_penilaian)
@include('Pengguna.Penilaian.penilaian_create')
@endif

@include('Pengguna.Penilaian.penilaian_show')
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
            orderable: false,
            width: '5%',
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
    $(document).on('click', '.btn-delete', function() {
        let alternatifId = $(this).data('id');
        let url = $(this).data('url');

        if (confirm('Apakah Anda yakin ingin menghapus penilaian untuk alternatif ini?')) {
            $.ajax({
                url: url,
                type: 'DELETE',
                data: {
                    _token: '{{ csrf_token() }}',
                },
                success: function(response) {
                    alert('Penilaian berhasil dihapus!');
                    location.reload();
                },
                error: function(xhr) {
                    location.reload();
                }
            });
        }
    });
    $(document).on('click', '.btn-detail', function() {
        let alternatifId = $(this).data('id');

        // Fetch data menggunakan AJAX
        $.ajax({
            url: `/Pengguna/penilaian/${alternatifId}/show`, // Pastikan route sudah sesuai
            type: 'GET',
            success: function(data) {
                if (data.success) {
                    // Update nama alternatif
                    $('#alternatifName').text(data.alternatif.nama);

                    const tableBody = $('#kriteriaTableBody');
                    tableBody.empty(); // Kosongkan data lama

                    // Looping kriteria untuk menampilkan subkriteria yang dipilih
                    data.kriteria.forEach(kriteria => {
                        // Ambil subkriteria yang dipilih berdasarkan penilaian
                        let selectedSubKriteria = kriteria.sub_kriteria.filter(
                            sub =>
                            data.penilaian.some(p => p.id_sub_kriteria == sub
                                .id)
                        );

                        if (selectedSubKriteria.length > 0) {
                            let subKriteriaList = selectedSubKriteria.map(sub =>
                                `${sub.nama}`);

                            let row = `
                                <tr>
                                    <td>${kriteria.nama}</td>
                                    <td>${subKriteriaList}</td>
                                </tr>
                            `;
                            tableBody.append(row);
                        }
                    });

                    // Tampilkan modal
                    $('#detailModal').modal('show');
                } else {
                    alert(data.message);
                }
            },
            error: function(xhr) {
                alert('Gagal memuat data!');
            }
        });
    });
});
</script>

