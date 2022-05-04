<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddGiornoToPrimanota extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('primanotas', function (Blueprint $table) {
            $table->addColumn('date', 'giorno')->after('mese')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('primanotas', function (Blueprint $table) {
            $table->dropColumn('giorno');
        });
    }
}
