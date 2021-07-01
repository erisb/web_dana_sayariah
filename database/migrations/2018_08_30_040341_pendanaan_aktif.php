<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class PendanaanAktif extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pendanaan_aktif', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('investor_id');
            $table->integer('proyek_id');
            $table->decimal('total_dana',15,2);
            $table->decimal('nominal_awal',15,2);
            $table->date('tanggal_invest');
            $table->date('last_pay')->nullable();
            $table->tinyInteger('status')->default('1');
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
        Schema::dropIfExists('pendanaan_aktif');
    }
}
