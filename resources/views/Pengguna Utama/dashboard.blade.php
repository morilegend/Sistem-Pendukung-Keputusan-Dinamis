@extends('Pengguna Utama.layouts.main')

@section('title', 'Dashboard')

@section('content')
    <div class="container-fluid animate-fade-in">
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800 ">Selamat Datang, {{ Auth::user()->nama }}</h1>
        </div>

        <div class="row">
            <!-- Kategori Alternatif -->
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-primary shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs  text-primary text-uppercase mb-1">
                                    Kategori Alternatif</div>
                                <div class="h5 mb-0  text-gray-800">{{ $KategoriAlternatif->count() }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-clone fa-2x text-gray-300"></i>
                            </div>
                        </div>
                        <div class="mt-3">
                            <button class="btn btn-primary btn-sm btn-block btn-detail" data-kategori="alternatif">
                                <i class="fas fa-eye mr-1"></i> Lihat Detail
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Kategori Kriteria -->
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-success shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs  text-success text-uppercase mb-1">
                                    Kategori Kriteria</div>
                                <div class="h5 mb-0  text-gray-800">{{ $KategoriKriteria->count() }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-tasks fa-2x text-gray-300"></i>
                            </div>
                        </div>
                        <div class="mt-3">
                            <button class="btn btn-success btn-sm btn-block btn-detail" data-kategori="kriteria">
                                <i class="fas fa-eye mr-1"></i> Lihat Detail
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Kategori Penilaian -->
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-warning shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs  text-warning text-uppercase mb-1">
                                    Kategori Penilaian</div>
                                <div class="h5 mb-0  text-gray-800">{{ $KategoriPenilaian->count() }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-edit fa-2x text-gray-300"></i>
                            </div>
                        </div>
                        <div class="mt-3">
                            <button class="btn btn-warning btn-sm btn-block btn-detail text-white" data-kategori="penilaian">
                                <i class="fas fa-eye mr-1"></i> Lihat Detail
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Anggota -->
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-danger shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs  text-danger text-uppercase mb-1">
                                    Total Anggota</div>
                                <div class="h5 mb-0  text-gray-800">{{ $anggota->count() }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-user fa-2x text-gray-300"></i>
                            </div>
                        </div>
                        <div class="mt-3">
                            <button class="btn btn-danger btn-sm btn-block btn-detail" data-kategori="anggota">
                                <i class="fas fa-eye mr-1"></i> Lihat Detail
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0  text-primary">Detail Data Terpilih</h6>
            </div>
            <div class="card-body" id="detailData">
                <div class="text-center py-5">
                    <i class="fas fa-mouse-pointer fa-3x text-gray-200 mb-3"></i>
                    <p class="text-gray-500">Pilih salah satu kategori di atas untuk melihat detail data secara instan.</p>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.querySelectorAll('.btn-detail').forEach(button => {
            button.addEventListener('click', function () {
                const kategori = this.dataset.kategori;
                const detailElement = document.getElementById('detailData');
                
                detailElement.innerHTML = `
                    <div class="text-center py-5">
                        <div class="spinner-border text-primary" role="status">
                            <span class="sr-only">Loading...</span>
                        </div>
                        <p class="mt-2 text-gray-500">Mengambil data...</p>
                    </div>
                `;

                // Fetch data dari server
                fetch(`/pengguna_utama/detail/${kategori}`)
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            detailElement.innerHTML = data.html;
                        } else {
                            detailElement.innerHTML = `<div class="alert alert-warning">${data.message}</div>`;
                        }
                    })
                    .catch(error => {
                        detailElement.innerHTML = `<div class="alert alert-danger">Error: ${error.message}</div>`;
                    });
            });
        });
    </script>
@endsection
