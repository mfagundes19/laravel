<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ReceiptPlanNotifyReceipt extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('receipt_plan_notify_receipt', function (Blueprint $table) {
            $table->id();
            $table->integer('receipt_plan_id')->unsigned()->nullable();
            $table->foreign('receipt_plan_id')->references('id')->on('receipt_plan')->onDelete('cascade');
            $table->integer('user_id')->unsigned()->nullable();
            $table->foreign('user_id')->references('id')->on('user')->onDelete('cascade');
            $table->text('observations')->nullable();
            $table->date('date')->nullable();
            $table->string('hour')->nullable();
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
        Schema::dropIfExists('receipt_plan_notify_receipt');
    }
}
