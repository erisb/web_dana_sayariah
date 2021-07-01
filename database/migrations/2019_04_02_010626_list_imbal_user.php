<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class list_imbal_user extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('list_imbal_user', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('proyek_id')->nulable();
            $table->integer('pendanaan_id')->nulable();
            $table->integer('investor_id')->nulable();
            $table->date('tanggal_payout')->nulable();
            $table->decimal('imbal_payout',15,2)->nulable();
            $table->integer('status_payout')->nulable();
            $table->integer('status_update')->nulable();
            $table->date('tgl_update')->nulable();
            $table->string('keterangan')->nulable();
            $table->integer('status_libur')->nulable();
            $table->string('keterangan_libur')->nulable();
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
        Schema::dropIfExists('list_imbal_user');
    }
}
