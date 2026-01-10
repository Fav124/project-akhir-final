<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('sakit_santris', function (Blueprint $table) {
            $table->id();
            $table->foreignId('santri_id')->constrained('santris')->onDelete('cascade');
            $table->date('tanggal_mulai_sakit');
            $table->date('tanggal_selesai_sakit')->nullable();
            $table->string('diagnosis');
            $table->text('gejala');
            $table->text('tindakan');
            $table->text('resep_obat');
            $table->decimal('suhu_tubuh', 4, 1)->nullable();
            $table->enum('status', ['sakit', 'sembuh', 'kontrol', 'sehat'])->default('sakit');
            $table->text('catatan')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sakit_santris');
    }
};
