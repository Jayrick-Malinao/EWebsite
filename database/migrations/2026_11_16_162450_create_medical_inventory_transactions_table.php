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
        Schema::create('medical_inventory_transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('medical_inventory_id')
                ->constrained()
                ->restrictOnDelete();
            $table->foreignId('resident_id')
                ->constrained()
                ->restrictOnDelete();
            $table->foreignId('released_by_id')
                ->constrained('users')
                ->restrictOnDelete();
            $table->string('method', 100);
            $table->text('purpose');
            $table->unsignedInteger('quantity');
            $table->dateTime('released_at');
            $table->timestamps();

            $table->index(
                ['medical_inventory_id', 'released_at'],
                'medical_inventory_transactions_inventory_released_index'
            );
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('medical_inventory_transactions');
    }
};
