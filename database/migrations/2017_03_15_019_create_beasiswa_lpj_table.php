<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBeasiswaLPJTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('beasiswa_lpj', function (Blueprint $table) {
            $table->integer('id_beasiswa')->unsigned();
            $table->integer('id_lpj')->unsigned();

            $table->foreign('id_beasiswa')->references('id_beasiswa')->on('beasiswa');
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
        Schema::dropIfExists('beasiswa_lpj');
    }
}
