<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('santri_sakits', function (Blueprint $table) {
            $table->timestamp('tgl_pulang')->nullable()->after('tgl_sembuh');
            $table->timestamp('tgl_kembali')->nullable()->after('tgl_pulang');
            $table->string('alasan_pulang', 255)->nullable()->after('tujuan_rujukan');
        });
    }

    public function down(): void
    {
        Schema::table('santri_sakits', function (Blueprint $table) {
            $table->dropColumn(['tgl_pulang', 'tgl_kembali', 'alasan_pulang']);
        });
    }
};

