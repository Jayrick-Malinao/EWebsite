<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('announcements', function (Blueprint $table) {
            $table->id();

            $table->string('title');
            $table->text('message');

            $table->enum('target_type', [
                'specific',
                'senior',
                'children',
                'pregnant',
                'general',
                'age_bracket',
            ]);

            $table->unsignedTinyInteger('min_age')->nullable();
            $table->unsignedTinyInteger('max_age')->nullable();

            $table->enum('priority', [
                'Normal',
                'Important',
                'Urgent',
            ])->default('Normal');

            $table->enum('status', [
                'Draft',
                'Published',
                'Archived',
            ])->default('Draft');

            $table->timestamp('published_at')->nullable();

            $table->foreignId('created_by')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->timestamps();

            $table->index('target_type');
            $table->index('status');
            $table->index('published_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('announcements');
    }
};

