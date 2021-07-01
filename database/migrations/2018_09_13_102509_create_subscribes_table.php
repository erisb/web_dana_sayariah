<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSubscribesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('subscribes', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('investor_id');
            $table->integer('pendanaanAktif_id');
            $table->integer('interval_pay')->default(1);
            $table->date('last_pay')->nullable();
            $table->string('BANK');
            $table->string('rekening');
            $table->string('pemilik_rekening');
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
        Schema::dropIfExists('subscribes');
    }
}
