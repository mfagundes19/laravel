<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNegociation extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('negotiation', function (Blueprint $table) {
            $table->id();
            $table->integer('supplier_id')->unsigned()->nullable();
            $table->foreign('supplier_id')->references('id')->on('supplier')->onDelete('cascade');
            $table->string('supplier_name')->nullable();
            $table->string('supplier_contact')->nullable();
            $table->string('supplier_telephone')->nullable();
            $table->string('supplier_email')->nullable();
            $table->string('shipping_amount')->nullable();
            $table->string('supplier_state')->nullable();
            $table->string('supplier_city')->nullable();
            $table->text('observations')->nullable();
            $table->string('negotiation_upload')->nullable();
            $table->string('total_amount')->nullable();
            $table->string('total_quantity')->nullable();
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
        Schema::dropIfExists('negotiation');
    }
}

