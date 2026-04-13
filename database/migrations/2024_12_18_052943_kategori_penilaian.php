<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('kategori_penilaian', function (Blueprint $table) {
            $table->id();
            $table->string('nama'); 
            $table->unsignedBigInteger('id_kategori_kriteria');
            $table->unsignedBigInteger('id_kategori_alternatif');
            $table->unsignedBigInteger('users_id');
            $table->timestamps();

            $table->foreign('id_kategori_kriteria')
                  ->references('id')
                  ->on('kategori_kriteria')
                  ->onDelete('cascade');

            $table->foreign('id_kategori_alternatif')
                  ->references('id')
                  ->on('kategori_alternatif')
                  ->onDelete('cascade');

            $table->foreign('users_id')
                  ->references('id')
                  ->on('users')
                  ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kategori_penilaian');
    }
};