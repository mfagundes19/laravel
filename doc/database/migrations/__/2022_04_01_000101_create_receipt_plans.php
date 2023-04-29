<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReceiptPlans extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('receipt_plans', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id')->unsigned()->nullable();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->integer('supplier_id')->unsigned()->nullable();
            $table->foreign('supplier_id')->references('id')->on('suppliers')->onDelete('cascade');
            $table->integer('operation_type_id')->unsigned()->nullable();
            $table->foreign('operation_type_id')->references('id')->on('operation_types')->onDelete('cascade');
            $table->date('date_start')->nullable();
            $table->date('date_expected')->nullable();
            $table->string('nf_number')->nullable();            
            $table->string('oc_number')->nullable();                        
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
        Schema::dropIfExists('receipt_plans');
    }
}
