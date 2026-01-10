<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTotalTerpakaiToObatsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('obats', function (Blueprint $table) {
            $table->integer('total_terpakai')->default(0)->after('stok');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('obats', function (Blueprint $table) {
            $table->dropColumn('total_terpakai');
        });
    }
}
