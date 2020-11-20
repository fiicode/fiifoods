<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFieldEntiteMotif extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('options', function (Blueprint $table) {
            $table->boolean('entite')->default(false)->after('unite');
            $table->boolean('motif')->default(false)->after('entite');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('options', function (Blueprint $table) {
            //
        });
    }
}
