<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMHariLibur extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('m_harilibur', function (Blueprint $table) {
            $table->increments('id_harilibur');
            $table->string('tgl_harilibur')->nulable();
            $table->string('deskripsi')->nulable();
            $table->string('dibuat')->nulable();
            $table->string('dimodifikasi')->nulable();
            $table->string('status')->nulable();
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
        Schema::dropIfExists('m_harilibur');
    }
}
