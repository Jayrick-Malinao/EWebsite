<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('announcement_sms_deliveries', function (Blueprint $table) {
            $table->timestamp('status_check_attempted_at')->nullable();
            $table->string('status_check_result', 32)->nullable();
        });

        Schema::create('announcement_sms_status_checks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('announcement_sms_delivery_id')
                ->constrained('announcement_sms_deliveries', indexName: 'sms_status_checks_delivery_fk')
                ->cascadeOnDelete();
            $table->timestamp('checked_at');
            $table->string('result', 32);
            $table->unsignedSmallInteger('http_status')->nullable();
            $table->string('provider_status', 32)->nullable();
        });

        Schema::create('announcement_sms_retry_history', function (Blueprint $table) {
            $table->id();
            $table->foreignId('announcement_sms_delivery_id')
                ->constrained('announcement_sms_deliveries', indexName: 'sms_retry_history_delivery_fk')
                ->cascadeOnDelete();
            $table->foreignId('requested_by')->nullable()->constrained('users')->nullOnDelete();
            $table->string('provider_reference', 128)->nullable();
            $table->string('provider_status', 32)->nullable();
            $table->unsignedSmallInteger('provider_http_status')->nullable();
            $table->timestamp('attempt_started_at')->nullable();
            $table->timestamp('sent_at')->nullable();
            $table->text('failure_reason')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        throw new RuntimeException('This migration cannot be rolled back without discarding SMS check and retry history.');
    }
};
