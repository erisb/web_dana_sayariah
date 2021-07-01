<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDetilImbalUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detil_imbal_users', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('investor_id')->nullable();
            $table->integer('proyek_id')->nullable();
            $table->integer('pendanaan_id')->nullable();
            $table->decimal('total_imbal',15,2)->nulable();
            $table->decimal('total_dana',15,2)->nulable();
            $table->decimal('sisa_imbal',15,2)->nulable();
            $table->decimal('proprosional',15,2)->nulable();            
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
        Schema::dropIfExists('detil_imbal_users');
    }
}
