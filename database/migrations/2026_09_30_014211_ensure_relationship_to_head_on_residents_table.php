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
        if (! Schema::hasColumn('residents', 'relationship_to_head')) {
            Schema::table('residents', function (Blueprint $table) {
                $table->string('relationship_to_head', 50)
                    ->nullable()
                    ->after('is_household_head');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasColumn('residents', 'relationship_to_head')) {
            Schema::table('residents', function (Blueprint $table) {
                $table->dropColumn('relationship_to_head');
            });
        }
    }
};