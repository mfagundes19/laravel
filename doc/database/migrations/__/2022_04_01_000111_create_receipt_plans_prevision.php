<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReceiptPlansPrevision extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('receipt_plans_prevision', function (Blueprint $table) {
            $table->id();
            $table->integer('receipt_plan_id')->unsigned()->nullable();
            $table->foreign('receipt_plan_id')->references('id')->on('receipt_plans')->onDelete('cascade');
            $table->integer('product_category_id')->unsigned()->nullable();
            $table->foreign('product_category_id')->references('id')->on('product_categories')->onDelete('cascade');
            $table->integer('product_type_id')->unsigned()->nullable();
            $table->foreign('product_type_id')->references('id')->on('product_types')->onDelete('cascade');
            $table->string('percent')->nullable();
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
        Schema::dropIfExists('receipt_plans_prevision');
    }
}
