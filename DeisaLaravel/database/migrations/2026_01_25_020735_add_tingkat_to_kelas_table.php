<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('kelas', function (Blueprint $table) {
            $table->integer('tingkat')->after('nama_kelas')->nullable()->comment('10, 11, 12');
        });
    }

    public function down(): void
    {
        Schema::table('kelas', function (Blueprint $table) {
            $table->dropColumn('tingkat');
        });
    }
};
