
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReceiptPlanPrevision extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('receipt_plan_prevision', function (Blueprint $table) {
            $table->id();
            $table->integer('receipt_plan_id')->unsigned()->nullable();
            $table->foreign('receipt_plan_id')->references('id')->on('receipt_plan')->onDelete('cascade');
            $table->integer('product_category_id')->unsigned()->nullable();
            $table->foreign('product_category_id')->references('id')->on('product_category')->onDelete('cascade');
            $table->integer('product_type_id')->unsigned()->nullable();
            $table->foreign('product_type_id')->references('id')->on('product_type')->onDelete('cascade');
            $table->integer('shaving_type_id')->unsigned()->nullable();
            $table->foreign('shaving_type_id')->references('id')->on('shaving_type')->onDelete('cascade');
            $table->string('prevision_percent')->nullable();
            $table->string('prevision_quantity')->nullable();
            $table->string('prevision_amount')->nullable();
            $table->string('prevision_total')->nullable();
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
        Schema::dropIfExists('receipt_plan_prevision');
    }
}
