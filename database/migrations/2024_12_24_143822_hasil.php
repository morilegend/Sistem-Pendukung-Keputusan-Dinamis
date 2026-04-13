<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up()
    {
        Schema::create('hasil', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_kategori_hasil');
            $table->string('alternatif');
            $table->integer('ranking');
            $table->decimal('penilaian', 10, 3);
            $table->string('alternatif_fuzzy');
            $table->integer('ranking_fuzzy');
            $table->decimal('penilaian_fuzzy', 10, 3);
            $table->timestamps();

            $table->foreign('id_kategori_hasil')
                ->references('id')->on('kategori_hasil') 
                ->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('hasil');
    }
};