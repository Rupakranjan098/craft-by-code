# Security Backup & Disaster Recovery Runbook

This application includes automated, encrypted database snapshotting and integrity-verified restoration via Artisan CLI and the Admin Security Center.

## 1. Encryption & Storage Architecture
- **Algorithm:** Authenticated AES-256-CBC + HMAC-SHA256 (`Illuminate\Support\Facades\Crypt`) wrapped around a gzipped JSON snapshot containing a SHA-256 integrity checksum.
- **Vault Location:** `storage/app/private/backups/*.json.gz.enc` (`0700` directory, `0600` file permissions, blocked from web access by `.htaccess` and Laravel routing).
- **Schedule:** Configured in `routes/console.php` to run daily at `02:30` server time with 14-day local retention (`php artisan security:backup --keep=14`).

## 2. Critical Key Backup Requirement
Encrypted backups require your production `APP_KEY` to decrypt. Store a copy of `APP_KEY` in a hardware/vault password manager or cloud KMS **separate** from your server filesystem. Without `APP_KEY`, encrypted `.enc` backups cannot be recovered.

## 3. Off-Site Replication Setup
Run the backup command with `--offsite-path=/mnt/offsite-backups` (or configure an external rsync/S3/Restic sync pushing `storage/app/private/backups/*.enc` to an encrypted off-site bucket):

```sh
php artisan security:backup --keep=14 --offsite-path=/path/to/mounted/offsite/vault
```

## 4. Verifying a Backup Without Modifying Data
Run integrity verification regularly (recommended monthly DR drill):

```sh
php artisan security:restore --verify-only
```

To verify a specific snapshot:

```sh
php artisan security:restore backup_YYYYMMDD_HHMMSS.json.gz.enc --verify-only
```

## 5. Disaster Recovery Procedure
1. Provision fresh server / clean Laravel deployment with exact `.env` (including original `APP_KEY`).
2. Run schema migrations first:
   ```sh
   php artisan migrate --force
   ```
3. Restore encrypted snapshot:
   ```sh
   php artisan security:restore backup_YYYYMMDD_HHMMSS.json.gz.enc --force
   ```
4. Verify site routes, administrator 2FA login, and uploaded files under `storage/app/uploads/`.
5. Rotate credentials/API tokens if the recovery followed a suspected compromise (`Admin -> Security Center`).

