<?php

// Admin
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\Admin\AdminController;
// Pengguna Utama
use App\Http\Controllers\PenggunaUtama\PenggunaUtamaController;
use App\Http\Controllers\PenggunaUtama\KategoriKriteriaController;
use App\Http\Controllers\PenggunaUtama\KategoriAlternatifController;
use App\Http\Controllers\PenggunaUtama\KategoriPenilaianController;
use App\Http\Controllers\PenggunaUtama\KriteriaController;
use App\Http\Controllers\PenggunaUtama\AlternatifController;
use App\Http\Controllers\PenggunaUtama\SubkriteriaController;
use App\Http\Controllers\PenggunaUtama\DetailPenilaianController;
use App\Http\Controllers\PenggunaUtama\PenilaianController;
use App\Http\Controllers\PenggunaUtama\PerhitunganController;
use App\Http\Controllers\PenggunaUtama\HasilController;
use App\Http\Controllers\PenggunaUtama\AnggotaController;
// Pengguna
use App\Http\Controllers\Pengguna\PenggunaController;
use App\Http\Controllers\Pengguna\KategoriKriteriaPenggunaController;
use App\Http\Controllers\Pengguna\KriteriaPenggunaController;
use App\Http\Controllers\Pengguna\SubkriteriaPenggunaController;
use App\Http\Controllers\Pengguna\KategoriAlternatifPenggunaController;
use App\Http\Controllers\Pengguna\AlternatifPenggunaController;
use App\Http\Controllers\Pengguna\KategoriPenilaianPenggunaController;
use App\Http\Controllers\Pengguna\PenilaianPenggunaController;
use App\Http\Controllers\Pengguna\PerhitunganPenggunaController;
use App\Http\Controllers\Pengguna\HasilPenggunaController;
use App\Http\Controllers\Pengguna\AnggotaPenggunaController;
use App\Http\Middleware\Role;

// Login
Route::get('/', [LoginController::class, 'index'])->name('login');
Route::post('/', [LoginController::class, 'authenticate']);

// Register
Route::get('/register', [RegisterController::class, 'index'])->name('register');
Route::post('/register', [RegisterController::class, 'store']);

// Admin Routes
Route::middleware(['auth', Role::class . ':Admin'])->group(function () {
    Route::get('/admin', [AdminController::class, 'index'])->name('admin.dashboard');
    Route::get('/admin/users', [AdminController::class, 'manageUsers'])->name('admin.manageUsers');
    Route::put('/admin/users/{id}/update-validation', [AdminController::class, 'updateValidation'])->name('admin.updateValidation');
});

// Pengguna Utama Routes
Route::middleware(['auth', Role::class . ':Pengguna Utama'])->prefix('pengguna_utama')->name('pengguna_utama.')->group(function () {
    Route::get('/', [PenggunaUtamaController::class, 'index'])->name('dashboard');
    Route::get('/detail/{kategori}', [PenggunaUtamaController::class, 'detailKategori']);


    // Kategori Kriteria Routes
    Route::get('/kategori_kriteria', [KategoriKriteriaController::class, 'index'])->name('kategori_kriteria.index');
    Route::get('/kategori_kriteria/create', [KategoriKriteriaController::class, 'create'])->name('kategori_kriteria.create');
    Route::post('/kategori_kriteria', [KategoriKriteriaController::class, 'store'])->name('kategori_kriteria.store');
    Route::get('/kategori_kriteria/{id}/edit', [KategoriKriteriaController::class, 'edit'])->name('kategori_kriteria.edit');
    Route::put('/kategori_kriteria/{id}', [KategoriKriteriaController::class, 'update'])->name('kategori_kriteria.update');
    Route::delete('/kategori_kriteria/{id}', [KategoriKriteriaController::class, 'destroy'])->name('kategori_kriteria.destroy');

    // Kategori Alternatif Routes
    Route::get('/kategori_alternatif', [KategoriAlternatifController::class, 'index'])->name('kategori_alternatif.index');
    Route::get('/kategori_alternatif/create', [KategoriAlternatifController::class, 'create'])->name('kategori_alternatif.create');
    Route::post('/kategori_alternatif', [KategoriAlternatifController::class, 'store'])->name('kategori_alternatif.store');
    Route::get('/kategori_alternatif/{id}/edit', [KategoriAlternatifController::class, 'edit'])->name('kategori_alternatif.edit');
    Route::put('/kategori_alternatif/{id}', [KategoriAlternatifController::class, 'update'])->name('kategori_alternatif.update');
    Route::delete('/kategori_alternatif/{id}', [KategoriAlternatifController::class, 'destroy'])->name('kategori_alternatif.destroy');

    // Kriteria Routes
    Route::get('/kriteria/{kategori_id}', [KriteriaController::class, 'index'])->name('kriteria.index');
    Route::get('/kriteria/create/{kategori_id}', [KriteriaController::class, 'create'])->name('kriteria.create');
    Route::post('/kriteria', [KriteriaController::class, 'store'])->name('kriteria.store');
    Route::get('/kriteria/{id}/edit', [KriteriaController::class, 'edit'])->name('kriteria.edit');
    Route::put('/kriteria/{id}', [KriteriaController::class, 'update'])->name('kriteria.update');
    Route::delete('/kriteria/{id}', [KriteriaController::class, 'destroy'])->name('kriteria.destroy');

    // Alternatif Routes
    Route::get('/alternatif/{kategori_id}', [AlternatifController::class, 'index'])->name('alternatif.index');
    Route::get('/alternatif/create/{kategori_id}', [AlternatifController::class, 'create'])->name('alternatif.create');
    Route::post('/alternatif', [AlternatifController::class, 'store'])->name('alternatif.store');
    Route::get('/alternatif/{id}/edit', [AlternatifController::class, 'edit'])->name('alternatif.edit');
    Route::put('/alternatif/{id}', [AlternatifController::class, 'update'])->name('alternatif.update');
    Route::delete('/alternatif/{id}', [AlternatifController::class, 'destroy'])->name('alternatif.destroy');

    // SubKriteria Routes
    Route::get('/sub_kriteria/{kriteria_id}', [SubKriteriaController::class, 'index'])->name('sub_kriteria.index');
    Route::get('/sub_kriteria/create/{kriteria_id}', [SubKriteriaController::class, 'create'])->name('sub_kriteria.create');
    Route::post('/sub_kriteria', [SubKriteriaController::class, 'store'])->name('sub_kriteria.store');
    Route::get('/sub_kriteria/{id}/edit', [SubKriteriaController::class, 'edit'])->name('sub_kriteria.edit');
    Route::put('/sub_kriteria/{id}', [SubKriteriaController::class, 'update'])->name('sub_kriteria.update');
    Route::delete('/sub_kriteria/{id}', [SubKriteriaController::class, 'destroy'])->name('sub_kriteria.destroy');

    // Kategori Penilaian Routes
    Route::get('/kategori_penilaian', [KategoriPenilaianController::class, 'index'])->name('kategori_penilaian.index');
    Route::get('/kategori_penilaian/create', [KategoriPenilaianController::class, 'create'])->name('kategori_penilaian.create');
    Route::post('/kategori_penilaian', [KategoriPenilaianController::class, 'store'])->name('kategori_penilaian.store');
    Route::get('/kategori_penilaian/{id}/edit', [KategoriPenilaianController::class, 'edit'])->name('kategori_penilaian.edit');
    Route::put('/kategori_penilaian/{id}', [KategoriPenilaianController::class, 'update'])->name('kategori_penilaian.update');
    Route::delete('/kategori_penilaian/{id}', [KategoriPenilaianController::class, 'destroy'])->name('kategori_penilaian.destroy');

    // Detail Penilaian
    Route::get('/penilaian/{kategoriPenilaianId}', [PenilaianController::class, 'index'])->name('penilaian.index');
    Route::get('/penilaian/create/{kategoriPenilaianId}', [PenilaianController::class, 'create'])->name('penilaian.create');
    Route::post('/penilaian', [PenilaianController::class, 'store'])->name('penilaian.store');
    Route::delete('/penilaian/delete-by-alternatif/{id_alternatif}', [PenilaianController::class, 'deleteByAlternatif'])->name('penilaian.deleteByAlternatif');
    Route::get('/penilaian/{id}/show', [PenilaianController::class, 'show'])->name('penilaian.show');


    
    // Perhitungan Routes
    Route::get('/perhitungan', [PerhitunganController::class, 'index'])->name('perhitungan.index');
    Route::post('/perhitungan/proses', [PerhitunganController::class, 'proses'])->name('perhitungan.proses');
    Route::post('/perhitungan/simpan_ranking', [PerhitunganController::class, 'simpanRanking'])->name('perhitungan.simpanRanking');

    // Hasil Routes
    Route::get('/hasil', [HasilController::class, 'index'])->name('hasil.index');
    Route::get('/hasil/{id}', [HasilController::class, 'show'])->name('hasil.show');
    Route::delete('/hasil/{id}', [HasilController::class, 'destroy'])->name('hasil.destroy');
    
    //Anggota
    Route::get('/anggota', [AnggotaController::class, 'index'])->name('anggota.index');
    Route::get('/anggota/create', [AnggotaController::class, 'create'])->name('anggota.create');
    Route::post('/anggota', [AnggotaController::class, 'store'])->name('anggota.store');
    Route::get('/anggota/{id}/edit', [AnggotaController::class, 'edit'])->name('anggota.edit');
    Route::put('/anggota/{id}', [AnggotaController::class, 'update'])->name('anggota.update');
    Route::delete('/anggota/{id}', [AnggotaController::class, 'destroy'])->name('anggota.destroy');
});


// Pengguna Routes
Route::middleware(['auth:web2'])->prefix('Pengguna')->name('pengguna.')->group(function () {
    Route::get('/', [PenggunaController::class, 'index'])->name('dashboard');
    
    //Kategori
    Route::get('/kategori_kriteria', [KategoriKriteriaPenggunaController::class, 'index'])->name('kategori_kriteria.index');
    Route::get('/kategori_alternatif', [KategoriAlternatifController::class, 'index'])->name('kategori_alternatif.index');
    
    // Kriteria Routes
    Route::get('/kriteria/{kategori_id}', [KriteriaPenggunaController::class, 'index'])->name('kriteria.index');
    Route::get('/kriteria/create/{kategori_id}', [KriteriaPenggunaController::class, 'create'])->name('kriteria.create');
    Route::post('/kriteria', [KriteriaPenggunaController::class, 'store'])->name('kriteria.store');
    Route::get('/kriteria/{id}/edit', [KriteriaPenggunaController::class, 'edit'])->name('kriteria.edit');
    Route::put('/kriteria/{id}', [KriteriaPenggunaController::class, 'update'])->name('kriteria.update');
    Route::delete('/kriteria/{id}', [KriteriaPenggunaController::class, 'destroy'])->name('kriteria.destroy');

    // SubKriteria Routes
    Route::get('/sub_kriteria/{kriteria_id}', [SubKriteriaPenggunaController::class, 'index'])->name('sub_kriteria.index');
    Route::get('/sub_kriteria/create/{kriteria_id}', [SubKriteriaPenggunaController::class, 'create'])->name('sub_kriteria.create');
    Route::post('/sub_kriteria', [SubKriteriaPenggunaController::class, 'store'])->name('sub_kriteria.store');
    Route::get('/sub_kriteria/{id}/edit', [SubKriteriaPenggunaController::class, 'edit'])->name('sub_kriteria.edit');
    Route::put('/sub_kriteria/{id}', [SubKriteriaPenggunaController::class, 'update'])->name('sub_kriteria.update');
    Route::delete('/sub_kriteria/{id}', [SubKriteriaPenggunaController::class, 'destroy'])->name('sub_kriteria.destroy');

    // Kategori Alternatif Routes
    Route::get('/kategori_alternatif', [KategoriAlternatifPenggunaController::class, 'index'])->name('kategori_alternatif.index');
    
    //Alternatif Routes
    Route::get('/alternatif/{kategori_id}', [AlternatifPenggunaController::class, 'index'])->name('alternatif.index');
    Route::get('/alternatif/create/{kategori_id}', [AlternatifPenggunaController::class, 'create'])->name('alternatif.create');
    Route::post('/alternatif', [AlternatifPenggunaController::class, 'store'])->name('alternatif.store');
    Route::get('/alternatif/{id}/edit', [AlternatifPenggunaController::class, 'edit'])->name('alternatif.edit');
    Route::put('/alternatif/{id}', [AlternatifPenggunaController::class, 'update'])->name('alternatif.update');
    Route::delete('/alternatif/{id}', [AlternatifPenggunaController::class, 'destroy'])->name('alternatif.destroy');

    // Kategori Penilaian Routes
    Route::get('/kategori_penilaian', [KategoriPenilaianPenggunaController::class, 'index'])->name('kategori_penilaian.index');

    // Detail Penilaian
    Route::get('/penilaian/{kategoriPenilaianId}', [PenilaianPenggunaController::class, 'index'])->name('penilaian.index');
    Route::get('/penilaian/create/{kategoriPenilaianId}', [PenilaianPenggunaController::class, 'create'])->name('penilaian.create');
    Route::post('/penilaian', [PenilaianPenggunaController::class, 'store'])->name('penilaian.store');
    Route::delete('/penilaian/delete-by-alternatif/{id_alternatif}', [PenilaianPenggunaController::class, 'deleteByAlternatif'])->name('penilaian.deleteByAlternatif');
    Route::get('/penilaian/{id}/show', [PenilaianPenggunaController::class, 'show'])->name('penilaian.show');

    // Perhitungan Routes
    Route::get('/perhitungan', [PerhitunganPenggunaController::class, 'index'])->name('perhitungan.index');
    Route::post('/perhitungan/proses', [PerhitunganPenggunaController::class, 'proses'])->name('perhitungan.proses');
    Route::post('/perhitungan/simpan_ranking', [PerhitunganPenggunaController::class, 'simpanRanking'])->name('perhitungan.simpanRanking');

    // Hasil Routes
    Route::get('/hasil', [HasilPenggunaController::class, 'index'])->name('hasil.index');
    Route::get('/hasil/{id}', [HasilPenggunaController::class, 'show'])->name('hasil.show');
    Route::delete('/hasil/{id}', [HasilPenggunaController::class, 'destroy'])->name('hasil.destroy');

    //Anggota
    Route::get('/anggota', [AnggotaPenggunaController::class, 'index'])->name('anggota.index');
    Route::get('/anggota/create', [AnggotaPenggunaController::class, 'create'])->name('anggota.create');
    Route::post('/anggota', [AnggotaPenggunaController::class, 'store'])->name('anggota.store');
    Route::get('/anggota/{id}/edit', [AnggotaPenggunaController::class, 'edit'])->name('anggota.edit');
    Route::put('/anggota/{id}', [AnggotaPenggunaController::class, 'update'])->name('anggota.update');
    Route::delete('/anggota/{id}', [AnggotaPenggunaController::class, 'destroy'])->name('anggota.destroy');



    
});

// Logout Route
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');