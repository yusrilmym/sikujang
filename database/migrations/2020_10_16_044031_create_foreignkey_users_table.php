<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateForeignkeyUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function(Blueprint $table){
            $table->foreign('id_finger')->references('id')->on('fingers')->onDelete('set null');
            $table->foreign('id_alam')->references('id')->on('alamats')->onDelete('set null');
            $table->foreign('id_jafung')->references('id')->on('positions')->onDelete('set null');
            $table->foreign('id_edu')->references('id')->on('educations')->onDelete('set null');
            $table->foreign('id_unit')->references('id')->on('units')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('foreignkey_users');
    }
}
