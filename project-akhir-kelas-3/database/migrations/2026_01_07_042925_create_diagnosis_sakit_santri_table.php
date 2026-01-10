<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDiagnosisSakitSantriTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('diagnosis_sakit_santri', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sakit_santri_id')->constrained('sakit_santris')->onDelete('cascade');
            $table->foreignId('diagnosis_id')->constrained('diagnoses')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('diagnosis_sakit_santri');
    }
}
