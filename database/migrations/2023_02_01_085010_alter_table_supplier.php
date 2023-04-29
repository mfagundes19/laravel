<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
//SevenFev
class AlterTableSupplier extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('supplier', function (Blueprint $table) {
            $table->integer('region_id')->unsigned()->nullable()->after('supplier_category_id');
            $table->foreign('region_id')->references('id')->on('region')->onDelete('cascade');
            $table->integer('indexer_state')->nullable()->after('municipal_registration');
            $table->text('payment_information')->nullable()->after('payment_information');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('supplier', function (Blueprint $table) {
            $table->dropColumn('region_id');
            $table->dropColumn('indexer_state');
            $table->dropColumn('payment_information');
        });
    }
}
