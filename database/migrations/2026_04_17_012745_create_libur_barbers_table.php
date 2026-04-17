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
        Schema::create('libur_barbers', function (Blueprint $table) {
    $table->id();
    $table->foreignId('barber_id')->constrained()->cascadeOnDelete();

    $table->date('tanggal');
    $table->string('keterangan')->nullable(); // 🔥 FIX DI SINI

    $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('libur_barbers');
    }
};
