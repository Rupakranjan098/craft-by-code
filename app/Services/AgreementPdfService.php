<?php

namespace App\Services;

use App\Models\Agreement;
use App\Models\AgreementAuditLog;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\StreamedResponse;

class AgreementPdfService
{
    public const DISK = 'local';
    public const DIRECTORY = 'private/agreements/pdfs';

    /**
     * Render the DomPDF instance with safe options and isolated paths
     */
    public function renderDomPdf(Agreement $agreement)
    {
        @mkdir(storage_path('fonts'), 0755, true);
        @mkdir(storage_path('framework/cache'), 0755, true);
        @mkdir(storage_path('app/private/agreements/pdfs'), 0755, true);

        return Pdf::loadView('admin.agreements.pdf', [
            'agreement' => $agreement,
        ])->setPaper('a4', 'portrait')
          ->setOptions([
              'isHtml5ParserEnabled' => true,
              'isRemoteEnabled' => false,
              'defaultFont' => 'Helvetica',
              'fontDir' => storage_path('fonts'),
              'fontCache' => storage_path('fonts'),
              'tempDir' => storage_path('framework/cache'),
              'chroot' => base_path(),
          ]);
    }

    /**
     * Generate official legal PDF document and cache to private storage
     */
    public function generate(Agreement $agreement): Agreement
    {
        $pdf = $this->renderDomPdf($agreement);
        $pdfBytes = $pdf->output();
        $pdfHash = hash('sha256', $pdfBytes);

        $safeNum = Str::slug($agreement->agreement_number);
        $filePath = self::DIRECTORY . '/' . $safeNum . '_' . substr($pdfHash, 0, 16) . '.pdf';

        try {
            Storage::disk(self::DISK)->put($filePath, $pdfBytes);
        } catch (\Throwable $e) {
            Log::warning("Agreement PDF storage write failed: {$e->getMessage()}");
        }

        $agreement->update([
            'pdf_path' => $filePath,
            'pdf_hash' => $pdfHash,
            'pdf_generated_at' => now(),
        ]);

        try {
            AgreementAuditLog::log(
                $agreement,
                'pdf_generated',
                "Compiled official legal PDF document with cryptographic checksum.",
                ['pdf_hash' => $pdfHash, 'file_size' => strlen($pdfBytes)]
            );
        } catch (\Throwable $e) {
            Log::warning("Agreement audit log write failed: {$e->getMessage()}");
        }

        return $agreement;
    }

    /**
     * Download Private PDF Document with bulletproof on-the-fly streaming fallback
     */
    public function download(Agreement $agreement): StreamedResponse
    {
        $filename = $agreement->agreement_number . '.pdf';

        // 1. Try serving existing file from local private storage if present
        try {
            if (! empty($agreement->pdf_path) && Storage::disk(self::DISK)->exists($agreement->pdf_path)) {
                $this->safeLogAudit($agreement, 'pdf_downloaded', "Admin downloaded official agreement PDF.");

                return Storage::disk(self::DISK)->download($agreement->pdf_path, $filename, [
                    'Content-Type' => 'application/pdf',
                    'Cache-Control' => 'no-store, no-cache, must-revalidate, max-age=0',
                    'Pragma' => 'no-cache',
                    'X-Content-Type-Options' => 'nosniff',
                ]);
            }
        } catch (\Throwable $e) {
            Log::warning("Storage disk download read failed, switching to live stream: {$e->getMessage()}");
        }

        // 2. Resilient on-the-fly generation & streamDownload
        $pdf = $this->renderDomPdf($agreement);
        $pdfBytes = $pdf->output();
        $pdfHash = hash('sha256', $pdfBytes);

        // Best effort disk caching
        try {
            $safeNum = Str::slug($agreement->agreement_number);
            $filePath = self::DIRECTORY . '/' . $safeNum . '_' . substr($pdfHash, 0, 16) . '.pdf';
            Storage::disk(self::DISK)->put($filePath, $pdfBytes);

            $agreement->update([
                'pdf_path' => $filePath,
                'pdf_hash' => $pdfHash,
                'pdf_generated_at' => now(),
            ]);
        } catch (\Throwable $e) {
            Log::warning("Agreement PDF disk cache write failed: {$e->getMessage()}");
        }

        $this->safeLogAudit($agreement, 'pdf_downloaded', "Admin downloaded official agreement PDF.");

        return response()->streamDownload(function () use ($pdfBytes) {
            echo $pdfBytes;
        }, $filename, [
            'Content-Type' => 'application/pdf',
            'Content-Length' => strlen($pdfBytes),
            'Cache-Control' => 'no-store, no-cache, must-revalidate, max-age=0',
            'Pragma' => 'no-cache',
            'X-Content-Type-Options' => 'nosniff',
        ]);
    }

    /**
     * View Private PDF Document in inline browser reader with on-the-fly streaming fallback
     */
    public function stream(Agreement $agreement): StreamedResponse
    {
        $filename = $agreement->agreement_number . '.pdf';

        // 1. Try serving from disk if available
        try {
            if (! empty($agreement->pdf_path) && Storage::disk(self::DISK)->exists($agreement->pdf_path)) {
                $this->safeLogAudit($agreement, 'pdf_viewed', "Admin viewed / streamed agreement PDF in secure reader.");

                return Storage::disk(self::DISK)->response($agreement->pdf_path, $filename, [
                    'Content-Type' => 'application/pdf',
                    'Content-Disposition' => 'inline; filename="' . $filename . '"',
                    'Cache-Control' => 'no-store, no-cache, must-revalidate, max-age=0',
                    'Pragma' => 'no-cache',
                    'X-Content-Type-Options' => 'nosniff',
                ]);
            }
        } catch (\Throwable $e) {
            Log::warning("Storage disk stream read failed, switching to live stream: {$e->getMessage()}");
        }

        // 2. Resilient live compilation
        $pdf = $this->renderDomPdf($agreement);
        $pdfBytes = $pdf->output();

        try {
            $pdfHash = hash('sha256', $pdfBytes);
            $safeNum = Str::slug($agreement->agreement_number);
            $filePath = self::DIRECTORY . '/' . $safeNum . '_' . substr($pdfHash, 0, 16) . '.pdf';
            Storage::disk(self::DISK)->put($filePath, $pdfBytes);

            $agreement->update([
                'pdf_path' => $filePath,
                'pdf_hash' => $pdfHash,
                'pdf_generated_at' => now(),
            ]);
        } catch (\Throwable $e) {
            Log::warning("Agreement PDF disk cache write failed: {$e->getMessage()}");
        }

        $this->safeLogAudit($agreement, 'pdf_viewed', "Admin viewed / streamed agreement PDF in secure reader.");

        return response()->stream(function () use ($pdfBytes) {
            echo $pdfBytes;
        }, 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="' . $filename . '"',
            'Content-Length' => strlen($pdfBytes),
            'Cache-Control' => 'no-store, no-cache, must-revalidate, max-age=0',
            'Pragma' => 'no-cache',
            'X-Content-Type-Options' => 'nosniff',
        ]);
    }

    /**
     * Safely log audit events without interrupting document downloads
     */
    protected function safeLogAudit(Agreement $agreement, string $action, string $details): void
    {
        try {
            AgreementAuditLog::log($agreement, $action, $details);
        } catch (\Throwable $e) {
            Log::warning("Audit log event '{$action}' failed to save: {$e->getMessage()}");
        }
    }
}
