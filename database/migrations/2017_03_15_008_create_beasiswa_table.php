<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBeasiswaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('beasiswa', function (Blueprint $table) {
            $table->increments('id_beasiswa');
            $table->string('nama_beasiswa');
            $table->text('deskripsi_beasiswa');
            $table->text('syarat'); //masih text belum object
            $table->integer('id_kategori')->unsigned();
            $table->integer('id_status')->unsigned();
            $table->dateTime('tanggal_buka');
            $table->dateTime('tanggal_tutup');
            $table->integer('kuota');
            $table->bigInteger('nominal');
            $table->string('dokumen_kerja_sama',100);
            $table->bigInteger('dana');
            $table->boolean('flag');
            $table->boolean('public');

            $table->foreign('id_kategori')->references('id_kategori')->on('kategori_beasiswa');
            $table->foreign('id_status')->references('id_status')->on('status_beasiswa');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('beasiswas');
    }
}
