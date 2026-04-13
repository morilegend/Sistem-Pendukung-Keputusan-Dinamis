<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('sub_kriteria', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_kriteria'); 
            $table->string('nama'); 
            $table->integer('nilai_crisp');
            $table->float('nilai_fuzzy', 8, 4);
            $table->timestamps();

            $table->foreign('id_kriteria')
                  ->references('id')
                  ->on('kriteria')
                  ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sub_kriteria');
    }
};