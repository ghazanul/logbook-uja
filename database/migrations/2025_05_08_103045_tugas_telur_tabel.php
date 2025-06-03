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
        Schema::create('tugas_telur', function (Blueprint $table) {
            $table->id();
            $table->integer('jumlah_telur');
            $table->integer('jumlah_telur_rusak')->nullable();;
            $table->foreignId('tugas_id')->constrained()->onDelete('cascade');
            $table->timestamps();
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tugas_telur');
    }
};
