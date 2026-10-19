<?php

namespace App\Http\Controllers;

use App\Models\AuditLog;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AuditLogController extends Controller
{
    /**
     * Display the audit logs.
     */
    public function index(Request $request): View
    {
        $query = AuditLog::query()
            ->with('user')
            ->latest('created_at');

        /*
         * Search
         */
        if ($request->filled('search')) {
            $search = trim($request->input('search'));

            $query->where(function ($q) use ($search) {
                $q->where('description', 'like', "%{$search}%")
                    ->orWhere('module', 'like', "%{$search}%")
                    ->orWhere('action', 'like', "%{$search}%")
                    ->orWhere('ip_address', 'like', "%{$search}%")
                    ->orWhereHas('user', function ($userQuery) use ($search) {
                        $userQuery
                            ->where('name', 'like', "%{$search}%")
                            ->orWhere('email', 'like', "%{$search}%");
                    });
            });
        }

        /*
         * Filter by action
         */
        if ($request->filled('action')) {
            $query->where('action', $request->input('action'));
        }

        /*
         * Filter by module
         */
        if ($request->filled('module')) {
            $query->where('module', $request->input('module'));
        }

        /*
         * Filter by starting date
         */
        if ($request->filled('date_from')) {
            $query->whereDate(
                'created_at',
                '>=',
                $request->input('date_from')
            );
        }

        /*
         * Filter by ending date
         */
        if ($request->filled('date_to')) {
            $query->whereDate(
                'created_at',
                '<=',
                $request->input('date_to')
            );
        }

        /*
         * Available filter values.
         */
        $actions = AuditLog::query()
            ->whereNotNull('action')
            ->distinct()
            ->orderBy('action')
            ->pluck('action');

        $modules = AuditLog::query()
            ->whereNotNull('module')
            ->distinct()
            ->orderBy('module')
            ->pluck('module');

        /*
         * Paginate the audit logs.
         *
         * withQueryString() keeps the active filters
         * when moving between pagination pages.
         */
        $auditLogs = $query
            ->paginate(20)
            ->withQueryString();

        return view('audit-logs.index', [
            'auditLogs' => $auditLogs,
            'actions' => $actions,
            'modules' => $modules,
        ]);
    }
}

