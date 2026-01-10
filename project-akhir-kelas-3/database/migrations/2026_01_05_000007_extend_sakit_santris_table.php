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
        Schema::table('sakit_santris', function (Blueprint $table) {
            // User who recorded this (petugas)
            $table->foreignId('user_id')->nullable()->after('santri_id')->constrained('users')->onDelete('set null');
            
            // Snapshot of class name when sick (in case santri moves class)
            $table->string('kelas_text')->nullable()->after('user_id');
            
            // Severity level
            $table->enum('tingkat_kondisi', ['ringan', 'sedang', 'berat'])->default('ringan')->after('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('sakit_santris', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropColumn(['user_id', 'kelas_text', 'tingkat_kondisi']);
        });
    }
};
