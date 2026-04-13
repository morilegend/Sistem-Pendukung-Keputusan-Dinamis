@extends('Admin.layouts.main')

@section('title', 'Dashboard')

@section('content')
<!-- Ambil Data CSS untuk Tabel -->
<link href="{{ asset('assets/vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">

<div class="container-fluid">
    <div class="col-xl-4 col-md-6 mb-4">
        <h1 class="mb-5 text-dark">Users</h1>
    </div>

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
        </div>
        <div class="card-body">
            <div class="table-responsive">

                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">

                    <thead class="text-white dark bg-secondary">
                        <tr>
                            <th>Nama</th>
                            <th>Email</th>
                            <th>No HP</th>
                            <th>Jenis Kelamin</th>
                            <th>Keperluan SPK</th>
                            <th>Domisili</th>
                            <th>Role</th>
                            <th>Validasi</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $user)
                        <!-- //Role Admin Check -->
                        @if($user->role !== 'admin' && $user->role !== "Admin")
                        <!-- Exclude admin -->
                        <tr>
                            <td>{{ $user->nama }}</td>
                            <td>{{ $user->email }}</td>
                            <td>{{ $user->no_hp }}</td>
                            <td>{{ $user->jenis_kelamin }}</td>
                            <td>{{ $user->keperluan_spk }}</td>
                            <td>{{ $user->domisili }}</td>
                            <td>{{ $user->role }}</td>
                            <td>
                                <span class="badge 
                                        @if($user->validasi == 'Diterima')
                                        text-success
                                        @elseif($user->validasi == 'Ditolak')
                                        text-danger
                                        @else
                                        text-warning
                                        @endif">
                                    {{ $user->validasi }}
                                </span>
                            </td>
                            <td>
                                <!-- Form untuk mengubah status validasi -->
                                <form action="{{ route('admin.updateValidation', $user->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <div class="d-flex flex-column align-items-center">
                                        <button type="submit" name="validasi" value="Diterima"
                                            class="btn btn-light btn-sm shadow-sm text-success mb-2">
                                            <i class="fas fa-check mr-2"></i> Terima
                                        </button>
                                        <button type="submit" name="validasi" value="Ditolak"
                                            class="btn btn-light btn-sm shadow-sm text-danger">
                                            <i class="fas fa-times mr-2"></i> Tolak
                                        </button>
                                    </div>
                                </form>
                            </td>
                        </tr>
                        @endif
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<!-- /.container-fluid -->

@endsection

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
<script src="{{ asset('assets/vendor/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('assets/vendor/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('assets/vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>

<script>
$(document).ready(function() {
    $('#dataTable').DataTable({
        info: false
    });
});
</script>