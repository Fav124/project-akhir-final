<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('santri_sakits', function (Blueprint $table) {
            $table->id();
            $table->foreignId('santri_id')->constrained('santris')->onDelete('cascade');
            $table->date('tgl_masuk')->default(now());
            $table->date('tgl_sembuh')->nullable();
            
            // Diagnosis string cache or primary diagnosis could be here, but we use pivot for multi-diagnosis
            $table->string('diagnosis_utama')->nullable(); // For quick view
            
            $table->text('gejala')->nullable();
            $table->text('tindakan')->nullable();
            $table->text('catatan')->nullable();
            
            // Status: Sakit, Pulang, Sembuh
            $table->enum('status', ['Sakit', 'Pulang', 'Sembuh'])->default('Sakit');
            
            // Referrals
            $table->enum('jenis_perawatan', ['UKS', 'Rumah Sakit', 'Pulang'])->default('UKS');
            $table->string('tujuan_rujukan')->nullable(); // Nama RS/Puskesmas
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('santri_sakits');
    }
};
