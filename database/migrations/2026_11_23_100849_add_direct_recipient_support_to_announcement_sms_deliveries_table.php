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
        Schema::table('announcement_sms_deliveries', function (Blueprint $table) {
            $table->foreignId('resident_id')
                ->nullable()
                ->after('household_head_resident_id')
                ->constrained('residents')
                ->cascadeOnDelete();

            $table->string('recipient_type', 20)
                ->default('household_head')
                ->after('resident_id');

            $table->foreignId('household_id')
                ->nullable()
                ->change();

            $table->foreignId('household_head_resident_id')
                ->nullable()
                ->change();

            $table->index(['announcement_id', 'contact_number']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('announcement_sms_deliveries', function (Blueprint $table) {
            $table->dropIndex(['announcement_id', 'contact_number']);
            $table->dropForeign(['resident_id']);
            $table->dropColumn(['resident_id', 'recipient_type']);

            $table->foreignId('household_id')
                ->nullable(false)
                ->change();

            $table->foreignId('household_head_resident_id')
                ->nullable(false)
                ->change();
        });
    }
};
