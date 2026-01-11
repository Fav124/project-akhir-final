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
            $table->string('nama')->nullable()->after('nama_lengkap');
        });

        Schema::table('obats', function (Blueprint $table) {
            $table->renameColumn('harga', 'harga_satuan');
            $table->renameColumn('tgl_kadaluarsa', 'tanggal_kadaluarsa');
        });

        Schema::table('santri_sakits', function (Blueprint $table) {
            $table->date('tanggal_mulai_sakit')->nullable()->after('santri_id');
            $table->text('keluhan')->nullable()->after('tanggal_mulai_sakit');
            $table->text('diagnosis')->nullable()->after('keluhan'); // Simplified string diagnosis
            $table->string('tingkat_kondisi')->nullable()->after('diagnosis');
        });

        Schema::table('wali_santris', function (Blueprint $table) {
            $table->string('no_telp_wali')->nullable()->after('no_hp');
        });
    }

    public function down(): void
    {
        Schema::table('santris', function (Blueprint $table) {
            $table->dropColumn('nama');
        });

        Schema::table('obats', function (Blueprint $table) {
            $table->renameColumn('harga_satuan', 'harga');
            $table->renameColumn('tanggal_kadaluarsa', 'tgl_kadaluarsa');
        });

        Schema::table('santri_sakits', function (Blueprint $table) {
            $table->dropColumn(['tanggal_mulai_sakit', 'keluhan', 'diagnosis', 'tingkat_kondisi']);
        });

        Schema::table('wali_santris', function (Blueprint $table) {
            $table->dropColumn('no_telp_wali');
        });
    }
};
