<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductType extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_type', function (Blueprint $table) {
            $table->id();
            $table->integer('category_id')->unsigned()->nullable();
            $table->foreign('category_id')->references('id')->on('product_category')->onDelete('cascade');
            $table->string('name');                
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
        Schema::dropIfExists('product_type');
    }
}
