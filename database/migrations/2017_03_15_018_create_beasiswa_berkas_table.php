<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBeasiswaBerkasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('beasiswa_berkas', function (Blueprint $table) {
            $table->integer('id_beasiswa')->unsigned();
            $table->integer('id_berkas')->unsigned();

            $table->foreign('id_beasiswa')->references('id_beasiswa')->on('beasiswa');
            $table->foreign('id_berkas')->references('id_berkas')->on('berkas');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('beasiswa_berkas');
    }
}
