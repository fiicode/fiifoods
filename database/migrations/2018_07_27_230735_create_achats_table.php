<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAchatsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('achats', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('foods_name_id')->unsigned();
            $table->foreign('foods_name_id', 'foreign_foods_name_achats')->references('id')->on('foods_names')->onDelete('cascade');
            $table->string('code')->nullable();
            $table->double('qtt')->unsigned()->nullable();
            //$table->string('unity')->nullable();
            $table->double('priceOfPurchase')->unsigned()->nullable();// prix d'achat
            $table->double('sellingPrice')->unsigned()->nullable();// prix de vente
            $table->double('paye')->unsigned()->nullable();
            $table->integer('fournisseur_id')->unsigned()->nullable();
            $table->foreign('fournisseur_id', 'foreign_fournisseur_achats')->references('id')->on('fournisseurs')->onDelete('cascade');
            $table->double('mntTotalAchat')->storedAs('qtt * priceOfPurchase');
            $table->double('mntTotalVent')->storedAs('qtt * sellingPrice');
            $table->double('reste')->storedAs('mntTotalAchat - paye');
            $table->integer('order_id')->unsigned()->nullable();
            $table->foreign('order_id', 'foreign_order_achats')->references('id')->on('orders')->onDelete('cascade');
            $table->integer('user_id')->unsigned();
            $table->foreign('user_id', 'foreign_user_achats')->references('id')->on('users')->onDelete('cascade');
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
        Schema::dropIfExists('achats');
    }
}
