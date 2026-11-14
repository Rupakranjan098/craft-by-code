<?php

namespace App\Services;

use App\Models\Agreement;
use App\Models\AgreementAuditLog;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\StreamedResponse;

class AgreementPdfService
{
    public const DISK = 'local';
    public const DIRECTORY = 'private/agreements/pdfs';

    public function generate(Agreement $agreement): Agreement
    {
        $pdf = Pdf::loadView('admin.agreements.pdf', [
            'agreement' => $agreement,
        ])->setPaper('a4', 'portrait')
          ->setOption([
              'isHtml5ParserEnabled' => true,
              'isRemoteEnabled' => false,
              'defaultFont' => 'Helvetica',
          ]);

        $pdfBytes = $pdf->output();
        $pdfHash = hash('sha256', $pdfBytes);

        $safeNum = Str::slug($agreement->agreement_number);
        $filePath = self::DIRECTORY . '/' . $safeNum . '_' . substr($pdfHash, 0, 16) . '.pdf';

        Storage::disk(self::DISK)->put($filePath, $pdfBytes);

        $agreement->update([
            'pdf_path' => $filePath,
            'pdf_hash' => $pdfHash,
            'pdf_generated_at' => now(),
        ]);

        AgreementAuditLog::log(
            $agreement,
            'pdf_generated',
            "Compiled official legal PDF document with cryptographic checksum.",
            ['pdf_hash' => $pdfHash, 'file_size' => strlen($pdfBytes)]
        );

        return $agreement;
    }

    public function download(Agreement $agreement): StreamedResponse
    {
        if (empty($agreement->pdf_path) || ! Storage::disk(self::DISK)->exists($agreement->pdf_path)) {
            $this->generate($agreement);
        }

        AgreementAuditLog::log(
            $agreement,
            'pdf_downloaded',
            "Admin downloaded official agreement PDF."
        );

        $filename = $agreement->agreement_number . '.pdf';

        return Storage::disk(self::DISK)->download($agreement->pdf_path, $filename, [
            'Content-Type' => 'application/pdf',
            'Cache-Control' => 'no-store, no-cache, must-revalidate, max-age=0',
            'Pragma' => 'no-cache',
            'X-Content-Type-Options' => 'nosniff',
        ]);
    }

    public function stream(Agreement $agreement): StreamedResponse
    {
        if (empty($agreement->pdf_path) || ! Storage::disk(self::DISK)->exists($agreement->pdf_path)) {
            $this->generate($agreement);
        }

        AgreementAuditLog::log(
            $agreement,
            'pdf_viewed',
            "Admin viewed / streamed agreement PDF in secure reader."
        );

        return Storage::disk(self::DISK)->response($agreement->pdf_path, $agreement->agreement_number . '.pdf', [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="' . $agreement->agreement_number . '.pdf"',
            'Cache-Control' => 'no-store, no-cache, must-revalidate, max-age=0',
            'Pragma' => 'no-cache',
            'X-Content-Type-Options' => 'nosniff',
        ]);
    }
}

