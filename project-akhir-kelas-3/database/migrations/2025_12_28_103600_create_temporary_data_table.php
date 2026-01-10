<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTemporaryDataTable extends Migration
{
    public function up()
    {
        Schema::create('temporary_data', function (Blueprint $table) {
            $table->id();
            $table->string('session_id'); // Track session pengguna
            $table->string('form_type'); // 'santri', 'sakit', 'kelas', 'obat', 'laporan'
            $table->json('data'); // Menyimpan isian form dalam format JSON

            $table->timestamps(); // created_at + updated_at otomatis

            // Index untuk performa
            $table->index('session_id');
            $table->index('form_type');

            // Cegah duplikasi data
            $table->unique(['session_id', 'form_type']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('temporary_data');
    }
}
