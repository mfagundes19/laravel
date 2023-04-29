<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMenu extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('menu', function (Blueprint $table) {
            $table->id();
            $table->integer('module_id')->nullable()->unsigned();
            $table->foreign('module_id')->references('id')->on('module');
            $table->integer('nivel_1_menu_id')->nullable()->unsigned();
            $table->foreign('nivel_1_menu_id')->references('id')->on('menu');
            $table->integer('nivel_2_menu_id')->nullable()->unsigned();
            $table->foreign('nivel_2_menu_id')->references('id')->on('menu');
            $table->string('name');
            $table->string('link');
            $table->string('nivel');
            $table->boolean('active')->default(true);
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
        Schema::dropIfExists('menu');
    }
}
