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
            ->assertSee('value="+63"', false)
            ->assertSee('title="Only Globe and DITO SIM numbers are supported."', false);

        $payload = $this->validHouseholdPayload();
        $payload['members'] = [[
            'first_name' => 'Maria',
            'middle_name' => '',
            'last_name' => 'Dela Cruz',
            'suffix' => '',
            'relationship_to_head' => 'Daughter',
            'birth_date' => '2010-06-15',
            'gender' => 'Female',
            'contact_number' => '+63 917 123 4567',
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
            'household_head_name' => 'Anne-Marie De La O’Connor',
        ]);

        $this->assertDatabaseHas('residents', [
            'first_name' => 'Anne-Marie',
            'middle_name' => 'De La',
            'last_name' => 'O’Connor',
            'contact_number' => '639187113445',
            'household_address' => 'Purok 2, Esperanza, Pilar, Sorsogon',
        ]);

        $this->assertDatabaseHas('residents', [
            'first_name' => 'Maria',
            'contact_number' => '639171234567',
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

    public function test_country_code_only_is_cleared_before_optional_contact_validation(): void
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
            ->assertRedirect(route('households.index'));

        $this->assertDatabaseHas('households', [
            'contact_number' => '',
        ]);

        $this->assertDatabaseHas('residents', [
            'is_household_head' => true,
            'contact_number' => '',
        ]);
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
            'contact_number',
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

        $this->get(route('residents.edit', $resident))
            ->assertOk()
            ->assertDontSee('45 Mabini Street')
            ->assertDontSee('House Number / Street')
            ->assertDontSee("Choose the resident's Purok if known.")
            ->assertSee('Purok 4')
            ->assertSee('Esperanza')
            ->assertSee('Pilar')
            ->assertSee('Sorsogon');

        $this->put(route('residents.update', $resident), [
            'household_id' => $resident->household_id,
            'is_household_head' => '1',
            'first_name' => 'Juan',
            'last_name' => 'Dela Cruz',
            'birth_date' => '1980-05-10',
            'gender' => 'Male',
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
                'last_name' => 'o’connor',
                'suffix' => '',
                'birth_date' => '1980-05-10',
                'gender' => 'Female',
                'contact_number' => '+63 (918) 711-3445',
                'email' => '',
                'civil_status' => 'Married',
                'philhealth_number' => '',
            ],
            'members' => [],
        ], $overrides);

    }
}
