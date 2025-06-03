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
        Schema::create('tugas_keadaan_bebek', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tugas_id')->constrained()->onDelete('cascade');
            $table->integer('jumlah_total_bebek');
            $table->integer('jumlah_bebek_sakit')->nullable();
            $table->integer('jumlah_bebek_sehat')->nullable();
            $table->integer('jumlah_bebek_mati')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tugas_keadaan_bebek');
    }
};
