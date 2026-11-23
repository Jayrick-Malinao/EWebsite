<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('announcement_sms_deliveries', function (Blueprint $table) {
            $table->string('status', 20)->default('Prepared')->change();
            $table->string('provider_reference', 128)->nullable()->unique();
            $table->string('provider_status', 32)->nullable();
            $table->unsignedSmallInteger('provider_http_status')->nullable();
            $table->unsignedSmallInteger('status_lookup_http_status')->nullable();
            $table->timestamp('attempt_started_at')->nullable();
            $table->timestamp('status_checked_at')->nullable();
        });

        DB::table('announcement_sms_deliveries')
            ->where('status', 'Sent')
            ->update(['status' => 'Unknown']);

        DB::table('announcement_sms_deliveries')
            ->where('status', 'Pending')
            ->update(['status' => 'Prepared']);

        DB::table('announcement_sms_deliveries')
            ->where('status', 'Failed')
            ->where(function ($query) {
                $query->where('failure_reason', 'like', '%acceptance is uncertain%')
                    ->orWhere('failure_reason', 'like', '%acceptance is unknown%');
            })
            ->update(['status' => 'Unknown']);
    }

    public function down(): void
    {
        throw new RuntimeException('This migration cannot be rolled back without discarding SMS tracking information.');
    }
};
