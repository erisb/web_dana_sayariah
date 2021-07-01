<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateManagePenghargaansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('manage_penghargaans', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title')->nullable();
            $table->longText('keterangan')->nullable();
            $table->date('tgl_publish')->nullable();
            $table->string('author')->nullable();
            $table->string('gambar',200)->nullable();
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
        Schema::dropIfExists('manage_penghargaans');
    }
}
