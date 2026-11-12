<?php

namespace App\Console\Commands;

use App\Security\SecurityLogger;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Throwable;

class SecurityBackupCommand extends Command
{
    protected $signature = 'security:backup
                            {--keep=14 : Number of most recent encrypted backups to retain locally}
                            {--offsite-path= : Optional secondary off-site directory path for encrypted replica}';

    protected $description = 'Create an encrypted, integrity-verified database snapshot in private storage';

    public function handle(): int
    {
        $connection = DB::connection();
        $driver = $connection->getDriverName();
        $tables = $this->extractDatabaseTables($driver);

        $snapshot = [
            'app' => config('app.name'),
            'driver' => $driver,
            'database' => $connection->getDatabaseName(),
            'created_at' => now()->toIso8601String(),
            'table_count' => count($tables),
            'tables' => $tables,
        ];

        $json = json_encode($snapshot, JSON_THROW_ON_ERROR);
        $compressed = gzencode($json, 9);
        if ($compressed === false) {
            $this->error('Failed to compress database snapshot.');

            return self::FAILURE;
        }

        $envelope = json_encode([
            'version' => 1,
            'sha256' => hash('sha256', $compressed),
            'payload' => base64_encode($compressed),
        ], JSON_THROW_ON_ERROR);

        $encrypted = Crypt::encryptString($envelope);

        $backupDir = storage_path('app/private/backups');
        File::ensureDirectoryExists($backupDir, 0700);
        @chmod($backupDir, 0700);

        $htaccessPath = $backupDir.DIRECTORY_SEPARATOR.'.htaccess';
        if (! file_exists($htaccessPath)) {
            File::put($htaccessPath, "Require all denied\n");
        }

        $filename = 'backup_'.now()->format('Ymd_His').'.json.gz.enc';
        $fullPath = $backupDir.DIRECTORY_SEPARATOR.$filename;
        File::put($fullPath, $encrypted);
        @chmod($fullPath, 0600);

        $offsiteDir = $this->option('offsite-path');
        if (is_string($offsiteDir) && trim($offsiteDir) !== '') {
            try {
                File::ensureDirectoryExists($offsiteDir, 0700);
                File::copy($fullPath, rtrim($offsiteDir, '/\\').DIRECTORY_SEPARATOR.$filename);
                $this->info('Off-site encrypted replica written.');
            } catch (Throwable $e) {
                $this->warn('Warning: Off-site replica failed: '.$e->getMessage());
            }
        }

        $keep = max(1, (int) $this->option('keep'));
        $this->pruneOldBackups($backupDir, $keep);

        SecurityLogger::log('database_backup_created', "Encrypted backup {$filename} created ({$snapshot['table_count']} tables)", 'info');
        $this->info("Encrypted backup saved: storage/app/private/backups/{$filename} ({$snapshot['table_count']} tables).");

        return self::SUCCESS;
    }

    private function extractDatabaseTables(string $driver): array
    {
        $tables = [];

        if ($driver === 'sqlite') {
            $rows = DB::select("SELECT name, sql FROM sqlite_master WHERE type = 'table' AND name NOT LIKE 'sqlite_%' ORDER BY name");
            foreach ($rows as $row) {
                $name = $row->name;
                $tables[$name] = [
                    'create_sql' => $row->sql,
                    'rows' => DB::table($name)->get()->map(fn ($r) => (array) $r)->all(),
                ];
            }

            return $tables;
        }

        $rawTables = DB::select('SHOW TABLES');
        foreach ($rawTables as $row) {
            $values = array_values((array) $row);
            $name = (string) ($values[0] ?? '');
            if ($name === '') {
                continue;
            }

            $escaped = str_replace('`', '``', $name);
            $createResult = DB::select("SHOW CREATE TABLE `{$escaped}`");
            $createArr = (array) ($createResult[0] ?? []);
            $createSql = $createArr['Create Table'] ?? null;

            $tables[$name] = [
                'create_sql' => $createSql,
                'rows' => DB::table($name)->get()->map(fn ($r) => (array) $r)->all(),
            ];
        }

        return $tables;
    }

    private function pruneOldBackups(string $backupDir, int $keep): void
    {
        $files = collect(File::files($backupDir))
            ->filter(fn ($f) => str_ends_with($f->getFilename(), '.enc'))
            ->sortByDesc(fn ($f) => $f->getMTime())
            ->values();

        if ($files->count() > $keep) {
            foreach ($files->slice($keep) as $oldFile) {
                @unlink($oldFile->getRealPath());
            }
        }
    }
}

