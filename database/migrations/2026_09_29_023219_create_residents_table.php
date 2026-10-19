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
        Schema::create('residents', function (Blueprint $table) {
            $table->id();

            // Basic resident information
            $table->string('first_name');
            $table->string('middle_name')->nullable();
            $table->string('last_name');
            $table->string('suffix')->nullable();

            // Personal information
            $table->date('birth_date');
            $table->enum('gender', [
                'Male',
                'Female',
            ]);

            // Contact information
            $table->string('contact_number')->nullable();
            $table->string('email')->nullable();

            // Address information
            $table->string('household_address')->nullable();

            // Civil information
            $table->string('civil_status')->nullable();

            // Optional health-center identifiers
            $table->string('philhealth_number')->nullable();

            // Status
            $table->enum('status', [
                'Active',
                'Inactive',
            ])->default('Active');

            $table->timestamps();

            // Useful indexes for searching/filtering
            $table->index('last_name');
            $table->index('birth_date');
            $table->index('gender');
            $table->index('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('residents');
    }
};