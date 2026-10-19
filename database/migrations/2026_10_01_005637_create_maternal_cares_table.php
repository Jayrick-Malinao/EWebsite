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
        Schema::create('maternal_cares', function (Blueprint $table) {
            $table->id();

            /*
             * Resident receiving maternal care.
             */
            $table->foreignId('resident_id')
                ->constrained('residents')
                ->cascadeOnDelete();

            /*
             * Pregnancy information.
             */
            $table->unsignedInteger('pregnancy_number')->nullable();

            $table->date('last_menstrual_period')->nullable();

            $table->date('expected_delivery_date')->nullable();

            $table->date('actual_delivery_date')->nullable();

            /*
             * Pregnancy status.
             *
             * Examples:
             * Pregnant
             * Delivered
             * Miscarriage
             * Stillbirth
             * Completed
             */
            $table->string('pregnancy_status')
                ->default('Pregnant');

            /*
             * Prenatal information.
             */
            $table->date('last_prenatal_visit')->nullable();

            $table->unsignedInteger('prenatal_visit_count')
                ->default(0);

            /*
             * Delivery information.
             */
            $table->string('delivery_type')->nullable();

            $table->string('place_of_delivery')->nullable();

            $table->string('birth_outcome')->nullable();

            /*
             * Risk and clinical information.
             */
            $table->text('pregnancy_risk_factors')->nullable();

            $table->text('medical_conditions')->nullable();

            $table->text('medications')->nullable();

            $table->text('remarks')->nullable();

            $table->timestamps();

            /*
             * Indexes for frequently searched/filterable fields.
             */
            $table->index('pregnancy_status');
            $table->index('expected_delivery_date');
            $table->index('actual_delivery_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('maternal_cares');
    }
}; 