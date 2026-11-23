<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('announcement_sms_status_checks', function (Blueprint $table) {
            $table->text('provider_reason')->nullable();
        });
    }

    public function down(): void
    {
        throw new RuntimeException('This migration cannot be rolled back without discarding SMS status check reasons.');
    }
};
