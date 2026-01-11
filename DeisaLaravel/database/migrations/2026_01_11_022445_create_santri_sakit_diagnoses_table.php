<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('santri_sakit_diagnoses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('santri_sakit_id')->constrained('santri_sakits')->onDelete('cascade');
            $table->foreignId('diagnosis_id')->constrained('diagnoses')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('santri_sakit_diagnoses');
    }
};
