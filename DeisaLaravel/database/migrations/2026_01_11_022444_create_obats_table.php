<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('obats', function (Blueprint $table) {
            $table->id();
            $table->string('kode_obat')->unique()->nullable();
            $table->string('nama_obat');
            $table->enum('kategori', ['Tablet', 'Kapsul', 'Sirup', 'Salep', 'Injeksi', 'Lainnya'])->nullable();
            $table->text('deskripsi')->nullable();
            $table->integer('stok_awal')->default(0);
            $table->integer('stok')->default(0);
            $table->integer('stok_minimum')->default(10);
            $table->string('satuan')->default('Strip'); // Tablet, Kapsul, Botol, Strip, Box, ml, mg
            $table->decimal('harga', 10, 2)->nullable();
            $table->date('tgl_kadaluarsa')->nullable();
            $table->string('lokasi_penyimpanan')->nullable();
            $table->string('foto')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('obats');
    }
};
