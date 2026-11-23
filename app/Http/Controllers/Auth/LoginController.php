<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Services\AuditLogService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class LoginController extends Controller
{
    /**
     * Display the login page.
     */
    public function showLoginForm(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function login(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'email' => [
                'required',
                'email',
                'max:255',
            ],
            'password' => [
                'required',
                'string',
                'min:8',
            ],
        ]);

        if (! Auth::attempt($credentials, $request->boolean('remember'))) {
            return back()
                ->withErrors([
                    'email' => 'The email or password you entered is incorrect.',
                ])
                ->onlyInput('email');
        }

        $request->session()->regenerate();

        /*
         * Record the successful login after authentication
         * and session regeneration.
         */
        AuditLogService::log(
            action: 'login',
            module: 'Authentication',
            description: 'User logged in successfully.',
        );

        return $this->redirectByRole();
    }

    /**
     * Redirect the authenticated user to the correct dashboard.
     */
    public function redirectByRole(): RedirectResponse
    {
        return match (Auth::user()->role) {
            'System Administrator' => redirect()->route('admin.dashboard'),
            'Official' => redirect()->route('official.dashboard'),
            'Health Worker' => redirect()->route('healthworker.dashboard'),
            default => $this->logoutUnauthorizedUser(),
        };
    }

    /**
     * Log out a user whose role is not recognized.
     */
    private function logoutUnauthorizedUser(): RedirectResponse
    {
        /*
         * Record the security event before logging the
         * authenticated user out.
         */
        AuditLogService::log(
            action: 'login_rejected',
            module: 'Authentication',
            description: 'Login rejected because the account has an invalid system role.',
        );

        Auth::logout();

        request()->session()->invalidate();
        request()->session()->regenerateToken();

        return redirect()
            ->route('login')
            ->withErrors([
                'email' => 'Your account does not have a valid system role.',
            ]);
    }

    /**
     * Log the authenticated user out.
     */
    public function logout(Request $request): RedirectResponse
    {
        /*
         * Record the logout before destroying the authenticated
         * session so the current user_id is still available.
         */
        AuditLogService::log(
            action: 'logout',
            module: 'Authentication',
            description: 'User logged out successfully.',
        );

        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
