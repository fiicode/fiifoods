<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFoodsNamesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('foods_names', function (Blueprint $table) {
            $table->increments('id');
            $table->string('foodsName')->unique();
            $table->integer('unite_id')->nullable();
            $table->boolean('inventaire')->default(false);
            $table->string('avatar')->nullable();
            $table->integer('user_id')->unsigned();
            $table->foreign('user_id', 'foreign_user_foods_names')->references('id')->on('users');
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
        Schema::dropIfExists('foods_names');
    }
}
