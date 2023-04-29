<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterTableReceiptPlanAddPaymentTerm extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('receipt_plan', function (Blueprint $table) {
            $table->integer('payment_term_id')->unsigned()->nullable();
            $table->foreign('payment_term_id')->references('id')->on('payment_term')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('receipt_plan', function (Blueprint $table) {
            $table->dropColumn('payment_term_id');
        });
    }
}
