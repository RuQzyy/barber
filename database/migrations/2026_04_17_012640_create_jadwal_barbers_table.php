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
        Schema::create('jadwal_barbers', function (Blueprint $table) {
        $table->id();
        $table->foreignId('barber_id')->constrained()->cascadeOnDelete();

        $table->string('hari'); // senin, selasa, dst
        $table->time('jam_mulai');
        $table->time('jam_selesai');

        $table->boolean('libur')->default(false); // true = libur

        $table->timestamps();
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jadwal_barbers');
    }
};
