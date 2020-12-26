<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePresenzeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('presenze', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id');
            $table->date('giorno');
            $table->float('ore');
            $table->integer('mese');
            $table->integer('anno');
            $table->integer('settimana');
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
        Schema::dropIfExists('presenze');
    }
}
