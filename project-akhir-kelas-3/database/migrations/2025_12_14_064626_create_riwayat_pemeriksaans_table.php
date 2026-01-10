<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRiwayatPemeriksaansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('riwayat_pemeriksaans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('santri_id')->constrained('santris')->onDelete('cascade');
            $table->date('tanggal_pemeriksaan');
            $table->string('keluhan');
            $table->string('suhu_tubuh');
            $table->string('tindakan');
            $table->enum('status_kondisi',['sehat','sakit','perlu perhatian']);
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
        Schema::dropIfExists('riwayat_pemeriksaans');
    }
}
