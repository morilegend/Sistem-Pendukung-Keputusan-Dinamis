<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('kriteria', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_kategori_kriteria');
            $table->string('nama');
            $table->integer('bobot');
            $table->float('bobot_decimal', 8, 6)->default(0);
            $table->enum('jenis', ['benefit', 'cost']);
            $table->timestamps();


            $table->foreign('id_kategori_kriteria')
                  ->references('id')
                  ->on('kategori_kriteria')
                  ->onDelete('cascade');
        });
    }


    public function down(): void
    {
        Schema::dropIfExists('kriteria');
    }
};