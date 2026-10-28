
<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\AnalyticsController;
use App\Http\Controllers\AnnouncementController;
use App\Http\Controllers\AuditLogController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\BackupController;
use App\Http\Controllers\CertificateController;
use App\Http\Controllers\ChildHealthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DatabaseAssistantController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\HealthRecordController;
use App\Http\Controllers\HealthVisitController;
use App\Http\Controllers\HouseholdController;
use App\Http\Controllers\ImmunizationController;
use App\Http\Controllers\MaternalCareController;
use App\Http\Controllers\MedicalInventoryController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\ResidentController;
use App\Http\Controllers\SeniorCitizenController;
use App\Http\Controllers\SystemSettingController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome')->name('home');

Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])
        ->name('login');

    Route::post('/login', [LoginController::class, 'login'])
        ->name('login.authenticate');
});

Route::post('/logout', [LoginController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');

/*
|--------------------------------------------------------------------------
| System Administrator Dashboard
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:System Administrator'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'admin'])
            ->name('dashboard');
    });

/*
|--------------------------------------------------------------------------
| Official Dashboard
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:Official'])
    ->prefix('official')
    ->name('official.')
    ->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'official'])
            ->name('dashboard');
    });

/*
|--------------------------------------------------------------------------
| Health Worker Dashboard
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:Health Worker'])
    ->prefix('healthworker')
    ->name('healthworker.')
    ->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'healthworker'])
            ->name('dashboard');
    });

/*
|--------------------------------------------------------------------------
| Residents
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {
    Route::middleware('role:System Administrator|Official|Health Worker')
        ->group(function () {
            Route::resource('residents', ResidentController::class);
        });
});

/*
|--------------------------------------------------------------------------
| Households
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {
    Route::middleware('role:System Administrator|Official|Health Worker')
        ->group(function () {
            Route::resource('households', HouseholdController::class);
        });
});

/*
|--------------------------------------------------------------------------
| Health Visits
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {
    Route::middleware('role:System Administrator|Official|Health Worker')
        ->group(function () {
            Route::resource('health-visits', HealthVisitController::class)
                ->parameters([
                    'health-visits' => 'healthVisit',
                ]);
        });
});

/*
|--------------------------------------------------------------------------
| Health Records
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {
    Route::middleware('role:System Administrator|Official|Health Worker')
        ->group(function () {
            Route::resource('health-records', HealthRecordController::class)
                ->parameters([
                    'health-records' => 'healthRecord',
                ]);
        });
});

/*
|--------------------------------------------------------------------------
| Immunizations
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {
    Route::middleware('role:System Administrator|Official|Health Worker')
        ->group(function () {
            Route::resource('immunizations', ImmunizationController::class);
        });
});

/*
|--------------------------------------------------------------------------
| Maternal Care
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {
    Route::middleware('role:System Administrator|Official|Health Worker')
        ->group(function () {
            Route::resource('maternal-care', MaternalCareController::class)
                ->parameters([
                    'maternal-care' => 'maternalCare',
                ]);
        });
});

/*
|--------------------------------------------------------------------------
| Child Health
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {
    Route::middleware('role:System Administrator|Official|Health Worker')
        ->group(function () {
            Route::resource('child-health', ChildHealthController::class)
                ->parameters([
                    'child-health' => 'childHealth',
                ]);
        });
});

/*
|--------------------------------------------------------------------------
| Senior Citizens
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {
    Route::middleware('role:System Administrator|Official|Health Worker')
        ->group(function () {
            Route::resource('senior-citizens', SeniorCitizenController::class)
                ->parameters([
                    'senior-citizens' => 'seniorCitizen',
                ]);
        });
});

/*
|--------------------------------------------------------------------------
| Certificates
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {
    Route::middleware('role:System Administrator|Official|Health Worker')
        ->group(function () {
            Route::resource('certificates', CertificateController::class)
                ->except(['destroy']);

            Route::delete('/certificates/{certificate}', [
                CertificateController::class,
                'destroy',
            ])->name('certificates.destroy');

            Route::get('/certificates/{certificate}/print', [
                CertificateController::class,
                'print',
            ])->name('certificates.print');
        });
});

/*
|--------------------------------------------------------------------------
| Announcements and SMS Delivery
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {
    Route::middleware('role:System Administrator|Official|Health Worker')
        ->group(function () {
            Route::get('/announcements', [
                AnnouncementController::class,
                'index',
            ])->name('announcements.index');

            Route::get('/announcements/create', [
                AnnouncementController::class,
                'create',
            ])->name('announcements.create');

            Route::post('/announcements/preview', [
                AnnouncementController::class,
                'preview',
            ])->name('announcements.preview');

            Route::post('/announcements', [
                AnnouncementController::class,
                'store',
            ])->name('announcements.store');

            /*
             * Manually send pending SMS messages for an announcement.
             */
            Route::post('/announcements/{announcement}/send-sms', [
                AnnouncementController::class,
                'sendPendingSms',
            ])->name('announcements.sms.send');

            Route::get('/announcements/{announcement}', [
                AnnouncementController::class,
                'show',
            ])->name('announcements.show');
        });
});

/*
|--------------------------------------------------------------------------
| Medical Inventory
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:System Administrator|Health Worker'])->group(function () {
    Route::get('/medical-inventories', [
        MedicalInventoryController::class,
        'index',
    ])->name('medical-inventories.index');

    Route::get('/medical-inventories/create', [
        MedicalInventoryController::class,
        'create',
    ])->name('medical-inventories.create');

    Route::post('/medical-inventories', [
        MedicalInventoryController::class,
        'store',
    ])->name('medical-inventories.store');

    Route::get('/medical-inventories/{medicalInventory}/edit', [
        MedicalInventoryController::class,
        'edit',
    ])->name('medical-inventories.edit');

    Route::put('/medical-inventories/{medicalInventory}', [
        MedicalInventoryController::class,
        'update',
    ])->name('medical-inventories.update');

    Route::delete('/medical-inventories/{medicalInventory}', [
        MedicalInventoryController::class,
        'destroy',
    ])->name('medical-inventories.destroy');
});

/*
|--------------------------------------------------------------------------
| Schedule
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {
    Route::get('/schedule', [
        EventController::class,
        'index',
    ])->name('schedule.index');

    Route::get('/schedule/create', [
        EventController::class,
        'create',
    ])->name('schedule.create');

    Route::post('/schedule', [
        EventController::class,
        'store',
    ])->name('schedule.store');

    Route::get('/schedule/{event}/edit', [
        EventController::class,
        'edit',
    ])->name('schedule.edit');

    Route::put('/schedule/{event}', [
        EventController::class,
        'update',
    ])->name('schedule.update');

    Route::delete('/schedule/{event}', [
        EventController::class,
        'destroy',
    ])->name('schedule.destroy');
});

/*
|--------------------------------------------------------------------------
| Notifications
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {
    Route::get('/notifications', [
        NotificationController::class,
        'index',
    ])->name('notifications.index');

    Route::post('/notifications/{notification}/read', [
        NotificationController::class,
        'markAsRead',
    ])->name('notifications.read');

    Route::post('/notifications/read-all', [
        NotificationController::class,
        'markAllAsRead',
    ])->name('notifications.read-all');
});

/*
|--------------------------------------------------------------------------
| Reports
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {
    Route::get('/reports', [
        ReportController::class,
        'index',
    ])->name('reports.index');
});

/*
|--------------------------------------------------------------------------
| Analytics
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {
    Route::get('/analytics', [
        AnalyticsController::class,
        'index',
    ])->name('analytics.index');
});

/*
|--------------------------------------------------------------------------
| Audit Logs
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:System Administrator'])->group(function () {
    Route::get('/audit-logs', [
        AuditLogController::class,
        'index',
    ])->name('audit-logs.index');
});

/*
|--------------------------------------------------------------------------
| Backups
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:System Administrator'])->group(function () {
    Route::get('/backups', [
        BackupController::class,
        'index',
    ])->name('backups.index');

    Route::post('/backups', [
        BackupController::class,
        'store',
    ])->name('backups.store');

    Route::get('/backups/{filename}/download', [
        BackupController::class,
        'download',
    ])->name('backups.download');

    Route::delete('/backups/{filename}', [
        BackupController::class,
        'destroy',
    ])->name('backups.destroy');
});

/*
|--------------------------------------------------------------------------
| System Settings
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:System Administrator'])->group(function () {
    Route::get('/settings', [
        SystemSettingController::class,
        'index',
    ])->name('settings.index');

    Route::put('/settings', [
        SystemSettingController::class,
        'update',
    ])->name('settings.update');

    Route::put('/account/profile', [
        AccountController::class,
        'updateProfile',
    ])->name('account.profile.update');

    Route::put('/account/password', [
        AccountController::class,
        'updatePassword',
    ])->name('account.password.update');
});

/*
|--------------------------------------------------------------------------
| User Management
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:System Administrator'])->group(function () {
    Route::get('/users', [
        UserController::class,
        'index',
    ])->name('users.index');

    Route::get('/users/create', [
        UserController::class,
        'create',
    ])->name('users.create');

    Route::post('/users', [
        UserController::class,
        'store',
    ])->name('users.store');

    Route::get('/users/{user}/edit', [
        UserController::class,
        'edit',
    ])->name('users.edit');

    Route::put('/users/{user}', [
        UserController::class,
        'update',
    ])->name('users.update');

    Route::patch('/users/{user}/toggle-status', [
        UserController::class,
        'toggleStatus',
    ])->name('users.toggle-status');

    Route::get('/users/{user}/delete', [
        UserController::class,
        'delete',
    ])->name('users.delete');

    Route::delete('/users/{user}', [
        UserController::class,
        'destroy',
    ])->name('users.destroy');
});

/*
|--------------------------------------------------------------------------
| Database Assistant
|--------------------------------------------------------------------------
| Authenticated, role-protected, read-only chatbot endpoint.
*/

Route::post('/assistant/chat', [
    DatabaseAssistantController::class,
    'chat',
])
    ->middleware([
        'auth',
        'role:System Administrator|Official|Health Worker',
    ])
    ->name('assistant.chat');
