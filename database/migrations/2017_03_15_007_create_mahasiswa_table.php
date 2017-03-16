<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMahasiswaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mahasiswa', function (Blueprint $table) {
            $table->string('username',20);
            $table->char('npm',10);
            $table->integer('id_fakultas')->unsigned();
            $table->integer('id_prodi')->unsigned();

            $table->primary('username');
            $table->foreign('username')->references('username')->on('user');
            $table->foreign('id_fakultas')->references('id_fakultas')->on('fakultas');
            $table->foreign('id_prodi')->references('id_prodi')->on('program_studi');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('mahasiswa');
    }
}
