<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // 1. Add angkatan_id to kelas
        Schema::table('kelas', function (Blueprint $table) {
            if (!Schema::hasColumn('kelas', 'angkatan_id')) {
                $table->foreignId('angkatan_id')->nullable()->constrained('angkatans')->onDelete('set null');
            }
        });

        // 2. Create kelas_jurusan pivot table
        Schema::create('kelas_jurusan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kelas_id')->constrained('kelas')->onDelete('cascade');
            $table->foreignId('jurusan_id')->constrained('jurusans')->onDelete('cascade');
            $table->timestamps();
        });

        // 3. Migrate existing data from kelas.jurusan_id to kelas_jurusan pivot
        $existingClasses = DB::table('kelas')->get();
        foreach ($existingClasses as $class) {
            if (isset($class->jurusan_id)) {
                DB::table('kelas_jurusan')->insert([
                    'kelas_id' => $class->id,
                    'jurusan_id' => $class->jurusan_id,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }

        // 4. Optionally drop the old column (commented out if you want to keep data for safety during dev, but user said "classes can have more than one major" suggesting a pivot is needed now)
        Schema::table('kelas', function (Blueprint $table) {
            $table->dropForeign(['jurusan_id']);
            $table->dropColumn('jurusan_id');
        });
    }

    public function down(): void
    {
        Schema::table('kelas', function (Blueprint $table) {
            $table->foreignId('jurusan_id')->nullable()->constrained('jurusans');
        });

        // Migrate back if needed (complex, usually not fully possible if multiple)
        
        Schema::dropIfExists('kelas_jurusan');
        
        Schema::table('kelas', function (Blueprint $table) {
            $table->dropForeign(['angkatan_id']);
            $table->dropColumn('angkatan_id');
        });
    }
};
