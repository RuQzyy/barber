<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
  public function up()
{
    Schema::create('bookings', function (Blueprint $table) {
        $table->id();

        $table->foreignId('user_id')->constrained()->cascadeOnDelete();
        $table->foreignId('barber_id')->constrained()->cascadeOnDelete();
        $table->foreignId('layanan_item_id')->constrained()->cascadeOnDelete();

        $table->date('tanggal');
        $table->time('jam');

        $table->integer('nomor_antrian');

        $table->string('qr_code')->unique()->nullable();

        $table->enum('status', ['menunggu', 'diproses', 'selesai'])
            ->default('menunggu');

        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
