<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class PenarikanDana extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('penarikan_dana', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('investor_id');
            $table->string('jumlah');
            $table->string('no_rekening');
            $table->string('bank');
            $table->string('perihal');
            $table->boolean('accepted')->default(0);
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
        Schema::dropIfExists('penarikan_dana');
    }
}
