<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePendonorTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pendonor', function (Blueprint $table) {
           $table->increments('id_pendonor');
           $table->string('username',20);
           $table->string('nama_instansi',50);


           $table->foreign('username')->references('username')->on('user');
        });

    DB::unprepared('ALTER TABLE `pendonor` DROP PRIMARY KEY, ADD PRIMARY KEY ( `id_pendonor`,`username`)');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pendonor');
    }
}
