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
            $table->integer('id_beasiswa')->unsigned();
            $table->integer('id_syarat');
            $table->string('syarat',50);

            $table->primary(['id_beasiswa','id_syarat']);
            $table->foreign('id_beasiswa')->references('id_beasiswa')->on('beasiswa');
        });
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
