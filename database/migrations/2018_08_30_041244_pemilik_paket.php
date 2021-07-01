<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class PemilikPaket extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pemilik_paket', function (Blueprint $table) {
            $table->increments('id_pemilik');
            $table->integer('proyek_id');
            $table->string('nama_pemilik');
            $table->string('email_pemilik');
            $table->string('phone_pemilik');
            $table->string('dokumen_terkait');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pemilik_paket');
    }
}
