<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMenuRoleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('menu_role', function (Blueprint $table) {
            $table->id();
            $table->foreignId('role_id')->constrained('options')->onDelete('cascade');
            $table->foreignId('menu_id')->constrained('options')->onDelete('cascade');
            $table->timestamps();
            //$table->foreign('role_id')->references('id')->on('options');
            // $table->foreign('menu_id)->references('id')->on('options');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('menu_role');
    }
}
