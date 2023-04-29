<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSupplier extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('supplier', function (Blueprint $table) {
            $table->id();
            $table->integer('registration_type_id')->unsigned()->nullable();
            $table->integer('supplier_category_id')->unsigned()->nullable();
            $table->foreign('supplier_category_id')->references('id')->on('supplier_category')->onDelete('cascade');
            $table->string('company');
            $table->string('name');
            $table->string('document');
            $table->string('email');
            $table->string('email_secundary')->nullable();
            $table->string('telephone');
            $table->string('telephone_secundary')->nullable();
            $table->string('zipcode')->nullable();
            $table->string('address')->nullable();
            $table->string('number')->nullable();
            $table->string('complement')->nullable();
            $table->string('city')->nullable();
            $table->string('district')->nullable();
            $table->string('state')->nullable();
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
        Schema::dropIfExists('supplier');
    }
}
