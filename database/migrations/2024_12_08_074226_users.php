<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('email')->unique();
            $table->string('password');
            $table->string('no_hp');
            $table->enum('jenis_kelamin', ['Pria', 'Wanita']);
            $table->string('keperluan_spk');
            $table->string('domisili');
            $table->enum('role', ['Admin', 'Pengguna Utama', 'Pengguna'])->default('Pengguna Utama');
            $table->enum('validasi', ['Diterima', 'Ditolak', 'Menunggu'])->default('Menunggu');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('users');
    }
};