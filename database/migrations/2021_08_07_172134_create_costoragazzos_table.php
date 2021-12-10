<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCostoragazzosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('costoragazzos', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('client_id');
            $table->integer('mese');
            $table->integer('anno');
            $table->float('contributo')->default(0);
            $table->float('totale');
            $table->float('saldo');
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
        Schema::dropIfExists('costoragazzos');
    }
}
