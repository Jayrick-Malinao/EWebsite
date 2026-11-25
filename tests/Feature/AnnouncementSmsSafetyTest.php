<?php

namespace Tests\Feature;

use App\Models\Announcement;
use App\Models\AnnouncementSmsDelivery;
use App\Models\Household;
use App\Models\Resident;
use App\Models\User;
use App\Notifications\AnnouncementPublishedNotification;
use App\Services\UniSmsService;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Exceptions;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;
use Mockery\MockInterface;
use PHPUnit\Framework\Attributes\TestWith;
use Tests\TestCase;

class AnnouncementSmsSafetyTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        Http::preventStrayRequests();
    }

    public function test_cancel_removes_unsubmitted_announcement_and_its_notifications(): void
    {
        [$admin, $announcement, $delivery] = $this->createSmsDelivery();
        $admin->notify(new AnnouncementPublishedNotification($announcement));
        $notificationId = $admin->notifications()->firstOrFail()->id;

        $response = $this->actingAs($admin)->post(route('announcements.cancel', $announcement));

        $response->assertRedirect(route('announcements.index'))
            ->assertSessionHas('success', 'Announcement canceled. No SMS messages were sent.');
        $this->assertModelMissing($announcement);
        $this->assertModelMissing($delivery);
        $this->assertDatabaseMissing('notifications', ['id' => $notificationId]);
        Http::assertNothingSent();
    }

    public function test_cancel_refuses_to_delete_an_attempted_sms(): void
    {
        [$admin, $announcement, $delivery] = $this->createSmsDelivery([
            'status' => 'Unknown',
            'attempt_started_at' => now(),
        ]);

        $response = $this->actingAs($admin)->post(route('announcements.cancel', $announcement));

        $response->assertRedirect(route('announcements.show', $announcement))
            ->assertSessionHas('error', 'This announcement cannot be canceled because SMS processing has already started.');
        $this->assertModelExists($announcement);
        $this->assertModelExists($delivery);
        Http::assertNothingSent();
    }

    public function test_cancel_requires_an_authorized_staff_role(): void
    {
        [, $announcement, $delivery] = $this->createSmsDelivery();
        $resident = User::factory()->create(['role' => 'Resident', 'status' => 'active']);

        $this->actingAs($resident)->post(route('announcements.cancel', $announcement))->assertForbidden();

        $this->assertModelExists($announcement);
        $this->assertModelExists($delivery);
    }

    public function test_confirmation_shows_prepared_and_uncertain_sms_without_claiming_success(): void
    {
        config(['services.unisms.enabled' => true, 'services.unisms.secret_key' => 'test-secret', 'services.unisms.sender_id' => 'TEST']);
        [$admin, $announcement, $delivery] = $this->createSmsDelivery();

        $this->actingAs($admin)->get(route('announcements.show', $announcement))
            ->assertOk()
            ->assertSee('Double-check the announcement')
            ->assertSee('Send 1 SMS')
            ->assertSee(route('announcements.cancel', $announcement))
            ->assertDontSee('Announcement directory')
            ->assertDontSee('SMS controls and details');

        $delivery->update(['status' => 'Unknown', 'attempt_started_at' => now()]);
        $this->actingAs($admin)->get(route('announcements.show', $announcement))
            ->assertOk()
            ->assertSee('No messages are ready to send')
            ->assertDontSee(route('announcements.cancel', $announcement))
            ->assertDontSee('>Sent</button>', false);
    }

    public function test_sms_summary_does_not_expose_provider_details_or_manual_controls(): void
    {
        [$admin, $announcement, $delivery] = $this->createSmsDelivery([
            'status' => 'Pending',
            'provider_reference' => 'msg_details_123',
            'provider_status' => 'pending',
            'provider_http_status' => 201,
            'sent_at' => '2026-01-15 09:00:00',
            'status_check_attempted_at' => '2026-01-15 09:05:00',
            'status_check_result' => 'connection_error',
        ]);
        DB::table('announcement_sms_status_checks')->insert([
            ['announcement_sms_delivery_id' => $delivery->id, 'checked_at' => '2026-01-15 09:02:00', 'result' => 'success', 'http_status' => 200, 'provider_status' => 'pending'],
            ['announcement_sms_delivery_id' => $delivery->id, 'checked_at' => '2026-01-15 09:05:00', 'result' => 'connection_error', 'http_status' => null, 'provider_status' => null],
        ]);

        $response = $this->actingAs($admin)->get(route('announcements.show', $announcement));

        $response->assertOk()
            ->assertSee('Pending: 1')
            ->assertDontSee('msg_details_123')
            ->assertDontSee('Last successful status check')
            ->assertDontSee('Check UniSMS status')
            ->assertDontSee('SMS controls and details');
    }

    public function test_sms_summary_does_not_claim_acceptance_without_evidence(): void
    {
        [$admin, $announcement] = $this->createSmsDelivery(['status' => 'Unknown']);

        $this->actingAs($admin)->get(route('announcements.show', $announcement))
            ->assertOk()
            ->assertSee('Unknown: 1')
            ->assertDontSee('>Sent</button>', false);
    }

    public function test_sms_status_command_is_due_every_five_minutes(): void
    {
        $this->travelTo(now()->startOfHour()->minute(10)->second(0));
        $schedule = $this->app->make(Schedule::class);

        $due = $schedule->dueEvents($this->app)
            ->contains(fn ($event): bool => str_contains($event->command ?? '', 'announcements:sync-sms-status'));
        $this->travel(1)->minute();
        $notDue = $schedule->dueEvents($this->app)
            ->contains(fn ($event): bool => str_contains($event->command ?? '', 'announcements:sync-sms-status'));

        $this->assertTrue($due);
        $this->assertFalse($notDue);
    }

    public function test_announcement_details_render_when_unisms_is_enabled(): void
    {
        config([
            'services.unisms.enabled' => true,
            'services.unisms.secret_key' => 'test-unisms-secret',
            'services.unisms.sender_id' => 'TEST-SENDER',
        ]);

        $admin = User::factory()->create([
            'role' => 'System Administrator',
            'status' => 'active',
        ]);

        $announcement = Announcement::create([
            'title' => 'Clinic schedule update',
            'message' => 'The clinic will open at 9 AM tomorrow.',
            'target_type' => 'general',
            'priority' => 'Important',
            'status' => 'Published',
            'published_at' => now(),
            'created_by' => $admin->id,
        ]);

        $response = $this->actingAs($admin)->get(
            route('announcements.show', $announcement)
        );

        $response
            ->assertOk()
            ->assertSee('Announcement details')
            ->assertSee('Clinic schedule update')
            ->assertSee('The clinic will open at 9 AM tomorrow.')
            ->assertSee('No SMS messages have been prepared for this announcement.');
    }

    public function test_announcement_details_show_failed_count_without_exposing_sms_details(): void
    {
        config([
            'services.unisms.enabled' => true,
            'services.unisms.secret_key' => 'test-unisms-secret',
            'services.unisms.sender_id' => 'TEST-SENDER',
        ]);

        $admin = User::factory()->create([
            'role' => 'System Administrator',
            'status' => 'active',
        ]);

        $household = Household::create([
            'household_code' => 'TEST-HH-0002',
            'household_head_name' => 'Test Household Head',
            'address' => 'Test Address',
            'contact_number' => '639171234567',
            'status' => 'Active',
        ]);

        $resident = Resident::create([
            'household_id' => $household->id,
            'is_household_head' => true,
            'relationship_to_head' => 'Self',
            'first_name' => 'Test',
            'last_name' => 'Resident',
            'birth_date' => '1990-01-01',
            'gender' => 'Female',
            'contact_number' => '639171234567',
            'household_address' => 'Test Address',
            'status' => 'Active',
        ]);

        $announcement = Announcement::create([
            'title' => 'SMS failure details test',
            'message' => 'Test announcement.',
            'target_type' => 'general',
            'priority' => 'Normal',
            'status' => 'Published',
            'published_at' => now(),
            'created_by' => $admin->id,
        ]);

        AnnouncementSmsDelivery::create([
            'announcement_id' => $announcement->id,
            'household_id' => $household->id,
            'household_head_resident_id' => $resident->id,
            'contact_number' => '639171234567',
            'status' => 'Failed',
            'failure_reason' => 'UniSMS did not accept the request (HTTP 401): Unauthorized.',
        ]);

        $response = $this->actingAs($admin)->get(
            route('announcements.show', $announcement)
        );

        $response
            ->assertOk()
            ->assertSee('Failed: 1')
            ->assertDontSee('Failed delivery details')
            ->assertDontSee('UniSMS did not accept the request (HTTP 401): Unauthorized.')
            ->assertDontSee('639171234567');
    }

    public function test_pending_sms_without_contact_number_is_failed_without_calling_sms_service(): void
    {
        // Enable the controller's processing path only for this test.
        // This does not change the .env file or enable real SMS sending.
        config([
            'services.unisms.enabled' => true,
            'services.unisms.secret_key' => 'test-unisms-secret',
            'services.unisms.sender_id' => 'TEST-SENDER',
        ]);

        $admin = User::factory()->create([
            'role' => 'System Administrator',
            'status' => 'active',
        ]);

        $household = Household::create([
            'household_code' => 'TEST-HH-0001',
            'household_head_name' => 'Test Household Head',
            'address' => 'Test Address',
            'contact_number' => null,
            'status' => 'Active',
        ]);

        $resident = Resident::create([
            'household_id' => $household->id,
            'is_household_head' => true,
            'relationship_to_head' => 'Self',
            'first_name' => 'Test',
            'last_name' => 'Resident',
            'birth_date' => '1990-01-01',
            'gender' => 'Female',
            'contact_number' => null,
            'household_address' => 'Test Address',
            'status' => 'Active',
        ]);

        $announcement = Announcement::create([
            'title' => 'Automated SMS Safety Test',
            'message' => 'This is a simulated announcement for testing.',
            'target_type' => 'general',
            'priority' => 'Normal',
            'status' => 'Published',
            'published_at' => now(),
            'created_by' => $admin->id,
        ]);

        $delivery = AnnouncementSmsDelivery::create([
            'announcement_id' => $announcement->id,
            'household_id' => $household->id,
            'household_head_resident_id' => $resident->id,
            'contact_number' => '',
            'status' => 'Prepared',
            'sent_at' => null,
            'failure_reason' => null,
        ]);

        // The SMS service must never be called for a blank number.
        $this->mock(
            UniSmsService::class,
            function (MockInterface $mock): void {
                $mock->shouldNotReceive('send');
            }
        );

        $response = $this->actingAs($admin)->post(
            route('announcements.sms.send', $announcement)
        );

        $response->assertRedirect(
            route('announcements.show', $announcement)
        );

        $response->assertSessionHas(
            'warning',
            'SMS processing finished. Accepted: 0; failed: 1.'
        );

        $this->assertDatabaseHas('announcement_sms_deliveries', [
            'id' => $delivery->id,
            'status' => 'Failed',
            'contact_number' => '',
            'sent_at' => null,
            'failure_reason' => 'No valid recipient contact number is recorded.',
        ]);
    }

    public function test_pending_sms_is_not_sent_when_unisms_is_disabled(): void
    {
        Http::preventStrayRequests();

        config([
            'services.unisms.enabled' => false,
            'services.unisms.secret_key' => 'test-unisms-secret',
            'services.unisms.sender_id' => 'TEST-SENDER',
        ]);

        $admin = User::factory()->create([
            'role' => 'System Administrator',
            'status' => 'active',
        ]);

        $announcement = Announcement::create([
            'title' => 'Disabled UniSMS test',
            'message' => 'This message must not be sent.',
            'target_type' => 'general',
            'priority' => 'Normal',
            'status' => 'Published',
            'published_at' => now(),
            'created_by' => $admin->id,
        ]);

        $response = $this->actingAs($admin)->post(
            route('announcements.sms.send', $announcement)
        );

        $response
            ->assertRedirect(route('announcements.show', $announcement))
            ->assertSessionHas(
                'error',
                'SMS sending is disabled. Configure UniSMS and enable UNISMS_SMS_ENABLED only when you are ready to send real messages.'
            );

        Http::assertNothingSent();
    }

    public function test_provider_status_500_is_saved_as_uncertain_and_not_retried(): void
    {
        Http::preventStrayRequests();

        config([
            'services.unisms.enabled' => true,
            'services.unisms.secret_key' => 'test-unisms-secret',
            'services.unisms.sender_id' => 'TEST-SENDER',
        ]);

        Http::fake([
            'unismsapi.com/api/sms' => Http::response([
                'message' => [
                    'status' => 'pending',
                    'reference_id' => 'msg_uncertain_123',
                ],
            ], 200, [
                'Content-Type' => 'application/json',
            ]),
        ]);

        $admin = User::factory()->create([
            'role' => 'System Administrator',
            'status' => 'active',
        ]);

        $household = Household::create([
            'household_code' => 'TEST-HH-0003',
            'household_head_name' => 'Test Household Head',
            'address' => 'Test Address',
            'contact_number' => '639171234567',
            'status' => 'Active',
        ]);

        $resident = Resident::create([
            'household_id' => $household->id,
            'is_household_head' => true,
            'relationship_to_head' => 'Self',
            'first_name' => 'Test',
            'last_name' => 'Resident',
            'birth_date' => '1990-01-01',
            'gender' => 'Female',
            'contact_number' => '639171234567',
            'household_address' => 'Test Address',
            'status' => 'Active',
        ]);

        $announcement = Announcement::create([
            'title' => 'Provider failure test',
            'message' => 'Synthetic SMS body for the provider failure test.',
            'target_type' => 'general',
            'priority' => 'Normal',
            'status' => 'Published',
            'published_at' => now(),
            'created_by' => $admin->id,
        ]);

        $delivery = AnnouncementSmsDelivery::create([
            'announcement_id' => $announcement->id,
            'household_id' => $household->id,
            'household_head_resident_id' => $resident->id,
            'contact_number' => '639171234567',
            'status' => 'Prepared',
        ]);

        $response = $this->actingAs($admin)->post(
            route('announcements.sms.send', $announcement)
        );

        $response->assertRedirect(route('announcements.show', $announcement));

        $this->assertDatabaseHas('announcement_sms_deliveries', [
            'id' => $delivery->id,
            'status' => 'Unknown',
            'sent_at' => null,
        ]);

        $this->assertStringContainsString(
            'acceptance is uncertain',
            $delivery->fresh()->failure_reason
        );

        $response = $this->actingAs($admin)->post(
            route('announcements.sms.send', $announcement)
        );

        $response->assertRedirect(route('announcements.show', $announcement));
        $response->assertSessionHas(
            'info',
            'There are no prepared SMS messages for this announcement.'
        );

        Http::assertSentCount(1);
        Http::assertSent(function ($request): bool {
            return $request->method() === 'POST'
                && $request->url() === 'https://unismsapi.com/api/sms'
                && $request->hasHeader(
                    'Authorization',
                    'Basic '.base64_encode('test-unisms-secret:')
                )
                && $request['recipient'] === '+639171234567'
                && $request['sender_id'] === 'TEST-SENDER'
                && str_contains($request['content'], 'Synthetic SMS body');
        });
    }

    public function test_provider_acceptance_is_pending_and_concurrent_requests_do_not_resend(): void
    {
        Http::preventStrayRequests();
        config([
            'services.unisms.enabled' => true,
            'services.unisms.secret_key' => 'test-secret',
            'services.unisms.sender_id' => 'TEST',
        ]);
        [$admin, $announcement, $delivery] = $this->createSmsDelivery();

        Http::fake([
            'unismsapi.com/api/sms' => function () use ($admin, $announcement) {
                $this->actingAs($admin)->post(route('announcements.sms.send', $announcement))
                    ->assertSessionHas('info', 'There are no prepared SMS messages for this announcement.');
                $this->actingAs($admin)->post(route('announcements.cancel', $announcement))
                    ->assertSessionHas('error', 'This announcement cannot be canceled because SMS processing has already started.');

                return Http::response(['message' => [
                    'reference_id' => 'msg_test_123',
                    'status' => 'pending',
                ]], 201);
            },
        ]);

        $this->actingAs($admin)->post(route('announcements.sms.send', $announcement))
            ->assertRedirect(route('announcements.show', $announcement));

        $this->assertDatabaseHas('announcement_sms_deliveries', [
            'id' => $delivery->id,
            'status' => 'Pending',
            'provider_reference' => 'msg_test_123',
            'provider_status' => 'pending',
            'provider_http_status' => 201,
        ]);
        $this->assertNotNull($delivery->fresh()->attempt_started_at);
        Http::assertSentCount(1);
        $this->actingAs($admin)->get(route('announcements.show', $announcement))
            ->assertOk()
            ->assertSee('Pending: 1')
            ->assertSee('0 confirmed delivered out of 1 total.')
            ->assertSee('>Sent</button>', false)
            ->assertSee('Handset delivery may still be unconfirmed.')
            ->assertDontSee(route('announcements.cancel', $announcement));
    }

    public function test_timeout_is_unknown_and_is_not_resubmitted(): void
    {
        Http::preventStrayRequests();
        config([
            'services.unisms.enabled' => true,
            'services.unisms.secret_key' => 'test-secret',
            'services.unisms.sender_id' => 'TEST',
        ]);
        [$admin, $announcement, $delivery] = $this->createSmsDelivery();
        Http::fake(['unismsapi.com/api/sms' => Http::failedConnection()]);

        $this->actingAs($admin)->post(route('announcements.sms.send', $announcement))->assertRedirect();
        $this->actingAs($admin)->post(route('announcements.sms.send', $announcement))->assertRedirect();

        $this->assertDatabaseHas('announcement_sms_deliveries', [
            'id' => $delivery->id,
            'status' => 'Unknown',
            'provider_reference' => null,
        ]);
        Http::assertSentCount(1);
    }

    public function test_duplicate_numbers_in_separate_records_are_submitted_only_once(): void
    {
        Http::preventStrayRequests();
        config([
            'services.unisms.enabled' => true,
            'services.unisms.secret_key' => 'test-secret',
            'services.unisms.sender_id' => 'TEST',
        ]);
        [$admin, $announcement, $first] = $this->createSmsDelivery();
        $duplicate = AnnouncementSmsDelivery::create([
            'announcement_id' => $announcement->id,
            'recipient_type' => 'resident',
            'contact_number' => '09171234567',
            'status' => 'Prepared',
        ]);
        Http::fake(['unismsapi.com/api/sms' => Http::response(['message' => [
            'reference_id' => 'msg_duplicate_test',
            'status' => 'pending',
        ]], 201)]);

        $this->actingAs($admin)->post(route('announcements.sms.send', $announcement))->assertRedirect();

        $this->assertSame('Pending', $first->fresh()->status);
        $this->assertSame('Failed', $duplicate->fresh()->status);
        $this->assertStringContainsString('already been processed', $duplicate->fresh()->failure_reason);
        Http::assertSentCount(1);
    }

    #[TestWith([401, 'Unauthorized'])]
    #[TestWith([422, 'Sender ID cannot reach this network'])]
    public function test_provider_rejection_is_recorded_without_retry(int $status, string $reason): void
    {
        Http::preventStrayRequests();
        config([
            'services.unisms.enabled' => true,
            'services.unisms.secret_key' => 'test-secret',
            'services.unisms.sender_id' => 'TEST',
        ]);
        [$admin, $announcement, $delivery] = $this->createSmsDelivery();
        Http::fake(['unismsapi.com/api/sms' => Http::response(['error' => $reason], $status)]);

        $this->actingAs($admin)->post(route('announcements.sms.send', $announcement))->assertRedirect();
        $this->actingAs($admin)->post(route('announcements.sms.send', $announcement))->assertRedirect();

        $this->assertSame('Failed', $delivery->fresh()->status);
        $this->assertSame($status, $delivery->fresh()->provider_http_status);
        $this->assertStringContainsString($reason, $delivery->fresh()->failure_reason);
        Http::assertSentCount(1);
    }

    #[TestWith(['pending', 'Pending'])]
    #[TestWith(['retrying', 'Pending'])]
    #[TestWith(['sent', 'Unknown'])]
    #[TestWith(['failed', 'Failed'])]
    public function test_status_lookup_uses_documented_provider_statuses(string $providerStatus, string $expectedStatus): void
    {
        Http::preventStrayRequests();
        config(['services.unisms.secret_key' => 'test-secret', 'services.unisms.sender_id' => 'TEST']);
        [$admin, $announcement, $delivery] = $this->createSmsDelivery([
            'status' => 'Pending',
            'provider_reference' => 'msg_status_123',
            'provider_status' => 'pending',
            'provider_http_status' => 201,
            'attempt_started_at' => now(),
        ]);
        Http::fake(['unismsapi.com/api/sms/msg_status_123' => Http::response([
            'message' => [
                'reference_id' => 'msg_status_123',
                'status' => $providerStatus,
                'fail_reason' => $providerStatus === 'failed' ? 'Sender ID inactive' : null,
            ],
        ])]);

        $this->actingAs($admin)->post(route('announcements.sms.refresh', $announcement))
            ->assertRedirect()
            ->assertSessionHas('success', 'UniSMS status checks: 1 updated; 0 skipped; 0 not yet due; 0 unavailable; 0 missing references; 0 invalid references.');

        $this->assertDatabaseHas('announcement_sms_deliveries', [
            'id' => $delivery->id,
            'status' => $expectedStatus,
            'provider_status' => $providerStatus,
            'provider_http_status' => 201,
            'status_lookup_http_status' => 200,
        ]);
        $this->assertDatabaseHas('announcement_sms_status_checks', [
            'announcement_sms_delivery_id' => $delivery->id,
            'result' => 'success',
            'provider_status' => $providerStatus,
            'provider_reason' => $providerStatus === 'failed' ? 'Sender ID inactive' : null,
        ]);
        Http::assertSent(fn ($request) => $request->method() === 'GET'
            && $request->hasHeader('Authorization', 'Basic '.base64_encode('test-secret:')));
    }

    public function test_provider_filter_failure_is_recorded_without_resending(): void
    {
        Http::preventStrayRequests();
        config(['services.unisms.secret_key' => 'test-secret']);
        [$admin, $announcement, $delivery] = $this->createSmsDelivery([
            'status' => 'Pending',
            'provider_reference' => 'msg_filtered',
            'provider_status' => 'pending',
        ]);
        Http::fake(['unismsapi.com/api/sms/msg_filtered' => Http::response(['message' => [
            'reference_id' => 'msg_filtered',
            'status' => 'failed',
            'fail_reason' => 'Message rejected by content filter.',
        ]])]);

        $this->actingAs($admin)->post(route('announcements.sms.refresh', $announcement))->assertRedirect();
        $this->actingAs($admin)->post(route('announcements.sms.refresh', $announcement))->assertRedirect();

        $this->assertDatabaseHas('announcement_sms_deliveries', [
            'id' => $delivery->id,
            'status' => 'Failed',
            'provider_reference' => 'msg_filtered',
            'provider_status' => 'failed',
            'failure_reason' => 'UniSMS reported this message as failed. Message rejected by content filter.',
        ]);
        $this->actingAs($admin)->get(route('announcements.show', $announcement))
            ->assertOk()
            ->assertSee('Failed: 1')
            ->assertDontSee('Message rejected by content filter.')
            ->assertDontSee('msg_filtered');
        Http::assertSentCount(1);
        Http::assertNotSent(fn ($request) => $request->method() !== 'GET');
    }

    public function test_retrying_status_checks_store_sanitized_reasons_without_resending(): void
    {
        Http::preventStrayRequests();
        config(['services.unisms.secret_key' => 'test-secret', 'services.unisms.sender_id' => 'TEST-SENDER']);
        [$admin, $announcement, $delivery] = $this->createSmsDelivery([
            'status' => 'Pending',
            'provider_reference' => 'msg_retrying_reason',
            'provider_status' => 'pending',
        ]);
        Http::fake(['unismsapi.com/api/sms/msg_retrying_reason' => Http::sequence()
            ->push(['message' => [
                'reference_id' => 'msg_retrying_reason',
                'status' => 'retrying',
                'recipient' => '+639171234567',
                'content' => 'Private announcement',
                'fail_reason' => 'Route unavailable for 09171234567; test-secret; Private announcement; TEST-SENDER.',
            ]])
            ->push(['message' => [
                'reference_id' => 'msg_retrying_reason',
                'status' => 'retrying',
                'fail_reason' => null,
            ]])
            ->push(['message' => [
                'reference_id' => 'msg_retrying_reason',
                'status' => 'retrying',
                'fail_reason' => ['unexpected'],
            ]])]);

        for ($i = 0; $i < 3; $i++) {
            $this->actingAs($admin)->post(route('announcements.sms.refresh', $announcement))
                ->assertSessionHas('success', 'UniSMS status checks: 1 updated; 0 skipped; 0 not yet due; 0 unavailable; 0 missing references; 0 invalid references.');
        }

        $this->assertDatabaseHas('announcement_sms_deliveries', [
            'id' => $delivery->id,
            'status' => 'Pending',
            'provider_reference' => 'msg_retrying_reason',
            'provider_status' => 'retrying',
            'failure_reason' => null,
        ]);
        $checks = DB::table('announcement_sms_status_checks')
            ->where('announcement_sms_delivery_id', $delivery->id)
            ->orderBy('id')
            ->get();
        $this->assertCount(3, $checks);
        $this->assertSame('Route unavailable for [phone redacted]; [redacted]; [redacted]; [redacted].', $checks[0]->provider_reason);
        $this->assertNull($checks[1]->provider_reason);
        $this->assertNull($checks[2]->provider_reason);
        $this->actingAs($admin)->get(route('announcements.show', $announcement))
            ->assertOk()
            ->assertSee('Retrying: 1')
            ->assertDontSee('Last reported provider detail')
            ->assertDontSee('test-secret')
            ->assertDontSee('Private announcement');
        Http::assertSentCount(3);
        Http::assertNotSent(fn ($request) => $request->method() !== 'GET');
    }

    public function test_webhook_requires_secret_and_does_not_regress_failed_messages(): void
    {
        config(['services.unisms.webhook_secret' => 'webhook-secret']);
        [, , $delivery] = $this->createSmsDelivery([
            'status' => 'Pending',
            'provider_reference' => 'msg_webhook_123',
            'provider_status' => 'pending',
            'attempt_started_at' => now(),
        ]);
        $payload = [
            'id' => 'msg_webhook_123',
            'event' => 'message.failed',
            'message' => [
                'reference_id' => 'msg_webhook_123',
                'status' => 'failed',
                'fail_reason' => 'Sender ID inactive',
            ],
        ];

        $this->postJson(route('announcements.sms.webhook'), $payload)->assertForbidden();
        $this->withHeader('webhook-secret-key', 'incorrect-secret')
            ->postJson(route('announcements.sms.webhook'), $payload)->assertForbidden();
        $this->assertSame('Pending', $delivery->fresh()->status);
        $this->withHeader('webhook-secret-key', 'webhook-secret')
            ->postJson(route('announcements.sms.webhook'), $payload)->assertOk();
        $this->assertSame('Failed', $delivery->fresh()->status);
        $this->assertStringContainsString('Sender ID inactive', $delivery->fresh()->failure_reason);

        $payload['event'] = 'message.retrying';
        $payload['message']['status'] = 'retrying';
        $this->withHeader('webhook-secret-key', 'webhook-secret')
            ->postJson(route('announcements.sms.webhook'), $payload)->assertOk();
        $this->assertSame('Failed', $delivery->fresh()->status);
    }

    #[TestWith(['sent', 'Unknown'])]
    #[TestWith(['failed', 'Failed'])]
    #[TestWith(['retrying', 'Pending'])]
    public function test_repeated_webhook_status_does_not_rewrite_the_delivery(string $providerStatus, string $expectedStatus): void
    {
        $this->travelTo(now()->startOfSecond());
        config(['services.unisms.webhook_secret' => 'webhook-secret']);
        [, , $delivery] = $this->createSmsDelivery([
            'status' => 'Pending',
            'provider_reference' => 'msg_repeat',
            'provider_status' => 'pending',
        ]);
        $payload = [
            'id' => 'msg_repeat',
            'event' => 'message.'.$providerStatus,
            'message' => ['reference_id' => 'msg_repeat', 'status' => $providerStatus],
        ];

        $this->withHeader('webhook-secret-key', 'webhook-secret')
            ->postJson(route('announcements.sms.webhook'), $payload)->assertOk();
        $firstUpdate = $delivery->fresh();
        $this->travel(2)->seconds();
        $this->withHeader('webhook-secret-key', 'webhook-secret')
            ->postJson(route('announcements.sms.webhook'), $payload)->assertOk();

        $this->assertSame($expectedStatus, $delivery->fresh()->status);
        $this->assertSame($providerStatus, $delivery->fresh()->provider_status);
        $this->assertSame($firstUpdate->status_checked_at->toDateTimeString(), $delivery->fresh()->status_checked_at->toDateTimeString());
    }

    #[TestWith(['sent', 'retrying', 'Unknown', 'sent'])]
    #[TestWith(['failed', 'sent', 'Failed', 'failed'])]
    #[TestWith(['sent', 'failed', 'Failed', 'failed'])]
    public function test_webhook_status_transitions_keep_the_existing_conservative_policy(
        string $firstStatus,
        string $secondStatus,
        string $expectedStatus,
        string $expectedProviderStatus,
    ): void {
        config(['services.unisms.webhook_secret' => 'webhook-secret']);
        [, , $delivery] = $this->createSmsDelivery([
            'status' => 'Pending',
            'provider_reference' => 'msg_transition',
            'provider_status' => 'pending',
        ]);

        foreach ([$firstStatus, $secondStatus] as $status) {
            $this->withHeader('webhook-secret-key', 'webhook-secret')
                ->postJson(route('announcements.sms.webhook'), [
                    'id' => 'msg_transition',
                    'event' => 'message.'.$status,
                    'message' => ['reference_id' => 'msg_transition', 'status' => $status],
                ])->assertOk();
        }

        $this->assertSame($expectedStatus, $delivery->fresh()->status);
        $this->assertSame($expectedProviderStatus, $delivery->fresh()->provider_status);
    }

    #[TestWith(['sent'])]
    #[TestWith(['failed'])]
    #[TestWith(['retrying'])]
    public function test_webhook_does_not_overwrite_delivered_status(string $providerStatus): void
    {
        config(['services.unisms.webhook_secret' => 'webhook-secret']);
        [, , $delivery] = $this->createSmsDelivery([
            'status' => 'Delivered',
            'provider_reference' => 'msg_delivered',
        ]);

        $this->withHeader('webhook-secret-key', 'webhook-secret')
            ->postJson(route('announcements.sms.webhook'), [
                'id' => 'msg_delivered',
                'event' => 'message.'.$providerStatus,
                'message' => ['reference_id' => 'msg_delivered', 'status' => $providerStatus],
            ])->assertOk();

        $this->assertSame('Delivered', $delivery->fresh()->status);
    }

    public function test_webhook_rejects_malformed_and_inconsistent_message_references(): void
    {
        config(['services.unisms.webhook_secret' => 'webhook-secret']);
        $headers = ['webhook-secret-key' => 'webhook-secret'];

        $this->withHeaders($headers)->postJson(route('announcements.sms.webhook'), [
            'id' => 'invalid reference',
            'event' => 'message.sent',
            'message' => ['reference_id' => 'invalid reference', 'status' => 'sent'],
        ])->assertUnprocessable();
        $this->withHeaders($headers)->postJson(route('announcements.sms.webhook'), [
            'id' => 'msg_first',
            'event' => 'message.sent',
            'message' => ['reference_id' => 'msg_second', 'status' => 'sent'],
        ])->assertUnprocessable();
        $this->withHeaders($headers)->postJson(route('announcements.sms.webhook'), [
            'id' => 'msg_first',
            'event' => 'message.sent',
            'message' => ['reference_id' => 'msg_first', 'status' => 'failed'],
        ])->assertUnprocessable();
        $this->withHeaders($headers)->postJson(route('announcements.sms.webhook'), [
            'id' => 'msg_first',
            'event' => 'message.unknown',
            'message' => ['reference_id' => 'msg_first', 'status' => 'sent'],
        ])->assertUnprocessable();
    }

    public function test_webhook_returns_unavailable_when_a_status_update_is_not_applied(): void
    {
        config(['services.unisms.webhook_secret' => 'webhook-secret']);
        [, , $delivery] = $this->createSmsDelivery([
            'status' => 'Pending',
            'provider_reference' => 'msg_unavailable',
            'provider_status' => 'pending',
        ]);
        $this->partialMock(UniSmsService::class, function (MockInterface $mock): void {
            $mock->shouldReceive('updateDeliveryStatus')->once()->andReturn(false);
        });

        $this->withHeader('webhook-secret-key', 'webhook-secret')
            ->postJson(route('announcements.sms.webhook'), [
                'id' => 'msg_unavailable',
                'event' => 'message.failed',
                'message' => ['reference_id' => 'msg_unavailable', 'status' => 'failed'],
            ])->assertStatus(503);

        $this->assertSame('Pending', $delivery->fresh()->status);
    }

    public function test_webhook_rolls_back_when_status_processing_fails(): void
    {
        config(['services.unisms.webhook_secret' => 'webhook-secret']);
        [, , $delivery] = $this->createSmsDelivery([
            'status' => 'Pending',
            'provider_reference' => 'msg_rollback',
            'provider_status' => 'pending',
        ]);
        Exceptions::fake();
        $this->partialMock(UniSmsService::class, function (MockInterface $mock): void {
            $mock->shouldReceive('updateDeliveryStatus')->once()
                ->andReturnUsing(function (AnnouncementSmsDelivery $delivery): void {
                    $delivery->update(['status' => 'Failed', 'provider_status' => 'failed']);

                    throw new \RuntimeException('Simulated status update failure.');
                });
        });

        $this->withHeader('webhook-secret-key', 'webhook-secret')
            ->postJson(route('announcements.sms.webhook'), [
                'id' => 'msg_rollback',
                'event' => 'message.failed',
                'message' => ['reference_id' => 'msg_rollback', 'status' => 'failed'],
            ])->assertServerError();

        $this->assertSame('Pending', $delivery->fresh()->status);
        $this->assertSame('pending', $delivery->fresh()->provider_status);
        Exceptions::assertReported(\RuntimeException::class);
    }

    public function test_invalid_status_response_and_webhook_are_not_applied(): void
    {
        Http::preventStrayRequests();
        config([
            'services.unisms.secret_key' => 'test-secret',
            'services.unisms.sender_id' => 'TEST',
            'services.unisms.webhook_secret' => 'webhook-secret',
        ]);
        [$admin, $announcement, $delivery] = $this->createSmsDelivery([
            'status' => 'Pending',
            'provider_reference' => 'msg_expected',
            'provider_status' => 'pending',
            'attempt_started_at' => now(),
        ]);
        Http::fake(['unismsapi.com/api/sms/msg_expected' => Http::response(['message' => [
            'reference_id' => 'msg_other',
            'status' => 'failed',
            'fail_reason' => 'Unverified reason',
        ]])]);

        $this->actingAs($admin)->post(route('announcements.sms.refresh', $announcement))
            ->assertSessionHas('warning', 'UniSMS status checks: 0 updated; 0 skipped; 0 not yet due; 1 unavailable; 0 missing references; 0 invalid references. UniSMS did not return a verifiable message status; the previous status was retained.');
        $this->withHeader('webhook-secret-key', 'webhook-secret')
            ->postJson(route('announcements.sms.webhook'), [
                'id' => 'msg_expected',
                'event' => 'message.sent',
                'message' => ['reference_id' => 'msg_expected', 'status' => 'failed'],
            ])->assertUnprocessable();

        $this->assertSame('Pending', $delivery->fresh()->status);
        $this->assertDatabaseHas('announcement_sms_status_checks', [
            'announcement_sms_delivery_id' => $delivery->id,
            'result' => 'invalid_response',
            'http_status' => 200,
            'provider_status' => null,
            'provider_reason' => null,
        ]);
        Http::assertSentCount(1);
    }

    public function test_checking_five_messages_updates_only_existing_records_and_never_sends_sms(): void
    {
        Http::preventStrayRequests();
        config(['services.unisms.secret_key' => 'test-secret', 'services.unisms.sender_id' => 'TEST']);
        [$admin, $announcement, $first] = $this->createSmsDelivery([
            'status' => 'Pending',
            'provider_reference' => 'msg_check_1',
            'provider_status' => 'pending',
            'attempt_started_at' => now(),
        ]);
        $deliveries = [$first];
        foreach (range(2, 5) as $index) {
            $deliveries[] = AnnouncementSmsDelivery::create([
                'announcement_id' => $announcement->id,
                'recipient_type' => 'resident',
                'contact_number' => '63917123456'.$index,
                'status' => 'Pending',
                'provider_reference' => 'msg_check_'.$index,
                'provider_status' => 'pending',
                'attempt_started_at' => now(),
            ]);
        }
        $statuses = ['pending', 'retrying', 'failed', 'sent', 'pending'];
        $responses = [];
        foreach ($statuses as $index => $status) {
            $reference = 'msg_check_'.($index + 1);
            $responses['unismsapi.com/api/sms/'.$reference] = Http::response(['message' => [
                'reference_id' => $reference,
                'status' => $status,
                'fail_reason' => $status === 'failed' ? 'Sender ID inactive' : null,
            ]]);
        }
        Http::fake($responses);

        $this->actingAs($admin)->post(route('announcements.sms.refresh', $announcement))
            ->assertSessionHas('success', 'UniSMS status checks: 5 updated; 0 skipped; 0 not yet due; 0 unavailable; 0 missing references; 0 invalid references.');
        $this->actingAs($admin)->post(route('announcements.sms.refresh', $announcement))
            ->assertSessionHas('success', 'UniSMS status checks: 3 updated; 1 skipped; 0 not yet due; 0 unavailable; 0 missing references; 0 invalid references.');

        $this->assertDatabaseCount('announcement_sms_deliveries', 5);
        foreach (['Pending', 'Pending', 'Failed', 'Unknown', 'Pending'] as $index => $status) {
            $this->assertDatabaseHas('announcement_sms_deliveries', [
                'id' => $deliveries[$index]->id,
                'announcement_id' => $announcement->id,
                'provider_reference' => 'msg_check_'.($index + 1),
                'status' => $status,
            ]);
        }
        Http::assertSentCount(8);
        Http::assertNotSent(fn ($request) => $request->method() !== 'GET');
    }

    public function test_status_page_distinguishes_provider_sent_from_other_unknown_outcomes(): void
    {
        Http::preventStrayRequests();
        config(['services.unisms.secret_key' => 'test-secret', 'services.unisms.sender_id' => 'TEST']);
        [$admin, $announcement, $delivery] = $this->createSmsDelivery([
            'status' => 'Pending',
            'provider_reference' => 'msg_page_status',
            'provider_status' => 'pending',
        ]);
        AnnouncementSmsDelivery::create([
            'announcement_id' => $announcement->id,
            'recipient_type' => 'resident',
            'contact_number' => '639171234568',
            'status' => 'Unknown',
        ]);
        Http::fake(['unismsapi.com/api/sms/msg_page_status' => Http::response(['message' => [
            'reference_id' => 'msg_page_status',
            'status' => 'sent',
        ]])]);

        $this->actingAs($admin)->post(route('announcements.sms.refresh', $announcement))->assertRedirect();
        $response = $this->actingAs($admin)->get(route('announcements.show', $announcement));

        $response->assertOk()
            ->assertSee('UniSMS reports 1 message sent;')
            ->assertSee('0 confirmed delivered out of 2 total.')
            ->assertSee('Handset delivery is not confirmed for messages reported as sent.')
            ->assertSee('Pending: 0')
            ->assertSee('Unknown: 1')
            ->assertDontSee('SMS controls and details');
        $this->assertDatabaseHas('announcement_sms_deliveries', [
            'id' => $delivery->id,
            'status' => 'Unknown',
            'provider_status' => 'sent',
        ]);
        Http::assertSentCount(1);
        Http::assertNotSent(fn ($request) => $request->method() !== 'GET');
    }

    public function test_sms_information_distinguishes_confirmed_delivery_from_pending_messages(): void
    {
        [$admin, $announcement] = $this->createSmsDelivery(['status' => 'Delivered']);
        AnnouncementSmsDelivery::create([
            'announcement_id' => $announcement->id,
            'recipient_type' => 'resident',
            'contact_number' => '639171234568',
            'status' => 'Pending',
        ]);

        $this->actingAs($admin)->get(route('announcements.show', $announcement))
            ->assertOk()
            ->assertSee('UniSMS reports 0 messages sent;')
            ->assertSee('1 confirmed delivered out of 2 total.')
            ->assertSee('Pending: 1');
    }

    #[TestWith([401, 'authentication failed'])]
    #[TestWith([429, 'rate limit reached'])]
    #[TestWith([503, 'temporarily unavailable'])]
    public function test_status_lookup_http_errors_preserve_pending(int $status, string $reason): void
    {
        Http::preventStrayRequests();
        config(['services.unisms.secret_key' => 'test-secret']);
        [$admin, $announcement, $delivery] = $this->createSmsDelivery([
            'status' => 'Pending',
            'provider_reference' => 'msg_error',
            'provider_status' => 'pending',
            'attempt_started_at' => now(),
        ]);
        Http::fake(['unismsapi.com/api/sms/msg_error' => Http::response([], $status)]);

        $response = $this->actingAs($admin)->post(route('announcements.sms.refresh', $announcement));

        $this->assertStringContainsString($reason, $response->getSession()->get('warning'));
        $this->assertSame('Pending', $delivery->fresh()->status);
        Http::assertSentCount(1);
    }

    public function test_status_lookup_timeout_preserves_pending(): void
    {
        Http::preventStrayRequests();
        config(['services.unisms.secret_key' => 'test-secret']);
        [$admin, $announcement, $delivery] = $this->createSmsDelivery([
            'status' => 'Pending',
            'provider_reference' => 'msg_timeout',
            'attempt_started_at' => now(),
        ]);
        Http::fake(['unismsapi.com/api/sms/msg_timeout' => Http::failedConnection()]);

        $this->actingAs($admin)->post(route('announcements.sms.refresh', $announcement))
            ->assertSessionHas('warning', 'UniSMS status checks: 0 updated; 0 skipped; 0 not yet due; 1 unavailable; 0 missing references; 0 invalid references. UniSMS status lookup failed; the previous status was retained. Remaining checks were deferred.');

        $this->assertSame('Pending', $delivery->fresh()->status);
        $this->assertSame('connection_error', $delivery->fresh()->status_check_result);
        $this->assertNotNull($delivery->fresh()->status_check_attempted_at);
        $this->assertDatabaseHas('announcement_sms_status_checks', [
            'announcement_sms_delivery_id' => $delivery->id,
            'result' => 'connection_error',
            'http_status' => null,
        ]);
        Http::assertSentCount(1);
    }

    public function test_scheduled_status_check_updates_due_pending_without_sending_or_rechecking_terminal_messages(): void
    {
        Http::preventStrayRequests();
        $this->freezeTime();
        config(['services.unisms.secret_key' => 'test-secret']);
        [, $announcement, $delivery] = $this->createSmsDelivery([
            'status' => 'Pending',
            'provider_reference' => 'msg_scheduled',
            'provider_status' => 'pending',
        ]);
        AnnouncementSmsDelivery::create([
            'announcement_id' => $announcement->id,
            'recipient_type' => 'resident',
            'contact_number' => '639171234568',
            'status' => 'Unknown',
            'provider_reference' => 'msg_already_sent',
            'provider_status' => 'sent',
            'status_check_attempted_at' => now(),
        ]);
        Http::fake(['unismsapi.com/api/sms/msg_scheduled' => Http::response(['message' => [
            'reference_id' => 'msg_scheduled',
            'status' => 'sent',
        ]])]);

        $this->artisan('announcements:sync-sms-status')->assertSuccessful();
        $this->artisan('announcements:sync-sms-status')->assertSuccessful();

        $this->assertDatabaseHas('announcement_sms_deliveries', [
            'id' => $delivery->id,
            'status' => 'Unknown',
            'provider_status' => 'sent',
            'status_check_result' => 'success',
        ]);
        $this->assertNotNull($delivery->fresh()->status_check_attempted_at);
        $this->assertDatabaseHas('announcement_sms_status_checks', [
            'announcement_sms_delivery_id' => $delivery->id,
            'result' => 'success',
            'http_status' => 200,
            'provider_status' => 'sent',
        ]);
        $this->assertDatabaseCount('announcement_sms_deliveries', 2);
        Http::assertSentCount(1);
        Http::assertNotSent(fn ($request) => $request->method() !== 'GET');
    }

    public function test_scheduled_check_cools_down_pending_and_stops_after_provider_rate_limit(): void
    {
        Http::preventStrayRequests();
        $this->freezeTime();
        config(['services.unisms.secret_key' => 'test-secret']);
        [, $announcement, $first] = $this->createSmsDelivery([
            'status' => 'Pending',
            'provider_reference' => 'msg_rate_limit',
            'provider_status' => 'pending',
        ]);
        $second = AnnouncementSmsDelivery::create([
            'announcement_id' => $announcement->id,
            'recipient_type' => 'resident',
            'contact_number' => '639171234568',
            'status' => 'Pending',
            'provider_reference' => 'msg_waiting',
            'provider_status' => 'pending',
        ]);
        Http::fake(['unismsapi.com/api/sms/msg_rate_limit' => Http::response([], 429)]);

        $this->artisan('announcements:sync-sms-status')
            ->expectsOutput('UniSMS status checks: 0 updated; 1 skipped; 0 not yet due; 1 unavailable; 0 missing references; 0 invalid references; 0 locked.')
            ->assertFailed();
        $this->artisan('announcements:sync-sms-status')
            ->expectsOutput('UniSMS status checks: 0 updated; 1 skipped; 1 not yet due; 0 unavailable; 0 missing references; 0 invalid references; 0 locked.')
            ->assertFailed();

        $this->assertDatabaseHas('announcement_sms_deliveries', [
            'id' => $first->id,
            'status' => 'Pending',
            'provider_status' => 'pending',
            'status_check_result' => 'http_error',
            'status_lookup_http_status' => 429,
        ]);
        $this->assertNotNull($first->fresh()->status_check_attempted_at);
        $this->assertNull($second->fresh()->status_check_attempted_at);
        $this->actingAs(User::query()->where('role', 'System Administrator')->firstOrFail())
            ->get(route('announcements.show', $announcement))
            ->assertOk()
            ->assertSee('Pending: 2')
            ->assertDontSee('Latest provider responses');
        Http::assertSentCount(1);
        Http::assertNotSent(fn ($request) => $request->method() !== 'GET');
    }

    #[TestWith([0, 4, 1])]
    #[TestWith([2, 59, 1])]
    public function test_scheduled_pending_checks_follow_cooldown(int $ageInDays, int $waitMinutes, int $additionalMinutes): void
    {
        Http::preventStrayRequests();
        $this->freezeTime();
        config(['services.unisms.secret_key' => 'test-secret']);
        [, , $delivery] = $this->createSmsDelivery([
            'status' => 'Pending',
            'provider_reference' => 'msg_cooldown',
            'provider_status' => 'pending',
        ]);
        $delivery->forceFill(['created_at' => now()->subDays($ageInDays)])->save();
        Http::fake(['unismsapi.com/api/sms/msg_cooldown' => Http::response(['message' => [
            'reference_id' => 'msg_cooldown',
            'status' => 'pending',
        ]])]);

        $this->artisan('announcements:sync-sms-status')->assertSuccessful();
        $this->travel($waitMinutes)->minutes();
        $this->artisan('announcements:sync-sms-status')->assertSuccessful();
        Http::assertSentCount(1);
        $this->travel($additionalMinutes)->minutes();
        $this->artisan('announcements:sync-sms-status')->assertSuccessful();

        $this->assertSame('Pending', $delivery->fresh()->status);
        $this->assertDatabaseCount('announcement_sms_status_checks', 2);
        Http::assertSentCount(2);
        Http::assertNotSent(fn ($request) => $request->method() !== 'GET');
    }

    public function test_scheduled_check_reports_due_missing_and_not_due_records(): void
    {
        $this->travelTo(now()->startOfDay()->addHours(10));
        config(['services.unisms.secret_key' => 'test-secret']);
        [$admin, $announcement, $unknown] = $this->createSmsDelivery([
            'status' => 'Unknown',
            'provider_reference' => 'msg_unknown_due',
        ]);
        $retrying = AnnouncementSmsDelivery::create([
            'announcement_id' => $announcement->id,
            'recipient_type' => 'resident',
            'contact_number' => '639171234568',
            'status' => 'Pending',
            'provider_status' => 'retrying',
            'provider_reference' => 'msg_not_due',
            'status_check_attempted_at' => now()->subMinute(),
        ]);
        DB::table('announcement_sms_status_checks')->insert([
            'announcement_sms_delivery_id' => $retrying->id,
            'checked_at' => now()->subMinute(),
            'result' => 'success',
            'http_status' => 200,
            'provider_status' => 'retrying',
            'provider_reason' => 'Provider is retrying.',
        ]);
        foreach ([null, 'invalid reference'] as $reference) {
            AnnouncementSmsDelivery::create([
                'announcement_id' => $announcement->id,
                'recipient_type' => 'resident',
                'contact_number' => '639171234569',
                'status' => 'Pending',
                'provider_reference' => $reference,
            ]);
        }
        Http::fake(['unismsapi.com/api/sms/msg_unknown_due' => Http::response(['message' => [
            'reference_id' => 'msg_unknown_due',
            'status' => 'failed',
            'fail_reason' => 'Content rejected.',
        ]])]);

        $this->artisan('announcements:sync-sms-status')
            ->expectsOutput('UniSMS status checks: 1 updated; 0 skipped; 1 not yet due; 0 unavailable; 1 missing references; 1 invalid references; 0 locked.')
            ->expectsOutput('Next eligibility for not-yet-due records: '.now()->addMinutes(4)->format('Y-m-d H:i:s T').'.')
            ->assertSuccessful();

        $this->assertSame('Failed', $unknown->fresh()->status);
        $this->assertSame('Pending', $retrying->fresh()->status);
        $this->actingAs($admin)->get(route('announcements.show', $announcement))
            ->assertOk()
            ->assertSee('Retrying: 1')
            ->assertSee('Failed: 1')
            ->assertDontSee('Provider is retrying.')
            ->assertDontSee('Content rejected.');
        $this->assertDatabaseCount('announcement_sms_deliveries', 4);
        Http::assertSentCount(1);
        Http::assertNotSent(fn ($request) => $request->method() !== 'GET');
    }

    public function test_automatic_check_reconciles_unknown_provider_sent_status_when_due(): void
    {
        $this->freezeTime();
        config(['services.unisms.secret_key' => 'test-secret']);
        [, , $delivery] = $this->createSmsDelivery([
            'status' => 'Unknown',
            'provider_reference' => 'msg_sent_recheck',
            'provider_status' => 'sent',
            'status_check_attempted_at' => now()->subMinutes(5),
        ]);
        Http::fake(['unismsapi.com/api/sms/msg_sent_recheck' => Http::response(['message' => [
            'reference_id' => 'msg_sent_recheck',
            'status' => 'failed',
            'fail_reason' => 'Provider rejected the message.',
        ]])]);

        $this->artisan('announcements:sync-sms-status')
            ->expectsOutput('UniSMS status checks: 1 updated; 0 skipped; 0 not yet due; 0 unavailable; 0 missing references; 0 invalid references; 0 locked.')
            ->assertSuccessful();

        $this->assertSame('Failed', $delivery->fresh()->status);
        Http::assertSentCount(1);
        Http::assertNotSent(fn ($request) => $request->method() !== 'GET');
    }

    public function test_scheduled_check_counts_records_deferred_by_batch_limit(): void
    {
        $this->freezeTime();
        config(['services.unisms.secret_key' => 'test-secret']);
        [, $announcement] = $this->createSmsDelivery([
            'status' => 'Pending',
            'provider_reference' => 'msg_batch_0',
        ]);
        foreach (range(1, 25) as $index) {
            AnnouncementSmsDelivery::create([
                'announcement_id' => $announcement->id,
                'recipient_type' => 'resident',
                'contact_number' => '639171234567',
                'status' => 'Pending',
                'provider_reference' => 'msg_batch_'.$index,
            ]);
        }
        Http::fake(['unismsapi.com/api/sms/*' => function ($request) {
            $reference = basename($request->url());

            return Http::response(['message' => ['reference_id' => $reference, 'status' => 'pending']]);
        }]);

        $this->artisan('announcements:sync-sms-status')
            ->expectsOutput('UniSMS status checks: 25 updated; 1 skipped; 0 not yet due; 0 unavailable; 0 missing references; 0 invalid references; 0 locked.')
            ->assertSuccessful();

        $this->assertDatabaseCount('announcement_sms_deliveries', 26);
        $this->assertDatabaseCount('announcement_sms_status_checks', 25);
        Http::assertSentCount(25);
        Http::assertNotSent(fn ($request) => $request->method() !== 'GET');
    }

    public function test_guarded_concurrent_status_change_is_counted_as_skipped(): void
    {
        config(['services.unisms.secret_key' => 'test-secret']);
        [, , $delivery] = $this->createSmsDelivery([
            'status' => 'Pending',
            'provider_reference' => 'msg_race',
            'provider_status' => 'pending',
        ]);
        Http::fake(['unismsapi.com/api/sms/msg_race' => function () use ($delivery) {
            $delivery->update(['status' => 'Failed', 'provider_status' => 'failed', 'failure_reason' => 'Newer failure']);

            return Http::response(['message' => ['reference_id' => 'msg_race', 'status' => 'retrying']]);
        }]);

        $this->artisan('announcements:sync-sms-status')
            ->expectsOutput('UniSMS status checks: 0 updated; 1 skipped; 0 not yet due; 0 unavailable; 0 missing references; 0 invalid references; 0 locked.')
            ->assertSuccessful();

        $this->assertSame('Failed', $delivery->fresh()->status);
        $this->assertSame('Newer failure', $delivery->fresh()->failure_reason);
        $this->assertDatabaseHas('announcement_sms_status_checks', [
            'announcement_sms_delivery_id' => $delivery->id,
            'result' => 'skipped',
            'provider_status' => 'retrying',
        ]);
        Http::assertSentCount(1);
        Http::assertNotSent(fn ($request) => $request->method() !== 'GET');
    }

    public function test_concurrent_sent_update_is_not_overwritten_by_stale_failed_lookup(): void
    {
        config(['services.unisms.secret_key' => 'test-secret']);
        [, , $delivery] = $this->createSmsDelivery([
            'status' => 'Pending',
            'provider_reference' => 'msg_sent_race',
            'provider_status' => 'pending',
        ]);
        Http::fake(['unismsapi.com/api/sms/msg_sent_race' => function () use ($delivery) {
            AnnouncementSmsDelivery::whereKey($delivery->id)->update([
                'status' => 'Unknown',
                'provider_status' => 'sent',
                'status_checked_at' => now(),
            ]);

            return Http::response(['message' => ['reference_id' => 'msg_sent_race', 'status' => 'failed']]);
        }]);

        $this->artisan('announcements:sync-sms-status')
            ->expectsOutput('UniSMS status checks: 0 updated; 1 skipped; 0 not yet due; 0 unavailable; 0 missing references; 0 invalid references; 0 locked.')
            ->assertSuccessful();

        $this->assertSame('Unknown', $delivery->fresh()->status);
        $this->assertSame('sent', $delivery->fresh()->provider_status);
        Http::assertSentCount(1);
        Http::assertNotSent(fn ($request) => $request->method() !== 'GET');
    }

    public function test_next_check_respects_the_transition_to_the_hourly_interval(): void
    {
        $this->travelTo(now()->startOfDay()->addHours(10));
        config(['services.unisms.secret_key' => 'test-secret']);
        [, , $delivery] = $this->createSmsDelivery([
            'status' => 'Pending',
            'provider_reference' => 'msg_age_boundary',
            'status_check_attempted_at' => now()->subMinute(),
        ]);
        $delivery->forceFill(['created_at' => now()->subDay()->addMinute()])->save();
        Http::fake(['unismsapi.com/api/sms/msg_age_boundary' => Http::response(['message' => [
            'reference_id' => 'msg_age_boundary',
            'status' => 'pending',
        ]])]);

        $this->artisan('announcements:sync-sms-status')
            ->expectsOutput('Next eligibility for not-yet-due records: '.now()->addMinutes(59)->format('Y-m-d H:i:s T').'.')
            ->assertSuccessful();
        Http::assertNothingSent();
        $this->travel(59)->minutes();
        $this->artisan('announcements:sync-sms-status')->assertSuccessful();
        Http::assertSentCount(1);
        Http::assertNotSent(fn ($request) => $request->method() !== 'GET');
    }

    public function test_provider_error_details_are_sanitized_without_logging_or_displaying_secrets(): void
    {
        Log::spy();
        config(['services.unisms.secret_key' => 'test-secret', 'services.unisms.sender_id' => 'TEST-SENDER', 'services.unisms.webhook_secret' => 'webhook-private']);
        [$admin, $announcement, $delivery] = $this->createSmsDelivery([
            'status' => 'Pending',
            'provider_reference' => 'msg_error_details',
        ]);
        $authorization = base64_encode('test-secret:');
        Http::fake(['unismsapi.com/api/sms/msg_error_details' => Http::response([
            'code' => 'RATE_LIMITED',
            'error' => "Blocked test-secret webhook-private Basic {$authorization} +639171234567 Private announcement TEST-SENDER",
            'message' => ['content' => 'Private announcement', 'recipient' => '+639171234567'],
        ], 429)]);

        $this->artisan('announcements:sync-sms-status')
            ->expectsOutput('UniSMS status checks: 0 updated; 0 skipped; 0 not yet due; 1 unavailable; 0 missing references; 0 invalid references; 0 locked.')
            ->assertFailed();

        $reason = DB::table('announcement_sms_status_checks')->where('announcement_sms_delivery_id', $delivery->id)->value('provider_reason');
        $this->assertStringContainsString('Provider code: RATE_LIMITED', $reason);
        foreach (['test-secret', 'webhook-private', $authorization, '+639171234567', 'Private announcement', 'TEST-SENDER'] as $secret) {
            $this->assertStringNotContainsString($secret, $reason);
        }
        $this->actingAs($admin)->get(route('announcements.show', $announcement))
            ->assertOk()
            ->assertDontSee('Provider code: RATE_LIMITED')
            ->assertDontSee('test-secret')
            ->assertDontSee($authorization)
            ->assertDontSee('Private announcement');
        Log::shouldHaveReceived('warning')->with('UniSMS status lookup failed.', [
            'delivery_id' => $delivery->id,
            'http_status' => 429,
        ])->once();
        Http::assertSentCount(1);
        Http::assertNotSent(fn ($request) => $request->method() !== 'GET');
    }

    #[TestWith(['delivered'])]
    #[TestWith(['Reverted'])]
    public function test_undocumented_provider_status_does_not_confirm_delivery(string $status): void
    {
        config(['services.unisms.secret_key' => 'test-secret']);
        [, , $delivery] = $this->createSmsDelivery([
            'status' => 'Pending',
            'provider_reference' => 'msg_unsupported',
        ]);
        Http::fake(['unismsapi.com/api/sms/msg_unsupported' => Http::response(['message' => [
            'reference_id' => 'msg_unsupported',
            'status' => $status,
            'fail_reason' => 'Provider detail: test-secret',
        ]])]);

        $this->artisan('announcements:sync-sms-status')->assertFailed();
        $this->assertSame('Pending', $delivery->fresh()->status);
        $this->assertSame('invalid_response', $delivery->fresh()->status_check_result);
        $this->assertDatabaseHas('announcement_sms_status_checks', [
            'announcement_sms_delivery_id' => $delivery->id,
            'result' => 'invalid_response',
            'provider_reason' => 'Provider detail: [redacted]',
        ]);
        Http::assertSentCount(1);
        Http::assertNotSent(fn ($request) => $request->method() !== 'GET');
    }

    public function test_rejected_sms_can_be_prepared_once_for_retry_without_sending(): void
    {
        Http::preventStrayRequests();
        config([
            'services.unisms.enabled' => true,
            'services.unisms.secret_key' => 'test-secret',
            'services.unisms.sender_id' => 'TEST',
        ]);
        [$admin, $announcement, $delivery] = $this->createSmsDelivery([
            'status' => 'Failed',
            'attempt_started_at' => now(),
            'provider_http_status' => 422,
            'failure_reason' => 'UniSMS rejected the request.',
        ]);

        $this->actingAs($admin)->post(route('announcements.sms.prepare-retry', [$announcement, $delivery->id]))
            ->assertSessionHas('success', 'The rejected SMS is prepared for retry. No SMS was sent; use the send button to confirm submission.');
        $this->actingAs($admin)->post(route('announcements.sms.prepare-retry', [$announcement, $delivery->id]))
            ->assertSessionHas('warning');

        $this->assertDatabaseHas('announcement_sms_deliveries', [
            'id' => $delivery->id,
            'status' => 'Prepared',
            'provider_http_status' => null,
            'attempt_started_at' => null,
        ]);
        $this->assertDatabaseHas('announcement_sms_retry_history', [
            'announcement_sms_delivery_id' => $delivery->id,
            'requested_by' => $admin->id,
            'provider_http_status' => 422,
            'failure_reason' => 'UniSMS rejected the request.',
        ]);
        $this->assertDatabaseCount('announcement_sms_retry_history', 1);
        Http::assertNothingSent();

        Http::fake(['unismsapi.com/api/sms' => Http::response(['message' => [
            'reference_id' => 'msg_safe_retry',
            'status' => 'pending',
        ]], 201)]);
        $this->actingAs($admin)->post(route('announcements.sms.send', $announcement))->assertRedirect();
        $this->actingAs($admin)->post(route('announcements.sms.send', $announcement))->assertRedirect();

        $this->assertDatabaseHas('announcement_sms_deliveries', [
            'id' => $delivery->id,
            'status' => 'Pending',
            'provider_reference' => 'msg_safe_retry',
        ]);
        $this->assertDatabaseCount('announcement_sms_retry_history', 1);
        Http::assertSentCount(1);
    }

    #[TestWith(['Pending', 201, 'msg_pending'])]
    #[TestWith(['Unknown', null, null])]
    #[TestWith(['Failed', 422, 'msg_accepted'])]
    #[TestWith(['Failed', 503, null])]
    public function test_accepted_or_uncertain_sms_cannot_be_prepared_for_retry(string $status, ?int $httpStatus, ?string $reference): void
    {
        Http::preventStrayRequests();
        [$admin, $announcement, $delivery] = $this->createSmsDelivery([
            'status' => $status,
            'attempt_started_at' => now(),
            'provider_http_status' => $httpStatus,
            'provider_reference' => $reference,
        ]);

        $this->actingAs($admin)->post(route('announcements.sms.prepare-retry', [$announcement, $delivery->id]))
            ->assertSessionHas('warning');

        $this->assertSame($status, $delivery->fresh()->status);
        $this->assertDatabaseCount('announcement_sms_retry_history', 0);
        Http::assertNothingSent();
    }

    public function test_retry_requires_authorization_and_delivery_belonging_to_announcement(): void
    {
        Http::preventStrayRequests();
        [$admin, $announcement, $delivery] = $this->createSmsDelivery([
            'status' => 'Failed',
            'attempt_started_at' => now(),
            'provider_http_status' => 422,
        ]);
        [, $otherAnnouncement] = $this->createSmsDelivery();
        $resident = User::factory()->create(['role' => 'Resident', 'status' => 'active']);

        $this->post(route('announcements.sms.prepare-retry', [$announcement, $delivery->id]))->assertRedirect(route('login'));
        $this->actingAs($resident)->post(route('announcements.sms.prepare-retry', [$announcement, $delivery->id]))->assertForbidden();
        $this->actingAs($admin)->post(route('announcements.sms.prepare-retry', [$otherAnnouncement, $delivery->id]))->assertNotFound();

        $this->assertSame('Failed', $delivery->fresh()->status);
        $this->assertDatabaseCount('announcement_sms_retry_history', 0);
        Http::assertNothingSent();
    }

    public function test_existing_delivered_status_is_not_overwritten_by_provider_webhook(): void
    {
        config(['services.unisms.webhook_secret' => 'webhook-secret']);
        [, , $delivery] = $this->createSmsDelivery([
            'status' => 'Delivered',
            'provider_reference' => 'msg_delivered_before',
        ]);

        $this->withHeader('webhook-secret-key', 'webhook-secret')
            ->postJson(route('announcements.sms.webhook'), [
                'id' => 'msg_delivered_before',
                'event' => 'message.retrying',
                'message' => [
                    'reference_id' => 'msg_delivered_before',
                    'status' => 'retrying',
                ],
            ])->assertOk();

        $this->assertSame('Delivered', $delivery->fresh()->status);
    }

    public function test_missing_provider_reference_is_reported_without_request_or_status_change(): void
    {
        Http::preventStrayRequests();
        [$admin, $announcement, $delivery] = $this->createSmsDelivery([
            'status' => 'Pending',
            'provider_reference' => null,
            'attempt_started_at' => now(),
        ]);

        $this->actingAs($admin)->post(route('announcements.sms.refresh', $announcement))
            ->assertSessionHas('warning', 'UniSMS status checks: 0 updated; 0 skipped; 0 not yet due; 0 unavailable; 1 missing references; 0 invalid references.');

        $this->assertSame('Pending', $delivery->fresh()->status);
        Http::assertNothingSent();
    }

    public function test_concurrent_status_check_is_rejected_without_provider_requests(): void
    {
        Http::preventStrayRequests();
        [$admin, $announcement] = $this->createSmsDelivery(['status' => 'Pending', 'provider_reference' => 'msg_locked']);
        $lock = Cache::lock('announcement-sms-status-'.$announcement->id, 60);
        $this->assertTrue($lock->get());

        try {
            $this->actingAs($admin)->post(route('announcements.sms.refresh', $announcement))
                ->assertSessionHas('warning', 'A UniSMS status check is already in progress for this announcement.');
            Http::assertNothingSent();
        } finally {
            $lock->release();
        }
    }

    public function test_scheduled_check_counts_a_locked_delivery_as_skipped(): void
    {
        [, $announcement] = $this->createSmsDelivery(['status' => 'Pending', 'provider_reference' => 'msg_locked_command']);
        $lock = Cache::lock('announcement-sms-status-'.$announcement->id, 60);
        $this->assertTrue($lock->get());

        try {
            $this->artisan('announcements:sync-sms-status')
                ->expectsOutput('UniSMS status checks: 0 updated; 1 skipped; 0 not yet due; 0 unavailable; 0 missing references; 0 invalid references; 1 locked.')
                ->assertSuccessful();
            Http::assertNothingSent();
        } finally {
            $lock->release();
        }
    }

    public function test_unauthorized_users_cannot_check_status(): void
    {
        Http::preventStrayRequests();
        [, $announcement, $delivery] = $this->createSmsDelivery(['status' => 'Pending', 'provider_reference' => 'msg_auth']);

        $this->post(route('announcements.sms.refresh', $announcement))->assertRedirect(route('login'));
        $user = User::factory()->create(['role' => 'Resident', 'status' => 'active']);
        $this->actingAs($user)->post(route('announcements.sms.refresh', $announcement))->assertForbidden();

        $this->assertSame('Pending', $delivery->fresh()->status);
        Http::assertNothingSent();
    }

    public function test_late_retry_webhook_does_not_replace_provider_sent_status(): void
    {
        config(['services.unisms.webhook_secret' => 'webhook-secret']);
        [, , $delivery] = $this->createSmsDelivery([
            'status' => 'Pending',
            'provider_reference' => 'msg_order_test',
            'provider_status' => 'pending',
            'attempt_started_at' => now(),
        ]);
        $payload = [
            'id' => 'msg_order_test',
            'event' => 'message.sent',
            'message' => ['reference_id' => 'msg_order_test', 'status' => 'sent'],
        ];

        $this->withHeader('webhook-secret-key', 'webhook-secret')
            ->postJson(route('announcements.sms.webhook'), $payload)->assertOk();
        $payload['event'] = 'message.retrying';
        $payload['message']['status'] = 'retrying';
        $this->withHeader('webhook-secret-key', 'webhook-secret')
            ->postJson(route('announcements.sms.webhook'), $payload)->assertOk();

        $this->assertSame('Unknown', $delivery->fresh()->status);
        $this->assertSame('sent', $delivery->fresh()->provider_status);
    }

    public function test_tracking_migration_preserves_existing_deliveries_without_assuming_delivery(): void
    {
        Schema::drop('announcement_sms_deliveries');
        $original = require database_path('migrations/2026_10_05_094300_create_announcement_sms_deliveries_table.php');
        $directRecipients = require database_path('migrations/2026_11_23_100849_add_direct_recipient_support_to_announcement_sms_deliveries_table.php');
        $original->up();
        $directRecipients->up();
        [, , $sent] = $this->createSmsDelivery(['status' => 'Sent', 'sent_at' => now()]);
        [, , $pending] = $this->createSmsDelivery(['status' => 'Pending']);
        [, , $uncertain] = $this->createSmsDelivery([
            'status' => 'Failed',
            'failure_reason' => 'Provider acceptance is uncertain.',
        ]);

        $migration = require database_path('migrations/2026_11_23_120401_add_provider_tracking_to_announcement_sms_deliveries_table.php');
        $migration->up();

        $this->assertDatabaseHas('announcement_sms_deliveries', ['id' => $sent->id, 'status' => 'Unknown']);
        $this->assertNotNull($sent->fresh()->sent_at);
        $this->assertDatabaseHas('announcement_sms_deliveries', ['id' => $pending->id, 'status' => 'Prepared']);
        $this->assertDatabaseHas('announcement_sms_deliveries', ['id' => $uncertain->id, 'status' => 'Unknown']);
    }

    /**
     * @return array{User, Announcement, AnnouncementSmsDelivery}
     */
    private function createSmsDelivery(array $attributes = []): array
    {
        $admin = User::factory()->create(['role' => 'System Administrator', 'status' => 'active']);
        $announcement = Announcement::create([
            'title' => 'Clinic notice',
            'message' => 'Please visit the clinic.',
            'target_type' => 'specific',
            'priority' => 'Normal',
            'status' => 'Published',
            'published_at' => now(),
            'created_by' => $admin->id,
        ]);
        $delivery = AnnouncementSmsDelivery::create(array_merge([
            'announcement_id' => $announcement->id,
            'recipient_type' => 'resident',
            'contact_number' => '639171234567',
            'status' => 'Prepared',
        ], $attributes));

        return [$admin, $announcement, $delivery];
    }
}
