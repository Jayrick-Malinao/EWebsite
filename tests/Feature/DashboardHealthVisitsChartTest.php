<?php

namespace Tests\Feature;

use App\Models\HealthVisit;
use App\Models\Resident;
use App\Models\User;
use DateTimeImmutable;
use DateTimeZone;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class DashboardHealthVisitsChartTest extends TestCase
{
    use RefreshDatabase;

    public function test_chart_groups_visits_into_the_selected_time_ranges(): void
    {
        $this->travelTo(new DateTimeImmutable('2024-01-03 12:00:00', new DateTimeZone(config('app.timezone'))));
        $this->createHealthVisitsTable();
        $resident = Resident::query()->create([
            'first_name' => 'Chart',
            'last_name' => 'Resident',
            'birth_date' => '1990-01-01',
            'gender' => 'Female',
        ]);
        foreach ([
            '2018-12-31', '2019-01-01', '2020-01-01',
            '2023-10-15', '2023-10-16', '2023-12-04', '2023-12-05', '2023-12-31',
            '2024-01-01', '2024-01-03', '2024-01-03', '2024-01-04', '2025-01-01',
        ] as $date) {
            HealthVisit::query()->create([
                'resident_id' => $resident->id,
                'visit_date' => $date,
                'visit_type' => 'Consultation',
            ]);
        }

        $response = $this->actingAs(User::factory()->create([
            'role' => 'System Administrator',
            'status' => 'active',
        ]))->withoutVite()->get(route('admin.dashboard'))->assertOk();
        $chart = $response->viewData('healthVisitChartData');

        $this->assertCount(30, $chart['day']['points']);
        $this->assertSame(['label' => 'Dec 5', 'count' => 1], $chart['day']['points'][0]);
        $this->assertSame(['label' => 'Jan 3', 'count' => 2], $chart['day']['points'][29]);
        $this->assertSame(5, array_sum(array_column($chart['day']['points'], 'count')));

        $this->assertCount(12, $chart['week']['points']);
        $this->assertSame(['label' => 'Oct 16, 2023', 'count' => 1], $chart['week']['points'][0]);
        $this->assertSame(['label' => 'Jan 1, 2024', 'count' => 3], $chart['week']['points'][11]);
        $this->assertSame(7, array_sum(array_column($chart['week']['points'], 'count')));

        $this->assertCount(12, $chart['month']['points']);
        $this->assertSame(['label' => 'Jan', 'count' => 4], $chart['month']['points'][0]);
        $this->assertSame(['label' => 'Feb', 'count' => 0], $chart['month']['points'][1]);
        $this->assertSame([1, 0, 0, 5, 4], array_column($chart['year']['points'], 'count'));
        $this->assertSame(['2018', '2019', '2020', '2021', '2022', '2023', '2024', '2025'], array_column($chart['all']['points'], 'label'));
        $this->assertSame([1, 1, 1, 0, 0, 5, 4, 1], array_column($chart['all']['points'], 'count'));
    }

    public function test_chart_shows_zero_counts_when_there_are_no_visits(): void
    {
        $this->travelTo(new DateTimeImmutable('2024-01-03 12:00:00', new DateTimeZone(config('app.timezone'))));
        $this->createHealthVisitsTable();

        $response = $this->actingAs(User::factory()->create([
            'role' => 'System Administrator',
            'status' => 'active',
        ]))->withoutVite()->get(route('admin.dashboard'))->assertOk();
        $chart = $response->viewData('healthVisitChartData');

        $this->assertSame(['label' => '2024', 'count' => 0], $chart['all']['points'][0]);
        foreach (['day', 'week', 'month', 'year', 'all'] as $range) {
            $this->assertSame(0, array_sum(array_column($chart[$range]['points'], 'count')));
        }
    }

    private function createHealthVisitsTable(): void
    {
        if (! Schema::hasTable('health_visits')) {
            Schema::create('health_visits', function (Blueprint $table): void {
                $table->id();
                $table->foreignId('resident_id')->constrained()->cascadeOnDelete();
                $table->dateTime('visit_date');
                $table->string('visit_type')->nullable();
                $table->timestamps();
            });
        }
    }
}
