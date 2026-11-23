<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('health_records')) {
            Schema::create('health_records', function (Blueprint $table) {
                $table->id();
                $table->foreignId('resident_id')->constrained()->cascadeOnDelete();
                $table->string('blood_type')->nullable();
                $table->text('allergies')->nullable();
                $table->text('chronic_conditions')->nullable();
                $table->text('medical_history')->nullable();
                $table->text('current_medications')->nullable();
                $table->text('disabilities')->nullable();
                $table->text('family_medical_history')->nullable();
                $table->string('emergency_contact_name')->nullable();
                $table->string('emergency_contact_number')->nullable();
                $table->string('emergency_contact_relationship')->nullable();
                $table->text('notes')->nullable();
                $table->timestamps();
            });
        }
    }

    public function down(): void
    {
        throw new RuntimeException('This migration cannot be rolled back without risking health record data.');
    }
};
