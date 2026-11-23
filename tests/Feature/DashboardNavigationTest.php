<?php

namespace Tests\Feature;

use App\Models\Resident;
use App\Models\User;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class DashboardNavigationTest extends TestCase
{
    use RefreshDatabase;

    public function test_each_role_dashboard_renders_its_own_mobile_navigation(): void
    {
        if (! Schema::hasTable('health_visits')) {
            Schema::create('health_visits', function (Blueprint $table): void {
                $table->id();
                $table->foreignId('resident_id')->constrained()->cascadeOnDelete();
                $table->dateTime('visit_date');
                $table->string('visit_type')->nullable();
                $table->timestamps();
            });
        }

        $this->withoutVite();

        foreach ([
            ['System Administrator', 'admin.dashboard', 'adminSidebar'],
            ['Health Worker', 'healthworker.dashboard', 'healthworkerSidebar'],
            ['Official', 'official.dashboard', 'officialSidebar'],
        ] as [$role, $route, $sidebarId]) {
            $user = User::factory()->create(['role' => $role, 'status' => 'active']);

            $response = $this->actingAs($user)->get(route($route));

            $response->assertOk()
                ->assertSee('id="'.$sidebarId.'"', false)
                ->assertSee('aria-controls="'.$sidebarId.'"', false)
                ->assertSee('id="sidebarOverlay"', false);
        }
    }

    public function test_login_form_has_a_password_visibility_control(): void
    {
        $response = $this->withoutVite()->get(route('login'));

        $response->assertOk()
            ->assertSee('type="password"', false)
            ->assertSee('aria-label="Show password"', false)
            ->assertSee('aria-controls="password"', false);
    }

    public function test_retired_certificate_routes_do_not_remove_historical_records(): void
    {
        $resident = Resident::create([
            'first_name' => 'Test',
            'last_name' => 'Resident',
            'birth_date' => '1990-01-01',
            'gender' => 'Female',
        ]);
        DB::table('certificates')->insert([
            'certificate_number' => 'HISTORICAL-TEST-1',
            'resident_id' => $resident->id,
            'certificate_type' => 'Historical',
            'date_issued' => '2025-01-01',
            'status' => 'Issued',
        ]);

        $this->actingAs(User::factory()->create(['role' => 'Official', 'status' => 'active']))
            ->get('/certificates')->assertNotFound();

        $this->assertDatabaseHas('certificates', ['certificate_number' => 'HISTORICAL-TEST-1']);
    }

    public function test_health_worker_can_access_announcements_from_the_sidebar(): void
    {
        config(['services.unisms.secret_key' => null]);
        $this->withoutVite();
        $user = User::factory()->create(['role' => 'Health Worker', 'status' => 'active']);

        $response = $this->actingAs($user)->get(route('announcements.index'));

        $response->assertOk()
            ->assertSeeInOrder([
                'id="healthworkerSidebar"',
                'href="'.route('announcements.index').'"',
                'bg-emerald-50 text-emerald-700',
                '<span>Announcements</span>',
            ], false);
    }
}
