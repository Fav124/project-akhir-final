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
        Schema::create('reminders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('title');
            $table->text('message')->nullable();
            $table->string('type'); // sick, obat, general
            $table->string('priority')->default('normal'); // low, normal, high
            $table->boolean('is_dismissed')->default(false);
            $table->json('data')->nullable(); // extra data like santri_id or obat_id
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reminders');
    }
};
