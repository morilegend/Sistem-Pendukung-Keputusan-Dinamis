@extends('Pengguna Utama.layouts.main')

@section('title', 'Sub Kriteria')

@section('content')
<link href="{{ asset('assets/vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">

<div class="container-fluid">
    <div>
        <h1 class="mb-5 text-dark">Sub Kriteria {{ $kriteria->nama }}</h1>
    </div>

    <div class="mb-4 d-flex justify-content-start">
        <button type="button" class="btn btn-primary shadow-sm" data-toggle="modal" data-target="#subKriteriaCreateModal">
            <i class="fas fa-plus fa-sm text-white-50 mr-2"></i> Tambah Sub Kriteria
        </button>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-center">
            <h6 class="m-0  text-primary">Daftar Sub Kriteria</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Sub Kriteria</th>
                            <th>Nilai Crisp</th>
                            <th>Nilai Fuzzy</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($subKriteria as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $item->nama }}</td>
                            <td>{{ $item->nilai_crisp }}</td>
                            <td>{{ $item->nilai_fuzzy }}</td>
                            <td>
                                <button type="button" class="btn btn-light btn-sm shadow-sm btn-edit text-warning" data-id="{{ $item->id }}"
                                    data-nama="{{ $item->nama }}" data-kriteria-id="{{ $item->id_kriteria }}"
                                    data-nilai-crisp="{{ $item->nilai_crisp }}" data-toggle="modal"
                                    data-nilai-fuzzy="{{ $item->nilai_fuzzy }}" data-toggle="modal"
                                    data-target="#subKriteriaEditModal">
                                    <i class="fas fa-edit mr-2"></i> Ubah
                                </button>

                                <form action="{{ route('pengguna_utama.sub_kriteria.destroy', $item->id) }}"
                                    method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    @if(!$item->digunakanDalamPenilaian)
                                    <button type="submit" class="btn btn-light btn-sm shadow-sm text-danger"
                                        onclick="return confirm('Apakah Anda yakin ingin menghapus sub kriteria ini?')">
                                        <i class="fas fa-trash mr-2"></i> Hapus
                                    </button>
                                    @else
                                    <button class="btn btn-light btn-sm shadow-sm" disabled>
                                        <i class="fas fa-trash text-gray-300"></i> Hapus
                                    </button>
                                    @endif
                                </form>

                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@include('Pengguna Utama.kriteria.subkriteria_create')
@include('Pengguna Utama.kriteria.subkriteria_update')

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

    $('.btn-edit').on('click', function() {
        const id = $(this).data('id');
        const nama = $(this).data('nama');
        const kriteriaId = $(this).data('kriteria-id');
        const nilaiCrisp = $(this).data('nilai-crisp');
        const nilaiFuzzy = $(this).data('nilai-fuzzy');

        // Set action form
        $('#subKriteriaEditModal form').attr('action',
            `{{ route('pengguna_utama.sub_kriteria.update', '') }}/${id}`);

        // Set nilai ke form modal edit
        $('#editNamaSubKriteria').val(nama);
        $('#editKriteriaId').val(kriteriaId);
        $('#editNilaiCrisp').val(nilaiCrisp);
        $('#editNilaiFuzzy').val(nilaiFuzzy);
    });
});
</script>

