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
    Schema::create('kursus_users', function (Blueprint $table) {

        $table->id();

        // 🔥 RELASI
        $table->foreignId('user_id')->constrained()->cascadeOnDelete();
        $table->foreignId('kursus_id')->constrained('kursus')->cascadeOnDelete();

        // 🔥 STATUS TRANSAKSI
        $table->enum('payment_status', ['pending','paid','failed'])
            ->default('pending');

        // 🔥 MIDTRANS
        $table->string('midtrans_order_id')->nullable();
        $table->text('snap_token')->nullable();

        // 🔥 WAKTU BAYAR
        $table->timestamp('paid_at')->nullable();

        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
{
    Schema::dropIfExists('kursus_users');
}
};
