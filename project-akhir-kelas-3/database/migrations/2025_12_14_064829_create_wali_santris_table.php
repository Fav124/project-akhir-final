<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWaliSantrisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wali_santris', function (Blueprint $table) {
            $table->id();
            $table->foreignId('santris_id')->constrained('santris')->onDelete('cascade');
            $table->string('nama_wali');
            $table->string('tempat_lahir');
            $table->date('tanggal_lahir');
            $table->string('hubungan');
            $table->string('no_hp');
            $table->string('alamat')->nullable();
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
        Schema::dropIfExists('wali_santris');
    }
}
