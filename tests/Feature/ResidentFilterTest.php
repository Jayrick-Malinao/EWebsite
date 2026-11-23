<?php

namespace Tests\Feature;

use App\Models\MaternalCare;
use App\Models\Resident;
use App\Models\SeniorCitizen;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ResidentFilterTest extends TestCase
{
    use RefreshDatabase;

    public function test_age_filters_include_the_requested_ages_and_exclude_future_birthdates(): void
    {
        $this->travelTo(now()->setDate(2026, 11, 22)->startOfDay());
        $this->actingAs($this->administrator());
        $newborn = $this->resident('Newborn', '2026-11-22');
        $five = $this->resident('Five', '2020-11-23');
        $six = $this->resident('Six', '2020-11-22');
        $eighteen = $this->resident('Eighteen', '2007-11-23');
        $nineteen = $this->resident('Nineteen', '2007-11-22');
        $future = $this->resident('Future', '2026-11-23');

        $this->get(route('residents.index', ['filter' => 'children_5']))
            ->assertOk()
            ->assertSee($newborn->full_name)
            ->assertSee($five->full_name)
            ->assertDontSee($six->full_name)
            ->assertDontSee($future->full_name);

        $this->get(route('residents.index', ['filter' => 'children_18']))
            ->assertOk()
            ->assertSee($eighteen->full_name)
            ->assertSee($six->full_name)
            ->assertDontSee($nineteen->full_name)
            ->assertDontSee($future->full_name);
    }

    public function test_senior_age_and_active_registration_are_separate_filters(): void
    {
        $this->travelTo(now()->setDate(2026, 11, 22)->startOfDay());
        $this->actingAs($this->administrator());
        $byAge = $this->resident('AgeSenior', '1966-11-22');
        $registered = $this->resident('RegisteredSenior', '1966-11-23');
        $inactive = $this->resident('InactiveSenior', '1970-01-01');
        SeniorCitizen::create(['resident_id' => $registered->id, 'senior_status' => 'Active']);
        SeniorCitizen::create(['resident_id' => $inactive->id, 'senior_status' => 'Inactive']);

        $this->get(route('residents.index', ['filter' => 'senior_age']))
            ->assertOk()
            ->assertSee($byAge->full_name)
            ->assertDontSee($registered->full_name);

        $this->get(route('residents.index', ['filter' => 'senior_registered']))
            ->assertOk()
            ->assertSee($registered->full_name)
            ->assertDontSee($byAge->full_name)
            ->assertDontSee($inactive->full_name);
    }

    public function test_pregnant_filter_requires_an_undelivered_pregnancy_record(): void
    {
        $this->actingAs($this->administrator());
        $pregnant = $this->resident('Expecting', '1995-01-01');
        $delivered = $this->resident('Delivered', '1994-01-01');
        $completed = $this->resident('Completed', '1993-01-01');
        MaternalCare::create(['resident_id' => $pregnant->id, 'pregnancy_status' => 'Pregnant']);
        MaternalCare::create(['resident_id' => $delivered->id, 'pregnancy_status' => 'Pregnant', 'actual_delivery_date' => '2025-01-01']);
        MaternalCare::create(['resident_id' => $completed->id, 'pregnancy_status' => 'Completed']);

        $this->get(route('residents.index', ['filter' => 'pregnant']))
            ->assertOk()
            ->assertSee($pregnant->full_name)
            ->assertDontSee($delivered->full_name)
            ->assertDontSee($completed->full_name);
    }

    public function test_filter_combines_with_search_and_can_be_cleared(): void
    {
        $this->travelTo(now()->setDate(2026, 11, 22)->startOfDay());
        $this->actingAs($this->administrator());
        $matching = $this->resident('Matching', '2024-01-01');
        $this->resident('MatchingAdult', '1980-01-01');
        $this->resident('OtherChild', '2024-01-01');

        $this->get(route('residents.index', ['search' => 'Matching', 'filter' => 'children_5']))
            ->assertOk()
            ->assertSee($matching->full_name)
            ->assertDontSee('MatchingAdult Resident')
            ->assertDontSee('OtherChild Resident')
            ->assertSee('Filter')
            ->assertSee('Children (18 and below)')
            ->assertSee('Senior Citizens (Active Record)')
            ->assertSee('name="filter" value="children_5"', false)
            ->assertSee('search=Matching&amp;filter=children_18', false)
            ->assertSee('All Residents');

        $this->get(route('residents.index', ['filter' => 'invalid']))
            ->assertSessionHasErrors('filter');
    }

    public function test_pagination_keeps_the_search_and_filter(): void
    {
        $this->travelTo(now()->setDate(2026, 11, 22)->startOfDay());
        $this->actingAs($this->administrator());
        for ($i = 1; $i <= 16; $i++) {
            $this->resident('Child'.$i, '2024-01-01');
        }

        $this->get(route('residents.index', ['search' => 'Child', 'filter' => 'children_5']))
            ->assertOk()
            ->assertSee('search=Child&amp;filter=children_5&amp;page=2', false);

        $this->get(route('residents.index', ['search' => 'Child', 'filter' => 'children_5', 'page' => 2]))
            ->assertOk()
            ->assertViewHas('residents', fn ($residents) => $residents->total() === 16 && $residents->count() === 1);
    }

    private function administrator(): User
    {
        return User::factory()->create([
            'role' => 'System Administrator',
            'status' => 'active',
        ]);
    }

    private function resident(string $firstName, string $birthDate): Resident
    {
        return Resident::create([
            'first_name' => $firstName,
            'last_name' => 'Resident',
            'birth_date' => $birthDate,
            'gender' => 'Female',
            'status' => 'Active',
        ]);
    }
}
