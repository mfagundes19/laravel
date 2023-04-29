<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReceivementPackpage extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('receivement_packpage', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id')->unsigned()->nullable();
            $table->foreign('user_id')->references('id')->on('user')->onDelete('cascade');
            $table->integer('receivement_id')->unsigned()->nullable();
            $table->foreign('receivement_id')->references('id')->on('receivement')->onDelete('cascade');
            $table->integer('product_type_id')->unsigned()->nullable();
            $table->foreign('product_type_id')->references('id')->on('product_type')->onDelete('cascade');
            $table->integer('shaving_type_id')->unsigned()->nullable();
            $table->foreign('shaving_type_id')->references('id')->on('shaving_type')->onDelete('cascade');
            $table->integer('container_type_id')->unsigned()->nullable();
            $table->foreign('container_type_id')->references('id')->on('container_type')->onDelete('cascade');
            $table->string('number_card')->nullable();
            $table->string('weight')->nullable();
            $table->string('elapsed_time')->nullable();
            $table->string('status')->nullable();
            $table->text('comment')->nullable();
            $table->text('observations')->nullable();
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
        Schema::dropIfExists('receivement_packpage');
    }
}

