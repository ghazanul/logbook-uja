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
        Schema::create('tugas', function (Blueprint $table) {
            $table->id();
            $table->enum('nama_tugas', ['Pakan', 'Kebersihan Kandang', 'Telur', 'Update Keadaan Bebek', 'Air']);
            $table->string('Status')->nullable();
            $table->date('tanggal');
            $table->string('keterangan')->nullable();
            $table->string('gambar');
            $table->foreignId('kandang_id')->constrained()->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tugas');
    }
};
