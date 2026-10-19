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
        Schema::table('residents', function (Blueprint $table) {
            $table->foreignId('household_id')
                ->nullable()
                ->after('id')
                ->constrained('households')
                ->nullOnDelete();

            $table->boolean('is_household_head')
                ->default(false)
                ->after('household_id');

            $table->index([
                'household_id',
                'is_household_head',
            ]);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('residents', function (Blueprint $table) {
            $table->dropForeign(['household_id']);
            $table->dropIndex([
                'residents_household_id_is_household_head_index',
            ]);

            $table->dropColumn([
                'household_id',
                'is_household_head',
            ]);
        });
    }
};