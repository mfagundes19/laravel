<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReceivement extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('receivement', function (Blueprint $table) {
            $table->id();
            $table->integer('receipt_plan_id')->unsigned()->nullable();
            $table->foreign('receipt_plan_id')->references('id')->on('receipt_plan')->onDelete('cascade');
            $table->integer('supplier_id')->unsigned()->nullable();
            $table->foreign('supplier_id')->references('id')->on('supplier')->onDelete('cascade');
            $table->integer('branch_id')->unsigned()->nullable();
            $table->foreign('branch_id')->references('id')->on('branch')->onDelete('cascade');
            $table->integer('operation_type_id')->unsigned()->nullable();
            $table->foreign('operation_type_id')->references('id')->on('operation_type')->onDelete('cascade');
            $table->integer('container_type_id')->unsigned()->nullable();
            $table->foreign('container_type_id')->references('id')->on('container_type')->onDelete('cascade');
            $table->integer('status_id')->unsigned()->nullable();
            $table->foreign('status_id')->references('id')->on('receivement_status')->onDelete('cascade');
            $table->date('date_receivement')->nullable();
            $table->string('nf_number')->nullable();            
            $table->string('ra_number')->nullable();
            $table->string('weight_nf')->nullable();
            $table->string('weight_received')->nullable();
            $table->string('weight_negotiated')->nullable();
            $table->string('weight_difference')->nullable();
            $table->string('weight_reference')->nullable();
            $table->string('start_time_receivement')->nullable();
            $table->string('final_time_receivement')->nullable();
            $table->string('receiver')->nullable();
            $table->string('massiness')->nullable();
            $table->string('massiness_received')->nullable();
            $table->string('time_discharge')->nullable();
            $table->text('checklist')->nullable();
            $table->text('observations')->nullable();
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
        Schema::dropIfExists('receivement');
    }
}
