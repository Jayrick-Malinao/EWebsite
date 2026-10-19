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
        Schema::create('immunizations', function (Blueprint $table) {
            $table->id();

            $table->foreignId('resident_id')
                ->constrained('residents')
                ->cascadeOnDelete();

            $table->string('vaccine_name');
            $table->string('vaccine_type')->nullable();
            $table->string('dose_number')->nullable();

            $table->date('date_administered');
            $table->date('next_dose_date')->nullable();

            $table->string('batch_number')->nullable();
            $table->string('administered_by')->nullable();
            $table->string('site_of_administration')->nullable();

            $table->text('remarks')->nullable();

            $table->timestamps();

            $table->index('date_administered');
            $table->index('vaccine_name');
            $table->index('next_dose_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('immunizations');
    }
};

