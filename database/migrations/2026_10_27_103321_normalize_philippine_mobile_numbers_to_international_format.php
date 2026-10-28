<?php

use App\Support\PhilippineMobileNumberFormatter;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        foreach ([
            ['residents', 'contact_number'],
            ['households', 'contact_number'],
            ['health_records', 'emergency_contact_number'],
            ['senior_citizens', 'caregiver_contact'],
            ['announcement_sms_deliveries', 'contact_number'],
        ] as [$table, $column]) {
            $this->normalizeColumn($table, $column);
        }

        $this->normalizeQuery(
            DB::table('system_settings')->where('key', 'contact_number'),
            'system_settings',
            'value',
        );
    }

    public function down(): void
    {
        // Formatting changes cannot be reversed without the original values.
    }

    private function normalizeColumn(string $table, string $column): void
    {
        if (! Schema::hasTable($table) || ! Schema::hasColumn($table, $column)) {
            return;
        }

        $this->normalizeQuery(
            DB::table($table)->whereNotNull($column),
            $table,
            $column,
        );
    }

    private function normalizeQuery(Builder $query, string $table, string $column): void
    {
        $query
            ->select(['id', $column])
            ->orderBy('id')
            ->chunkById(500, function ($records) use ($table, $column): void {
                foreach ($records as $record) {
                    $currentNumber = (string) $record->{$column};
                    $normalizedNumber = PhilippineMobileNumberFormatter::normalize($currentNumber);

                    if ($normalizedNumber !== $currentNumber) {
                        DB::table($table)
                            ->where('id', $record->id)
                            ->update([$column => $normalizedNumber]);
                    }
                }
            });
    }
};
