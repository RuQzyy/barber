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
    Schema::table('kursus', function (Blueprint $table) {

        if (!Schema::hasColumn('kursus', 'kelas')) {
            $table->enum('kelas', ['private','reguler'])
                ->after('nama_kursus');
        }

        if (!Schema::hasColumn('kursus', 'materi')) {
            $table->text('materi')->nullable();
        }

        if (!Schema::hasColumn('kursus', 'wa_instruktur')) {
            $table->string('wa_instruktur')->nullable();
        }

        if (!Schema::hasColumn('kursus', 'wa_group')) {
            $table->string('wa_group')->nullable();
        }

    });
}

public function down(): void
{
    Schema::table('kursus', function (Blueprint $table) {

        $table->dropColumn([
            'kelas',
            'materi',
            'wa_instruktur',
            'wa_group'
        ]);

    });
}
};
