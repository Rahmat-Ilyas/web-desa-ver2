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
        Schema::create('programs', function (Blueprint $table) {
            $table->id();
            $table->string('judul');
            $table->string('kategori')->default('Pembangunan Fisik');
            $table->text('deskripsi');
            $table->string('icon')->default('fa-tasks');
            $table->string('color')->default('bg-blue-50 text-blue-600');
            $table->string('status')->default('Rencana'); // Rencana, Berjalan, Selesai
            $table->integer('progress')->default(0);
            $table->string('waktu_pelaksanaan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('programs');
    }
};
