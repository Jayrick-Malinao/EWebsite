<?php

namespace Tests\Feature;

use App\Models\Announcement;
use App\Models\AnnouncementSmsDelivery;
use App\Models\Household;
use App\Models\Resident;
use App\Models\User;
use App\Services\PhilSmsService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Mockery\MockInterface;
use Tests\TestCase;

class AnnouncementSmsSafetyTest extends TestCase
{
    use RefreshDatabase;

    public function test_pending_sms_without_contact_number_is_failed_without_calling_sms_service(): void
    {
        // Enable the controller's processing path only for this test.
        // This does not change the .env file or enable real SMS sending.
        config([
            'services.philsms.enabled' => true,
            'services.philsms.api_token' => 'test-api-token',
            'services.philsms.sender_id' => 'EWebsite',
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
            PhilSmsService::class,
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
            'failure_reason' =>
                'No contact number is recorded for this household head.',
        ]);
    }
}