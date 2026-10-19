<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::dropIfExists('health_visits');
    }

    public function down(): void
    {
        Schema::create('health_visits', function (Blueprint $table) {
            $table->id();

            $table->foreignId('resident_id')
                ->constrained('residents')
                ->cascadeOnDelete();

            $table->date('visit_date');
            $table->string('visit_type');
            $table->text('chief_complaint')->nullable();
            $table->text('assessment')->nullable();
            $table->text('treatment')->nullable();
            $table->text('remarks')->nullable();
            $table->string('attended_by')->nullable();

            $table->timestamps();
        });
    }
};