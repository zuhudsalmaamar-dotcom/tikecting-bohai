<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tickets', function (Blueprint $table) {
            $table->id();

            $table->string('ticket_number')->unique();

            // User yang membuat tiket
            $table->foreignId('user_id')
                ->constrained('users')
                ->cascadeOnDelete();

            // Teknisi yang menangani tiket
            $table->foreignId('technician_id')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            // Kategori tiket
            $table->foreignId('category_id')
                ->constrained('categories')
                ->restrictOnDelete();

            $table->string('title');
            $table->text('description');

            $table->enum('priority', [
                'low',
                'medium',
                'high',
                'critical'
            ])->default('medium');

            $table->enum('status', [
                'open',
                'assigned',
                'in_progress',
                'resolved',
                'closed',
                'rejected'
            ])->default('open');

            $table->string('attachment')->nullable();

            $table->timestamp('resolved_at')->nullable();
            $table->timestamp('closed_at')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tickets');
    }
};