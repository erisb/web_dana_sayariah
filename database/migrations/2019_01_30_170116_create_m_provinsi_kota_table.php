<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMProvinsiKotaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('m_provinsi_kota', function (Blueprint $table) {
            $table->increments('id_provinsi');
            $table->integer('kode_provinsi')->nullable();
            $table->string('kode_kota',5)->nullable();
            $table->string('nama_provinsi',155)->nullable();
            $table->string('nama_kota',155)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('m_provinsi_kota');
    }
}
