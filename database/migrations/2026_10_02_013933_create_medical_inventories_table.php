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
        Schema::create('medical_inventories', function (Blueprint $table) {
            $table->id();

            $table->string('medicine_name');

            $table->date('expiry_date');

            $table->unsignedInteger('quantity');

            /*
             * These fields prevent the same expiry alert
             * from being sent repeatedly.
             */
            $table->boolean('alert_1_month_sent')->default(false);
            $table->boolean('alert_15_days_sent')->default(false);
            $table->boolean('alert_7_days_sent')->default(false);
            $table->boolean('alert_expiry_sent')->default(false);

            $table->timestamps();

            /*
             * Indexes for faster expiry monitoring.
             */
            $table->index('expiry_date');
            $table->index(['expiry_date', 'quantity']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('medical_inventories');
    }
};