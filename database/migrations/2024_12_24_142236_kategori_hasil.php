<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Auth;

return new class extends Migration
{
    public function up()
    {
        Schema::create('kategori_hasil', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_kategori_penilaian');
            $table->unsignedBigInteger('users_id');
            $table->string('nama');
            $table->timestamps();
            $table->foreign('id_kategori_penilaian')
                  ->references('id')->on('kategori_penilaian')
                  ->onDelete('cascade');
            
            // Relasi ke tabel users
            $table->foreign('users_id')
                  ->references('id')->on('users')
                  ->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('kategori_hasil');
    }
};