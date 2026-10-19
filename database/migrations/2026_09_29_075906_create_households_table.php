<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('households', function (Blueprint $table) {
            $table->id();

            $table->string('household_code')
                ->unique();

            $table->string('household_head_name');

            $table->string('address');

            $table->string('contact_number')
                ->nullable();

            $table->enum('status', [
                'Active',
                'Inactive',
            ])->default('Active');

            $table->timestamps();

            $table->index('household_head_name');
            $table->index('status');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('households');
    }
};

