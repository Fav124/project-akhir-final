<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class BackfillTotalTerpakaiToObatsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $totals = DB::table('sakit_santri_obat')
            ->select('obat_id', DB::raw('SUM(jumlah) as total'))
            ->groupBy('obat_id')
            ->get();

        foreach ($totals as $item) {
            DB::table('obats')
                ->where('id', $item->obat_id)
                ->update(['total_terpakai' => $item->total]);
        }
    }

    public function down()
    {
        DB::table('obats')->update(['total_terpakai' => 0]);
    }
}
