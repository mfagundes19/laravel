<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReceivements extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('receivements', function (Blueprint $table) {
            $table->id();
            $table->integer('receipt_plan_id')->unsigned()->nullable();
            $table->foreign('receipt_plan_id')->references('id')->on('receipt_plans')->onDelete('cascade');            
            $table->integer('fiscal_status_id')->unsigned()->nullable();
            $table->foreign('fiscal_status_id')->references('id')->on('fiscal_status')->onDelete('cascade');            
            $table->integer('segregation_status_id')->unsigned()->nullable();
            $table->foreign('segregation_status_id')->references('id')->on('segregation_status')->onDelete('cascade');
            $table->date('date_receivement')->nullable();
            $table->integer('user_id')->unsigned()->nullable();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->integer('container_type_id')->unsigned()->nullable();
            $table->foreign('container_type_id')->references('id')->on('container_types')->onDelete('cascade');
            $table->integer('cargo_quality_id')->unsigned()->nullable();
            $table->foreign('cargo_quality_id')->references('id')->on('cargo_qualities')->onDelete('cascade');
            $table->string('cargo_addressing')->nullable();            
            $table->string('number_volume_processed')->nullable();
            $table->integer('segregator_id')->unsigned()->nullable();
            $table->foreign('segregator_id')->references('id')->on('segregators')->onDelete('cascade');
            $table->date('date_start')->nullable();
            $table->date('date_end')->nullable();
            $table->string('time_total_cargo_processing')->nullable();
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
        Schema::dropIfExists('receivements');
    }
}
