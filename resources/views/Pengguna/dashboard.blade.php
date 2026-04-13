@extends('Pengguna.layouts.main')

@section('title', 'Dashboard')

@section('content')
    <div class="container-fluid animate-fade-in">
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800 ">Selamat Datang, {{ Auth::user()->nama }}</h1>
        </div>

        <div class="row">
            <!-- Kategori Kriteria -->
            <div class="col-xl-4 col-md-6 mb-4">
                <div class="card border-left-primary shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs  text-primary text-uppercase mb-1">
                                    Kategori Kriteria</div>
                                <div class="h5 mb-0  text-gray-800">{{ $kategoriKriteria->count() }} Item</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-tasks fa-2x text-gray-300"></i>
                            </div>
                        </div>
                        <div class="mt-3">
                            <ul class="list-group list-group-flush small">
                                @foreach ($kategoriKriteria->take(3) as $kategori)
                                    <li class="list-group-item bg-transparent px-0 py-1 text-gray-600">
                                        <i class="fas fa-check-circle text-success mr-2"></i>{{ $kategori->nama }}
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Kategori Alternatif -->
            <div class="col-xl-4 col-md-6 mb-4">
                <div class="card border-left-success shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs  text-success text-uppercase mb-1">
                                    Kategori Alternatif</div>
                                <div class="h5 mb-0  text-gray-800">{{ $kategoriAlternatif->count() }} Item</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-clone fa-2x text-gray-300"></i>
                            </div>
                        </div>
                        <div class="mt-3">
                            <ul class="list-group list-group-flush small">
                                @foreach ($kategoriAlternatif->take(3) as $alternatif)
                                    <li class="list-group-item bg-transparent px-0 py-1 text-gray-600">
                                        <i class="fas fa-check-circle text-success mr-2"></i>{{ $alternatif->nama }}
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Anggota -->
            <div class="col-xl-4 col-md-6 mb-4">
                <div class="card border-left-info shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs  text-info text-uppercase mb-1">
                                    Total Anggota</div>
                                <div class="h5 mb-0  text-gray-800">{{ $anggota->count() }} Orang</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-user-friends fa-2x text-gray-300"></i>
                            </div>
                        </div>
                        <div class="mt-3">
                            <ul class="list-group list-group-flush small">
                                @foreach ($anggota->take(3) as $item)
                                    <li class="list-group-item bg-transparent px-0 py-1 text-gray-600">
                                        <i class="fas fa-user-circle text-info mr-2"></i>{{ $item->nama }}
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
<script src="{{ asset('assets/vendor/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('assets/vendor/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('assets/vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>
