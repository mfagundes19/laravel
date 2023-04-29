<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDateTableNegociation extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('negotiation', function (Blueprint $table) {
            $table->date('date_expiration')->nullable()->after('total_quantity');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('negotiation', function (Blueprint $table) {
            $table->dropColumn('date_expiration');
        });
    }
}
