<?php

namespace Tests\Feature;

use App\Models\Announcement;
use App\Models\Certificate;
use App\Models\Event;
use App\Models\Household;
use App\Models\Immunization;
use App\Models\MedicalInventory;
use App\Models\Resident;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Schema;
use Illuminate\Testing\TestResponse;
use Tests\TestCase;

class DatabaseAssistantTest extends TestCase
{
    use RefreshDatabase;

    protected function tearDown(): void
    {
        Carbon::setTestNow();

        parent::tearDown();
    }

    public function test_resident_and_household_counts_use_current_database_fixtures_in_english_and_tagalog(): void
    {
        $admin = $this->user('System Administrator');

        Resident::create([
            'first_name' => 'Aira',
            'last_name' => 'Santos',
            'birth_date' => '1990-01-01',
            'gender' => 'Female',
            'status' => 'Active',
        ]);
        Resident::create([
            'first_name' => 'Marco',
            'last_name' => 'Reyes',
            'birth_date' => '1985-03-12',
            'gender' => 'Male',
            'status' => 'Inactive',
        ]);
        Household::create([
            'household_code' => 'TEST-HH-0001',
            'household_head_name' => 'Aira Santos',
            'address' => 'Test Street',
            'status' => 'Active',
        ]);

        Http::fake();

        $residentCount = $this->chat($admin, 'How many residents are registered?');
        $residentCount->assertOk();
        $this->assertStringContainsString(
            'Registered residents: 2',
            $residentCount->json('reply')
        );

        $tagalogResidentCount = $this->chat($admin, 'Ilan ang registered residents?');
        $tagalogResidentCount->assertOk();
        $this->assertStringContainsString(
            'Mga rehistradong residente: 2',
            $tagalogResidentCount->json('reply')
        );

        $householdCount = $this->chat($admin, 'How many households are registered?');
        $this->assertStringContainsString(
            'There are 1 registered household',
            $householdCount->json('reply')
        );

        $tagalogHouseholdCount = $this->chat($admin, 'Ilang sambahayan ang rehistrado?');
        $this->assertStringContainsString(
            'May 1 na nakarehistrong sambahayan',
            $tagalogHouseholdCount->json('reply')
        );

        Http::assertNothingSent();
    }

    public function test_household_membership_search_returns_linked_residents_and_actual_member_count(): void
    {
        $official = $this->user('Official');
        $household = Household::create([
            'household_code' => 'TEST-HH-0002',
            'household_head_name' => 'Mika Example',
            'address' => 'Membership Test Street',
            'status' => 'Active',
        ]);
        Resident::create([
            'household_id' => $household->id,
            'is_household_head' => true,
            'relationship_to_head' => 'Self',
            'first_name' => 'Mika',
            'last_name' => 'Example',
            'birth_date' => '1990-01-01',
            'gender' => 'Female',
        ]);
        Resident::create([
            'household_id' => $household->id,
            'is_household_head' => false,
            'relationship_to_head' => 'Child',
            'first_name' => 'Noah',
            'last_name' => 'Example',
            'birth_date' => '2015-01-01',
            'gender' => 'Male',
        ]);

        Http::fake();

        $members = $this->chat(
            $official,
            'List household members for TEST-HH-0002'
        );
        $this->assertStringContainsString('Mika Example', $members->json('reply'));
        $this->assertStringContainsString('Noah Example', $members->json('reply'));

        $count = $this->chat(
            $official,
            'How many residents are in household TEST-HH-0002?'
        );
        $this->assertStringContainsString(
            'Registered household members: 2',
            $count->json('reply')
        );

        Http::assertNothingSent();
    }

    public function test_upcoming_schedule_this_week_and_expiring_inventory_use_database_results(): void
    {
        Carbon::setTestNow('2026-10-24 10:00:00');
        $healthWorker = $this->user('Health Worker');

        Event::create([
            'title' => 'This Week Clinic',
            'event_type' => 'Clinic',
            'event_date' => Carbon::today()->addDay(),
            'location' => 'Health Center',
        ]);
        Event::create([
            'title' => 'Next Week Clinic',
            'event_type' => 'Clinic',
            'event_date' => Carbon::today()->endOfWeek()->addDay(),
            'location' => 'Health Center',
        ]);
        MedicalInventory::create([
            'medicine_name' => 'Amoxicillin Soon',
            'expiry_date' => Carbon::today()->addDays(12),
            'quantity' => 16,
        ]);
        MedicalInventory::create([
            'medicine_name' => 'Amoxicillin Later',
            'expiry_date' => Carbon::today()->addDays(45),
            'quantity' => 8,
        ]);

        Http::fake();

        $schedules = $this->chat($healthWorker, 'May upcoming schedules ba this week?');
        $schedules->assertOk();
        $this->assertStringContainsString('This Week Clinic', $schedules->json('reply'));
        $this->assertStringNotContainsString('Next Week Clinic', $schedules->json('reply'));

        $inventory = $this->chat(
            $healthWorker,
            'Which medical items are expiring soon?'
        );
        $inventory->assertOk();
        $this->assertStringContainsString('Amoxicillin Soon', $inventory->json('reply'));
        $this->assertStringNotContainsString('Amoxicillin Later', $inventory->json('reply'));

        Http::assertNothingSent();
    }

    public function test_published_announcements_and_certificate_statuses_are_read_from_the_database(): void
    {
        $official = $this->user('Official');
        $resident = $this->resident();

        Announcement::create([
            'title' => 'Published Notice',
            'message' => 'Current public notice.',
            'target_type' => 'general',
            'status' => 'Published',
            'published_at' => now(),
        ]);
        Announcement::create([
            'title' => 'Draft Notice',
            'message' => 'Not yet published.',
            'target_type' => 'general',
            'status' => 'Draft',
        ]);

        Certificate::create([
            'certificate_number' => 'CERT-TEST-001',
            'resident_id' => $resident->id,
            'certificate_type' => 'Barangay Certificate',
            'date_issued' => now()->toDateString(),
            'status' => 'Issued',
        ]);
        Certificate::create([
            'certificate_number' => 'CERT-TEST-002',
            'resident_id' => $resident->id,
            'certificate_type' => 'Barangay Clearance',
            'date_issued' => now()->toDateString(),
            'status' => 'Cancelled',
        ]);

        Http::fake();

        $announcements = $this->chat($official, 'Show published announcements');
        $this->assertStringContainsString('Published Notice', $announcements->json('reply'));
        $this->assertStringNotContainsString('Draft Notice', $announcements->json('reply'));

        $statuses = $this->chat($official, 'Show certificate statuses');
        $this->assertStringContainsString('Issued: 1', $statuses->json('reply'));
        $this->assertStringContainsString('Cancelled: 1', $statuses->json('reply'));

        Http::assertNothingSent();
    }

    public function test_zero_inventory_results_are_distinct_from_database_query_failures(): void
    {
        $admin = $this->user('System Administrator');
        Http::fake();

        $empty = $this->chat($admin, 'Which medicines are expiring soon?');
        $this->assertStringContainsString(
            'No inventory items are recorded',
            $empty->json('reply')
        );

        Schema::dropIfExists('medical_inventories');
        $failed = $this->chat($admin, 'Which medicines are expiring soon?');
        $this->assertStringContainsString(
            'No result was assumed',
            $failed->json('reply')
        );
        $this->assertStringNotContainsString(
            'No inventory items are recorded',
            $failed->json('reply')
        );
    }

    public function test_inventory_is_hidden_from_roles_without_inventory_page_access(): void
    {
        $official = $this->user('Official');
        MedicalInventory::create([
            'medicine_name' => 'Restricted Inventory Item',
            'expiry_date' => Carbon::today()->addDays(10),
            'quantity' => 10,
        ]);

        Http::fake();

        $response = $this->chat(
            $official,
            'Which medical items are expiring soon?'
        );

        $this->assertStringContainsString(
            'available only to authorized health personnel',
            $response->json('reply')
        );
        $this->assertStringNotContainsString(
            'Restricted Inventory Item',
            $response->json('reply')
        );
        Http::assertNothingSent();
    }

    public function test_roles_without_assistant_route_access_cannot_read_clinical_records(): void
    {
        $unauthorized = $this->user('Resident');

        $this->chat($unauthorized, 'How many health visits?')
            ->assertForbidden();
    }

    public function test_official_can_read_clinical_records_permitted_by_the_system_routes(): void
    {
        $official = $this->user('Official');
        $resident = $this->resident();
        Immunization::create([
            'resident_id' => $resident->id,
            'vaccine_name' => 'Test Vaccine',
            'date_administered' => now()->toDateString(),
        ]);

        Http::fake();

        $response = $this->chat(
            $official,
            'Show immunizations for Test Resident'
        );

        $this->assertStringContainsString(
            'Test Vaccine',
            $response->json('reply')
        );
        Http::assertNothingSent();
    }

    public function test_health_visit_count_reports_missing_schema_as_unavailable_not_zero(): void
    {
        $official = $this->user('Official');
        $this->resident();
        Http::fake();

        $healthRecord = $this->chat(
            $official,
            'Show health records for Test Resident'
        );
        $this->assertStringContainsString(
            'Health records are not available in the current database schema',
            $healthRecord->json('reply')
        );

        $response = $this->chat($official, 'How many health visits?');

        $this->assertStringContainsString(
            'not available in the current database schema',
            $response->json('reply')
        );
        $this->assertStringNotContainsString(
            'There are 0 health visit',
            $response->json('reply')
        );
        Http::assertNothingSent();
    }

    public function test_resident_list_does_not_include_unrequested_contact_or_identifier_data(): void
    {
        $official = $this->user('Official');

        Resident::create([
            'first_name' => 'Privacy',
            'last_name' => 'Example',
            'birth_date' => '1991-02-03',
            'gender' => 'Female',
            'contact_number' => '09171234567',
            'email' => 'private@example.test',
            'household_address' => 'Private Address',
            'philhealth_number' => 'PH-PRIVATE-001',
        ]);

        $response = $this->chat($official, 'List all residents');
        $reply = $response->json('reply');

        $this->assertStringContainsString('Privacy Example', $reply);
        $this->assertStringNotContainsString('09171234567', $reply);
        $this->assertStringNotContainsString('private@example.test', $reply);
        $this->assertStringNotContainsString('Private Address', $reply);
        $this->assertStringNotContainsString('PH-PRIVATE-001', $reply);
    }

    public function test_ambiguous_record_question_requests_a_clarification_without_querying_ollama(): void
    {
        $admin = $this->user('System Administrator');
        Http::fake();

        $response = $this->chat($admin, 'Show records for a resident');

        $this->assertStringContainsString(
            'Which record do you mean',
            $response->json('reply')
        );
        Http::assertNothingSent();
    }

    public function test_flexible_planner_rejects_private_columns_and_unlisted_tables(): void
    {
        $admin = $this->user('System Administrator');
        $plans = Http::sequence()
            ->push([
                'message' => [
                    'content' => json_encode([
                        'type' => 'database',
                        'table' => 'residents',
                        'select' => ['residents.philhealth_number'],
                        'joins' => [],
                        'filters' => [],
                        'order_by' => [],
                        'limit' => 10,
                        'aggregate' => null,
                    ]),
                ],
            ])
            ->push([
                'message' => [
                    'content' => json_encode([
                        'type' => 'database',
                        'table' => 'system_settings',
                        'select' => ['system_settings.key'],
                        'joins' => [],
                        'filters' => [],
                        'order_by' => [],
                        'limit' => 10,
                        'aggregate' => null,
                    ]),
                ],
            ]);
        Http::fake(['*api/chat' => $plans]);

        $privateColumn = $this->chat($admin, 'Query resident registry fields');
        $this->assertStringContainsString(
            'could not safely run',
            $privateColumn->json('reply')
        );

        $unlistedTable = $this->chat($admin, 'Query internal settings fields');
        $this->assertStringContainsString(
            'could not safely run',
            $unlistedTable->json('reply')
        );

        Http::assertSentCount(2);
    }

    public function test_flexible_results_are_formatted_without_a_second_model_call(): void
    {
        $admin = $this->user('System Administrator');
        $this->resident('Current', 'Record');
        Http::fake([
            '*api/chat' => Http::response([
                'message' => [
                    'content' => json_encode([
                        'type' => 'database',
                        'table' => 'residents',
                        'select' => [
                            'residents.first_name',
                            'residents.last_name',
                        ],
                        'joins' => [],
                        'filters' => [],
                        'order_by' => [],
                        'limit' => 10,
                        'aggregate' => null,
                    ]),
                ],
            ]),
        ]);

        $response = $this->chat($admin, 'Query resident directory entries');

        $this->assertStringContainsString('Current', $response->json('reply'));
        $this->assertStringContainsString('Record', $response->json('reply'));
        Http::assertSentCount(1);
    }

    public function test_unsupported_flexible_question_returns_a_clear_safe_response(): void
    {
        $admin = $this->user('System Administrator');
        Http::fake([
            '*api/chat' => Http::response([
                'message' => [
                    'content' => json_encode([
                        'type' => 'unsupported',
                        'reason' => 'Model-generated unsupported explanation.',
                    ]),
                ],
            ]),
        ]);

        $response = $this->chat($admin, 'Query the future system module');

        $this->assertStringContainsString(
            'not available through the assistant',
            $response->json('reply')
        );
        $this->assertStringNotContainsString(
            'Model-generated',
            $response->json('reply')
        );
        Http::assertSentCount(1);
    }

    public function test_ollama_connection_timeout_returns_a_safe_unavailable_message(): void
    {
        $admin = $this->user('System Administrator');
        $attempts = 0;
        Http::fake(function () use (&$attempts) {
            $attempts++;

            throw new ConnectionException('Connection timed out.');
        });

        $response = $this->chat($admin, 'What are healthy sleep habits?');

        $this->assertStringContainsString(
            'temporarily unavailable',
            $response->json('reply')
        );
        $this->assertSame(1, $attempts);
    }

    private function user(string $role): User
    {
        return User::factory()->create([
            'role' => $role,
            'status' => 'active',
        ]);
    }

    private function resident(
        string $firstName = 'Test',
        string $lastName = 'Resident'
    ): Resident {
        return Resident::create([
            'first_name' => $firstName,
            'last_name' => $lastName,
            'birth_date' => '1990-01-01',
            'gender' => 'Female',
            'status' => 'Active',
        ]);
    }

    private function chat(User $user, string $message): TestResponse
    {
        return $this->actingAs($user)->postJson(
            route('assistant.chat'),
            ['message' => $message]
        );
    }
}
