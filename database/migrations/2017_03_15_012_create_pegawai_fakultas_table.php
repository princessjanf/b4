<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePegawaiFakultasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pegawai_fakultas', function (Blueprint $table) {
            $table->char('no_identitas',10);
            $table->integer('id_fakultas')->unsigned();

            $table->primary('no_identitas',10);
            $table->foreign('no_identitas',10)->references('no_identitas')->on('pegawai');
            $table->foreign('id_fakultas')->references('id_fakultas')->on('fakultas');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pegawai_fakultas');
    }
}
