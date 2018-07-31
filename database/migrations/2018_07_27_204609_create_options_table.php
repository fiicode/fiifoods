<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('options', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->boolean('unite')->default(false);
            $table->boolean('versemFournisseur')->default(false);
            $table->boolean('creditFournisseur')->default(false);
            $table->boolean('versemClient')->default(false);
            $table->boolean('creditClient')->default(false);
            $table->integer('client_id')->nullable();
            $table->integer('fournisseur_id')->nullable();
            $table->integer('user_id')->unsigned();
            $table->foreign('user_id', 'foreign_user')->references('id')->on('users');
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
        Schema::dropIfExists('options');
    }
}
