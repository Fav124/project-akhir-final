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
            $table->string('nama_obat');
            $table->text('deskripsi')->nullable();
            $table->integer('stok')->default(0);
            $table->string('satuan'); // contoh: tablet, botol, strip, ml
            $table->integer('stok_minimum')->default(0); // batas minimum stok
            $table->decimal('harga_satuan', 10, 2)->nullable(); // bisa kosong kalau belum diketahui
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('obats');
    }
};
