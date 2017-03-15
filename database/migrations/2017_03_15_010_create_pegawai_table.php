<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePegawaiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pegawai', function (Blueprint $table) {
            $table->char('no_identitas',18);
            $table->string('username',20);
            $table->integer('id_role_pegawai')->unsigned();
            $table->string('jabatan',50);

            $table->primary(['no_identitas','username']);
            $table->foreign('id_role_pegawai')->references('id_role_pegawai')->on('role_pegawai');
            $table->foreign('username')->references('username')->on('user');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pegawai');
    }
}
