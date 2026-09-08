<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Jalankan migrasi penambahan kolom
     */
    public function up(): void
    {
        Schema::table('tickets', function (Blueprint $table) {
            if (!Schema::hasColumn('tickets', 'technician_id')) {
                $table->foreignId('technician_id')->nullable()->after('status')->constrained('users')->nullOnDelete();
            }
            if (!Schema::hasColumn('tickets', 'technician_name')) {
                $table->string('technician_name')->nullable()->after('technician_id');
            }
            if (!Schema::hasColumn('tickets', 'notes')) {
                $table->text('notes')->nullable()->after('technician_name');
            }
        });
    }

    /**
     * Batalkan migrasi
     */
    public function down(): void
    {
        Schema::table('tickets', function (Blueprint $table) {
            if (Schema::hasColumn('tickets', 'technician_id')) {
                $table->dropForeign(['technician_id']);
                $table->dropColumn('technician_id');
            }
            if (Schema::hasColumn('tickets', 'technician_name')) {
                $table->dropColumn('technician_name');
            }
            if (Schema::hasColumn('tickets', 'notes')) {
                $table->dropColumn('notes');
            }
        });
    }
};