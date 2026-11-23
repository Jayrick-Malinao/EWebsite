<?php

namespace App\Services;

use Illuminate\Support\Facades\File;
use RuntimeException;
use Symfony\Component\Process\Process;

class BackupService
{
    /**
     * Create a database backup.
     *
     * @return array{
     *     filename: string,
     *     path: string,
     *     size: int
     * }
     */
    public function createDatabaseBackup(): array
    {
        $connection = config('database.connections.mysql');

        $database = $connection['database'] ?? null;
        $host = $connection['host'] ?? '127.0.0.1';
        $port = (string) ($connection['port'] ?? 3306);
        $username = $connection['username'] ?? null;
        $password = $connection['password'] ?? null;

        if (! $database || ! $username) {
            throw new RuntimeException(
                'The MySQL database configuration is incomplete.'
            );
        }

        $mysqldump = $this->findMysqldump();

        $backupDirectory = storage_path('app/private/backups');

        File::ensureDirectoryExists($backupDirectory);

        $timestamp = now()->format('Y-m-d_H-i-s');

        $filename = "ewebsite_backup_{$timestamp}.sql";

        $backupPath = $backupDirectory.DIRECTORY_SEPARATOR.$filename;

        $environment = [
            'MYSQL_PWD' => (string) ($password ?? ''),
        ];

        $process = new Process([
            $mysqldump,
            '--host='.$host,
            '--port='.$port,
            '--user='.$username,
            '--single-transaction',
            '--routines',
            '--triggers',
            '--events',
            '--result-file='.$backupPath,
            $database,
        ]);

        $process->setTimeout(300);
        $process->setEnv($environment);
        $process->run();

        if (! $process->isSuccessful()) {
            if (File::exists($backupPath)) {
                File::delete($backupPath);
            }

            $error = trim($process->getErrorOutput());

            throw new RuntimeException(
                'Database backup failed.'
                .($error !== '' ? ' '.$error : '')
            );
        }

        if (! File::exists($backupPath)) {
            throw new RuntimeException(
                'Database backup completed without creating the backup file.'
            );
        }

        $size = File::size($backupPath);

        if ($size === 0) {
            File::delete($backupPath);

            throw new RuntimeException(
                'Database backup created an empty file.'
            );
        }

        return [
            'filename' => $filename,
            'path' => $backupPath,
            'size' => $size,
        ];
    }

    /**
     * Locate the mysqldump executable.
     */
    private function findMysqldump(): string
    {
        $configuredPath = env('MYSQLDUMP_PATH');

        if ($configuredPath && File::exists($configuredPath)) {
            return $configuredPath;
        }

        $laragonPath = 'C:\\laragon\\bin\\mysql\\mysql-8.4.3-winx64\\bin\\mysqldump.exe';

        if (File::exists($laragonPath)) {
            return $laragonPath;
        }

        throw new RuntimeException(
            'mysqldump.exe could not be found. Please verify the Laragon MySQL installation.'
        );
    }
}
