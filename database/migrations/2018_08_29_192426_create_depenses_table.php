<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDepensesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('depenses', function (Blueprint $table) {
            $table->increments('id');
            $table->string('description')->nullable();
            $table->double('montant')->unsigned();
            $table->integer('entite')->unsigned();
            $table->foreign('entite', 'foreign_option_entite_depenses')->references('id')->on('options');
            $table->integer('motif')->unsigned();
            $table->foreign('motif', 'foreign_option_motif_depenses')->references('id')->on('options');
            $table->integer('user_id')->unsigned();
            $table->foreign('user_id', 'foreign_user_depenses')->references('id')->on('users');
            $table->timestamps();
            $table->softDeletes();
            $table->boolean('deleted')->default(false);
            $table->boolean('archived')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('depenses');
    }
}
