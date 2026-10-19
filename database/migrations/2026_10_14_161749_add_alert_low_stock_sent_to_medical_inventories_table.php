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
        Schema::table('medical_inventories', function (Blueprint $table) {
            $table->boolean('alert_low_stock_sent')
                ->default(false)
                ->after('alert_expiry_sent');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('medical_inventories', function (Blueprint $table) {
            $table->dropColumn('alert_low_stock_sent');
        });
    }
};
