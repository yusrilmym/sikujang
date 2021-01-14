<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTupoksijftTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tupoksijft', function (Blueprint $table) {
            $table->BigIncrements('id');
            $table->unsignedBigInteger('id_jabatan')->nullable();
            $table->string('butir_kegiatan')->nullable();
            $table->float('angka_kredit')->nullable();
            $table->string('satuan_hasil')->nullable();
            $table->float('ket_hasil')->nullable();
            $table->float('konstanta')->nullable();
            $table->float('wpk')->nullable();
            $table->float('volume_kerja')->nullable();
            $table->float('beban_kerja')->nullable();
            $table->float('formasi')->nullable();
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
        Schema::dropIfExists('tupoksijft');
    }
}
