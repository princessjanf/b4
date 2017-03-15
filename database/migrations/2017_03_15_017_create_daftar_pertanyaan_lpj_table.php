<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDaftarPertanyaanLPJTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('daftar_pertanyaan_lpj', function (Blueprint $table) {
            $table->integer('id_lpj')->unsigned();
            $table->integer('id_pertanyaan');
            $table->text('pertanyaan');
            $table->text('jawaban')->nullable();

            $table->primary(['id_lpj','id_pertanyaan']);
            $table->foreign('id_lpj')->references('id_lpj')->on('lpj');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('daftar_pertanyaan_lpj');
    }
}
