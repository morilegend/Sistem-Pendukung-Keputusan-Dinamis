<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('kategori_kriteria', function (Blueprint $table) {
            $table->id(); 
            $table->unsignedBigInteger('users_id');
            $table->string('nama'); 
            $table->text('keterangan')->nullable(); 
            $table->timestamps(); 

 
            $table->foreign('users_id')
                  ->references('id')
                  ->on('users')
                  ->onDelete('cascade');
        });
    }


    public function down(): void
    {
        Schema::dropIfExists('kategori_kriteria');
    }
};