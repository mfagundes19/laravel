<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNegociationPrevision extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('negotiation_prevision', function (Blueprint $table) {
            $table->id();
            $table->integer('negotiation_id')->unsigned()->nullable();
            $table->foreign('negotiation_id')->references('id')->on('negotiation')->onDelete('cascade');
            $table->string('description')->nullable();
            $table->string('quantity')->nullable();
            $table->string('amount')->nullable();
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
        Schema::dropIfExists('negotiation_prevision');
    }
}

