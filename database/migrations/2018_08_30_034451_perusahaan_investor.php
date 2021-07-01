<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class PerusahaanInvestor extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('perusahaan_investor', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('investor_id');
            $table->string('nama_perusahaan');
            $table->string('alamat_perusahaan');
            $table->string('jabatan');
            $table->string('pic_surat_tugas');
            $table->string('desc_tugas');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('perusahaan_investor');
    }
}
