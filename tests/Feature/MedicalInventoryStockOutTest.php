<?php

namespace Tests\Feature;

use App\Models\MedicalInventory;
use App\Models\MedicalInventoryTransaction;
use App\Models\Resident;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MedicalInventoryStockOutTest extends TestCase
{
    use RefreshDatabase;

    public function test_stock_out_page_requires_an_authenticated_inventory_role(): void
    {
        $this->get(route('medical-inventories.stock-out'))
            ->assertRedirect(route('login'));

        $this->actingAs($this->user('Official'))
            ->get(route('medical-inventories.stock-out'))
            ->assertForbidden();
    }

    public function test_stock_out_page_shows_searchable_medicine_and_resident_selectors(): void
    {
        $this->travelTo(now(config('app.timezone'))->setDate(2026, 11, 16)->setTime(9, 30));
        $user = $this->user('Health Worker');
        $inventory = $this->inventory('2026-11-20', 7);
        $expired = $this->inventory('2026-11-15', 5);
        $outOfStock = $this->inventory('2026-11-20', 0);
        $expiresToday = $this->inventory('2026-11-16', 3);
        $resident = $this->resident();

        $response = $this->actingAs($user)
            ->get(route('medical-inventories.stock-out'));

        $response->assertOk()
            ->assertSee('medicine-search', false)
            ->assertSee('medical-inventory-options', false)
            ->assertSee('resident-search', false)
            ->assertSee('resident-options', false)
            ->assertSee($inventory->medicine_name)
            ->assertSee('Available 7')
            ->assertSee($expiresToday->medicine_name)
            ->assertDontSee($expired->medicine_name)
            ->assertDontSee($outOfStock->medicine_name)
            ->assertSee($resident->full_name)
            ->assertSee($user->name);
    }

    public function test_valid_stock_out_decrements_stock_and_records_the_authenticated_release(): void
    {
        $this->travelTo(now(config('app.timezone'))->setDate(2026, 11, 16)->setTime(9, 30));
        $user = $this->user('Health Worker');
        $otherUser = $this->user('System Administrator');
        $inventory = $this->inventory('2026-11-16', 10);
        $resident = $this->resident();

        $response = $this->actingAs($user)->post(
            route('medical-inventories.stock-out.store'),
            $this->releasePayload($inventory, $resident, [
                'quantity' => 3,
                'released_by_id' => $otherUser->id,
                'released_at' => '2030-01-02 03:04:05',
            ]),
        );

        $response->assertRedirect(route('medical-inventories.index'))
            ->assertSessionHas('success', 'Medicine stock released successfully.');
        $this->assertDatabaseHas('medical_inventories', [
            'id' => $inventory->id,
            'quantity' => 7,
        ]);
        $this->assertDatabaseHas('medical_inventory_transactions', [
            'medical_inventory_id' => $inventory->id,
            'resident_id' => $resident->id,
            'released_by_id' => $user->id,
            'method' => 'Handed directly to resident',
            'purpose' => 'Treatment',
            'quantity' => 3,
            'released_at' => '2026-11-16 09:30:00',
        ]);

        $transaction = MedicalInventoryTransaction::query()
            ->with(['medicalInventory', 'resident', 'releasedBy'])
            ->firstOrFail();
        $this->assertSame($inventory->id, $transaction->medicalInventory->id);
        $this->assertSame($resident->id, $transaction->resident->id);
        $this->assertSame($user->id, $transaction->releasedBy->id);
    }

    public function test_stock_out_rejects_an_empty_request_without_creating_a_transaction(): void
    {
        $this->actingAs($this->user('Health Worker'))
            ->post(route('medical-inventories.stock-out.store'), [])
            ->assertSessionHasErrors([
                'medical_inventory_id',
                'resident_id',
                'method',
                'purpose',
                'quantity',
                'confirmation',
            ]);

        $this->assertDatabaseCount('medical_inventory_transactions', 0);
    }

    public function test_stock_out_rejects_a_non_integer_quantity(): void
    {
        $user = $this->user('Health Worker');
        $inventory = $this->inventory('2026-11-20', 10);
        $resident = $this->resident();

        $this->actingAs($user)
            ->post(
                route('medical-inventories.stock-out.store'),
                $this->releasePayload($inventory, $resident, ['quantity' => '1.5']),
            )
            ->assertSessionHasErrors([
                'quantity' => 'The quantity field must be an integer.',
            ]);

        $this->assertDatabaseHas('medical_inventories', [
            'id' => $inventory->id,
            'quantity' => 10,
        ]);
        $this->assertDatabaseCount('medical_inventory_transactions', 0);
    }

    public function test_stock_out_rejects_a_zero_quantity(): void
    {
        $user = $this->user('Health Worker');
        $inventory = $this->inventory('2026-11-20', 10);
        $resident = $this->resident();

        $this->actingAs($user)
            ->post(
                route('medical-inventories.stock-out.store'),
                $this->releasePayload($inventory, $resident, ['quantity' => 0]),
            )
            ->assertSessionHasErrors([
                'quantity' => 'Release quantity must be at least one unit.',
            ]);

        $this->assertDatabaseHas('medical_inventories', [
            'id' => $inventory->id,
            'quantity' => 10,
        ]);
        $this->assertDatabaseCount('medical_inventory_transactions', 0);
    }

    public function test_stock_out_rejects_a_quantity_above_current_stock(): void
    {
        $this->travelTo(now(config('app.timezone'))->setDate(2026, 11, 16)->setTime(9, 30));
        $user = $this->user('Health Worker');
        $inventory = $this->inventory('2026-11-20', 2);
        $resident = $this->resident();

        $this->actingAs($user)
            ->post(
                route('medical-inventories.stock-out.store'),
                $this->releasePayload($inventory, $resident, ['quantity' => 3]),
            )
            ->assertSessionHasErrors([
                'quantity' => 'Only 2 units are currently available.',
            ]);

        $this->assertDatabaseHas('medical_inventories', [
            'id' => $inventory->id,
            'quantity' => 2,
        ]);
        $this->assertDatabaseCount('medical_inventory_transactions', 0);
    }

    public function test_stock_out_rejects_expired_medicine_without_changing_its_stock(): void
    {
        $this->travelTo(now(config('app.timezone'))->setDate(2026, 11, 16)->setTime(9, 30));
        $user = $this->user('Health Worker');
        $inventory = $this->inventory('2026-11-15', 4);
        $resident = $this->resident();

        $this->actingAs($user)
            ->post(
                route('medical-inventories.stock-out.store'),
                $this->releasePayload($inventory, $resident),
            )
            ->assertSessionHasErrors([
                'medical_inventory_id' => 'Expired medicine cannot be released.',
            ]);

        $this->assertDatabaseHas('medical_inventories', [
            'id' => $inventory->id,
            'quantity' => 4,
        ]);
        $this->assertDatabaseCount('medical_inventory_transactions', 0);
    }

    public function test_index_separates_expired_stock_and_displays_actual_quantity_totals(): void
    {
        $this->travelTo(now(config('app.timezone'))->setDate(2026, 11, 16)->setTime(9, 30));
        $this->actingAs($this->user('Health Worker'));
        $expiredInventory = $this->inventory('2026-11-15', 3);
        $unexpiredInventory = $this->inventory('2026-11-16', 7);

        $this->get(route('medical-inventories.index'))
            ->assertOk()
            ->assertSee('Expired medicine')
            ->assertSee('Unexpired medicine')
            ->assertSee('Expired stock')
            ->assertSee('3 units')
            ->assertSee('7 units')
            ->assertSee('Expires Today')
            ->assertSee('aria-valuenow="30"', false)
            ->assertSee('aria-valuenow="70"', false);

        $this->assertDatabaseHas('medical_inventories', [
            'id' => $expiredInventory->id,
            'quantity' => 3,
            'expiry_date' => '2026-11-15 00:00:00',
        ]);
        $this->assertDatabaseHas('medical_inventories', [
            'id' => $unexpiredInventory->id,
            'quantity' => 7,
            'expiry_date' => '2026-11-16 00:00:00',
        ]);
    }

    public function test_inventory_mobile_card_exposes_edit_and_confirmed_delete_actions(): void
    {
        $inventory = $this->inventory('2026-11-20', 7);

        $response = $this->actingAs($this->user('Health Worker'))
            ->get(route('medical-inventories.index'))
            ->assertOk();

        $mobileCards = str($response->getContent())
            ->between('<section class="space-y-4 lg:hidden">', '</section>')
            ->toString();

        $this->assertStringContainsString('aria-label="More actions for '.$inventory->medicine_name.'"', $mobileCards);
        $this->assertStringContainsString('aria-expanded="false"', $mobileCards);
        $this->assertStringContainsString('data-menu-panel hidden', $mobileCards);
        $this->assertStringContainsString('href="'.route('medical-inventories.edit', $inventory).'"', $mobileCards);
        $this->assertStringContainsString('action="'.route('medical-inventories.destroy', $inventory).'"', $mobileCards);
        $this->assertStringContainsString('data-confirm-title="Delete this inventory item?"', $mobileCards);
        $this->assertStringContainsString('name="_method" value="DELETE"', $mobileCards);
    }

    private function user(string $role): User
    {
        return User::factory()->create([
            'role' => $role,
            'status' => 'active',
        ]);
    }

    private function inventory(string $expiryDate, int $quantity): MedicalInventory
    {
        return MedicalInventory::query()->create([
            'medicine_name' => 'Paracetamol '.$quantity,
            'expiry_date' => $expiryDate,
            'quantity' => $quantity,
        ]);
    }

    private function resident(): Resident
    {
        return Resident::query()->create([
            'first_name' => 'Maria',
            'middle_name' => 'Santos',
            'last_name' => 'Dela Cruz',
            'birth_date' => '1990-04-12',
            'gender' => 'Female',
        ]);
    }

    private function releasePayload(
        MedicalInventory $inventory,
        Resident $resident,
        array $overrides = [],
    ): array {
        return array_merge([
            'medical_inventory_id' => $inventory->id,
            'resident_id' => $resident->id,
            'method' => 'Handed directly to resident',
            'purpose' => 'Treatment',
            'quantity' => 1,
            'confirmation' => '1',
        ], $overrides);
    }
}
