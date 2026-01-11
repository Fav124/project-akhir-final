<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('diagnoses', function (Blueprint $table) {
            $table->id();
            $table->string('nama_diagnosis');
            $table->enum('kategori', ['Ringan', 'Sedang', 'Berat'])->default('Ringan');
            $table->text('deskripsi')->nullable();
            $table->softDeletes(); // Spec: Tidak bisa dihapus jika masih digunakan (soft delete)
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('diagnoses');
    }
};
