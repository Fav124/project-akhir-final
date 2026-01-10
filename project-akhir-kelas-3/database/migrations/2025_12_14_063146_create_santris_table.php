<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSantrisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('santris', function (Blueprint $table) {
            $table->id();
            $table->string('foto')->nullable();
            $table->string('nis')->unique();
            $table->string('nama_lengkap');
            $table->enum('jenis_kelamin', ['laki-laki','perempuan']);
            $table->foreignId('kelas_id')->constrained('kelas')->onDelete('cascade');
            $table->string('tempat_lahir');
            $table->date('tanggal_lahir');
            $table->string('status');
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
        Schema::dropIfExists('santris');
    }
}
