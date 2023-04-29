<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReceiptPlanUpload extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('receipt_plan_upload', function (Blueprint $table) {
            $table->id();
            $table->integer('receipt_plan_id')->unsigned()->nullable();
            $table->foreign('receipt_plan_id')->references('id')->on('receipt_plan')->onDelete('cascade');
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
        Schema::dropIfExists('receipt_plan_upload');
    }
}

