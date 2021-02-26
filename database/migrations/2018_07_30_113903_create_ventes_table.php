<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVentesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ventes', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('foods_name_id')->unsigned();
            $table->foreign('foods_name_id', 'foreign_foods_name_ventes')->references('id')->on('foods_names')->onDelete('cascade');
            $table->string('factureNum')->nullable();
            $table->double('qtt')->unsigned()->nullable();
            $table->double('pu')->unsigned()->nullable();
            $table->double('paye')->unsigned()->nullable();
            $table->integer('client_id')->unsigned()->nullable();
            $table->foreign('client_id', 'foreign_client_ventes')->references('id')->on('clients')->onDelete('cascade');
            $table->double('mtt')->storedAs('qtt * pu');
            $table->double('reste')->storedAs('mtt - paye');
            $table->integer('facture_id')->unsigned()->nullable();
            $table->foreign('facture_id', 'foreign_facture_ventes')->references('id')->on('factures')->onDelete('cascade');
            $table->integer('user_id')->unsigned();
            $table->foreign('user_id', 'foreign_user_ventes')->references('id')->on('users')->onDelete('cascade');
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
        Schema::dropIfExists('ventes');
    }
}
