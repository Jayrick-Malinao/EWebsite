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
        Schema::create('senior_citizens', function (Blueprint $table) {
            $table->id();

            /*
             * Existing resident connected to this senior citizen record.
             */
            $table->foreignId('resident_id')
                ->constrained('residents')
                ->cascadeOnDelete();

            /*
             * Senior citizen identification.
             */
            $table->string('osca_id_number')->nullable()->unique();
            $table->date('osca_registration_date')->nullable();

            /*
             * Senior citizen classification.
             */
            $table->string('senior_status')->default('Active');
            $table->string('classification')->nullable();

            /*
             * Health and assistance information.
             */
            $table->string('blood_type')->nullable();
            $table->text('medical_conditions')->nullable();
            $table->text('maintenance_medications')->nullable();
            $table->text('disabilities')->nullable();

            /*
             * Social and support information.
             */
            $table->string('living_arrangement')->nullable();
            $table->string('primary_caregiver')->nullable();
            $table->string('caregiver_contact')->nullable();

            /*
             * Benefits and services.
             */
            $table->boolean('receives_social_pension')->default(false);
            $table->boolean('receives_health_assistance')->default(false);
            $table->boolean('receives_other_benefits')->default(false);

            /*
             * Additional notes.
             */
            $table->text('remarks')->nullable();

            $table->timestamps();

            $table->index('senior_status');
            $table->index('classification');
            $table->index('osca_registration_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('senior_citizens');
    }
};