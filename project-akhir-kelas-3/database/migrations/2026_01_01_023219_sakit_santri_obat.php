<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('sakit_santri_obat', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sakit_santri_id')->constrained('sakit_santris')->onDelete('cascade');
            $table->foreignId('obat_id')->constrained('obats')->onDelete('cascade');
            $table->integer('jumlah')->default(1);
            $table->string('dosis')->nullable(); // Contoh: 3x sehari
            $table->text('keterangan')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sakit_santri_obat');
    }
};
