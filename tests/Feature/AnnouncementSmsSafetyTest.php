<?php

namespace Tests\Feature;

use App\Models\Announcement;
use App\Models\AnnouncementSmsDelivery;
use App\Models\Household;
use App\Models\Resident;
use App\Models\User;
use App\Services\UniSmsService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Http;
use Mockery\MockInterface;
use Tests\TestCase;

class AnnouncementSmsSafetyTest extends TestCase
{
    use RefreshDatabase;

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
            ->assertSee('SMS delivery');
    }

    public function test_announcement_details_show_sanitized_sms_failure_reason(): void
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
            ->assertSee('Failed delivery details')
            ->assertSee('UniSMS did not accept the request (HTTP 401): Unauthorized.')
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
            'status' => 'Pending',
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
            'failure_reason' => 'No contact number is recorded for this household head.',
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
            'status' => 'Pending',
        ]);

        $response = $this->actingAs($admin)->post(
            route('announcements.sms.send', $announcement)
        );

        $response->assertRedirect(route('announcements.show', $announcement));

        $this->assertDatabaseHas('announcement_sms_deliveries', [
            'id' => $delivery->id,
            'status' => 'Failed',
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
            'There are no pending SMS messages for this announcement.'
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
}
