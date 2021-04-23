<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAgricolturasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('agricolturas', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id');
            $table->integer('settimana');
            $table->integer('mese');
            $table->integer('anno');
            $table->string('giorno');
            $table->char('tipo');
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
        Schema::dropIfExists('agricolturas');
    }
}
