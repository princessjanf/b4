<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMelamarTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('melamar', function (Blueprint $table) {
            $table->integer('id_beasiswa')->unsigned();
            $table->string('username',20);
            $table->string('status_lamaran',20);
            $table->dateTime('waktu_melamar');

            $table->primary(['id_beasiswa','username']);
            $table->foreign('id_beasiswa')->references('id_beasiswa')->on('beasiswa');
            $table->foreign('username')->references('username')->on('mahasiswa');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('melamar');
    }
}
