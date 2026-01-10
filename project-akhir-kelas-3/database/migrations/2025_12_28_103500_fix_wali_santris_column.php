<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class FixWaliSantrisColumn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Drop the incorrect foreign key and column
        Schema::table('wali_santris', function (Blueprint $table) {
            $table->dropForeign(['santris_id']);
            $table->dropColumn('santris_id');
        });

        // Add the correct column
        Schema::table('wali_santris', function (Blueprint $table) {
            $table->foreignId('santri_id')->after('id')->constrained('santris')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('wali_santris', function (Blueprint $table) {
            $table->dropForeign(['santri_id']);
            $table->dropColumn('santri_id');
        });

        Schema::table('wali_santris', function (Blueprint $table) {
            $table->foreignId('santris_id')->after('id')->constrained('santris')->onDelete('cascade');
        });
    }
}
