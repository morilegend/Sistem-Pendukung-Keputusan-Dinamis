<?php

namespace App\Http\Controllers\PenggunaUtama;

use App\Http\Controllers\Controller;
use App\Models\Anggota;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;


//Belum SELESAI
class AnggotaController extends Controller
{
    // Menampilkan daftar anggota
    public function index()
    {
        $userId = auth()->id(); 
        $anggota = Anggota::where('users_id', $userId)->get();
        return view('Pengguna Utama.Anggota.Anggota', compact('anggota'));
    }


    public function store(Request $request)
    {
        // Validasi data yang diterima
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|email|unique:anggota,email|max:255',
            'password' => 'required|string|min:8|max:255',
            'jabatan' => 'required|string|max:255',
            'jenis_kelamin' => 'required|in:Pria,Wanita',
        ], [
            'nama.required' => 'Nama wajib diisi.',
            'nama.max' => 'Nama tidak boleh lebih dari 255 karakter.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Email tidak valid.',
            'email.unique' => 'Email sudah digunakan.',
            'email.max' => 'Email tidak boleh lebih dari 255 karakter.',
            'password.required' => 'Password wajib diisi.',
            'password.min' => 'Password minimal 8 karakter.',
            'password.max' => 'Password tidak boleh lebih dari 255 karakter.',
            'jabatan.required' => 'Jabatan wajib diisi.',
            'jabatan.max' => 'Jabatan tidak boleh lebih dari 255 karakter.',
            'jenis_kelamin.required' => 'Jenis kelamin wajib dipilih.',
            'jenis_kelamin.in' => 'Jenis kelamin harus berupa Pria atau Wanita.',
        ]);

        Anggota::create([
            'users_id' => auth()->user()->id,
            'nama' => $validated['nama'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'jabatan' => $validated['jabatan'],
            'jenis_kelamin' => $validated['jenis_kelamin'],
            'akses_kriteria' => $request->input('akses_kriteria') === 'Ya',
            'akses_alternatif' => $request->input('akses_alternatif') === 'Ya',
            'akses_penilaian' => $request->input('akses_penilaian') === 'Ya',
            'akses_simpan_perhitungan' => $request->input('akses_simpan_perhitungan') === 'Ya',
            'akses_anggota' => $request->input('akses_anggota') === 'Ya',
        ]);

        return redirect()->route('pengguna_utama.anggota.index')->with('success', 'Anggota berhasil ditambahkan.');
    }


    public function edit($id)
    {
        $anggota = Anggota::findOrFail($id);
        return view('Pengguna Utama.Anggota.Anggota_update', compact('anggota'));
    }

    public function update(Request $request, $id)
    {
        // Cari anggota berdasarkan ID
        $anggota = Anggota::findOrFail($id);
    
        // Validasi data yang diterima
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|email|unique:anggota,email,' . $id,
            'jabatan' => 'required|string|max:255',
            'jenis_kelamin' => 'required|in:Pria,Wanita',
            'akses_kriteria' => 'boolean',
            'akses_alternatif' => 'boolean',
            'akses_penilaian' => 'boolean',
            'akses_simpan_perhitungan' => 'boolean',
        ], [
            'nama.required' => 'Nama wajib diisi.',
            'nama.max' => 'Nama tidak boleh lebih dari 255 karakter.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Email tidak valid.',
            'email.unique' => 'Email sudah digunakan.',
            'jabatan.required' => 'Jabatan wajib diisi.',
            'jabatan.max' => 'Jabatan tidak boleh lebih dari 255 karakter.',
            'jenis_kelamin.required' => 'Jenis kelamin wajib dipilih.',
            'jenis_kelamin.in' => 'Jenis kelamin harus berupa Pria atau Wanita.',
        ]);
    
        // Update data anggota
        $anggota->update([
            'nama' => $validated['nama'],
            'email' => $validated['email'],
            'jabatan' => $validated['jabatan'],
            'jenis_kelamin' => $validated['jenis_kelamin'],
            'akses_kriteria' => $request->input('akses_kriteria', false),
            'akses_alternatif' => $request->input('akses_alternatif', false),
            'akses_penilaian' => $request->input('akses_penilaian', false),
            'akses_simpan_perhitungan' => $request->input('akses_simpan_perhitungan', false),
            'akses_anggota' => $request->input('akses_anggota', false),
        ]);
    
        return redirect()->route('pengguna_utama.anggota.index')->with('success', 'Data anggota berhasil diperbarui.');
    }

    // Menghapus anggota
    public function destroy($id)
    {
        $anggota = Anggota::findOrFail($id);
        $anggota->delete();

        return redirect()->route('pengguna_utama.anggota.index')->with('success', 'Anggota berhasil dihapus');
    }
}