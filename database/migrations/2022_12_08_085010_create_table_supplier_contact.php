<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableSupplierContact extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('supplier_contact', function (Blueprint $table) {
            $table->id();
            $table->integer('supplier_id')->unsigned()->nullable();
            $table->foreign('supplier_id')->references('id')->on('supplier')->onDelete('cascade');
            $table->string('name')->nullable(); 
            $table->string('email')->nullable(); 
            $table->string('telephone')->nullable(); 
            $table->string('role')->nullable();
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
        Schema::table('supplier_contact', function (Blueprint $table) {
            Schema::dropIfExists('supplier_contact');
        });
    }
}
