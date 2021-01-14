<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use phpDocumentor\Reflection\Types\Nullable;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->BigIncrements('id');
            $table->string('nickname');
            $table->string('fullname');
            $table->string('nip', 30)->unique();
            $table->string('nik', 30)->nullable();
            $table->string('gol')->nullable();
            $table->string('email')->unique();
            $table->date('tmt')->nullable();
            $table->unsignedBigInteger('id_alam')->nullable();
            $table->unsignedBigInteger('id_jafung')->nullable();
            $table->unsignedBigInteger('id_edu')->nullable();
            $table->unsignedBigInteger('id_unit')->nullable();
            $table->unsignedBigInteger('id_finger')->nullable();
            $table->string('jenis_peg')->nullable();
            $table->string('agama')->nullable();
            $table->string('tpt_lahir')->nullable();
            $table->date('tgl_lahir')->nullable();
            $table->string('gender')->nullable();
            $table->string('status')->default('aktif')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('role')->default('user');
            $table->mediumText('bio')->nullable();
            $table->string('photo')->default('avatar.png')->nullable();
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
