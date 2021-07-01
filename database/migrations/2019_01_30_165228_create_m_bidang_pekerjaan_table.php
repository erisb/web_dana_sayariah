<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMBidangPekerjaanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('m_bidang_pekerjaan', function (Blueprint $table) {
            $table->increments('id_bidang_pekerjaan');
            $table->string('kode_bidang_pekerjaan',10)->nullable();
            $table->string('bidang_pekerjaan',100)->nullable();
            $table->string('penjelasan',1500)->nullable();
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
        Schema::dropIfExists('m_bidang_pekerjaan');
    }
}
