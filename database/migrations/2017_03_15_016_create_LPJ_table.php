<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLPJTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lpj', function (Blueprint $table) {
            $table->increments('id_lpj');
            $table->string('username',20);
            $table->integer('id_beasiswa')->unsigned();
            $table->string('periode',15);

            $table->foreign('username')->references('username')->on('mahasiswa');
            $table->foreign('id_beasiswa')->references('id_beasiswa')->on('beasiswa');
        });
    DB::unprepared('ALTER TABLE `lpj` DROP PRIMARY KEY, ADD PRIMARY KEY ( `id_lpj`,`username`,`id_beasiswa`)');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('lpj');
    }
}
