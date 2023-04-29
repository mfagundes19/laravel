<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterTableSupplier0812 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('supplier', function (Blueprint $table) {
            $table->string('municipal_registration')->nullable()->after('state_registration');
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
            $table->dropColumn('municipal_registration');
        });
    }
}
