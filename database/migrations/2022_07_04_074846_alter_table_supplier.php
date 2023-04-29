<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

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
            $table->string('nickname')->nullable();
            $table->string('state_registration')->nullable();
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
            $table->dropColumn('nickname');
            $table->dropColumn('state_registration');
        });
    }
}
