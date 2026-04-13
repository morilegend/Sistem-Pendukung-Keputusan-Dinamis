@extends('Admin.layouts.main')

@section('title', 'Dashboard')

@section('content')
    <div class="container-fluid animate-fade-in">
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800 ">Selamat Datang, {{ Auth::user()->nama }}</h1>
        </div>

        <div class="row">
            <!-- Validasi Diterima -->
            <div class="col-xl-4 col-md-6 mb-4">
                <div class="card border-left-success shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs  text-success text-uppercase mb-1">
                                    Validasi Diterima</div>
                                <div class="h5 mb-0  text-gray-800">{{ $validasi_diterima }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-check-circle fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Validasi Ditolak -->
            <div class="col-xl-4 col-md-6 mb-4">
                <div class="card border-left-danger shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs  text-danger text-uppercase mb-1">
                                    Validasi Ditolak</div>
                                <div class="h5 mb-0  text-gray-800">{{ $validasi_ditolak }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-times-circle fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Validasi Menunggu -->
            <div class="col-xl-4 col-md-6 mb-4">
                <div class="card border-left-warning shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs  text-warning text-uppercase mb-1">
                                    Validasi Menunggu</div>
                                <div class="h5 mb-0  text-gray-800">{{ $validasi_menunggu }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-clock fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
