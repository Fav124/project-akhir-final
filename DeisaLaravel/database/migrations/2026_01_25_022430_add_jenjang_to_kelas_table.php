<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('kelas', function (Blueprint $table) {
            $table->string('jenjang')->after('id')->nullable()->comment('TK, SD, SMP, SMA, SMK, Kuliah');
            $table->string('nama_kelas')->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('kelas', function (Blueprint $table) {
            $table->dropColumn('jenjang');
        });
    }
};
