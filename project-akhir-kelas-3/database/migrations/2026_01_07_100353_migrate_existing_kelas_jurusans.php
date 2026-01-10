<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MigrateExistingKelasJurusans extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // 1. Get existing data from kelas
        $existing = \Illuminate\Support\Facades\DB::table('kelas')->whereNotNull('jurusan_id')->get();
        
        // Clear previous attempts if any
        \Illuminate\Support\Facades\DB::table('jurusan_kelas')->truncate();
        
        // 2. Insert into jurusan_kelas
        foreach ($existing as $item) {
            \Illuminate\Support\Facades\DB::table('jurusan_kelas')->insert([
                'jurusan_id' => $item->jurusan_id,
                'kelas_id' => $item->id,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // 3. Drop column from kelas
        Schema::table('kelas', function (Blueprint $table) {
            $table->dropForeign(['jurusan_id']);
            $table->dropColumn('jurusan_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('kelas', function (Blueprint $table) {
            $table->unsignedBigInteger('jurusan_id')->nullable();
        });

        // Optional: Re-migrate back? Usually not perfectly reversible if multiple jurusans were added.
        // We'll just leave them in pivot table or pick one.
    }
}
