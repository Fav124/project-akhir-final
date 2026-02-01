<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('kelas', function (Blueprint $table) {
            $table->string('kode_kelas')->nullable()->unique()->after('nama_kelas');
        });

        Schema::table('santri_sakits', function (Blueprint $table) {
            $table->string('kode_riwayat')->nullable()->unique()->after('id');
        });

        Schema::table('jurusans', function (Blueprint $table) {
            // Check if column exists but not unique, or just add unique index
            // Since it's nullable in creation, let's just add unique constraint.
            // But if there are duplicates it will fail. Assuming empty or unique for now.
            // It was created nullable in previous migration.
            // SQLite might have issues modifying columns, but let's try standard way.
            // Actually, better to just modify the column to be unique.
            // However, modifying columns depending on DB driver can be tricky.
            // Let's try adding unique index.
            $table->unique('kode_jurusan');
        });
    }

    public function down(): void
    {
        Schema::table('kelas', function (Blueprint $table) {
            $table->dropColumn('kode_kelas');
        });

        Schema::table('santri_sakits', function (Blueprint $table) {
            $table->dropColumn('kode_riwayat');
        });

        Schema::table('jurusans', function (Blueprint $table) {
            $table->dropUnique(['kode_jurusan']);
        });
    }
};
