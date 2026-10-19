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
        Schema::create('audit_logs', function (Blueprint $table) {
            $table->id();

            // User who performed the action.
            $table->foreignId('user_id')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            // Action performed: created, updated, deleted, login, logout, etc.
            $table->string('action', 50);

            // System module affected: Residents, Households, Schedule, etc.
            $table->string('module', 100)->nullable();

            // Type and ID of the affected record.
            $table->string('auditable_type', 255)->nullable();
            $table->unsignedBigInteger('auditable_id')->nullable();

            // Human-readable explanation of the activity.
            $table->text('description')->nullable();

            // Values before and after an update, when applicable.
            $table->json('old_values')->nullable();
            $table->json('new_values')->nullable();

            // Request information for accountability/security.
            $table->ipAddress('ip_address')->nullable();
            $table->text('user_agent')->nullable();

            $table->timestamps();

            // Useful for audit-log filtering and reporting.
            $table->index(['user_id', 'created_at']);
            $table->index(['module', 'created_at']);
            $table->index(['action', 'created_at']);
            $table->index(['auditable_type', 'auditable_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('audit_logs');
    }
};

