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
    Schema::create('kursus', function (Blueprint $table) {
        $table->id();
        $table->string('nama_kursus');
        $table->integer('harga');
        $table->integer('jumlah_pertemuan');
        $table->text('deskripsi')->nullable();
        $table->string('gambar')->nullable();
        $table->boolean('is_rekomendasi')->default(false);
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kursus');
    }
};
