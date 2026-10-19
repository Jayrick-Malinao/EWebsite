<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('announcement_sms_deliveries', function (Blueprint $table) {
            $table->id();

            $table->foreignId('announcement_id')
                ->constrained('announcements')
                ->cascadeOnDelete();

            $table->foreignId('household_id')
                ->constrained('households')
                ->cascadeOnDelete();

            $table->foreignId('household_head_resident_id')
                ->constrained('residents')
                ->restrictOnDelete();

            $table->string('contact_number', 30);

            $table->timestamp('sent_at')->nullable();

            $table->enum('status', [
                'Pending',
                'Sent',
                'Failed',
            ])->default('Pending');

            $table->text('failure_reason')->nullable();

            $table->timestamps();

            $table->unique([
                'announcement_id',
                'household_id',
            ]);

            $table->index('household_head_resident_id');
            $table->index('status');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('announcement_sms_deliveries');
    }
};

