<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReceivementUpload extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('receivement_upload', function (Blueprint $table) {
            $table->id();
            $table->integer('receivement_id')->unsigned()->nullable();
            $table->foreign('receivement_id')->references('id')->on('receivement')->onDelete('cascade');
            $table->string('filename')->nullable();
            $table->string('name')->nullable();
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
        Schema::dropIfExists('receivement_upload');
    }
}

