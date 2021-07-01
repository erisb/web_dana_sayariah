<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBorrowerTipePendanaansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('brw_tipe_pendanaan', function (Blueprint $table) {
            $table->increments('tipe_id');
            $table->string('pendanaan_nama');
            $table->longText('pendanaan_keterangan');
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
        Schema::dropIfExists('brw_tipe_pendanaan');
    }
}
