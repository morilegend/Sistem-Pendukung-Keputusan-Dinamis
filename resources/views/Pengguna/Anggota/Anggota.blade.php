@extends('Pengguna.layouts.main')

@section('title', 'Anggota')

@section('content')

<link href="{{ asset('assets/vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">

<div class="container-fluid">
    <div class="col-xl-4 col-md-6 mb-4">
        <h1 class="mb-5 text-dark">Data Anggota</h1>
    </div>
    @if(Auth::user()->akses_anggota)
    <div class="mb-4 d-flex justify-content-start">
        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#anggotaCreateModal">
            Tambah Anggota
        </button>
    </div>
    @endif

    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-center">
            <h6 class="m-0  text-primary">Daftar Anggota</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>Jenis Kelamin</th>
                            <th>Email</th>
                            <th>Jabatan</th>
                            @if(Auth::user()->akses_anggota)
                            <th>Aksi</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($anggota as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $item->nama }}</td>
                            <td>{{ $item->jenis_kelamin }}</td>
                            <td>{{ $item->email }}</td>
                            <td>{{ $item->jabatan }}</td>
                            @if(Auth::user()->akses_anggota)
                            <td>
                                <!-- Tombol Ubah -->
                                <button type="button" class="btn btn-light btn-sm shadow-sm btn-edit text-warning" data-id="{{ $item->id }}"
                                    data-id="{{ $item->id }}" data-nama="{{ $item->nama }}"
                                    data-email="{{ $item->email }}" data-jabatan="{{ $item->jabatan }}"
                                    data-jenis_kelamin="{{ $item->jenis_kelamin }}"
                                    data-akses_kriteria="{{ $item->akses_kriteria }}"
                                    data-akses_alternatif="{{ $item->akses_alternatif }}"
                                    data-akses_penilaian="{{ $item->akses_penilaian }}"
                                    data-akses_simpan_perhitungan="{{ $item->akses_simpan_perhitungan }}"
                                    data-akses_anggota="{{ $item->akses_anggota }}" title="Ubah">
                                    <i class="fas fa-edit mr-2"></i> Ubah
                                </button>
                                <!-- Tombol Hapus -->
                                <form action="{{ route('pengguna.anggota.destroy', $item->id) }}" method="POST"
                                    style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-light btn-sm shadow-sm text-danger">
                                        <i class="fas fa-trash mr-2"></i> Hapus
                                    </button>
                                </form>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center">Tidak ada data anggota yang tersedia.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@if(Auth::user()->akses_anggota)
@include('Pengguna.Anggota.anggota_create')
@include('Pengguna.Anggota.anggota_update')
@endif
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
});

$(document).ready(function() {
    // Ketika tombol Edit diklik
    $('.btn-edit').on('click', function() {
        const id = $(this).data('id');
        const nama = $(this).data('nama');
        const email = $(this).data('email');
        const jabatan = $(this).data('jabatan');
        const jenis_kelamin = $(this).data('jenis_kelamin');
        const akses_kriteria = $(this).data('akses_kriteria') === 1;
        const akses_alternatif = $(this).data('akses_alternatif') === 1;
        const akses_penilaian = $(this).data('akses_penilaian') === 1;
        const akses_simpan_perhitungan = $(this).data('akses_simpan_perhitungan') === 1;
        const akses_anggota = $(this).data('akses_anggota') === 1;

        if (!id || !nama || !email || !jabatan || !jenis_kelamin) {
            alert('Data tidak lengkap. Harap periksa kembali.');
            return;
        }

        // Set action form dan isi input
        $('#editAnggotaForm').attr('action', `{{ url('Pengguna/anggota') }}/${id}`);
        $('#anggota_id').val(id);
        $('#nama_update').val(nama);
        $('#email_update').val(email);
        $('#jabatan_update').val(jabatan);
        $('#jenis_kelamin_update').val(jenis_kelamin);
        $('#akses_kriteria_update').prop('checked', akses_kriteria);
        $('#akses_alternatif_update').prop('checked', akses_alternatif);
        $('#akses_penilaian_update').prop('checked', akses_penilaian);
        $('#akses_simpan_perhitungan_update').prop('checked', akses_simpan_perhitungan);
        $('#akses_anggota_update').prop('checked', akses_anggota);

        // Tampilkan modal
        $('#anggotaEditModal').modal('show');
    });

    // Reset form ketika modal ditutup
    $('#anggotaEditModal').on('hidden.bs.modal', function() {
        $('#editAnggotaForm').trigger('reset');
        $('#editAnggotaForm').attr('action', '');
    });
});
</script>

