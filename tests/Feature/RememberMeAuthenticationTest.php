<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

class RememberMeAuthenticationTest extends TestCase
{
    use RefreshDatabase;

    public static function dashboardRoles(): array
    {
        return [
            'administrator' => ['System Administrator', 'admin.dashboard'],
            'official' => ['Official', 'official.dashboard'],
            'health worker' => ['Health Worker', 'healthworker.dashboard'],
        ];
    }

    #[DataProvider('dashboardRoles')]
    public function test_remember_cookie_restores_user_and_opens_the_role_dashboard(string $role, string $dashboard): void
    {
        $this->withoutVite();
        $user = User::factory()->create(['role' => $role, 'status' => 'active']);

        $login = $this->post(route('login.authenticate'), [
            'email' => $user->email,
            'password' => 'password',
            'remember' => '1',
        ]);

        $login->assertRedirect(route($dashboard));
        $cookieName = Auth::guard()->getRecallerName();
        $login->assertCookieNotExpired($cookieName);
        $cookie = $login->getCookie($cookieName, false);
        $this->assertNotSame(0, $cookie->getExpiresTime());

        $this->flushSession();
        Auth::forgetGuards();
        $home = $this->withUnencryptedCookie($cookieName, $cookie->getValue())->get(route('home'));

        $home->assertOk()
            ->assertSee('Go to Dashboard')
            ->assertSee('href="'.route('dashboard').'"', false)
            ->assertHeaderContains('Cache-Control', 'no-store');
        $this->assertAuthenticatedAs($user);
        $this->assertTrue(Auth::viaRemember());
        $this->get(route('login'))->assertRedirect(route('dashboard'));
        $this->get(route('dashboard'))->assertRedirect(route($dashboard));
    }

    public function test_unchecked_remember_uses_a_browser_session_without_a_remember_cookie(): void
    {
        $user = User::factory()->create(['role' => 'Official', 'status' => 'active']);

        $response = $this->post(route('login.authenticate'), [
            'email' => $user->email,
            'password' => 'password',
        ]);

        $response->assertRedirect(route('official.dashboard'))
            ->assertCookieMissing(Auth::guard()->getRecallerName());
        $sessionCookie = $response->getCookie(config('session.cookie'), false);
        $this->assertNotNull($sessionCookie);
        $this->assertSame(0, $sessionCookie->getExpiresTime());

        $this->flushSession();
        Auth::forgetGuards();
        $this->get(route('dashboard'))->assertRedirect(route('login'));
    }

    public function test_seeded_admin_email_and_password_can_log_in(): void
    {
        $admin = User::factory()->create([
            'email' => 'admin@gmail.com',
            'password' => 'Admin@123',
            'role' => 'System Administrator',
            'status' => 'active',
        ]);

        $response = $this->post(route('login.authenticate'), [
            'email' => 'admin@gmail.com',
            'password' => 'Admin@123',
        ]);

        $response->assertRedirect(route('admin.dashboard'));
        $this->assertAuthenticatedAs($admin);
    }

    public function test_remember_checkbox_is_unchecked_on_the_login_page(): void
    {
        $response = $this->withoutVite()->get(route('login'))->assertOk();

        $document = new \DOMDocument;
        $document->loadHTML($response->getContent(), LIBXML_NOERROR | LIBXML_NOWARNING);
        $xpath = new \DOMXPath($document);
        $this->assertSame(1, $xpath->query("//input[@type='checkbox' and @name='remember' and not(@checked)]")->length);
    }

    public function test_failed_login_does_not_issue_a_remember_cookie(): void
    {
        $user = User::factory()->create(['role' => 'Official', 'status' => 'active']);

        $response = $this->post(route('login.authenticate'), [
            'email' => $user->email,
            'password' => 'incorrect-password',
            'remember' => '1',
        ]);

        $response->assertSessionHasErrors('email')
            ->assertCookieMissing(Auth::guard()->getRecallerName());
        $this->assertGuest();
    }

    public function test_logout_invalidates_a_remember_cookie_and_the_session(): void
    {
        $this->withoutVite();
        $user = User::factory()->create(['role' => 'Official', 'status' => 'active']);
        $login = $this->post(route('login.authenticate'), [
            'email' => $user->email,
            'password' => 'password',
            'remember' => '1',
        ]);
        $cookieName = Auth::guard()->getRecallerName();
        $cookie = $login->getCookie($cookieName, false);
        $oldToken = $user->fresh()->getRememberToken();

        $logout = $this->withUnencryptedCookie($cookieName, $cookie->getValue())
            ->post(route('logout'));

        $logout->assertRedirect(route('login'))->assertCookieExpired($cookieName);
        $this->assertNotSame($oldToken, $user->fresh()->getRememberToken());
        $this->flushSession();
        Auth::forgetGuards();
        $this->get(route('home'))->assertOk()->assertSee('Sign In')->assertDontSee('Go to Dashboard');
        $this->assertGuest();
        $this->get(route('dashboard'))->assertRedirect(route('login'));
    }

    public function test_guest_sees_sign_in_and_cannot_access_the_dashboard(): void
    {
        $this->withoutVite();

        $this->get(route('home'))
            ->assertOk()
            ->assertSee('href="'.route('login').'"', false)
            ->assertSee('Sign In')
            ->assertDontSee('Go to Dashboard')
            ->assertHeaderContains('Cache-Control', 'no-store');
        $this->get(route('dashboard'))->assertRedirect(route('login'));
    }

    public function test_authenticated_user_cannot_access_another_roles_dashboard(): void
    {
        $user = User::factory()->create(['role' => 'Official', 'status' => 'active']);

        $this->actingAs($user)->get(route('admin.dashboard'))->assertForbidden();
    }

    public function test_remember_and_session_cookies_are_secure_through_a_trusted_https_proxy(): void
    {
        $user = User::factory()->create(['role' => 'Official', 'status' => 'active']);

        $response = $this->withServerVariables([
            'REMOTE_ADDR' => '127.0.0.1',
            'HTTP_X_FORWARDED_PROTO' => 'https',
        ])->post(route('login.authenticate'), [
            'email' => $user->email,
            'password' => 'password',
            'remember' => '1',
        ]);

        $response->assertRedirect();
        $rememberCookie = $response->getCookie(Auth::guard()->getRecallerName(), false);
        $sessionCookie = $response->getCookie(config('session.cookie'), false);
        $this->assertNotNull($rememberCookie);
        $this->assertNotNull($sessionCookie);
        $this->assertTrue($rememberCookie->isSecure());
        $this->assertTrue($rememberCookie->isHttpOnly());
        $this->assertSame('lax', $rememberCookie->getSameSite());
        $this->assertTrue($sessionCookie->isSecure());
        $this->assertTrue($sessionCookie->isHttpOnly());
    }

    public function test_landing_links_use_the_public_https_host_from_a_trusted_proxy(): void
    {
        $response = $this->withoutVite()->withServerVariables([
            'REMOTE_ADDR' => '127.0.0.1',
            'HTTP_X_FORWARDED_PROTO' => 'https',
            'HTTP_X_FORWARDED_HOST' => 'records.example.test',
            'HTTP_X_FORWARDED_PORT' => '443',
        ])->get('http://localhost/');

        $response->assertOk()
            ->assertSee('href="https://records.example.test/login"', false);
    }
}
