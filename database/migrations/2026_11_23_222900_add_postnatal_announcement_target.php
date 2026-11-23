<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('announcements', function (Blueprint $table): void {
            $table->enum('target_type', ['specific', 'senior', 'children', 'pregnant', 'postnatal', 'general', 'age_bracket'])->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (DB::table('announcements')->where('target_type', 'postnatal')->exists()) {
            throw new RuntimeException('Cannot remove the postnatal target while postnatal announcements exist.');
        }

        Schema::table('announcements', function (Blueprint $table): void {
            $table->enum('target_type', ['specific', 'senior', 'children', 'pregnant', 'general', 'age_bracket'])->change();
        });
    }
};
