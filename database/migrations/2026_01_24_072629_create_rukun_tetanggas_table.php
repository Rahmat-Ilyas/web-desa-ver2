<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('rukun_tetanggas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('rukun_warga_id')->constrained('rukun_wargas')->cascadeOnDelete();
            $table->string('no_rt');
            $table->string('nama_ketua');
            $table->string('no_hp')->nullable();
            $table->string('foto_ketua')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rukun_tetanggas');
    }
};
