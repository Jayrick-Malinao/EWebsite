<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Services\AuditLogService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class UserController extends Controller
{
    /**
     * Display the staff accounts.
     */
    public function index(Request $request): View
    {
        /*
         * Main staff accounts query.
         *
         * Only Health Worker and Official accounts
         * are managed through this module.
         */
        $query = User::query()
            ->whereIn('role', [
                'Health Worker',
                'Official',
            ])
            ->orderBy('name');

        /*
         * Search by name or email.
         */
        if ($request->filled('search')) {
            $search = trim($request->input('search'));

            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            });
        }

        /*
         * Filter by role.
         */
        if ($request->filled('role')) {
            $query->where(
                'role',
                $request->input('role')
            );
        }

        /*
         * Filter by status.
         */
        if ($request->filled('status')) {
            $query->where(
                'status',
                $request->input('status')
            );
        }

        /*
         * Paginated staff list.
         *
         * withQueryString() keeps search/filter values
         * when moving between pagination pages.
         */
        $users = $query
            ->paginate(15)
            ->withQueryString();

        /*
         * Summary counts.
         *
         * These are intentionally calculated separately
         * from the paginated results so the summary cards
         * always represent all staff accounts.
         */
        $staffQuery = User::query()
            ->whereIn('role', [
                'Health Worker',
                'Official',
            ]);

        $totalStaff = (clone $staffQuery)->count();

        $healthWorkers = (clone $staffQuery)
            ->where('role', 'Health Worker')
            ->count();

        $officials = (clone $staffQuery)
            ->where('role', 'Official')
            ->count();

        return view('users.index', [
            'users' => $users,
            'totalStaff' => $totalStaff,
            'healthWorkers' => $healthWorkers,
            'officials' => $officials,
        ]);
    }

    /**
     * Show the form for creating a staff account.
     */
    public function create(): View
    {
        return view('users.create');
    }

    /**
     * Store a new staff account.
     */
    public function store(Request $request): RedirectResponse
    {
        /*
         * Normalize the input before validation.
         *
         * This ensures that values such as:
         *
         * Maria@gmail.com
         * MARIA@GMAIL.COM
         * maria@gmail.com
         *
         * are treated consistently.
         */
        $request->merge([
            'email' => strtolower(
                trim($request->input('email', ''))
            ),
            'name' => trim(
                $request->input('name', '')
            ),
        ]);

        /*
         * Validate the new staff account.
         */
        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
            ],

            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                'unique:users,email',
            ],

            'password' => [
                'required',
                'string',
                'min:8',
                'confirmed',
            ],

            'role' => [
                'required',
                Rule::in([
                    'Health Worker',
                    'Official',
                ]),
            ],
        ]);

        /*
         * Create the staff account.
         *
         * The User model should automatically hash the
         * password through its password cast.
         */
        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => $validated['password'],
            'role' => $validated['role'],
            'status' => 'active',
        ]);

        /*
         * Record account creation in the audit log.
         */
        AuditLogService::created(
            module: 'Users',
            model: $user,
            description:
                'Staff account created: '
                . $user->name
                . ' (' . $user->role . ').',
        );

        /*
         * Return to the Users list.
         */
        return redirect()
            ->route('users.index')
            ->with(
                'success',
                'Staff account created successfully.'
            );
    }

    /**
     * Show the form for editing a staff account.
     */
    public function edit(User $user): View
    {
        $this->ensureManageableStaff($user);

        return view('users.edit', [
            'user' => $user,
        ]);
    }

    /**
     * Update a staff account.
     */
    public function update(
        Request $request,
        User $user
    ): RedirectResponse {
        $this->ensureManageableStaff($user);

        /*
         * Normalize input before validation.
         */
        $request->merge([
            'email' => strtolower(
                trim($request->input('email', ''))
            ),
            'name' => trim(
                $request->input('name', '')
            ),
        ]);

        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
            ],

            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique('users', 'email')
                    ->ignore($user->id),
            ],

            'password' => [
                'nullable',
                'string',
                'min:8',
                'confirmed',
            ],

            'role' => [
                'required',
                Rule::in([
                    'Health Worker',
                    'Official',
                ]),
            ],
        ]);

        /*
         * Capture the old values for audit logging.
         */
        $oldValues = [
            'name' => $user->name,
            'email' => $user->email,
            'role' => $user->role,
            'status' => $user->status,
        ];

        /*
         * Update account information.
         */
        $user->name = $validated['name'];
        $user->email = $validated['email'];
        $user->role = $validated['role'];

        /*
         * Only change the password when a new password
         * was actually provided.
         */
        if (! empty($validated['password'])) {
            $user->password = $validated['password'];
        }

        $user->save();

        /*
         * Capture the new values for audit logging.
         */
        $newValues = [
            'name' => $user->name,
            'email' => $user->email,
            'role' => $user->role,
            'status' => $user->status,
        ];

        /*
         * Record the update only when account information
         * actually changed.
         */
        if ($oldValues !== $newValues) {
            AuditLogService::updated(
                module: 'Users',
                model: $user,
                oldValues: $oldValues,
                newValues: $newValues,
                description:
                    'Staff account updated: '
                    . $user->name
                    . '.',
            );
        }

        return redirect()
            ->route('users.index')
            ->with(
                'success',
                'Staff account updated successfully.'
            );
    }

    /**
     * Activate or deactivate a staff account.
     */
    public function toggleStatus(User $user): RedirectResponse
    {
        $this->ensureManageableStaff($user);

        $oldStatus = $user->status;

        $user->status = $user->status === 'active'
            ? 'inactive'
            : 'active';

        $user->save();

        AuditLogService::updated(
            module: 'Users',
            model: $user,
            oldValues: [
                'status' => $oldStatus,
            ],
            newValues: [
                'status' => $user->status,
            ],
            description:
                'Staff account '
                . $user->status
                . ': '
                . $user->name
                . '.',
        );

        $message = $user->status === 'active'
            ? 'Staff account activated successfully.'
            : 'Staff account deactivated successfully.';

        return redirect()
            ->route('users.index')
            ->with('success', $message);
    }

    /**
     * Show the delete confirmation page.
     */
    public function delete(User $user): View
    {
        /*
         * Only Health Worker and Official accounts
         * can be deleted through this module.
         *
         * System Administrator accounts are protected.
         */
        $this->ensureManageableStaff($user);

        return view('users.delete', [
            'user' => $user,
        ]);
    }

    /**
     * Permanently delete a staff account.
     */
    public function destroy(User $user): RedirectResponse
    {
        /*
         * Only Health Worker and Official accounts
         * can be deleted through this module.
         *
         * System Administrator accounts are protected.
         */
        $this->ensureManageableStaff($user);

        /*
         * Store the user's name before deletion
         * for the success message.
         */
        $userName = $user->name;

        /*
         * Record the deletion before removing the user.
         *
         * AuditLogService::deleted() automatically stores
         * the user's current attributes in old_values.
         */
        AuditLogService::deleted(
            module: 'Users',
            model: $user,
            description:
                'Staff account deleted: '
                . $user->name
                . ' ('
                . $user->role
                . ', '
                . $user->email
                . ').',
        );

        /*
         * Permanently remove the staff account.
         */
        $user->delete();

        return redirect()
            ->route('users.index')
            ->with(
                'success',
                'Staff account for '
                . $userName
                . ' was permanently deleted.'
            );
    }

    /**
     * Ensure only Health Worker and Official accounts
     * can be managed through this module.
     */
    private function ensureManageableStaff(User $user): void
    {
        abort_unless(
            in_array(
                $user->role,
                [
                    'Health Worker',
                    'Official',
                ],
                true
            ),
            404
        );
    }
}

