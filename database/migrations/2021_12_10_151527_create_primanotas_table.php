<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePrimanotasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('primanotas', function (Blueprint $table) {
            $table->id();
            $table->float('importo');
            $table->string('causale');
            $table->string('progressivo')->nullable();
            $table->bigInteger('user_id');
            $table->integer('anno');
            $table->integer('mese');
            $table->string('tipo');
            $table->string('fornitore')->nullable();
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
        Schema::dropIfExists('primanotas');
    }
}
