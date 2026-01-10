<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('obat_histories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('obat_id')->constrained('obats')->onDelete('cascade');
            $table->date('tanggal_pembelian');
            $table->integer('jumlah');
            $table->string('supplier')->nullable();
            $table->decimal('harga_total', 12, 2)->nullable();
            $table->text('keterangan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('obat_histories');
    }
};
