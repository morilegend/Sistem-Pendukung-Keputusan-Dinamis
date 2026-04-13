<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('anggota', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('users_id');
            $table->string('nama');
            $table->string('email')->unique(); 
            $table->string('password');
            $table->string('jabatan'); 
            $table->enum('jenis_kelamin', ['Pria', 'Wanita']); // Jenis kelamin: Pria atau Wanita
            $table->boolean('akses_kriteria');
            $table->boolean('akses_alternatif');
            $table->boolean('akses_penilaian');
            $table->boolean('akses_simpan_perhitungan');
            $table->boolean('akses_anggota');
            $table->timestamps();
            $table->foreign('users_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('anggota');
    }
};