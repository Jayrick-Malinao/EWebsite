<?php

namespace Tests\Feature;

use App\Models\Announcement;
use App\Models\AnnouncementSmsDelivery;
use App\Models\Household;
use App\Models\Resident;
use App\Models\SeniorCitizen;
use App\Models\SystemSetting;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PhilippineMobileNumberBackfillTest extends TestCase
{
    use RefreshDatabase;

    public function test_existing_valid_mobile_numbers_are_normalized_across_contact_fields(): void
    {
        $admin = User::factory()->create([
            'role' => 'System Administrator',
            'status' => 'active',
        ]);

        $household = Household::create([
            'household_code' => 'TEST-HH-0001',
            'household_head_name' => 'Test Household Head',
            'address' => 'Test Address',
            'contact_number' => '09187113445',
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
            'contact_number' => '09171234567',
            'household_address' => 'Test Address',
            'status' => 'Active',
        ]);

        $seniorCitizen = SeniorCitizen::create([
            'resident_id' => $resident->id,
            'caregiver_contact' => '0063 917 123 4567',
        ]);

        $announcement = Announcement::create([
            'title' => 'Normalization test',
            'message' => 'Test message.',
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
            'contact_number' => '09171234567',
            'status' => 'Failed',
        ]);

        $setting = SystemSetting::create([
            'key' => 'contact_number',
            'value' => '09171234567',
        ]);

        $migration = require database_path(
            'migrations/2026_10_27_103321_normalize_philippine_mobile_numbers_to_international_format.php'
        );
        $migration->up();

        $this->assertDatabaseHas('households', [
            'id' => $household->id,
            'contact_number' => '639187113445',
        ]);

        $this->assertDatabaseHas('residents', [
            'id' => $resident->id,
            'contact_number' => '639171234567',
        ]);

        $this->assertDatabaseHas('senior_citizens', [
            'id' => $seniorCitizen->id,
            'caregiver_contact' => '639171234567',
        ]);

        $this->assertDatabaseHas('announcement_sms_deliveries', [
            'id' => $delivery->id,
            'contact_number' => '639171234567',
        ]);

        $this->assertDatabaseHas('system_settings', [
            'id' => $setting->id,
            'value' => '639171234567',
        ]);
    }
}
