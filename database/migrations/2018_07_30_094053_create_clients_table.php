<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clients', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nom');
            $table->string('adress')->nullable();
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->string('entrepris')->nullable();
            $table->string('webSite')->nullable();
            $table->integer('user_id')->unsigned();
            $table->foreign('user_id', 'foreign_user_clients')->references('id')->on('users');
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
        Schema::dropIfExists('clients');
    }
}
