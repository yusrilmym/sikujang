<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAlamatsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('alamats', function (Blueprint $table) {
            $table->BigIncrements('id');
            $table->string('kp')->nullable();
            $table->string('jl')->nullable();
            $table->string('rt')->nullable();
            $table->string('rw')->nullable();
            $table->string('no')->nullable();
            $table->string('kel')->nullable();
            $table->string('kec')->nullable();
            $table->string('kota')->nullable();
            $table->string('kab')->nullable();
            $table->string('prov')->nullable();
            $table->string('pos')->nullable();
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
        Schema::dropIfExists('alamats');
    }
}
