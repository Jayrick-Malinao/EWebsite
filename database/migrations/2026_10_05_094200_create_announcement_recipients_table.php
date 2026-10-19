<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('announcement_recipients', function (Blueprint $table) {
            $table->id();

            $table->foreignId('announcement_id')
                ->constrained('announcements')
                ->cascadeOnDelete();

            $table->foreignId('resident_id')
                ->constrained('residents')
                ->cascadeOnDelete();

            $table->timestamp('read_at')->nullable();

            $table->timestamps();

            $table->unique([
                'announcement_id',
                'resident_id',
            ]);

            $table->index('resident_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('announcement_recipients');
    }
};
