<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Proyek extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('proyek', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nama')->nullable();
            $table->string('alamat')->nullable();
            $table->longText('geocode')->nullable();
            $table->decimal('profit_margin',5,2)->nullable();
            $table->decimal('total_need',15,2)->nullable();
            $table->decimal('harga_paket',15,2)->nullable();
            $table->string('akad')->nullable();
            $table->date('tgl_mulai')->nullable();
            $table->date('tgl_selesai')->nullable();

            $table->date('tgl_mulai_penggalangan')->nullable();
            $table->date('tgl_selesai_penggalangan')->nullable();

            $table->decimal('terkumpul',15,2)->nullable();
            $table->boolean('status')->nullable();
            
            $table->string('status_tampil')->nullable();
            $table->string('waktu_bagi')->nullable();
            $table->string('tenor_waktu')->nullable();
            $table->longText('embed_picture')->nullable();

            $table->integer('id_deskripsi')->nullable();
            $table->integer('id_legalitas')->nullable();
            $table->integer('id_pemilik')->nullable();
            $table->integer('id_simulasi')->nullable();           

            $table->string('gambar_utama')->nullable();
            $table->tinyInteger('interval')->default('1');
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
        Schema::dropIfExists('proyek');
    }
}
