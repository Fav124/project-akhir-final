<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('wali_santris', function (Blueprint $table) {
            $table->id();
            $table->foreignId('santri_id')->constrained('santris')->onDelete('cascade');
            $table->string('nama_wali');
            $table->enum('hubungan', ['Ayah', 'Ibu', 'Kakek', 'Nenek', 'Paman', 'Bibi', 'Wali']);
            $table->string('no_hp');
            $table->string('no_hp_alt')->nullable();
            $table->string('pekerjaan')->nullable();
            $table->text('alamat')->nullable(); // Auto-fill from santri logic on frontend, but stored here
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('wali_santris');
    }
};
