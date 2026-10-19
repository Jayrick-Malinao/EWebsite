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
        Schema::create('events', function (Blueprint $table) {
            $table->id();

            $table->string('title');

            $table->string('event_type');

            $table->date('event_date');

            $table->time('start_time')->nullable();

            $table->time('end_time')->nullable();

            $table->string('location')->nullable();

            $table->text('description')->nullable();

            /*
             * Prevents the 7-day reminder from
             * being generated more than once.
             */
            $table->boolean('reminder_sent')->default(false);

            /*
             * User who created the event.
             */
            $table->foreignId('created_by')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->timestamps();

            /*
             * Useful for calendar queries.
             */
            $table->index('event_date');

            $table->index([
                'event_date',
                'reminder_sent',
            ]);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};