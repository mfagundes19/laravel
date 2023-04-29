<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReceiptPlan extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('receipt_plan', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id')->unsigned()->nullable();
            $table->foreign('user_id')->references('id')->on('user')->onDelete('cascade');
            $table->integer('supplier_id')->unsigned()->nullable();
            $table->foreign('supplier_id')->references('id')->on('supplier')->onDelete('cascade');
            $table->integer('branch_id')->unsigned()->nullable();
            $table->foreign('branch_id')->references('id')->on('branch')->onDelete('cascade');
            $table->integer('operation_type_id')->unsigned()->nullable();
            $table->foreign('operation_type_id')->references('id')->on('operation_type')->onDelete('cascade');
            $table->integer('shipping_company_id')->unsigned()->nullable();
            $table->foreign('shipping_company_id')->references('id')->on('shipping_company')->onDelete('cascade');
            $table->integer('payment_method_id')->unsigned()->nullable();
            $table->foreign('payment_method_id')->references('id')->on('payment_method')->onDelete('cascade');
            $table->date('date_start')->nullable();
            $table->date('date_expected')->nullable();
            $table->string('nf_number')->nullable();            
            $table->string('oc_number')->nullable();      
            $table->string('shipping')->nullable(); 
            $table->decimal('shipping_amount', 20, 2)->nullable();
            $table->string('place_discharge')->nullable(); 
            $table->string('payment_term')->nullable(); 
            $table->string('payment_base_date')->nullable(); 
            $table->string('payment_comment')->nullable(); 
            $table->string('total_quantity')->nullable();
            $table->string('total_traded')->nullable();
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
        Schema::dropIfExists('receipt_plan');
    }
}
