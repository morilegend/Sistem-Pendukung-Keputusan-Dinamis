<?php

namespace App\Http\Controllers\PenggunaUtama;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\KategoriAlternatif;
use App\Models\KategoriKriteria;
use App\Models\KategoriPenilaian;
use App\Models\Anggota;

class PenggunaUtamaController extends Controller
{
    public function index()
    {
        $userId = auth()->id(); 
        $KategoriAlternatif = KategoriAlternatif::where('users_id', $userId)->get();
        $KategoriKriteria = KategoriKriteria::where('users_id', $userId)->get();
        $KategoriPenilaian = KategoriPenilaian::where('users_id', $userId)->get();
        $anggota = Anggota::where('users_id', $userId)->get();

        return view('Pengguna Utama.dashboard', [
            'KategoriAlternatif' => $KategoriAlternatif,
            'KategoriKriteria' => $KategoriKriteria,
            'KategoriPenilaian' => $KategoriPenilaian,
            'anggota' => $anggota,
        ]);
    }

    public function detailKategori($kategori)
{
    $userId = auth()->id();
    $html = '';

    switch ($kategori) {
        case 'alternatif':
            $data = KategoriAlternatif::where('users_id', $userId)->get();
            $html .= '<table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Nama Alternatif</th>
                            </tr>
                        </thead>
                        <tbody>';
            foreach ($data as $index => $item) {
                $html .= '<tr>
                            <td>' . ($index + 1) . '</td>
                            <td>' . $item->nama . '</td>
                        </tr>';
            }
            $html .= '</tbody></table>';
            break;

        case 'kriteria':
            $data = KategoriKriteria::where('users_id', $userId)->get();
            $html .= '<table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Nama Kriteria</th>
                            </tr>
                        </thead>
                        <tbody>';
            foreach ($data as $index => $item) {
                $html .= '<tr>
                            <td>' . ($index + 1) . '</td>
                            <td>' . $item->nama . '</td>
                        </tr>';
            }
            $html .= '</tbody></table>';
            break;

        case 'penilaian':
            $data = KategoriPenilaian::where('users_id', $userId)->get();
            $html .= '<table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Nama Penilaian</th>
                            </tr>
                        </thead>
                        <tbody>';
            foreach ($data as $index => $item) {
                $html .= '<tr>
                            <td>' . ($index + 1) . '</td>
                            <td>' . $item->nama . '</td>
                        </tr>';
            }
            $html .= '</tbody></table>';
            break;

        case 'anggota':
            $data = Anggota::where('users_id', $userId)->get();
            $html .= '<table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Nama Anggota</th>
                                <th>Email</th>
                                <th>Jabatan</th>
                            </tr>
                        </thead>
                        <tbody>';
            foreach ($data as $index => $item) {
                $html .= '<tr>
                            <td>' . ($index + 1) . '</td>
                            <td>' . $item->nama . '</td>
                            <td>' . $item->email . '</td>
                            <td>' . $item->jabatan . '</td>
                        </tr>';
            }
            $html .= '</tbody></table>';
            break;

        default:
            return response()->json([
                'success' => false,
                'message' => 'Kategori tidak ditemukan.',
            ]);
    }

    return response()->json([
        'success' => true,
        'html' => $html,
    ]);
}

}