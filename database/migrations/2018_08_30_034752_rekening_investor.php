<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RekeningInvestor extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rekening_investor', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('investor_id');
            $table->string('va_number');
            $table->decimal('total_dana',15,2);
            $table->decimal('unallocated',15,2);
            
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
        Schema::dropIfExists('rekening_investor');
    }
}
