<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTupoksijfuTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tupoksijfu', function (Blueprint $table) {
            $table->BigIncrements('id');
            $table->unsignedBigInteger('id_jabatan')->nullable();
            $table->string('uraian_tugas')->nullable();
            $table->string('satuan_hasil')->nullable();
            $table->float('waktu_penyelesaian')->nullable();
            $table->float('waktu_efektif')->nullable();
            $table->float('beban_kerja')->nullable();
            $table->float('pegawai_dibutuhkan')->nullable();
            $table->timestamps();

            $table->foreign('id_jabatan')->references('id')->on('positions')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tupoksijfu');
    }
}
