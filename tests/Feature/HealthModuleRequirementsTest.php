<?php

namespace Tests\Feature;

use App\Models\ChildHealth;
use App\Models\HealthRecord;
use App\Models\HealthVisit;
use App\Models\Immunization;
use App\Models\MaternalCare;
use App\Models\Resident;
use App\Models\SeniorCitizen;
use App\Models\User;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class HealthModuleRequirementsTest extends TestCase
{
    use RefreshDatabase;

    public function test_health_record_stores_split_emergency_contact_name_and_rejects_resident_reassignment(): void
    {
        $this->actingAsHealthWorker();
        $this->ensureLegacyClinicalTablesExist();
        $resident = $this->createResident('Health', '1990-01-01');
        $otherResident = $this->createResident('Other', '1992-01-01');

        $this->withoutVite()->get(route('health-records.index'))->assertOk();

        $this->withoutVite()
            ->get(route('health-records.create'))
            ->assertOk()
            ->assertSee('resident_search')
            ->assertSee($resident->full_name);

        $this->post(route('health-records.store'), [
            'resident_id' => $resident->id,
            'emergency_contact_first_name' => 'Maria2',
            'emergency_contact_number' => '0918-7111-34',
        ])->assertSessionHasErrors(['emergency_contact_first_name', 'emergency_contact_number']);

        $this->post(route('health-records.store'), [
            'resident_id' => $resident->id,
            'emergency_contact_first_name' => 'Maria',
            'emergency_contact_middle_name' => 'Luz',
            'emergency_contact_last_name' => 'Santos',
            'emergency_contact_number' => '0918-7111-344',
            'emergency_contact_relationship' => 'Guardian',
        ])->assertRedirect(route('health-records.index'));

        $healthRecord = HealthRecord::query()->where('resident_id', $resident->id)->firstOrFail();

        $this->assertSame('Maria Luz Santos', $healthRecord->emergency_contact_name);
        $this->assertSame('639187111344', $healthRecord->emergency_contact_number);
        $this->assertSame('Guardian', $healthRecord->emergency_contact_relationship);

        $this->put(route('health-records.update', $healthRecord), [
            'resident_id' => $otherResident->id,
            'emergency_contact_first_name' => 'Maria',
            'emergency_contact_middle_name' => 'Luz',
            'emergency_contact_last_name' => 'Santos',
        ])->assertSessionHasErrors('resident_id');

        $this->assertDatabaseHas('health_records', [
            'id' => $healthRecord->id,
            'resident_id' => $resident->id,
            'emergency_contact_name' => 'Maria Luz Santos',
        ]);
    }

    public function test_health_record_migration_preserves_existing_records(): void
    {
        $resident = $this->createResident('Existing', '1990-01-01');
        $record = HealthRecord::query()->create(['resident_id' => $resident->id]);
        $migration = require database_path('migrations/2026_11_23_160846_ensure_health_records_table_exists.php');

        $migration->up();

        $this->assertModelExists($record);
    }

    public function test_health_visit_uses_configured_current_time_and_rejects_future_updates(): void
    {
        $this->actingAsHealthWorker();
        $this->ensureLegacyClinicalTablesExist();
        $this->travelTo(new \DateTimeImmutable('2026-03-10 14:25:30', new \DateTimeZone(config('app.timezone'))));
        $resident = $this->createResident('Visit', '1990-01-01');

        $this->withoutVite()
            ->get(route('health-visits.create'))
            ->assertOk()
            ->assertSee('resident_search')
            ->assertDontSee('name="visit_date"', false);

        $this->post(route('health-visits.store'), [
            'resident_id' => $resident->id,
            'visit_date' => '2030-01-01T10:00',
            'visit_type' => 'General Consultation',
        ])->assertRedirect(route('health-visits.index'));

        $healthVisit = HealthVisit::query()->firstOrFail();

        $this->assertSame('2026-03-10 14:25:30', $healthVisit->visit_date->format('Y-m-d H:i:s'));

        $showResponse = $this->get(route('health-visits.show', $healthVisit))
            ->assertOk()
            ->assertSeeInOrder(['Back to Health Visits', 'Edit Visit']);
        $this->assertSame(1, substr_count($showResponse->getContent(), 'Edit Visit'));

        $this->put(route('health-visits.update', $healthVisit), [
            'resident_id' => $resident->id,
            'visit_date' => now()->addDay()->format('Y-m-d\TH:i'),
            'visit_type' => 'General Consultation',
        ])->assertSessionHasErrors('visit_date');

        $this->assertSame('2026-03-10 14:25:30', $healthVisit->fresh()->visit_date->format('Y-m-d H:i:s'));
    }

    public function test_immunization_uses_current_date_and_rejects_resident_reassignment(): void
    {
        $this->actingAsHealthWorker();
        $this->travelTo(new \DateTimeImmutable('2026-03-10 09:00:00', new \DateTimeZone(config('app.timezone'))));
        $resident = $this->createResident('Immunized', '1990-01-01');
        $otherResident = $this->createResident('Alternate', '1992-01-01');

        $this->post(route('immunizations.store'), [
            'resident_id' => $resident->id,
            'vaccine_name' => 'Influenza',
            'date_administered' => '2030-01-01',
        ])->assertRedirect(route('immunizations.index'));

        $immunization = Immunization::query()->firstOrFail();
        $this->assertSame('2026-03-10', $immunization->date_administered->toDateString());

        $this->put(route('immunizations.update', $immunization), [
            'resident_id' => $otherResident->id,
            'vaccine_name' => 'Influenza',
            'date_administered' => '2026-03-10',
        ])->assertSessionHasErrors('resident_id');

        $this->assertDatabaseHas('immunizations', [
            'id' => $immunization->id,
            'resident_id' => $resident->id,
        ]);
        $this->assertSame('2026-03-10', $immunization->fresh()->date_administered->toDateString());
    }

    public function test_maternal_care_update_cannot_change_its_resident(): void
    {
        $this->actingAsHealthWorker();
        $resident = $this->createResident('Maternal', '1990-01-01');
        $otherResident = $this->createResident('Different', '1992-01-01');

        $this->withoutVite()
            ->get(route('maternal-care.create'))
            ->assertOk()
            ->assertSee('resident_search')
            ->assertSee($resident->full_name);

        $maternalCare = MaternalCare::query()->create([
            'resident_id' => $resident->id,
            'pregnancy_number' => 1,
            'pregnancy_status' => 'Pregnant',
        ]);

        $this->put(route('maternal-care.update', $maternalCare), [
            'resident_id' => $otherResident->id,
            'pregnancy_status' => 'Delivered',
        ])->assertSessionHasErrors('resident_id');

        $this->assertDatabaseHas('maternal_cares', [
            'id' => $maternalCare->id,
            'resident_id' => $resident->id,
            'pregnancy_status' => 'Pregnant',
        ]);
    }

    public function test_child_health_create_enforces_age_limit_and_updates_keep_the_existing_resident(): void
    {
        $this->actingAsHealthWorker();
        $this->travelTo(new \DateTimeImmutable('2026-01-10 12:00:00', new \DateTimeZone(config('app.timezone'))));
        $cutoff = today()->subYears(5);
        $eligibleResident = $this->createResident('Five', $cutoff->toDateString());
        $overAgeResident = $this->createResident('Overage', $cutoff->copy()->subDay()->toDateString());

        $payload = [
            'resident_id' => $eligibleResident->id,
            'assessment_date' => today()->toDateString(),
        ];

        $response = $this->post(route('child-health.store'), $payload)
            ->assertSessionHasNoErrors();
        $childHealth = ChildHealth::query()->firstOrFail();
        $response->assertRedirect(route('child-health.show', $childHealth));

        $this->post(route('child-health.store'), [
            ...$payload,
            'resident_id' => $overAgeResident->id,
        ])->assertSessionHasErrors('resident_id');

        $this->put(route('child-health.update', $childHealth), [
            'resident_id' => $overAgeResident->id,
            'assessment_date' => today()->toDateString(),
        ])->assertSessionHasErrors('resident_id');

        $this->travelTo(new \DateTimeImmutable('2027-01-11 12:00:00', new \DateTimeZone(config('app.timezone'))));

        $this->put(route('child-health.update', $childHealth), [
            'resident_id' => $eligibleResident->id,
            'assessment_date' => today()->toDateString(),
        ])->assertRedirect(route('child-health.index'));

        $this->assertDatabaseHas('child_healths', [
            'id' => $childHealth->id,
            'resident_id' => $eligibleResident->id,
        ]);
    }

    public function test_senior_citizen_creation_requires_age_60_and_sets_registration_date_server_side(): void
    {
        $this->actingAsHealthWorker();
        $this->travelTo(new \DateTimeImmutable('2026-03-10 12:00:00', new \DateTimeZone(config('app.timezone'))));
        $eligibleResident = $this->createResident('Senior', today()->subYears(60)->toDateString());
        $underAgeResident = $this->createResident('NotSenior', today()->subYears(60)->addDay()->toDateString());

        $this->withoutVite()
            ->get(route('senior-citizens.create'))
            ->assertOk()
            ->assertSee('resident_search')
            ->assertSee($eligibleResident->full_name)
            ->assertDontSee($underAgeResident->full_name)
            ->assertSee('Senior ID');

        $payload = [
            'resident_id' => $eligibleResident->id,
            'osca_id_number' => 'SENIOR-1',
            'osca_registration_date' => 'not-a-date',
            'senior_status' => 'Active',
        ];

        $this->post(route('senior-citizens.store'), $payload)
            ->assertRedirect(route('senior-citizens.index'));

        $this->assertDatabaseHas('senior_citizens', [
            'resident_id' => $eligibleResident->id,
        ]);
        $this->assertSame(
            '2026-03-10',
            SeniorCitizen::query()->firstOrFail()->osca_registration_date->toDateString()
        );

        $this->post(route('senior-citizens.store'), [
            ...$payload,
            'resident_id' => $underAgeResident->id,
            'osca_id_number' => 'SENIOR-2',
        ])->assertSessionHasErrors('resident_id');
    }

    public function test_immunization_show_keeps_the_linked_resident_and_record_details(): void
    {
        $this->actingAsHealthWorker();
        $resident = $this->createResident('Accurate', '1990-01-01');
        $immunization = Immunization::query()->create([
            'resident_id' => $resident->id,
            'vaccine_name' => 'Tetanus',
            'vaccine_type' => 'Booster',
            'dose_number' => 'Dose 2',
            'date_administered' => '2026-03-10',
        ]);

        $this->withoutVite()
            ->get(route('immunizations.show', $immunization))
            ->assertOk()
            ->assertSee($resident->full_name)
            ->assertSee('Tetanus')
            ->assertSee('Booster')
            ->assertSee('Dose 2')
            ->assertSee('Mar 10, 2026');
    }

    public function test_edit_and_show_views_keep_fixed_residents_and_remove_requested_delete_controls(): void
    {
        $this->actingAsHealthWorker();
        $this->ensureLegacyClinicalTablesExist();
        $this->withoutVite();
        $resident = $this->createResident('Fixed', '2022-01-01');

        $healthRecord = HealthRecord::query()->create([
            'resident_id' => $resident->id,
        ]);
        $this->get(route('health-records.edit', $healthRecord))
            ->assertOk()
            ->assertSee($resident->full_name)
            ->assertSee('name="resident_id" value="'.$resident->id.'"', false);

        $maternalCare = MaternalCare::query()->create([
            'resident_id' => $resident->id,
            'pregnancy_number' => 1,
            'pregnancy_status' => 'Pregnant',
        ]);
        $this->get(route('maternal-care.edit', $maternalCare))
            ->assertOk()
            ->assertSee($resident->full_name)
            ->assertDontSee('Delete Record');
        $this->get(route('maternal-care.show', $maternalCare))
            ->assertOk()
            ->assertDontSee('Delete Record');

        $childHealth = ChildHealth::query()->create([
            'resident_id' => $resident->id,
            'assessment_date' => '2026-03-10',
        ]);
        $this->get(route('child-health.edit', $childHealth))
            ->assertOk()
            ->assertSee($resident->full_name)
            ->assertSee('Back to Child Health');
        $this->get(route('child-health.show', $childHealth))
            ->assertOk()
            ->assertDontSee('Delete Record');

        $immunization = Immunization::query()->create([
            'resident_id' => $resident->id,
            'vaccine_name' => 'Polio',
            'date_administered' => '2026-03-10',
        ]);
        $this->get(route('immunizations.edit', $immunization))
            ->assertOk()
            ->assertSee($resident->full_name)
            ->assertDontSee('Delete');

        $seniorCitizen = SeniorCitizen::query()->create([
            'resident_id' => $resident->id,
            'senior_status' => 'Active',
        ]);
        $this->get(route('senior-citizens.show', $seniorCitizen))
            ->assertOk()
            ->assertSee('Created:')
            ->assertDontSee('Edit Record')
            ->assertDontSee('Delete Record');
    }

    private function actingAsHealthWorker(): void
    {
        $this->actingAs(User::factory()->create([
            'role' => 'System Administrator',
            'status' => 'active',
        ]));
    }

    private function createResident(string $firstName, string $birthDate, string $gender = 'Female'): Resident
    {
        return Resident::query()->create([
            'first_name' => $firstName,
            'last_name' => 'Test',
            'birth_date' => $birthDate,
            'gender' => $gender,
        ]);
    }

    private function ensureLegacyClinicalTablesExist(): void
    {
        if (! Schema::hasTable('health_visits')) {
            Schema::create('health_visits', function (Blueprint $table): void {
                $table->id();
                $table->foreignId('resident_id')->constrained()->cascadeOnDelete();
                $table->dateTime('visit_date');
                $table->string('visit_type')->nullable();
                $table->text('chief_complaint')->nullable();
                $table->text('assessment')->nullable();
                $table->text('treatment')->nullable();
                $table->text('remarks')->nullable();
                $table->string('attended_by')->nullable();
                $table->timestamps();
            });
        }
    }
}
