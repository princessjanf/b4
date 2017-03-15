<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDirektoratKerjasamaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('direktorat_kerjasama', function (Blueprint $table) {
            $table->char('no_identitas',18);

            $table->primary('no_identitas',18);
            $table->foreign('no_identitas')->references('no_identitas')->on('pegawai');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('direktorat_kerjasama');
    }
}
