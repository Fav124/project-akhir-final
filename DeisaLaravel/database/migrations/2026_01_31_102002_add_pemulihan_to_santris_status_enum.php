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
        Schema::table('santris', function (Blueprint $table) {
            $table->enum('status_kesehatan', ['Sehat', 'Sakit', 'Rawat Inap', 'Pulang', 'Pemulihan'])->default('Sehat')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('santris', function (Blueprint $table) {
            $table->enum('status_kesehatan', ['Sehat', 'Sakit', 'Rawat Inap', 'Pulang'])->default('Sehat')->change();
        });
    }
};
