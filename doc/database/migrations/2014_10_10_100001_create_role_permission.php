<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRolePermission extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('role_permission', function (Blueprint $table) {
            $table->id();
            $table->integer('role_id')->unsigned();
            $table->foreign('role_id')->references('id')->on('role')->onDelete('cascade');
            $table->integer('module_id')->unsigned();
            $table->foreign('module_id')->references('id')->on('module')->onDelete('cascade');
            $table->boolean('allow_view', false);
            $table->boolean('allow_create', false);
            $table->boolean('allow_edit', false);
            $table->boolean('allow_delete', false);
            $table->boolean('allow_extra', false);
            $table->boolean('allow_master', false);
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
        Schema::dropIfExists('role_permission');
    }
}
