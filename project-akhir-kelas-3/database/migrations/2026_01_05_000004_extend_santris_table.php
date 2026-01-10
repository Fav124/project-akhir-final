<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('santris', function (Blueprint $table) {
            // Add jurusan relation
            $table->foreignId('jurusan_id')->nullable()->after('kelas_id')->constrained('jurusans')->onDelete('set null');
            
            // Add additional santri data
            $table->string('asal_daerah')->nullable()->after('tanggal_lahir');
            $table->enum('status_kesehatan', ['sehat', 'sakit'])->default('sehat')->after('status');
            
            // Wali/Orang tua data
            $table->string('nama_ayah')->nullable()->after('status_kesehatan');
            $table->string('nama_ibu')->nullable()->after('nama_ayah');
            $table->string('nama_wali')->nullable()->after('nama_ibu');
            $table->string('pekerjaan_wali')->nullable()->after('nama_wali');
            $table->string('phone_wali')->nullable()->after('pekerjaan_wali');
            $table->text('alamat_wali')->nullable()->after('phone_wali');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('santris', function (Blueprint $table) {
            $table->dropForeign(['jurusan_id']);
            $table->dropColumn([
                'jurusan_id',
                'asal_daerah',
                'status_kesehatan',
                'nama_ayah',
                'nama_ibu',
                'nama_wali',
                'pekerjaan_wali',
                'phone_wali',
                'alamat_wali'
            ]);
        });
    }
};
