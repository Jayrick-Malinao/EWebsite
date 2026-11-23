<?php

namespace Tests\Feature;

use App\Models\Household;
use App\Models\Resident;
use App\Models\User;
use App\Rules\PersonName;
use App\Rules\PhilippineMobileNumber;
use App\Support\PhilippineMobileNumberFormatter;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Validator;
use Tests\TestCase;

class FormInputValidationTest extends TestCase
{
    use RefreshDatabase;

    public function test_mobile_numbers_are_grouped_for_display_without_changing_invalid_values(): void
    {
        $this->assertSame(
            '+6391 7123 4567',
            PhilippineMobileNumberFormatter::formatForDisplay('639171234567')
        );
        $this->assertSame(
            '+6391 7123 4567',
            PhilippineMobileNumberFormatter::formatForDisplay('+63 917 123 4567')
        );
        $this->assertSame(
            '12345',
            PhilippineMobileNumberFormatter::formatForDisplay('12345')
        );
        $this->assertNull(PhilippineMobileNumberFormatter::formatForDisplay(null));
    }

    public function test_person_names_allow_unicode_letters_and_valid_separators_only(): void
    {
        $validNames = [
            'Dela Cruz',
            'Anne-Marie',
            "O'Connor",
            'José Niño',
            'O’Connor',
        ];

        foreach ($validNames as $name) {
            $validator = Validator::make(
                ['name' => $name],
                ['name' => ['required', new PersonName]],
            );

            $this->assertTrue($validator->passes(), "Expected [{$name}] to be accepted.");
        }

        $validator = Validator::make(
            ['name' => 'Anne2'],
            ['name' => ['required', new PersonName]],
        );

        $this->assertFalse($validator->passes());
    }

    public function test_new_person_names_accept_letters_spaces_and_hyphens_only(): void
    {
        foreach (['Anne-Marie', 'José Dela Cruz'] as $name) {
            $this->assertTrue(Validator::make(['name' => $name], ['name' => [new PersonName(false)]])->passes());
        }

        foreach (['Anne2', "O'Connor", 'Maria_Clara'] as $name) {
            $this->assertFalse(Validator::make(['name' => $name], ['name' => [new PersonName(false)]])->passes());
        }
    }

    public function test_mobile_number_rule_accepts_only_the_international_format(): void
    {
        $valid = Validator::make(
            ['phone' => '639187113445'],
            ['phone' => ['nullable', new PhilippineMobileNumber]],
        );

        $this->assertTrue($valid->passes());

        foreach ([
            '0918-711-3445',
            '09187113445',
            '+639187113445',
            '00639187113445',
            '63918711344',
            '63918711344A',
        ] as $number) {
            $invalid = Validator::make(
                ['phone' => $number],
                ['phone' => ['nullable', new PhilippineMobileNumber]],
            );

            $this->assertFalse($invalid->passes(), "Expected [{$number}] to be rejected.");
        }
    }

    public function test_household_form_normalizes_names_and_mobile_numbers_before_saving(): void
    {
        $this->actingAs(User::factory()->create([
            'role' => 'System Administrator',
            'status' => 'active',
        ]));

        $this->get(route('households.create'))
            ->assertOk()
            ->assertDontSee('House Number / Street')
            ->assertDontSee("Choose the household's Purok if known.")
            ->assertSee('Select Purok')
            ->assertSee('placeholder="09XX-XXXX-XXX"', false)
            ->assertSee('title="Enter an 11-digit mobile number starting with 09."', false);

        $payload = $this->validHouseholdPayload();
        $payload['members'] = [[
            'first_name' => 'Maria',
            'middle_name' => '',
            'last_name' => 'Dela Cruz',
            'suffix' => '',
            'relationship_to_head' => 'Daughter',
            'birth_date' => '2010-06-15',
            'gender' => 'Female',
            'contact_number' => '0917-1234-567',
            'email' => '',
            'civil_status' => 'Single',
            'philhealth_number' => '',
            'purok' => 'Purok 2',
        ]];

        $response = $this->post(route('households.store'), $payload);

        $response->assertRedirect(route('households.index'));

        $this->assertDatabaseHas('households', [
            'address' => 'Purok 2, Esperanza, Pilar, Sorsogon',
            'contact_number' => '639187113445',
            'household_head_name' => 'Anne-Marie De La Santos',
        ]);

        $this->assertDatabaseHas('residents', [
            'first_name' => 'Anne-Marie',
            'middle_name' => 'De La',
            'last_name' => 'Santos',
            'contact_number' => '639187113445',
            'household_address' => 'Purok 2, Esperanza, Pilar, Sorsogon',
        ]);

        $this->assertDatabaseHas('residents', [
            'first_name' => 'Maria',
            'contact_number' => '639187113445',
        ]);

        $this->get(route('households.edit', Household::query()->firstOrFail()))
            ->assertOk()
            ->assertDontSee('House Number / Street')
            ->assertDontSee("Choose the household's Purok if known.")
            ->assertSee('Purok 2')
            ->assertSee('Esperanza')
            ->assertSee('Pilar')
            ->assertSee('Sorsogon')
            ->assertSee('+6391 8711 3445');

        $household = Household::query()->firstOrFail();
        $head = $household->residents()
            ->where('is_household_head', true)
            ->firstOrFail();

        $updatePayload = $this->validHouseholdPayload([
            'address' => '',
            'purok' => 'Purok 5',
            'household_head' => [
                'id' => $head->id,
            ],
        ]);
        $updatePayload['household_code'] = $household->household_code;

        $this->put(route('households.update', $household), $updatePayload)
            ->assertRedirect(route('households.show', $household));

        $this->assertDatabaseHas('households', [
            'id' => $household->id,
            'address' => 'Purok 5, Esperanza, Pilar, Sorsogon',
        ]);

        $this->assertDatabaseHas('residents', [
            'id' => $head->id,
            'household_address' => 'Purok 5, Esperanza, Pilar, Sorsogon',
        ]);
    }

    public function test_household_create_rejects_country_code_only_and_international_mobile_numbers(): void
    {
        $this->actingAs(User::factory()->create([
            'role' => 'System Administrator',
            'status' => 'active',
        ]));

        $payload = $this->validHouseholdPayload([
            'contact_number' => '+63',
            'household_head' => [
                'contact_number' => '+63',
            ],
        ]);

        $this->post(route('households.store'), $payload)
            ->assertSessionHasErrors(['household_head.contact_number']);

        $payload['contact_number'] = '639187113445';
        $payload['household_head']['contact_number'] = '+639187113445';
        $this->post(route('households.store'), $payload)
            ->assertSessionHasErrors(['household_head.contact_number']);
        $this->assertDatabaseCount('households', 0);
    }

    public function test_household_form_rejects_invalid_names_phone_numbers_and_dropdown_values(): void
    {
        $this->actingAs(User::factory()->create([
            'role' => 'System Administrator',
            'status' => 'active',
        ]));

        $response = $this->post(route('households.store'), $this->validHouseholdPayload([
            'contact_number' => '091A-711-3445',
            'purok' => 'Purok 7',
            'household_head' => [
                'first_name' => 'Anne2',
                'middle_name' => '',
                'last_name' => "O'Connor",
                'birth_date' => '1980-05-10',
                'gender' => 'Unknown',
                'civil_status' => 'Married',
                'contact_number' => '',
            ],
        ]));

        $response->assertSessionHasErrors([
            'household_head.contact_number',
            'purok',
            'household_head.first_name',
            'household_head.gender',
        ]);

        $this->assertSame(0, Household::query()->count());
        $this->assertSame(0, Resident::query()->count());
    }

    public function test_household_form_requires_a_purok(): void
    {
        $this->actingAs(User::factory()->create([
            'role' => 'System Administrator',
            'status' => 'active',
        ]));

        $response = $this->post(route('households.store'), $this->validHouseholdPayload([
            'purok' => '',
        ]));

        $response->assertSessionHasErrors('purok');

        $this->assertSame(0, Household::query()->count());
    }

    public function test_family_members_store_their_own_purok_address(): void
    {
        $this->actingAs(User::factory()->create([
            'role' => 'System Administrator',
            'status' => 'active',
        ]));

        $payload = $this->validHouseholdPayload();
        $payload['members'] = [[
            'first_name' => 'Maria',
            'middle_name' => '',
            'last_name' => 'Dela Cruz',
            'suffix' => '',
            'relationship_to_head' => 'Daughter',
            'birth_date' => '2010-06-15',
            'gender' => 'Female',
            'contact_number' => '',
            'email' => '',
            'civil_status' => 'Single',
            'philhealth_number' => '',
            'purok' => 'Purok 5',
        ]];

        $this->post(route('households.store'), $payload)
            ->assertRedirect(route('households.index'));

        $household = Household::query()->firstOrFail();
        $member = $household->residents()
            ->where('is_household_head', false)
            ->firstOrFail();

        $this->assertDatabaseHas('residents', [
            'id' => $member->id,
            'household_address' => 'Purok 5, Esperanza, Pilar, Sorsogon',
        ]);

        $this->get(route('households.edit', $household))
            ->assertOk()
            ->assertSee('Address')
            ->assertSee('member-0-purok')
            ->assertSee('Purok 5');

        $updatePayload = $this->validHouseholdPayload();
        $updatePayload['household_code'] = $household->household_code;
        $updatePayload['household_head']['id'] = $household->residents()
            ->where('is_household_head', true)
            ->value('id');
        $updatePayload['members'] = [[
            'id' => $member->id,
            'first_name' => 'Maria',
            'middle_name' => '',
            'last_name' => 'Dela Cruz',
            'suffix' => '',
            'relationship_to_head' => 'Daughter',
            'birth_date' => '2010-06-15',
            'gender' => 'Female',
            'contact_number' => '',
            'email' => '',
            'civil_status' => 'Single',
            'philhealth_number' => '',
            'purok' => 'Purok 6',
        ]];

        $this->put(route('households.update', $household), $updatePayload)
            ->assertRedirect(route('households.show', $household));

        $this->assertDatabaseHas('residents', [
            'id' => $member->id,
            'household_address' => 'Purok 6, Esperanza, Pilar, Sorsogon',
        ]);
    }

    public function test_family_member_status_and_details_are_saved_on_household_create_and_edit(): void
    {
        $this->actingAs(User::factory()->create(['role' => 'System Administrator', 'status' => 'active']));
        $payload = $this->validHouseholdPayload();
        $payload['members'] = [[
            'first_name' => 'Maria',
            'last_name' => 'Santos',
            'relationship_to_head' => 'Daughter',
            'birth_date' => '2010-06-15',
            'gender' => 'Female',
            'civil_status' => 'Single',
            'purok' => 'Purok 5',
            'status' => 'Inactive',
        ]];

        $this->post(route('households.store'), $payload)
            ->assertRedirect(route('households.index'));

        $household = Household::query()->firstOrFail();
        $member = $household->residents()->where('is_household_head', false)->firstOrFail();
        $this->assertSame('Inactive', $member->status);

        $payload['household_code'] = $household->household_code;
        $payload['household_head']['id'] = $household->residents()->where('is_household_head', true)->value('id');
        $payload['household_head']['contact_number'] = '0917-9876-543';
        $payload['members'][0]['id'] = $member->id;
        $payload['members'][0]['status'] = 'Active';
        $payload['members'][] = [
            'first_name' => 'Luis',
            'last_name' => 'Santos',
            'suffix' => 'Jr.',
            'relationship_to_head' => 'Son',
            'birth_date' => '2012-02-10',
            'gender' => 'Male',
            'civil_status' => 'Single',
            'purok' => 'Purok 6',
            'contact_number' => '0917-1234-567',
            'email' => 'luis@example.test',
            'philhealth_number' => '001234',
            'status' => 'Inactive',
        ];

        $this->put(route('households.update', $household), $payload)
            ->assertRedirect(route('households.show', $household));

        $this->assertDatabaseHas('residents', ['id' => $member->id, 'status' => 'Active', 'contact_number' => '639179876543']);
        $this->assertDatabaseHas('residents', [
            'household_id' => $household->id,
            'first_name' => 'Luis',
            'suffix' => 'Jr.',
            'household_address' => 'Purok 6, Esperanza, Pilar, Sorsogon',
            'contact_number' => '639179876543',
            'email' => 'luis@example.test',
            'philhealth_number' => '001234',
            'status' => 'Inactive',
        ]);
    }

    public function test_household_member_status_rejects_invalid_values_and_omission_preserves_existing_status(): void
    {
        $this->actingAs(User::factory()->create(['role' => 'System Administrator', 'status' => 'active']));
        $payload = $this->validHouseholdPayload();
        $payload['members'] = [[
            'first_name' => 'Maria',
            'last_name' => 'Santos',
            'relationship_to_head' => 'Daughter',
            'birth_date' => '2010-06-15',
            'gender' => 'Female',
            'civil_status' => 'Single',
            'purok' => 'Purok 2',
            'status' => 'Unsupported',
        ]];

        $this->post(route('households.store'), $payload)->assertSessionHasErrors('members.0.status');
        $this->assertDatabaseMissing('residents', ['first_name' => 'Maria']);

        $payload['members'][0]['status'] = 'Inactive';
        $this->post(route('households.store'), $payload)->assertRedirect(route('households.index'));
        $household = Household::query()->firstOrFail();
        $member = $household->residents()->where('is_household_head', false)->firstOrFail();
        $payload['household_code'] = $household->household_code;
        $payload['household_head']['id'] = $household->residents()->where('is_household_head', true)->value('id');
        $payload['members'][0]['id'] = $member->id;
        $payload['members'][0]['status'] = 'Unsupported';

        $this->put(route('households.update', $household), $payload)->assertSessionHasErrors('members.0.status');
        $this->assertSame('Inactive', $member->fresh()->status);

        unset($payload['members'][0]['status']);
        $this->put(route('households.update', $household), $payload)
            ->assertRedirect(route('households.show', $household));
        $this->assertSame('Inactive', $member->fresh()->status);
    }

    public function test_household_member_templates_include_resident_address_and_status(): void
    {
        $this->actingAs(User::factory()->create(['role' => 'System Administrator', 'status' => 'active']));
        $household = Household::create([
            'household_code' => 'HH-000001',
            'household_head_name' => 'Maria Santos',
            'address' => 'Purok 2, Esperanza, Pilar, Sorsogon',
            'status' => 'Active',
        ]);

        foreach ([route('households.create'), route('households.edit', $household)] as $url) {
            $response = $this->get($url)->assertOk();
            $document = new \DOMDocument;
            $document->loadHTML('<?xml encoding="UTF-8">'.$response->getContent(), LIBXML_NOERROR | LIBXML_NOWARNING);
            $xpath = new \DOMXPath($document);

            $this->assertSame(1, $xpath->query("//template[@id='member-template']//select[@data-field='purok' and @required]")->length);
            $this->assertSame(1, $xpath->query("//template[@id='member-template']//select[@data-field='status' and @required]/option[@value='Inactive']")->length);
        }
    }

    public function test_new_members_added_during_edit_follow_create_name_rules_without_rejecting_legacy_members(): void
    {
        $this->actingAs(User::factory()->create(['role' => 'System Administrator', 'status' => 'active']));
        $payload = $this->validHouseholdPayload();
        $this->post(route('households.store'), $payload)->assertRedirect(route('households.index'));

        $household = Household::query()->firstOrFail();
        $existing = $household->residents()->create([
            'first_name' => "O'Connor",
            'last_name' => 'Santos',
            'suffix' => 'III',
            'birth_date' => '2010-01-01',
            'gender' => 'Female',
            'relationship_to_head' => 'Daughter',
            'civil_status' => 'Single',
            'household_address' => 'Purok 2, Esperanza, Pilar, Sorsogon',
            'status' => 'Active',
        ]);
        $payload['household_code'] = $household->household_code;
        $payload['household_head']['id'] = $household->residents()->where('is_household_head', true)->value('id');
        $payload['members'] = [
            [
                'id' => $existing->id,
                'first_name' => "O'Connor",
                'last_name' => 'Santos',
                'suffix' => 'III',
                'relationship_to_head' => 'Daughter',
                'birth_date' => '2010-01-01',
                'gender' => 'Female',
                'civil_status' => 'Single',
                'purok' => 'Purok 2',
            ],
            [
                'first_name' => "O'Brien",
                'last_name' => 'Santos',
                'relationship_to_head' => 'Son',
                'birth_date' => '2012-01-01',
                'gender' => 'Male',
                'civil_status' => 'Single',
                'purok' => 'Purok 2',
            ],
        ];

        $this->put(route('households.update', $household), $payload)
            ->assertSessionHasErrors('members.1.first_name')
            ->assertSessionDoesntHaveErrors('members.0.first_name');
        $this->assertDatabaseMissing('residents', ['first_name' => "O'Brien"]);

        $payload['members'][1]['first_name'] = 'Brian';
        $payload['members'][1]['suffix'] = 'III';
        $this->put(route('households.update', $household), $payload)
            ->assertSessionHasErrors('members.1.suffix')
            ->assertSessionDoesntHaveErrors('members.0.suffix');

        $payload['members'][1]['suffix'] = 'Jr.';
        $this->put(route('households.update', $household), $payload)
            ->assertRedirect(route('households.show', $household));
        $this->assertDatabaseHas('residents', ['id' => $existing->id, 'first_name' => "O'Connor", 'suffix' => 'III']);
        $this->assertDatabaseHas('residents', ['household_id' => $household->id, 'first_name' => 'Brian', 'suffix' => 'Jr.']);
    }

    public function test_family_member_form_rejects_an_unsupported_purok(): void
    {
        $this->actingAs(User::factory()->create([
            'role' => 'System Administrator',
            'status' => 'active',
        ]));

        $payload = $this->validHouseholdPayload();
        $payload['members'] = [[
            'first_name' => 'Maria',
            'middle_name' => '',
            'last_name' => 'Dela Cruz',
            'relationship_to_head' => 'Daughter',
            'birth_date' => '2010-06-15',
            'gender' => 'Female',
            'civil_status' => 'Single',
            'purok' => 'Purok 7',
        ]];

        $this->post(route('households.store'), $payload)
            ->assertSessionHasErrors('members.0.purok');

        $this->assertSame(0, Household::query()->count());
        $this->assertSame(0, Resident::query()->count());
    }

    public function test_household_creation_rejects_invalid_names_suffixes_birthdates_and_contacts(): void
    {
        $this->actingAs(User::factory()->create(['role' => 'System Administrator', 'status' => 'active']));

        $payload = $this->validHouseholdPayload([
            'contact_number' => '0818-7111-344',
            'household_head' => [
                'first_name' => "Anne's",
                'suffix' => 'III',
                'birth_date' => now()->addDay()->toDateString(),
                'contact_number' => '0918-7111-34',
                'email' => 'not-an-email',
            ],
        ]);
        $payload['members'] = [[
            'first_name' => 'Maria2',
            'last_name' => 'Santos',
            'suffix' => 'IV',
            'relationship_to_head' => 'Daughter',
            'birth_date' => now()->addDay()->toDateString(),
            'gender' => 'Female',
            'contact_number' => '639171234567',
            'civil_status' => 'Single',
            'purok' => 'Purok 2',
        ]];

        $this->post(route('households.store'), $payload)->assertSessionHasErrors([
            'household_head.first_name',
            'household_head.suffix',
            'household_head.birth_date',
            'household_head.contact_number',
            'household_head.email',
            'members.0.first_name',
            'members.0.suffix',
            'members.0.birth_date',
        ]);

        $this->assertDatabaseCount('households', 0);
    }

    public function test_household_birthdates_and_formatted_numbers_are_saved_and_ages_change_with_time(): void
    {
        $this->actingAs(User::factory()->create(['role' => 'System Administrator', 'status' => 'active']));
        $this->travelTo(new \DateTimeImmutable('2026-03-09 12:00:00', new \DateTimeZone(config('app.timezone'))));
        $payload = $this->validHouseholdPayload([
            'contact_number' => '0918-7111-344',
            'household_head' => [
                'birth_date' => '2000-02-29',
                'contact_number' => '0918-7111-344',
                'suffix' => 'Jr.',
            ],
        ]);
        $payload['members'] = [[
            'first_name' => 'Maria',
            'last_name' => 'Santos',
            'suffix' => 'Sr.',
            'relationship_to_head' => 'Daughter',
            'birth_date' => '2010-03-10',
            'gender' => 'Female',
            'civil_status' => 'Single',
            'purok' => 'Purok 2',
        ]];

        $this->post(route('households.store'), $payload)->assertRedirect(route('households.index'));

        $household = Household::query()->firstOrFail();
        $member = $household->residents()->where('is_household_head', false)->firstOrFail();
        $this->assertDatabaseHas('households', ['id' => $household->id, 'contact_number' => '639187111344']);
        $this->assertSame('2010-03-10', $member->birth_date->toDateString());
        $this->assertDatabaseHas('residents', ['id' => $member->id, 'suffix' => 'Sr.']);
        $this->get(route('households.show', $household))
            ->assertOk()->assertSee('Age: 26 years')->assertSee('Age: 15 years');
        $this->get(route('residents.show', $member))
            ->assertOk()->assertSee('March 10, 2010')->assertSee('15 years old');

        $this->travel(1)->days();
        $this->get(route('households.show', $household))->assertOk()->assertSee('Age: 16 years');
        $this->get(route('residents.show', $member))->assertOk()->assertSee('16 years old');

        $household->load('residents');
        foreach ($household->residents as $resident) {
            $resident->birth_date = null;
        }
        $this->view('households.show', ['household' => $household])->assertSee('Age: N/A');
        $member->birth_date = null;
        $this->view('residents.show', ['resident' => $member])->assertSeeInOrder(['Date of Birth', '—', 'Age', '—']);
    }

    public function test_resident_create_validates_names_suffix_birthdate_and_optional_contact_fields(): void
    {
        $this->actingAs(User::factory()->create(['role' => 'System Administrator', 'status' => 'active']));
        $this->travelTo(new \DateTimeImmutable('2026-03-09 12:00:00', new \DateTimeZone(config('app.timezone'))));

        $payload = [
            'is_household_head' => '1',
            'first_name' => 'Ana2',
            'last_name' => 'Dela Cruz',
            'suffix' => 'III',
            'birth_date' => '2026-03-10',
            'gender' => 'Female',
            'purok' => 'Purok 4',
            'civil_status' => 'Single',
            'status' => 'Active',
            'contact_number' => '0918-7111-34',
            'email' => 'invalid',
            'philhealth_number' => 'AB123',
        ];

        $this->post(route('residents.store'), $payload)
            ->assertSessionHasErrors([
                'first_name',
                'suffix',
                'birth_date',
                'contact_number',
                'email',
                'philhealth_number' => 'The PhilHealth number must contain digits only.',
            ]);

        $payload['first_name'] = 'Ana-Maria';
        $payload['suffix'] = 'Jr.';
        $payload['birth_date'] = '2000-03-10';
        $payload['contact_number'] = '0918-7111-344';
        $payload['email'] = '';
        $payload['philhealth_number'] = '001234567890';
        $this->post(route('residents.store'), $payload)->assertRedirect(route('residents.index'));

        $resident = Resident::query()->where('first_name', 'Ana-Maria')->firstOrFail();
        $this->assertSame('639187111344', $resident->contact_number);
        $this->assertSame('2000-03-10', $resident->birth_date->toDateString());
        $this->assertSame('001234567890', $resident->philhealth_number);
        $this->get(route('residents.show', $resident))->assertOk()->assertSee('25 years old');

        $payload['philhealth_number'] = '12-345';
        $this->put(route('residents.update', $resident), $payload)
            ->assertSessionHasErrors(['philhealth_number' => 'The PhilHealth number must contain digits only.']);
        $this->assertSame('001234567890', $resident->fresh()->philhealth_number);

        $payload['philhealth_number'] = '009876543210';
        $this->put(route('residents.update', $resident), $payload)->assertRedirect(route('residents.index'));
        $this->assertSame('009876543210', $resident->fresh()->philhealth_number);
    }

    public function test_household_create_and_update_validate_head_and_member_philhealth_numbers(): void
    {
        $this->actingAs(User::factory()->create(['role' => 'System Administrator', 'status' => 'active']));
        $payload = $this->validHouseholdPayload([
            'household_head' => ['philhealth_number' => 'AB123'],
        ]);
        $payload['members'] = [[
            'first_name' => 'Maria',
            'last_name' => 'Santos',
            'relationship_to_head' => 'Daughter',
            'birth_date' => '2010-03-10',
            'gender' => 'Female',
            'civil_status' => 'Single',
            'purok' => 'Purok 2',
            'philhealth_number' => '12-345',
        ]];

        $this->post(route('households.store'), $payload)->assertSessionHasErrors([
            'household_head.philhealth_number' => 'The household head PhilHealth number must contain digits only.',
            'members.0.philhealth_number' => 'The family member PhilHealth number must contain digits only.',
        ]);
        $this->assertDatabaseCount('households', 0);

        $payload['household_head']['philhealth_number'] = '001234';
        $payload['members'][0]['philhealth_number'] = '005678';
        $this->post(route('households.store'), $payload)->assertRedirect(route('households.index'));

        $household = Household::query()->firstOrFail();
        $head = $household->residents()->where('is_household_head', true)->firstOrFail();
        $member = $household->residents()->where('is_household_head', false)->firstOrFail();
        $this->assertSame('001234', $head->philhealth_number);
        $this->assertSame('005678', $member->philhealth_number);

        $payload['household_code'] = $household->household_code;
        $payload['household_head']['id'] = $head->id;
        $payload['members'][0]['id'] = $member->id;
        $payload['household_head']['philhealth_number'] = 'ABC';
        $payload['members'][0]['philhealth_number'] = '12-345';
        $this->put(route('households.update', $household), $payload)->assertSessionHasErrors([
            'household_head.philhealth_number',
            'members.0.philhealth_number',
        ]);
        $this->assertSame('001234', $head->fresh()->philhealth_number);
        $this->assertSame('005678', $member->fresh()->philhealth_number);

        $payload['household_head']['philhealth_number'] = '000987';
        $payload['members'][0]['philhealth_number'] = '000654';
        $this->put(route('households.update', $household), $payload)
            ->assertRedirect(route('households.show', $household));
        $this->assertSame('000987', $head->fresh()->philhealth_number);
        $this->assertSame('000654', $member->fresh()->philhealth_number);
    }

    public function test_staff_account_creation_rejects_invalid_name_characters_and_requires_email(): void
    {
        $this->actingAs(User::factory()->create(['role' => 'System Administrator', 'status' => 'active']));

        $this->post(route('users.store'), [
            'first_name' => 'Maria2',
            'last_name' => 'Santos',
            'email' => '',
            'password' => 'password123',
            'password_confirmation' => 'password123',
            'role' => 'Health Worker',
        ])->assertSessionHasErrors(['first_name', 'email']);
    }

    public function test_resident_form_serializes_purok_and_locality_into_existing_address_fields(): void
    {
        $this->actingAs(User::factory()->create([
            'role' => 'System Administrator',
            'status' => 'active',
        ]));

        $this->get(route('residents.create'))
            ->assertOk()
            ->assertDontSee('House Number / Street')
            ->assertDontSee("Choose the resident's Purok if known.")
            ->assertSee('Select Purok');

        $response = $this->post(route('residents.store'), [
            'is_household_head' => '1',
            'first_name' => 'Juan',
            'last_name' => 'Dela Cruz',
            'birth_date' => '1980-05-10',
            'gender' => 'Male',
            'contact_number' => '09171234567',
            'household_address' => '45 Mabini Street',
            'purok' => 'Purok 4',
            'civil_status' => 'Married',
            'status' => 'Active',
        ]);

        $response->assertRedirect(route('residents.index'));

        $this->assertDatabaseHas('households', [
            'address' => 'Purok 4, Esperanza, Pilar, Sorsogon',
        ]);

        $this->assertDatabaseHas('residents', [
            'household_address' => 'Purok 4, Esperanza, Pilar, Sorsogon',
        ]);

        $resident = Resident::query()->firstOrFail();

        $editResponse = $this->get(route('residents.edit', $resident))
            ->assertOk()
            ->assertDontSee('45 Mabini Street')
            ->assertDontSee('House Number / Street')
            ->assertDontSee("Choose the resident's Purok if known.")
            ->assertSee('Purok 4')
            ->assertSee('Esperanza')
            ->assertSee('Pilar')
            ->assertSee('Sorsogon');

        $this->assertMatchesRegularExpression('/<option\s+value="Purok 4"\s+selected\s*>/', $editResponse->getContent());

        $this->put(route('residents.update', $resident), [
            'household_id' => $resident->household_id,
            'is_household_head' => '1',
            'first_name' => 'Juan',
            'last_name' => 'Dela Cruz',
            'birth_date' => '1980-05-10',
            'gender' => 'Male',
            'contact_number' => '09171234567',
            'household_address' => '46 Mabini Street',
            'purok' => 'Purok 5',
            'civil_status' => 'Married',
            'status' => 'Active',
        ])->assertRedirect(route('residents.index'));

        $this->assertDatabaseHas('households', [
            'id' => $resident->household_id,
            'address' => 'Purok 5, Esperanza, Pilar, Sorsogon',
        ]);

        $this->assertDatabaseHas('residents', [
            'id' => $resident->id,
            'household_address' => 'Purok 5, Esperanza, Pilar, Sorsogon',
        ]);
    }

    public function test_user_filters_keep_search_and_combined_role_and_status_selection(): void
    {
        $this->actingAs(User::factory()->create([
            'role' => 'System Administrator',
            'status' => 'active',
        ]));
        User::factory()->create(['name' => 'Matching Worker', 'role' => 'Health Worker', 'status' => 'inactive']);
        User::factory()->create(['name' => 'Active Worker', 'role' => 'Health Worker', 'status' => 'active']);
        User::factory()->create(['name' => 'Inactive Official', 'role' => 'Official', 'status' => 'inactive']);

        $response = $this->get(route('users.index', [
            'search' => 'Worker',
            'role' => 'Health Worker',
            'status' => 'inactive',
        ]));

        $response->assertOk()
            ->assertSee('Matching Worker')
            ->assertDontSee('Active Worker')
            ->assertDontSee('Inactive Official');

        $document = new \DOMDocument;
        $document->loadHTML($response->getContent(), LIBXML_NOERROR | LIBXML_NOWARNING);
        $xpath = new \DOMXPath($document);
        $this->assertSame(1, $xpath->query("//input[@name='search' and @value='Worker']")->length);
        $this->assertSame(1, $xpath->query("//select[@name='role']/option[@value='Health Worker' and @selected]")->length);
        $this->assertSame(1, $xpath->query("//select[@name='status']/option[@value='inactive' and @selected]")->length);
    }

    public function test_user_filters_reject_unsupported_role_and_status_values(): void
    {
        $this->actingAs(User::factory()->create([
            'role' => 'System Administrator',
            'status' => 'active',
        ]));

        $response = $this->get(route('users.index', [
            'role' => 'Administrator',
            'status' => 'enabled',
        ]));

        $response->assertSessionHasErrors(['role', 'status']);
    }

    /**
     * @param  array<string, mixed>  $overrides
     * @return array<string, mixed>
     */
    private function validHouseholdPayload(array $overrides = []): array
    {
        return array_replace_recursive([
            'address' => '123 Main Street',
            'purok' => 'Purok 2',
            'contact_number' => '09187113445',
            'status' => 'Active',
            'household_head' => [
                'first_name' => 'anne-marie',
                'middle_name' => 'de la',
                'last_name' => 'santos',
                'suffix' => '',
                'birth_date' => '1980-05-10',
                'gender' => 'Female',
                'contact_number' => '0918-7113-445',
                'email' => '',
                'civil_status' => 'Married',
                'philhealth_number' => '',
            ],
            'members' => [],
        ], $overrides);

    }
}
