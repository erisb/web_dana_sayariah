<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateManageKhazanahsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('manage_khazanahs', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title')->nulable();
            $table->string('author')->nulable();
            $table->date('tgl_publish')->nulable();
            $table->longText('keterangan')->nulable();
            $table->string('gambar')->nulable();
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
        Schema::dropIfExists('manage_khazanahs');
    }
}
