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
        Schema::create('certificates', function (Blueprint $table) {
            $table->id();

            // Automatically generated certificate reference number
            $table->string('certificate_number')->unique();

            // Resident receiving the certificate
            $table->foreignId('resident_id')
                ->constrained('residents')
                ->cascadeOnDelete();

            // Certificate classification
            $table->string('certificate_type');

            // Reason/purpose for requesting the certificate
            $table->string('purpose')->nullable();

            // Date the certificate was issued
            $table->date('date_issued');

            // User who issued/generated the certificate
            $table->foreignId('issued_by')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            // Certificate status
            $table->enum('status', [
                'Issued',
                'Cancelled',
            ])->default('Issued');

            // Additional notes
            $table->text('remarks')->nullable();

            $table->timestamps();

            // Useful indexes
            $table->index('certificate_type');
            $table->index('date_issued');
            $table->index('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('certificates');
    }
};