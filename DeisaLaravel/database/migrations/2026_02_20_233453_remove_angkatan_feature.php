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
        // Drop the foreign key and column from the santris table
        Schema::table('santris', function (Blueprint $table) {
            $table->dropForeign(['angkatan_id']);
            $table->dropColumn('angkatan_id');
        });

        // Drop the angkatans table
        Schema::dropIfExists('angkatans');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::create('angkatans', function (Blueprint $table) {
            $table->id();
            $table->string('nama_angkatan');
            $table->year('tahun');
            $table->timestamps();
        });

        Schema::table('santris', function (Blueprint $table) {
            $table->foreignId('angkatan_id')->nullable()->constrained('angkatans')->nullOnDelete();
        });
    }
};