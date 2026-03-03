<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('kepulangan_santris', function (Blueprint $table) {
            $table->id();
            $table->foreignId('santri_id')->constrained('santris')->onDelete('cascade');
            $table->foreignId('santri_sakit_id')->nullable()->constrained('santri_sakits')->onDelete('set null');

            // Jenis kepulangan
            $table->enum('jenis_kepulangan', ['Sakit', 'Izin', 'Libur', 'Lainnya'])->default('Izin');
            $table->string('alasan_pulang');

            // Tanggal & waktu
            $table->datetime('tgl_pulang');
            $table->datetime('tgl_kembali_rencana')->nullable(); // Rencana kembali
            $table->datetime('tgl_kembali_aktual')->nullable(); // Aktual kembali

            // Penjemput
            $table->string('nama_penjemput')->nullable();
            $table->string('hubungan_penjemput')->nullable(); // Orang Tua, Wali, dll
            $table->string('no_telepon_penjemput')->nullable();

            // Status kepulangan
            $table->enum('status', ['Pulang', 'Kembali', 'Terlambat'])->default('Pulang');

            // Catatan tambahan
            $table->text('catatan')->nullable();

            // User yang mencatat
            $table->foreignId('created_by')->nullable()->constrained('users')->onDelete('set null');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kepulangan_santris');
    }
};
