<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEducationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('educations', function (Blueprint $table) {
            $table->BigIncrements('id');
            $table->string('sd')->nullable();
            $table->string('smp')->nullable();
            $table->string('sma')->nullable();
            $table->string('d3_jur')->nullable();
            $table->string('d3_univ')->nullable();
            $table->string('s1_jur')->nullable();
            $table->string('s1_univ')->nullable();
            $table->string('s2_jur')->nullable();
            $table->string('s2_univ')->nullable();
            $table->string('s3_jur')->nullable();
            $table->string('s3_univ')->nullable();
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
        Schema::dropIfExists('educations');
    }
}
