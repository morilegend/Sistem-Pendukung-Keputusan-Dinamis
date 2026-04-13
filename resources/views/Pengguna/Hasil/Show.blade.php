@extends('Pengguna.layouts.main')

@section('title', 'Perankingan')

@section('content')
<div class="container-fluid">
    <div class="col-xl-4 col-md-6 mb-4">
        <h1 class="mb-5 text-dark">Perankingan</h1>
    </div>

    <!-- Tabel untuk menampilkan data terkait -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0  text-primary">Perankingan SAW</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                @php
                $relatedHasil = $relatedHasil->sortBy('ranking');
                @endphp
                <table class="table table-bordered">
                    <thead class="thead-light">
                        <tr>
                            <th>Ranking</th>
                            <th>Alternatif</th>
                            <th>Penilaian</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($relatedHasil as $index => $item)
                        <tr>
                            <td>{{ $item->ranking }}</td>
                            <td>{{ $item->alternatif }}</td>
                            <td>{{ $item->penilaian }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0  text-primary">Perankingan SAW Fuzzy</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                @php
                $relatedHasil = $relatedHasil->sortBy('ranking_fuzzy');
                @endphp
                <table class="table table-bordered">
                    <thead class="thead-light">
                        <tr>
                            <th>Ranking</th>
                            <th>Alternatif</th>
                            <th>Penilaian</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($relatedHasil as $index => $item)
                        <tr>
                            <td>{{ $item->ranking_fuzzy }}</td>
                            <td>{{ $item->alternatif_fuzzy }}</td>
                            <td>{{ $item->penilaian_fuzzy }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
