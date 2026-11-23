<?php

namespace Tests\Feature;

use App\Models\Announcement;
use App\Models\AnnouncementSmsDelivery;
use App\Models\Household;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class HouseholdResidentWorkflowTest extends TestCase
{
    use RefreshDatabase;

    public function test_deleting_a_household_removes_its_sms_deliveries_before_its_residents(): void
    {
        $this->actingAs($this->administrator());
        $household = $this->householdWithHead();
        $head = $household->residents()->firstOrFail();
        $announcement = $this->announcement();
        $delivery = $this->smsDelivery($announcement, $household, $head->id);
        $otherHousehold = Household::create([
            'household_code' => 'HH-000002',
            'household_head_name' => 'Other Head',
            'address' => 'Purok 2, Esperanza, Pilar, Sorsogon',
            'status' => 'Active',
        ]);
        $otherHead = $otherHousehold->residents()->create([
            'first_name' => 'Other',
            'last_name' => 'Head',
            'birth_date' => '1980-01-01',
            'gender' => 'Female',
            'status' => 'Active',
        ]);
        $otherDelivery = $this->smsDelivery($announcement, $otherHousehold, $otherHead->id);

        $this->delete(route('households.destroy', $household))
            ->assertRedirect(route('households.index'))
            ->assertSessionHas('success', 'Household deleted successfully.');

        $this->assertModelMissing($household);
        $this->assertModelMissing($head);
        $this->assertModelMissing($delivery);
        $this->assertModelExists($announcement);
        $this->assertModelExists($otherHousehold);
        $this->assertModelExists($otherDelivery);
    }

    public function test_household_deletion_preserves_deliveries_for_other_households(): void
    {
        $this->actingAs($this->administrator());
        $household = $this->householdWithHead();
        $head = $household->residents()->firstOrFail();
        $announcement = $this->announcement();
        $ownDelivery = $this->smsDelivery($announcement, $household, $head->id);
        $otherHousehold = Household::create([
            'household_code' => 'HH-000002',
            'household_head_name' => 'Other Head',
            'address' => 'Purok 2, Esperanza, Pilar, Sorsogon',
            'status' => 'Active',
        ]);
        $otherDelivery = $this->smsDelivery($announcement, $otherHousehold, $head->id);

        $this->delete(route('households.destroy', $household))
            ->assertRedirect(route('households.index'))
            ->assertSessionHas('error', 'This household cannot be deleted because one of its residents is referenced by an SMS delivery for another household.');

        $this->assertModelExists($household);
        $this->assertModelExists($head);
        $this->assertModelExists($ownDelivery);
        $this->assertModelExists($otherDelivery);

        $this->get(route('households.index'))
            ->assertOk()
            ->assertSee('This household cannot be deleted because one of its residents is referenced by an SMS delivery for another household.');
    }

    public function test_resident_edit_pairs_birthdate_with_a_read_only_age(): void
    {
        $this->actingAs($this->administrator());
        $household = $this->householdWithHead();
        $resident = $household->residents()->firstOrFail();

        $response = $this->withSession(['_old_input' => ['birth_date' => '2000-03-10']])
            ->get(route('residents.edit', $resident))
            ->assertOk();

        $xpath = $this->htmlXPath($response->getContent());
        $this->assertBirthDateAgePair($xpath, "//input[@name='birth_date']", '2000-03-10');
    }

    public function test_household_edit_pairs_each_birthdate_with_its_own_read_only_age(): void
    {
        $this->actingAs($this->administrator());
        $household = $this->householdWithHead();
        $member = $household->residents()->create([
            'is_household_head' => false,
            'relationship_to_head' => 'Daughter',
            'first_name' => 'Maria',
            'last_name' => 'Nguyen',
            'birth_date' => '2010-06-15',
            'gender' => 'Female',
            'status' => 'Active',
        ]);

        $response = $this->withSession(['_old_input' => [
            'household_head' => ['birth_date' => '1981-05-10'],
            'members' => [['id' => $member->id, 'birth_date' => '2011-06-15']],
        ]])->get(route('households.edit', $household))->assertOk();

        $xpath = $this->htmlXPath($response->getContent());
        $this->assertBirthDateAgePair($xpath, "//input[@name='household_head[birth_date]']", '1981-05-10');
        $this->assertBirthDateAgePair($xpath, "//input[@name='members[0][birth_date]']", '2011-06-15');
        $this->assertBirthDateAgePair($xpath, "//template[@id='member-template']//input[@data-field='birth_date']", '');
    }

    public function test_household_edit_retains_submitted_member_data_after_validation_failure(): void
    {
        $this->actingAs($this->administrator());
        $household = $this->householdWithHead();
        $removed = $household->residents()->create([
            'first_name' => 'Removed',
            'last_name' => 'Member',
            'birth_date' => '2010-01-01',
            'gender' => 'Female',
            'status' => 'Active',
        ]);
        $retained = $household->residents()->create([
            'first_name' => 'Retained',
            'last_name' => 'Member',
            'birth_date' => '2011-01-01',
            'gender' => 'Female',
            'household_address' => 'Purok 5, Esperanza, Pilar, Sorsogon',
            'status' => 'Active',
        ]);

        $response = $this->withSession(['_old_input' => [
            'members' => [
                1 => ['id' => $retained->id, 'first_name' => 'Edited', 'status' => 'Inactive'],
                2 => ['first_name' => 'New Member', 'purok' => 'Purok 6', 'status' => 'Inactive'],
            ],
        ]])->get(route('households.edit', $household))->assertOk();

        $xpath = $this->htmlXPath($response->getContent());
        $this->assertSame(0, $xpath->query("//input[@name='members[0][id]']")->length);
        $this->assertSame('Edited', $xpath->query("//input[@name='members[1][first_name]']")->item(0)->getAttribute('value'));
        $this->assertSame(1, $xpath->query("//select[@name='members[1][status]']/option[@value='Inactive' and @selected]")->length);
        $this->assertSame(1, $xpath->query("//select[@name='members[1][purok]']/option[@value='Purok 5' and @selected]")->length);
        $response->assertSee('New Member');
        $this->assertModelExists($removed);
    }

    public function test_household_list_shows_each_households_resident_count(): void
    {
        $this->actingAs($this->administrator());
        $household = $this->householdWithHead();
        $household->residents()->create([
            'is_household_head' => false,
            'relationship_to_head' => 'Daughter',
            'first_name' => 'Maria',
            'last_name' => 'Nguyen',
            'birth_date' => '2010-06-15',
            'gender' => 'Female',
            'household_address' => $household->address,
            'civil_status' => 'Single',
            'status' => 'Active',
        ]);
        Household::create([
            'household_code' => 'HH-000002',
            'household_head_name' => 'Empty Household',
            'address' => 'Purok 2, Esperanza, Pilar, Sorsogon',
            'status' => 'Active',
        ]);

        $response = $this->get(route('households.index'))->assertOk();

        $document = new \DOMDocument;
        $document->loadHTML($response->getContent(), LIBXML_NOERROR | LIBXML_NOWARNING);
        $xpath = new \DOMXPath($document);

        foreach (['HH-000001' => '2', 'HH-000002' => '0'] as $code => $count) {
            $tableCount = $xpath->query("//tbody/tr[td[1]//p[normalize-space()='$code']]/td[5]");
            $mobileCount = $xpath->query("//article[.//p[normalize-space()='$code']]//div[p[normalize-space()='Members']]/p[2]");

            $this->assertSame(1, $tableCount->length);
            $this->assertSame($count, trim($tableCount->item(0)->textContent));
            $this->assertSame(1, $mobileCount->length);
            $this->assertSame($count, trim($mobileCount->item(0)->textContent));
        }
    }

    public function test_household_edit_splits_head_name_and_saves_the_full_name_to_existing_column(): void
    {
        $this->actingAs($this->administrator());
        $household = $this->householdWithHead();

        $this->get(route('households.edit', $household))
            ->assertOk()
            ->assertSee('name="household_head[first_name]"', false)
            ->assertSee('name="household_head[middle_name]"', false)
            ->assertSee('name="household_head[last_name]"', false)
            ->assertDontSee('name="household_head_name"', false);

        $head = $household->residents()->where('is_household_head', true)->firstOrFail();

        $this->put(route('households.update', $household), [
            'household_code' => $household->household_code,
            'purok' => 'Purok 2',
            'contact_number' => '',
            'status' => 'Active',
            'household_head' => [
                'id' => $head->id,
                'first_name' => 'Alicia',
                'middle_name' => 'Mae',
                'last_name' => 'Nguyen',
                'suffix' => '',
                'birth_date' => '1980-05-10',
                'gender' => 'Female',
                'contact_number' => '09171234567',
                'email' => '',
                'civil_status' => 'Married',
                'philhealth_number' => '',
            ],
            'members' => [],
        ])->assertRedirect(route('households.show', $household));

        $this->assertDatabaseHas('households', [
            'id' => $household->id,
            'household_head_name' => 'Alicia Mae Nguyen',
        ]);
        $this->assertDatabaseHas('residents', [
            'id' => $head->id,
            'first_name' => 'Alicia',
            'middle_name' => 'Mae',
            'last_name' => 'Nguyen',
        ]);
    }

    public function test_household_head_and_family_details_can_be_expanded_in_one_container(): void
    {
        $this->actingAs($this->administrator());
        $household = $this->householdWithHead();
        $household->residents()->create([
            'is_household_head' => false,
            'relationship_to_head' => 'Daughter',
            'first_name' => 'Maria',
            'middle_name' => null,
            'last_name' => 'Nguyen',
            'birth_date' => '2010-06-15',
            'gender' => 'Female',
            'household_address' => $household->address,
            'civil_status' => 'Single',
            'status' => 'Active',
        ]);

        $response = $this->get(route('households.show', $household))
            ->assertOk()
            ->assertSee('Household Head')
            ->assertSee('Family Members')
            ->assertSee('Alicia Nguyen')
            ->assertSee('Maria Nguyen')
            ->assertSee('<details', false);

        $this->assertSame(2, substr_count($response->getContent(), '<details'));
    }

    public function test_resident_create_can_search_households_and_defaults_to_family_member(): void
    {
        $this->actingAs($this->administrator());
        $household = $this->householdWithHead();

        $response = $this->get(route('residents.create'))
            ->assertOk()
            ->assertSee('id="household_search"', false)
            ->assertSee('list="household-options"', false)
            ->assertSee('id="household-options"', false)
            ->assertSee('data-household-id="'.$household->id.'"', false)
            ->assertSee('name="household_id"', false)
            ->assertSee('Family Member');

        $this->assertCancelLinkReturnsToIndex($response->getContent());

        $this->assertSame(
            1,
            preg_match(
                '/<option\b(?=[^>]*value="0")(?=[^>]*selected)[^>]*>\s*Family Member/s',
                $response->getContent(),
            ),
        );

        $this->post(route('residents.store'), [
            'household_id' => $household->id,
            'is_household_head' => '0',
            'relationship_to_head' => 'Daughter',
            'first_name' => 'Maria',
            'last_name' => 'Nguyen',
            'birth_date' => '2010-06-15',
            'gender' => 'Female',
            'purok' => 'Purok 2',
            'civil_status' => 'Single',
            'status' => 'Active',
        ])->assertRedirect(route('residents.index'));

        $this->assertDatabaseHas('residents', [
            'household_id' => $household->id,
            'first_name' => 'Maria',
            'is_household_head' => false,
            'relationship_to_head' => 'Daughter',
            'contact_number' => '639171234567',
        ]);
    }

    public function test_updating_the_head_synchronizes_only_their_household_contacts(): void
    {
        $this->actingAs($this->administrator());
        $household = $this->householdWithHead();
        $head = $household->residents()->where('is_household_head', true)->firstOrFail();
        $delivery = $this->smsDelivery($this->announcement(), $household, $head->id);
        $member = $household->residents()->create([
            'is_household_head' => false,
            'first_name' => 'Maria',
            'last_name' => 'Nguyen',
            'birth_date' => '2010-06-15',
            'gender' => 'Female',
            'contact_number' => '639171111111',
            'status' => 'Active',
        ]);
        $other = Household::create([
            'household_code' => 'HH-OTHER',
            'household_head_name' => 'Other Head',
            'address' => 'Purok 2',
            'contact_number' => '639172222222',
            'status' => 'Active',
        ]);
        $otherHead = $other->residents()->create([
            'is_household_head' => true,
            'first_name' => 'Other',
            'last_name' => 'Head',
            'birth_date' => '1980-01-01',
            'gender' => 'Female',
            'contact_number' => '639172222222',
            'status' => 'Active',
        ]);

        $this->put(route('residents.update', $head), [
            'is_household_head' => '1',
            'first_name' => 'Alicia',
            'last_name' => 'Nguyen',
            'birth_date' => '1980-05-10',
            'gender' => 'Female',
            'contact_number' => '09173334444',
            'purok' => 'Purok 2',
            'civil_status' => 'Married',
            'status' => 'Active',
        ])->assertRedirect(route('residents.index'));

        $this->assertSame('639173334444', $head->fresh()->contact_number);
        $this->assertSame($household->id, $head->fresh()->household_id);
        $this->assertSame('639173334444', $member->fresh()->contact_number);
        $this->assertSame('639173334444', $household->fresh()->contact_number);
        $this->assertSame('639172222222', $otherHead->fresh()->contact_number);
        $this->assertSame('09123456789', $delivery->fresh()->contact_number);
    }

    public function test_household_head_contact_is_required_and_invalid_updates_do_not_change_members(): void
    {
        $this->actingAs($this->administrator());
        $household = $this->householdWithHead();
        $head = $household->residents()->where('is_household_head', true)->firstOrFail();

        foreach (['', '123'] as $number) {
            $this->put(route('residents.update', $head), [
                'household_id' => $household->id,
                'is_household_head' => '1',
                'first_name' => 'Alicia',
                'last_name' => 'Nguyen',
                'birth_date' => '1980-05-10',
                'gender' => 'Female',
                'contact_number' => $number,
                'purok' => 'Purok 2',
                'civil_status' => 'Married',
                'status' => 'Active',
            ])->assertSessionHasErrors('contact_number');
        }

        $this->assertSame('639171234567', $head->fresh()->contact_number);
    }

    public function test_resident_list_does_not_show_the_add_resident_button(): void
    {
        $this->actingAs($this->administrator());
        $this->householdWithHead();

        $this->get(route('residents.index'))
            ->assertOk()
            ->assertSee('Alicia Nguyen')
            ->assertDontSee('Add Resident');
    }

    public function test_resident_list_shows_each_residents_saved_purok(): void
    {
        $this->actingAs($this->administrator());
        $household = $this->householdWithHead();
        $household->residents()->create([
            'is_household_head' => false,
            'relationship_to_head' => 'Daughter',
            'first_name' => 'Maria',
            'last_name' => 'Nguyen',
            'birth_date' => '2010-06-15',
            'gender' => 'Female',
            'household_address' => '45 Mabini Street, Purok 5, Esperanza, Pilar, Sorsogon',
            'civil_status' => 'Single',
            'status' => 'Active',
        ]);
        $household->residents()->create([
            'is_household_head' => false,
            'relationship_to_head' => 'Son',
            'first_name' => 'Luis',
            'last_name' => 'Nguyen',
            'birth_date' => '2012-06-15',
            'gender' => 'Male',
            'household_address' => null,
            'civil_status' => 'Single',
            'status' => 'Active',
        ]);

        $response = $this->get(route('residents.index'))->assertOk();

        $document = new \DOMDocument;
        $document->loadHTML('<?xml encoding="UTF-8">'.$response->getContent(), LIBXML_NOERROR | LIBXML_NOWARNING);
        $xpath = new \DOMXPath($document);

        foreach (['Alicia Nguyen' => 'Purok 2', 'Maria Nguyen' => 'Purok 5', 'Luis Nguyen' => '—'] as $name => $purok) {
            $cell = $xpath->query("//tbody/tr[td[1]//p[normalize-space()='$name']]/td[2]");
            $this->assertSame(1, $cell->length);
            $this->assertSame($purok, trim($cell->item(0)->textContent));
        }
    }

    public function test_resident_role_is_still_required_by_controller_validation(): void
    {
        $this->actingAs($this->administrator());
        $household = $this->householdWithHead();

        $this->post(route('residents.store'), [
            'household_id' => $household->id,
            'relationship_to_head' => 'Daughter',
            'first_name' => 'Maria',
            'last_name' => 'Nguyen',
            'birth_date' => '2010-06-15',
            'gender' => 'Female',
            'purok' => 'Purok 2',
            'civil_status' => 'Single',
            'status' => 'Active',
        ])->assertSessionHasErrors('is_household_head');

        $this->assertDatabaseMissing('residents', [
            'first_name' => 'Maria',
            'last_name' => 'Nguyen',
        ]);
    }

    public function test_resident_edit_cancel_returns_to_index_and_show_omits_the_final_footer_card(): void
    {
        $this->actingAs($this->administrator());
        $household = $this->householdWithHead();
        $resident = $household->residents()->where('is_household_head', true)->firstOrFail();

        $editResponse = $this->get(route('residents.edit', $resident))
            ->assertOk()
            ->assertSee('Cancel');

        $this->assertCancelLinkReturnsToIndex($editResponse->getContent());

        $this->get(route('residents.show', $resident))
            ->assertOk()
            ->assertDontSee('Return to Resident List');
    }

    private function htmlXPath(string $content): \DOMXPath
    {
        $document = new \DOMDocument;
        $document->loadHTML('<?xml encoding="UTF-8">'.$content, LIBXML_NOERROR | LIBXML_NOWARNING);

        return new \DOMXPath($document);
    }

    private function assertBirthDateAgePair(\DOMXPath $xpath, string $selector, string $expectedBirthDate): void
    {
        $birthDates = $xpath->query($selector.'[@data-age-source]');
        $this->assertSame(1, $birthDates->length);
        $this->assertSame($expectedBirthDate, $birthDates->item(0)->getAttribute('value'));
        $this->assertSame(today()->toDateString(), $birthDates->item(0)->getAttribute('data-today'));
        $this->assertSame(today()->toDateString(), $birthDates->item(0)->getAttribute('max'));
        $this->assertSame(1, $xpath->query($selector.'/../following-sibling::div[1]//input[@data-age-display and @readonly and not(@name)]')->length);
    }

    private function assertCancelLinkReturnsToIndex(string $content): void
    {
        $pattern = '/<a\s+href="'.preg_quote(route('residents.index'), '/').'"[^>]*class="clay-cancel-button/s';

        $this->assertSame(1, preg_match($pattern, $content));
    }

    private function announcement(): Announcement
    {
        return Announcement::create([
            'title' => 'Test announcement',
            'message' => 'Test message',
            'target_type' => 'general',
        ]);
    }

    private function smsDelivery(Announcement $announcement, Household $household, int $residentId): AnnouncementSmsDelivery
    {
        return AnnouncementSmsDelivery::create([
            'announcement_id' => $announcement->id,
            'household_id' => $household->id,
            'household_head_resident_id' => $residentId,
            'contact_number' => '09123456789',
            'status' => 'Sent',
        ]);
    }

    private function administrator(): User
    {
        return User::factory()->create([
            'role' => 'System Administrator',
            'status' => 'active',
        ]);
    }

    private function householdWithHead(): Household
    {
        $household = Household::create([
            'household_code' => 'HH-000001',
            'household_head_name' => 'Alicia Nguyen',
            'address' => 'Purok 2, Esperanza, Pilar, Sorsogon',
            'status' => 'Active',
        ]);

        $household->residents()->create([
            'is_household_head' => true,
            'relationship_to_head' => 'Household Head',
            'first_name' => 'Alicia',
            'last_name' => 'Nguyen',
            'birth_date' => '1980-05-10',
            'gender' => 'Female',
            'contact_number' => '639171234567',
            'household_address' => $household->address,
            'civil_status' => 'Married',
            'status' => 'Active',
        ]);

        return $household;
    }
}
