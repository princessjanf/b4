<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePegawaiUniversitasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pegawai_universitas', function (Blueprint $table) {
            $table->char('no_identitas',18);
            $table->string('lokasi',50);

            $table->primary('no_identitas',18);
            $table->foreign('no_identitas',18)->references('no_identitas')->on('pegawai');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pegawai_universitas');
    }
}
