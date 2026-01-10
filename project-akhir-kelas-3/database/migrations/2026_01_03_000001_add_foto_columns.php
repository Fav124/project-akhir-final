<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFotoColumns extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Tambah foto ke santris table
        if (Schema::hasTable('santris') && !Schema::hasColumn('santris', 'foto')) {
            Schema::table('santris', function (Blueprint $table) {
                $table->string('foto')->nullable()->after('nis');
            });
        }

        // Tambah foto ke obats table
        if (Schema::hasTable('obats') && !Schema::hasColumn('obats', 'foto')) {
            Schema::table('obats', function (Blueprint $table) {
                $table->string('foto')->nullable()->after('nama_obat');
            });
        }

        // Tambah foto ke wali_santris table
        if (Schema::hasTable('wali_santris') && !Schema::hasColumn('wali_santris', 'foto')) {
            Schema::table('wali_santris', function (Blueprint $table) {
                $table->string('foto')->nullable()->after('nama_wali');
            });
        }

        // Tambah foto ke sakit_santris table
        if (Schema::hasTable('sakit_santris') && !Schema::hasColumn('sakit_santris', 'foto')) {
            Schema::table('sakit_santris', function (Blueprint $table) {
                $table->string('foto')->nullable()->after('santri_id');
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Drop foto columns
        if (Schema::hasColumn('santris', 'foto')) {
            Schema::table('santris', function (Blueprint $table) {
                $table->dropColumn('foto');
            });
        }

        if (Schema::hasColumn('obats', 'foto')) {
            Schema::table('obats', function (Blueprint $table) {
                $table->dropColumn('foto');
            });
        }

        if (Schema::hasColumn('wali_santris', 'foto')) {
            Schema::table('wali_santris', function (Blueprint $table) {
                $table->dropColumn('foto');
            });
        }

        if (Schema::hasColumn('sakit_santris', 'foto')) {
            Schema::table('sakit_santris', function (Blueprint $table) {
                $table->dropColumn('foto');
            });
        }
    }
}
