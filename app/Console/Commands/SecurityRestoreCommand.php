<?php

namespace App\Console\Commands;

use App\Security\SecurityLogger;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Throwable;

class SecurityRestoreCommand extends Command
{
    protected $signature = 'security:restore
                            {file? : Backup filename inside storage/app/private/backups (defaults to latest)}
                            {--verify-only : Decrypt and verify backup integrity without modifying database}
                            {--force : Execute full database restore from verified encrypted snapshot}';

    protected $description = 'Verify or restore an encrypted database backup snapshot';

    public function handle(): int
    {
        $backupDir = storage_path('app/private/backups');
        $requested = $this->argument('file');

        $targetPath = null;
        if (is_string($requested) && trim($requested) !== '') {
            $basename = basename($requested);
            $candidate = $backupDir.DIRECTORY_SEPARATOR.$basename;
            if (is_file($candidate)) {
                $targetPath = $candidate;
            }
        } else {
            if (is_dir($backupDir)) {
                $latest = collect(File::files($backupDir))
                    ->filter(fn ($f) => str_ends_with($f->getFilename(), '.enc'))
                    ->sortByDesc(fn ($f) => $f->getMTime())
                    ->first();
                $targetPath = $latest?->getRealPath();
            }
        }

        if (! $targetPath || ! is_file($targetPath)) {
            $this->error('Encrypted backup file not found.');

            return self::FAILURE;
        }

        try {
            $encrypted = File::get($targetPath);
            $envelopeJson = Crypt::decryptString($encrypted);
            $envelope = json_decode($envelopeJson, true, 512, JSON_THROW_ON_ERROR);

            $compressed = base64_decode((string) ($envelope['payload'] ?? ''), true);
            if ($compressed === false || empty($envelope['sha256'])) {
                $this->error('Backup envelope malformed.');

                return self::FAILURE;
            }

            $actualHash = hash('sha256', $compressed);
            if (! hash_equals((string) $envelope['sha256'], $actualHash)) {
                $this->error('Integrity verification FAILED: SHA-256 mismatch.');

                return self::FAILURE;
            }

            $json = gzdecode($compressed);
            if ($json === false) {
                $this->error('Failed to decompress backup payload.');

                return self::FAILURE;
            }

            $snapshot = json_decode($json, true, 512, JSON_THROW_ON_ERROR);
        } catch (Throwable $e) {
            $this->error('Backup decryption/verification failed: '.$e->getMessage());

            return self::FAILURE;
        }

        $tables = $snapshot['tables'] ?? [];
        $this->info('Verified encrypted backup: '.basename($targetPath));
        $this->line('Snapshot created at: '.($snapshot['created_at'] ?? 'unknown').' | Driver: '.($snapshot['driver'] ?? 'unknown').' | Tables: '.count($tables));

        foreach ($tables as $tableName => $meta) {
            $rowCount = is_array($meta['rows'] ?? null) ? count($meta['rows']) : 0;
            $this->line(" - {$tableName}: {$rowCount} row(s)");
        }

        if ($this->option('verify-only')) {
            $this->info('Verification completed cleanly (--verify-only). Database was not modified.');

            return self::SUCCESS;
        }

        if (! $this->option('force')) {
            $this->warn('Dry run only. Pass --force to restore rows into the active database.');

            return self::SUCCESS;
        }

        $driver = DB::connection()->getDriverName();
        $this->setForeignKeyChecks($driver, false);

        try {
            foreach ($tables as $tableName => $meta) {
                $rows = $meta['rows'] ?? [];
                if (! DB::getSchemaBuilder()->hasTable($tableName)) {
                    $this->warn("Skipping missing table {$tableName}. Run migrations first.");
                    continue;
                }

                DB::table($tableName)->delete();

                foreach (array_chunk($rows, 200) as $chunk) {
                    DB::table($tableName)->insert($chunk);
                }
            }
        } finally {
            $this->setForeignKeyChecks($driver, true);
        }

        SecurityLogger::log('database_restored', 'Restored database from encrypted snapshot '.basename($targetPath), 'critical');
        $this->info('Database restore completed successfully from '.basename($targetPath));

        return self::SUCCESS;
    }

    private function setForeignKeyChecks(string $driver, bool $enabled): void
    {
        if ($driver === 'sqlite') {
            DB::statement($enabled ? 'PRAGMA foreign_keys = ON' : 'PRAGMA foreign_keys = OFF');
        } else {
            DB::statement($enabled ? 'SET FOREIGN_KEY_CHECKS=1' : 'SET FOREIGN_KEY_CHECKS=0');
        }
    }
}

