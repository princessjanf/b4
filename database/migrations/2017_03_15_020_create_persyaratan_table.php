<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePersyaratanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('persyaratan', function (Blueprint $table) {
            $table->increments('id_syarat');
            $table->integer('id_beasiswa')->unsigned();
            $table->string('syarat',50);

            $table->foreign('id_beasiswa')->references('id_beasiswa')->on('beasiswa');
        });
        DB::unprepared('ALTER TABLE `persyaratan` DROP PRIMARY KEY, ADD PRIMARY KEY ( `id_syarat`,`id_beasiswa`)');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('persyaratan');
    }
}
