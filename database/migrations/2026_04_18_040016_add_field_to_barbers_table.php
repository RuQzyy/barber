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
    Schema::table('barbers', function (Blueprint $table) {

        if (!Schema::hasColumn('barbers', 'no_hp')) {
            $table->string('no_hp')->nullable();
        }

        if (!Schema::hasColumn('barbers', 'is_mentor')) {
            $table->boolean('is_mentor')->default(false);
        }

    });
}

public function down(): void
{
    Schema::table('barbers', function (Blueprint $table) {

        $table->dropColumn(['no_hp','is_mentor']);

    });
}
};
