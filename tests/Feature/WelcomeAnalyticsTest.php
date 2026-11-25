<?php

namespace Tests\Feature;

use App\Models\ChildHealth;
use App\Models\Event;
use App\Models\HealthRecord;
use App\Models\HealthVisit;
use App\Models\Household;
use App\Models\Immunization;
use App\Models\MaternalCare;
use App\Models\MedicalInventory;
use App\Models\Resident;
use App\Models\SeniorCitizen;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Tests\TestCase;

class WelcomeAnalyticsTest extends TestCase
{
    use LazilyRefreshDatabase;

    public function test_public_monthly_health_visit_chart_shows_actual_current_year_counts(): void
    {
        $this->travelTo(now()->setDate(2026, 3, 10)->startOfDay());
        $resident = Resident::query()->create([
            'first_name' => 'Private',
            'last_name' => 'Resident',
            'birth_date' => '1990-01-01',
            'gender' => 'Female',
        ]);
        foreach (['2025-12-31 23:59:59', '2026-01-01 00:00:00', '2026-03-10 09:00:00', '2026-03-10 10:00:00', '2026-12-31 23:59:59', '2027-01-01 00:00:00'] as $date) {
            HealthVisit::query()->create([
                'resident_id' => $resident->id,
                'visit_date' => $date,
                'visit_type' => 'Private visit type',
            ]);
        }

        $response = $this->withoutVite()->get(route('home'))->assertOk();

        $this->assertSame(2026, $response->viewData('healthVisitYear'));
        $this->assertSame([
            ['label' => 'Jan', 'count' => 1], ['label' => 'Feb', 'count' => 0],
            ['label' => 'Mar', 'count' => 2], ['label' => 'Apr', 'count' => 0],
            ['label' => 'May', 'count' => 0], ['label' => 'Jun', 'count' => 0],
            ['label' => 'Jul', 'count' => 0], ['label' => 'Aug', 'count' => 0],
            ['label' => 'Sep', 'count' => 0], ['label' => 'Oct', 'count' => 0],
            ['label' => 'Nov', 'count' => 0], ['label' => 'Dec', 'count' => 1],
        ], $response->viewData('monthlyHealthVisits'));
        $response->assertSee('Monthly Health Visits')
            ->assertSee('Mar: 2 visits')
            ->assertDontSee('Private visit type')
            ->assertDontSee('Private Resident')
            ->assertDontSee('Age group distribution');
    }

    public function test_public_demographic_charts_show_actual_group_counts(): void
    {
        $this->travelTo(now()->setDate(2026, 3, 10)->startOfDay());
        $ages = [0, 4, 0, 4, 2, 5, 17, 5, 17, 10, 18, 59, 18, 59, 30, 60, 80, 60, 80, 70];
        foreach ($ages as $index => $age) {
            Resident::query()->create([
                'first_name' => 'Private',
                'last_name' => 'Person',
                'birth_date' => now()->subYears($age)->toDateString(),
                'gender' => $index < 10 ? 'Male' : 'Female',
                'status' => $index % 2 === 0 ? 'Active' : 'Inactive',
            ]);
        }

        $response = $this->withoutVite()->get(route('home'))->assertOk();

        $this->assertSame([
            'gender' => ['Male' => 10, 'Female' => 10, 'Other / Unspecified' => 0],
            'status' => ['Active' => 10, 'Inactive' => 10, 'Unknown status' => 0],
        ], $response->viewData('demographics'));
        $response->assertSee('Gender distribution')
            ->assertSee('Resident status')
            ->assertSee('10 (50.0%)')
            ->assertDontSee('Private Person');
    }

    public function test_demographic_distributions_with_small_groups_are_not_sent_to_the_page(): void
    {
        $this->travelTo(now()->setDate(2026, 3, 10)->startOfDay());
        for ($index = 0; $index < 9; $index++) {
            Resident::query()->create([
                'first_name' => 'Private',
                'last_name' => 'Person',
                'birth_date' => $index < 4 ? '2024-03-10' : '1990-03-10',
                'gender' => 'Male',
                'status' => $index < 4 ? 'Inactive' : 'Active',
            ]);
        }

        $response = $this->withoutVite()->get(route('home'))->assertOk();

        $this->assertSame([
            'gender' => ['Male' => 9, 'Female' => 0, 'Other / Unspecified' => 0],
            'status' => null,
        ], $response->viewData('demographics'));
        $response->assertSee('Some groups are too small to display publicly.')
            ->assertDontSee('4 (44.4%)')
            ->assertDontSee('5 (55.6%)');
    }

    public function test_public_overview_shows_database_totals_without_individual_details(): void
    {
        $this->travelTo(now()->setDate(2026, 3, 10)->startOfDay());
        $resident = Resident::query()->create([
            'first_name' => 'Private',
            'last_name' => 'Resident',
            'birth_date' => '1990-01-01',
            'gender' => 'Female',
        ]);
        Household::query()->create([
            'household_code' => 'TEST-1',
            'household_head_name' => 'Private Household',
            'address' => 'Private Address',
        ]);
        HealthRecord::query()->create(['resident_id' => $resident->id, 'notes' => 'Private clinical note']);
        Immunization::query()->create(['resident_id' => $resident->id, 'vaccine_name' => 'Private vaccine', 'date_administered' => '2026-03-01']);
        MaternalCare::query()->create(['resident_id' => $resident->id]);
        ChildHealth::query()->create(['resident_id' => $resident->id, 'assessment_date' => '2026-03-01']);
        SeniorCitizen::query()->create(['resident_id' => $resident->id]);
        Event::query()->create(['title' => 'Private event', 'event_type' => 'Other', 'event_date' => '2026-03-09']);
        Event::query()->create(['title' => 'Future event', 'event_type' => 'Other', 'event_date' => '2026-03-10']);
        MedicalInventory::query()->create(['medicine_name' => 'Private medicine', 'expiry_date' => '2027-01-01', 'quantity' => 25]);

        $response = $this->withoutVite()->get(route('home'))->assertOk();

        $this->assertSame([
            'residents' => 1,
            'households' => 1,
            'events' => 2,
            'upcomingEvents' => 1,
            'inventory' => 1,
            'healthEntries' => 5,
        ], $response->viewData('overview'));
        $response->assertSee('Health &amp; program entries', false)
            ->assertSee('SYSTEM TOTALS')
            ->assertSee('<span>Residents</span><strong>1</strong>', false)
            ->assertSee('<span>All events</span><strong>2</strong>', false)
            ->assertSee('<span>Upcoming events</span><strong>1</strong>', false)
            ->assertSee('<div class="analytics-stat">5</div>', false)
            ->assertDontSee('Private Resident')
            ->assertDontSee('Private Household')
            ->assertDontSee('Private clinical note')
            ->assertDontSee('Private vaccine')
            ->assertDontSee('Private event')
            ->assertDontSee('Private medicine');
    }

    public function test_small_health_totals_are_withheld_from_the_public_overview(): void
    {
        $resident = Resident::query()->create([
            'first_name' => 'Private',
            'last_name' => 'Resident',
            'birth_date' => '1990-01-01',
            'gender' => 'Female',
        ]);
        HealthRecord::query()->create(['resident_id' => $resident->id]);
        for ($i = 0; $i < 3; $i++) {
            Immunization::query()->create(['resident_id' => $resident->id, 'vaccine_name' => 'Vaccine', 'date_administered' => '2026-03-01']);
        }

        $response = $this->withoutVite()->get(route('home'))->assertOk();

        $this->assertNull($response->viewData('overview')['healthEntries']);
        $response->assertSee('Not displayed for privacy');
    }

    public function test_empty_database_shows_zero_totals_and_withholds_health_count(): void
    {
        $response = $this->withoutVite()->get(route('home'))->assertOk();

        $this->assertSame([
            'residents' => 0,
            'households' => 0,
            'events' => 0,
            'upcomingEvents' => 0,
            'inventory' => 0,
            'healthEntries' => null,
        ], $response->viewData('overview'));
        $this->assertSame([
            'gender' => ['Male' => 0, 'Female' => 0, 'Other / Unspecified' => 0],
            'status' => ['Active' => 0, 'Inactive' => 0, 'Unknown status' => 0],
        ], $response->viewData('demographics'));
        $this->assertSame(array_fill(0, 12, 0), array_column($response->viewData('monthlyHealthVisits'), 'count'));
        $response->assertSee('Not displayed for privacy')
            ->assertSee('0 (0.0%)');
    }
}
