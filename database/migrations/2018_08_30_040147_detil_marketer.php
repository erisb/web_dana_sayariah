<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DetilMarketer extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detil_marketer', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('marketer_id');
            $table->string('nama_lengkap');
            $table->string('alamat');
            $table->string('phone');
            $table->string('no_rek');
            $table->string('bank');
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
        Schema::dropIfExists('detil_marketer');
    }
}
