<?php

namespace App\Services;

use App\Models\AuditLog;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;

class AuditLogService
{
    /**
     * Record a system activity.
     *
     * @param  string       $action
     * @param  string|null  $module
     * @param  Model|null   $model
     * @param  string|null  $description
     * @param  array|null   $oldValues
     * @param  array|null   $newValues
     */
    public static function log(
        string $action,
        ?string $module = null,
        ?Model $model = null,
        ?string $description = null,
        ?array $oldValues = null,
        ?array $newValues = null,
    ): AuditLog {
        return AuditLog::create([
            'user_id' => Auth::id(),

            'action' => strtolower($action),

            'module' => $module,

            'auditable_type' => $model?->getMorphClass(),

            'auditable_id' => $model?->getKey(),

            'description' => $description,

            'old_values' => $oldValues,

            'new_values' => $newValues,

            'ip_address' => Request::ip(),

            'user_agent' => Request::userAgent(),
        ]);
    }

    /**
     * Record a newly created record.
     */
    public static function created(
        string $module,
        Model $model,
        ?string $description = null,
        ?array $newValues = null,
    ): AuditLog {
        return self::log(
            action: 'created',
            module: $module,
            model: $model,
            description: $description,
            newValues: $newValues ?? $model->getAttributes(),
        );
    }

    /**
     * Record an updated record.
     */
    public static function updated(
        string $module,
        Model $model,
        array $oldValues,
        array $newValues,
        ?string $description = null,
    ): AuditLog {
        return self::log(
            action: 'updated',
            module: $module,
            model: $model,
            description: $description,
            oldValues: $oldValues,
            newValues: $newValues,
        );
    }

    /**
     * Record a deleted record.
     */
    public static function deleted(
        string $module,
        Model $model,
        ?string $description = null,
        ?array $oldValues = null,
    ): AuditLog {
        return self::log(
            action: 'deleted',
            module: $module,
            model: $model,
            description: $description,
            oldValues: $oldValues ?? $model->getAttributes(),
        );
    }
}

