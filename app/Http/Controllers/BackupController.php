<?php

namespace App\Http\Controllers;

use App\Services\AuditLogService;
use App\Services\BackupService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use RuntimeException;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class BackupController extends Controller
{
    /**
     * Display available database backups.
     */
    public function index(): View
    {
        $backupDirectory = storage_path('app/private/backups');

        File::ensureDirectoryExists($backupDirectory);

        $backups = collect(File::files($backupDirectory))
            ->filter(function ($file) {
                return strtolower($file->getExtension()) === 'sql';
            })
            ->sortByDesc(function ($file) {
                return $file->getMTime();
            })
            ->values()
            ->map(function ($file) {
                return [
                    'filename' => $file->getFilename(),
                    'path' => $file->getPathname(),
                    'size' => $file->getSize(),
                    'modified_at' => $file->getMTime(),
                ];
            });

        return view('backups.index', compact('backups'));
    }

    /**
     * Create a new database backup.
     */
    public function store(
        BackupService $backupService
    ): RedirectResponse {
        try {
            $backup = $backupService->createDatabaseBackup();

            AuditLogService::log(
                action: 'created',
                module: 'Backups',
                description: 'Database backup created: ' . $backup['filename'] . '.',
            );

            return redirect()
                ->route('backups.index')
                ->with(
                    'success',
                    'Database backup created successfully.'
                );
        } catch (RuntimeException $exception) {
            report($exception);

            return redirect()
                ->route('backups.index')
                ->with(
                    'error',
                    'The database backup could not be created.'
                );
        }
    }

    /**
     * Download a database backup.
     */
    public function download(string $filename): BinaryFileResponse
    {
        $filename = basename($filename);

        $path = storage_path(
            'app/private/backups/' . $filename
        );

        abort_unless(
            File::exists($path)
            && strtolower(File::extension($path)) === 'sql',
            404
        );

        return response()->download(
            $path,
            $filename,
            [
                'Content-Type' => 'application/sql',
            ]
        );
    }

    /**
     * Delete a database backup.
     */
    public function destroy(string $filename): RedirectResponse
    {
        $filename = basename($filename);

        $path = storage_path(
            'app/private/backups/' . $filename
        );

        abort_unless(
            File::exists($path)
            && strtolower(File::extension($path)) === 'sql',
            404
        );

        File::delete($path);

        AuditLogService::log(
            action: 'deleted',
            module: 'Backups',
            description: 'Database backup deleted: ' . $filename . '.',
        );

        return redirect()
            ->route('backups.index')
            ->with(
                'success',
                'Database backup deleted successfully.'
            );
    }
}

