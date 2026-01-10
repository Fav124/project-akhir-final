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
        Schema::table('obats', function (Blueprint $table) {
            $table->date('tanggal_kadaluarsa')->nullable()->after('harga_satuan')->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('obats', function (Blueprint $table) {
            $table->dropIndex(['tanggal_kadaluarsa']);
            $table->dropColumn('tanggal_kadaluarsa');
        });
    }
};
