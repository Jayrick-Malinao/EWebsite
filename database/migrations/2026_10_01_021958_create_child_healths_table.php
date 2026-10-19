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
        Schema::create('child_healths', function (Blueprint $table) {
            $table->id();

            $table->foreignId('resident_id')
                ->constrained('residents')
                ->cascadeOnDelete();

            $table->date('assessment_date');

            $table->decimal('weight_kg', 5, 2)->nullable();
            $table->decimal('height_cm', 5, 2)->nullable();

            $table->string('nutritional_status')->nullable();

            $table->string('breastfeeding_status')->nullable();

            $table->string('vitamin_a_status')->nullable();
            $table->date('vitamin_a_date')->nullable();

            $table->string('deworming_status')->nullable();
            $table->date('deworming_date')->nullable();

            $table->text('developmental_milestones')->nullable();
            $table->text('health_assessment')->nullable();
            $table->text('remarks')->nullable();

            $table->timestamps();

            $table->index('assessment_date');
            $table->index('nutritional_status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('child_healths');
    }
};