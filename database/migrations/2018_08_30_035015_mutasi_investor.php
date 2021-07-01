<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class MutasiInvestor extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mutasi_investor', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('investor_id');
            $table->integer('pendanaan_id');
            $table->string('nominal');
            $table->string('perihal')->nullable();
            $table->string('tipe');
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
        Schema::dropIfExists('mutasi_investor');
    }
}
