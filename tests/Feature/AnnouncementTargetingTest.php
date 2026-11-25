<?php

namespace Tests\Feature;

use App\Models\Announcement;
use App\Models\AnnouncementRecipient;
use App\Models\AnnouncementSmsDelivery;
use App\Models\HealthVisit;
use App\Models\Household;
use App\Models\Resident;
use App\Models\SeniorCitizen;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Client\Request as ClientRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Str;
use Tests\TestCase;

class AnnouncementTargetingTest extends TestCase
{
    use RefreshDatabase;

    public function test_senior_target_uses_active_senior_citizen_records(): void
    {
        $admin = $this->createAdmin();
        $oldResidentWithoutRecord = $this->createResident(
            'Old',
            now()->subYears(70)->toDateString()
        );
        $registeredSenior = $this->createResident(
            'Registered',
            now()->subYears(55)->toDateString()
        );
        SeniorCitizen::create([
            'resident_id' => $registeredSenior->id,
            'senior_status' => 'Active',
        ]);

        $response = $this->actingAs($admin)->postJson(
            route('announcements.preview'),
            ['title' => 'Senior clinic', 'message' => 'Visit the clinic.', 'target_type' => 'senior', 'priority' => 'Normal']
        );

        $response
            ->assertOk()
            ->assertJsonPath('qualifying_residents', 1)
            ->assertJsonPath('households.0.qualifying_members.0.id', $registeredSenior->id)
            ->assertJsonMissingPath('households.0.qualifying_members.1.id');
    }

    public function test_children_target_uses_birth_date_ages_from_zero_through_five(): void
    {
        $admin = $this->createAdmin();
        $this->travelTo(now()->startOfDay());
        $newborn = $this->createResident('Newborn', now()->toDateString());
        $fiveYearOld = $this->createResident('Five', now()->subYears(5)->toDateString());
        $sixYearOld = $this->createResident('Six', now()->subYears(6)->toDateString());

        $response = $this->actingAs($admin)->postJson(
            route('announcements.preview'),
            [
                'title' => 'Child health',
                'message' => 'Bring your child.',
                'target_type' => 'children',
                'min_age' => 6,
                'max_age' => 6,
                'priority' => 'Normal',
            ]
        );

        $response->assertOk()->assertJsonPath('qualifying_residents', 2);
        $qualifyingIds = collect($response->json('households'))
            ->flatMap(fn (array $household): array => collect($household['qualifying_members'])
                ->pluck('id')
                ->all())
            ->all();

        sort($qualifyingIds);
        $expectedIds = [$newborn->id, $fiveYearOld->id];
        sort($expectedIds);

        $this->assertSame($expectedIds, $qualifyingIds);
        $this->assertNotContains($sixYearOld->id, $qualifyingIds);
    }

    public function test_pregnant_target_requires_a_prenatal_health_visit(): void
    {
        $admin = $this->createAdmin();
        $pregnantResident = $this->createResident(
            'Pregnant',
            now()->subYears(24)->toDateString()
        );
        HealthVisit::create([
            'resident_id' => $pregnantResident->id,
            'visit_type' => 'Prenatal',
            'visit_date' => now(),
        ]);

        $deliveredResident = $this->createResident(
            'Delivered',
            now()->subYears(25)->toDateString()
        );
        HealthVisit::create([
            'resident_id' => $deliveredResident->id,
            'visit_type' => 'Postnatal',
            'visit_date' => now(),
        ]);

        $response = $this->actingAs($admin)->postJson(
            route('announcements.preview'),
            ['title' => 'Prenatal visit', 'message' => 'Contact the clinic.', 'target_type' => 'pregnant', 'priority' => 'Normal']
        );

        $response
            ->assertOk()
            ->assertJsonPath('qualifying_residents', 1)
            ->assertJsonPath('households.0.qualifying_members.0.id', $pregnantResident->id);

        $this->actingAs($admin)->postJson(route('announcements.preview'), ['target_type' => 'postnatal'])
            ->assertOk()
            ->assertJsonPath('qualifying_residents', 1)
            ->assertJsonPath('households.0.qualifying_members.0.id', $deliveredResident->id);
    }

    public function test_specific_target_persists_only_the_selected_resident_without_household_head_sms(): void
    {
        Http::preventStrayRequests();
        Notification::fake();

        $admin = $this->createAdmin();
        $household = $this->createHousehold('Specific');
        $head = $this->createResident('Head', '1980-01-01', [
            'household_id' => $household->id,
            'is_household_head' => true,
        ]);
        $selectedResident = $this->createResident('Selected', '1990-01-01', [
            'household_id' => $household->id,
        ]);

        $response = $this->actingAs($admin)->post(
            route('announcements.store'),
            [
                'title' => 'Resident-specific notice',
                'message' => 'This is for one resident.',
                'target_type' => 'specific',
                'resident_id' => $selectedResident->id,
                'priority' => 'Normal',
            ]
        );

        $announcement = Announcement::query()->latest('id')->firstOrFail();

        $response
            ->assertRedirect(route('announcements.show', $announcement))
            ->assertSessionHas('success', 'Announcement published successfully. No SMS messages were sent.');

        $this->assertDatabaseHas('announcement_recipients', [
            'announcement_id' => $announcement->id,
            'resident_id' => $selectedResident->id,
        ]);
        $this->assertDatabaseMissing('announcement_recipients', [
            'announcement_id' => $announcement->id,
            'resident_id' => $head->id,
        ]);
        $delivery = AnnouncementSmsDelivery::query()->sole();
        $this->assertSame('resident', $delivery->recipient_type);
        $this->assertSame($selectedResident->id, $delivery->resident_id);
        $this->actingAs($admin)->get(route('announcements.show', $announcement))
            ->assertOk()
            ->assertSee('Resident-specific notice')
            ->assertSee('This is for one resident.')
            ->assertSee($selectedResident->full_name)
            ->assertSee('Specific resident')
            ->assertSee('Normal priority');
        Http::assertNothingSent();
    }

    public function test_general_target_prepares_sms_only_for_household_heads_and_never_sends_on_publish(): void
    {
        Http::preventStrayRequests();
        Notification::fake();

        $admin = $this->createAdmin();
        $household = $this->createHousehold('General');
        $head = $this->createResident('Head', '1980-01-01', [
            'household_id' => $household->id,
            'is_household_head' => true,
            'contact_number' => '09171234567',
        ]);
        $member = $this->createResident('Member', '1990-01-01', [
            'household_id' => $household->id,
            'contact_number' => '09179876543',
        ]);

        $response = $this->actingAs($admin)->post(
            route('announcements.store'),
            [
                'title' => 'Community notice',
                'message' => 'This is for all active residents.',
                'target_type' => 'general',
                'priority' => 'Normal',
            ]
        );

        $announcement = Announcement::query()->latest('id')->firstOrFail();
        $delivery = AnnouncementSmsDelivery::query()->sole();

        $response->assertRedirect(route('announcements.show', $announcement));
        $this->assertSame(2, AnnouncementRecipient::query()
            ->where('announcement_id', $announcement->id)
            ->count());
        $this->assertSame($head->id, $delivery->household_head_resident_id);
        $this->assertSame('639171234567', $delivery->contact_number);
        $this->assertNotSame($member->id, $delivery->household_head_resident_id);
        Http::assertNothingSent();
    }

    public function test_multiple_specific_residents_are_directly_deduplicated_by_phone(): void
    {
        Http::preventStrayRequests();
        Notification::fake();

        $admin = $this->createAdmin();
        $first = $this->createResident('First', '1990-01-01', [
            'contact_number' => '09171234567',
        ]);
        $second = $this->createResident('Second', '1991-01-01', [
            'contact_number' => '+639171234567',
        ]);

        $response = $this->actingAs($admin)->post(
            route('announcements.store'),
            [
                'title' => 'Multiple selected residents',
                'message' => 'Direct notice.',
                'target_type' => 'specific',
                'resident_ids' => [$first->id, $second->id],
                'priority' => 'Normal',
            ]
        );

        $announcement = Announcement::query()->latest('id')->firstOrFail();
        $response->assertRedirect(route('announcements.show', $announcement));
        $this->assertDatabaseCount('announcement_recipients', 2);
        $this->assertDatabaseCount('announcement_sms_deliveries', 1);
        $this->assertDatabaseHas('announcement_sms_deliveries', [
            'announcement_id' => $announcement->id,
            'recipient_type' => 'resident',
            'contact_number' => '639171234567',
        ]);
    }

    public function test_inactive_resident_cannot_be_selected(): void
    {
        $admin = $this->createAdmin();
        $inactive = $this->createResident('Inactive', '1990-01-01', [
            'status' => 'Inactive',
        ]);

        $this->actingAs($admin)
            ->postJson(route('announcements.preview'), [
                'target_type' => 'specific',
                'resident_ids' => [$inactive->id],
            ])
            ->assertUnprocessable();
    }

    public function test_pregnant_residents_with_duplicate_phone_get_one_direct_sms(): void
    {
        Http::preventStrayRequests();
        Notification::fake();

        $admin = $this->createAdmin();
        $first = $this->createResident('Pregnant One', '1990-01-01', [
            'contact_number' => '09171234567',
        ]);
        $second = $this->createResident('Pregnant Two', '1991-01-01', [
            'contact_number' => '+639171234567',
        ]);
        HealthVisit::create([
            'resident_id' => $first->id,
            'visit_type' => 'Prenatal',
            'visit_date' => now(),
        ]);
        HealthVisit::create([
            'resident_id' => $second->id,
            'visit_type' => 'Prenatal',
            'visit_date' => now(),
        ]);

        $this->actingAs($admin)
            ->postJson(route('announcements.preview'), [
                'target_type' => 'pregnant',
            ])
            ->assertOk()
            ->assertJsonPath('sms_recipients', 1);
    }

    public function test_postnatal_preview_matches_the_published_recipients(): void
    {
        Http::preventStrayRequests();
        Notification::fake();
        $admin = $this->createAdmin();
        $resident = $this->createResident('Postnatal', '1990-01-01');
        HealthVisit::create(['resident_id' => $resident->id, 'visit_type' => 'Postnatal', 'visit_date' => now()]);

        $preview = $this->actingAs($admin)->postJson(route('announcements.preview'), ['target_type' => 'postnatal'])
            ->assertOk()->assertJsonPath('qualifying_residents', 1)->assertJsonPath('sms_recipients', 1);
        $this->post(route('announcements.store'), [
            'title' => 'Postnatal follow-up',
            'message' => 'Please visit the clinic.',
            'target_type' => 'postnatal',
            'priority' => 'Normal',
            'preview_hash' => $preview->json('preview_hash'),
        ])->assertSessionHasNoErrors();

        $announcement = Announcement::query()->where('target_type', 'postnatal')->firstOrFail();
        $this->assertSame([$resident->id], $announcement->recipients()->pluck('resident_id')->all());
        $this->assertSame($preview->json('recipients.0.contact_number'), $announcement->smsDeliveries()->sole()->contact_number);
        Http::assertNothingSent();
    }

    public function test_general_preview_includes_residents_without_households_and_deduplicates_numbers(): void
    {
        $admin = $this->createAdmin();
        $this->createResident('Head', '1980-01-01', ['contact_number' => '09171234567']);
        $duplicate = $this->createResident('Duplicate', '1990-01-01', ['contact_number' => '639171234567']);
        $duplicate->update(['household_id' => null]);
        $independent = $this->createResident('Independent', '1990-01-01', ['contact_number' => '09179999999']);
        $independent->update(['household_id' => null]);

        $this->actingAs($admin)->postJson(route('announcements.preview'), ['target_type' => 'general'])
            ->assertOk()
            ->assertJsonPath('qualifying_residents', 3)
            ->assertJsonPath('sms_recipients', 2);
    }

    public function test_publication_requires_a_new_preview_when_recipients_change(): void
    {
        Http::preventStrayRequests();
        $admin = $this->createAdmin();
        $resident = $this->createResident('First', '1990-01-01');
        $preview = $this->actingAs($admin)->postJson(route('announcements.preview'), ['target_type' => 'specific', 'resident_ids' => [$resident->id]])
            ->assertOk();
        $resident->update(['contact_number' => '639179999999']);

        $this->post(route('announcements.store'), [
            'title' => 'Changed contact',
            'message' => 'Please visit the clinic.',
            'target_type' => 'specific',
            'resident_ids' => [$resident->id],
            'priority' => 'Normal',
            'preview_hash' => $preview->json('preview_hash'),
        ])->assertSessionHasErrors('target_type');

        $this->assertDatabaseCount('announcements', 0);
        Http::assertNothingSent();
    }

    public function test_age_bracket_includes_boundary_ages_and_deduplicates_household_heads(): void
    {
        $admin = $this->createAdmin();
        $household = $this->createHousehold('AgeBracket');
        $head = $this->createResident('Head', '1980-01-01', [
            'household_id' => $household->id,
            'is_household_head' => true,
            'contact_number' => '09171234567',
        ]);
        $this->createResident('Boundary Twenty', now()->subYears(20)->toDateString(), [
            'household_id' => $household->id,
            'is_household_head' => false,
        ]);
        $this->createResident('Boundary Thirty', now()->subYears(30)->toDateString(), [
            'household_id' => $household->id,
            'is_household_head' => false,
        ]);

        $this->actingAs($admin)
            ->postJson(route('announcements.preview'), [
                'target_type' => 'age_bracket',
                'min_age' => 20,
                'max_age' => 30,
            ])
            ->assertOk()
            ->assertJsonPath('sms_recipients', 1);

        $this->assertNotNull($head);
    }

    public function test_age_targets_exclude_invalid_and_future_dates_and_validate_ranges(): void
    {
        $admin = $this->createAdmin();
        $invalid = $this->createResident('Invalid', '2010-01-01');
        DB::table('residents')->where('id', $invalid->id)->update(['birth_date' => '2010-02-31']);
        $this->createResident('Future', now()->addDay()->toDateString());
        $eligible = $this->createResident('Eligible', now()->subYears(5)->toDateString());

        $this->actingAs($admin)->postJson(route('announcements.preview'), ['target_type' => 'children'])
            ->assertOk()
            ->assertJsonPath('qualifying_residents', 1)
            ->assertJsonPath('residents.0.id', $eligible->id);

        foreach ([['min_age' => -1, 'max_age' => 5], ['min_age' => 9, 'max_age' => 5], ['min_age' => '1.5', 'max_age' => 5]] as $range) {
            $this->postJson(route('announcements.preview'), array_merge(['target_type' => 'age_bracket'], $range))
                ->assertUnprocessable();
        }
    }

    public function test_custom_age_bracket_can_include_residents_older_than_120(): void
    {
        $admin = $this->createAdmin();
        $resident = $this->createResident('Older', now()->subYears(121)->toDateString());

        $this->actingAs($admin)->postJson(route('announcements.preview'), [
            'target_type' => 'age_bracket',
            'min_age' => 121,
            'max_age' => 121,
        ])->assertOk()
            ->assertJsonPath('qualifying_residents', 1)
            ->assertJsonPath('residents.0.id', $resident->id);
    }

    public function test_create_view_offers_searchable_residents_with_their_actual_ids(): void
    {
        $admin = $this->createAdmin();
        $resident = $this->createResident('Searchable', '1990-01-01');

        $response = $this->actingAs($admin)->get(route('announcements.create'));

        $response
            ->assertOk()
            ->assertSee('id="residentSearch"', false)
            ->assertSee('data-resident-id="'.$resident->id.'"', false)
            ->assertSee('Resident #'.$resident->id);
    }

    public function test_index_renders_live_sms_credits_from_unisms(): void
    {
        Http::preventStrayRequests();
        Http::fake([
            'https://unismsapi.com/api/account' => Http::response([
                'status' => 'active',
                'sms_credits' => 42,
            ]),
        ]);
        config(['services.unisms.secret_key' => 'test-unisms-secret']);

        $admin = $this->createAdmin();
        Announcement::create([
            'title' => 'Credit balance test',
            'message' => 'A test announcement.',
            'target_type' => 'general',
            'priority' => 'Normal',
            'status' => 'Published',
            'published_at' => now(),
            'created_by' => $admin->id,
        ]);

        $response = $this->actingAs($admin)->get(route('announcements.index'));

        $response
            ->assertOk()
            ->assertSee('SMS Credits')
            ->assertSee('Announcement')
            ->assertSee('Target')
            ->assertSee('Recipient')
            ->assertSee('Publish</th>', false)
            ->assertDontSee('Priority</th>', false)
            ->assertDontSee('Action</th>', false)
            ->assertSee('42')
            ->assertDontSee('test-unisms-secret');

        Http::assertSent(fn (ClientRequest $request): bool => $request->method() === 'GET'
            && $request->url() === 'https://unismsapi.com/api/account'
            && $request->hasHeader(
                'Authorization',
                'Basic '.base64_encode('test-unisms-secret:')
            ));
    }

    public function test_index_paginates_three_announcements_and_keeps_summary_counts_across_pages(): void
    {
        Http::preventStrayRequests();
        config(['services.unisms.secret_key' => null]);
        $admin = $this->createAdmin();

        foreach (range(1, 7) as $number) {
            Announcement::create([
                'title' => 'Notice '.$number,
                'message' => 'Community update.',
                'target_type' => 'general',
                'priority' => $number === 1 ? 'Urgent' : 'Normal',
                'status' => 'Published',
                'published_at' => now(),
                'created_by' => $admin->id,
            ]);
        }

        $this->actingAs($admin)->get(route('announcements.index'))
            ->assertOk()
            ->assertSee('Notice 7')
            ->assertSee('Notice 5')
            ->assertDontSee('Notice 4')
            ->assertViewHas('publishedCount', 7)
            ->assertViewHas('urgentCount', 1);

        $this->actingAs($admin)->get(route('announcements.index', ['page' => 2]))
            ->assertOk()
            ->assertSee('Notice 4')
            ->assertSee('Notice 2')
            ->assertDontSee('Notice 1')
            ->assertDontSee('Notice 5')
            ->assertViewHas('publishedCount', 7)
            ->assertViewHas('urgentCount', 1);

        $this->actingAs($admin)->get(route('announcements.index', ['page' => 3]))
            ->assertOk()
            ->assertSee('Notice 1')
            ->assertDontSee('Notice 2')
            ->assertViewHas('publishedCount', 7)
            ->assertViewHas('urgentCount', 1);
        Http::assertNothingSent();
    }

    public function test_index_shows_sms_credits_unavailable_when_provider_balance_is_invalid(): void
    {
        Http::preventStrayRequests();
        Http::fake([
            'https://unismsapi.com/api/account' => Http::response([
                'status' => 'active',
                'sms_credits' => '42',
            ]),
        ]);
        config(['services.unisms.secret_key' => 'test-unisms-secret']);

        $response = $this->actingAs($this->createAdmin())
            ->get(route('announcements.index'));

        $response
            ->assertOk()
            ->assertSee('SMS Credits')
            ->assertSee('Unavailable')
            ->assertDontSee('>42<');
    }

    public function test_index_shows_sms_credits_unavailable_when_provider_rejects_the_account_request(): void
    {
        Http::preventStrayRequests();
        Http::fake([
            'https://unismsapi.com/api/account' => Http::response([
                'message' => 'Unauthorized',
            ], 401),
        ]);
        config(['services.unisms.secret_key' => 'test-unisms-secret']);

        $response = $this->actingAs($this->createAdmin())
            ->get(route('announcements.index'));

        $response
            ->assertOk()
            ->assertSee('Unavailable')
            ->assertSee('HTTP 401')
            ->assertDontSee('test-unisms-secret');
    }

    public function test_index_shows_sms_credits_unavailable_when_provider_connection_fails(): void
    {
        Http::preventStrayRequests();
        Http::fake([
            'https://unismsapi.com/api/account' => Http::failedConnection(),
        ]);
        config(['services.unisms.secret_key' => 'test-unisms-secret']);

        $response = $this->actingAs($this->createAdmin())
            ->get(route('announcements.index'));

        $response
            ->assertOk()
            ->assertSee('Unavailable')
            ->assertSee('temporarily unavailable')
            ->assertDontSee('test-unisms-secret');
    }

    public function test_index_shows_sms_credits_unavailable_without_calling_provider_when_unconfigured(): void
    {
        Http::preventStrayRequests();
        config(['services.unisms.secret_key' => null]);

        $response = $this->actingAs($this->createAdmin())
            ->get(route('announcements.index'));

        $response
            ->assertOk()
            ->assertSee('Unavailable')
            ->assertSee('UniSMS secret key is not configured.');

        Http::assertNothingSent();
    }

    public function test_announcement_can_be_deleted_from_its_directory(): void
    {
        $admin = $this->createAdmin();
        $announcement = Announcement::create([
            'title' => 'Remove this notice',
            'message' => 'This notice will be removed.',
            'target_type' => 'general',
            'priority' => 'Normal',
            'status' => 'Published',
            'published_at' => now(),
            'created_by' => $admin->id,
        ]);

        $response = $this->actingAs($admin)->delete(
            route('announcements.destroy', $announcement)
        );

        $response
            ->assertRedirect(route('announcements.index'))
            ->assertSessionHas('success', 'Announcement deleted successfully.');
        $this->assertModelMissing($announcement);
    }

    public function test_invalid_household_head_phone_is_not_prepared_as_a_pending_sms(): void
    {
        Http::preventStrayRequests();
        Notification::fake();

        $admin = $this->createAdmin();
        $household = $this->createHousehold('InvalidPhone');
        $head = $this->createResident('Head', '1980-01-01', [
            'household_id' => $household->id,
            'is_household_head' => true,
            'contact_number' => 'not-a-mobile-number',
        ]);

        $response = $this->actingAs($admin)->post(
            route('announcements.store'),
            [
                'title' => 'Contact check',
                'message' => 'This message must not be sent.',
                'target_type' => 'general',
                'priority' => 'Normal',
            ]
        );

        $announcement = Announcement::query()->latest('id')->firstOrFail();
        $response->assertRedirect(route('announcements.show', $announcement));
        $this->assertDatabaseCount('announcement_sms_deliveries', 0);
        Http::assertNothingSent();
    }

    private function createAdmin(): User
    {
        return User::factory()->create([
            'role' => 'System Administrator',
            'status' => 'active',
        ]);
    }

    private function createHousehold(string $label): Household
    {
        return Household::create([
            'household_code' => 'TEST-'.$label.'-'.Str::upper(Str::random(8)),
            'household_head_name' => $label.' household head',
            'address' => 'Test address',
            'status' => 'Active',
        ]);
    }

    /**
     * @param  array<string, mixed>  $attributes
     */
    private function createResident(
        string $firstName,
        string $birthDate,
        array $attributes = []
    ): Resident {
        $household = isset($attributes['household_id'])
            ? Household::findOrFail($attributes['household_id'])
            : $this->createHousehold($firstName);

        return Resident::create(array_merge([
            'household_id' => $household->id,
            'is_household_head' => true,
            'relationship_to_head' => 'Self',
            'first_name' => $firstName,
            'last_name' => 'Resident',
            'birth_date' => $birthDate,
            'gender' => 'Female',
            'contact_number' => '639171234567',
            'household_address' => 'Test address',
            'status' => 'Active',
        ], $attributes));
    }
}
