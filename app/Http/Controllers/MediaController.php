<?php

namespace App\Http\Controllers;

use App\Security\SecureFileUpload;
use App\Security\SecurityLogger;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class MediaController extends Controller
{
    private const MIME_TYPES = [
        'jpg' => 'image/jpeg',
        'jpeg' => 'image/jpeg',
        'png' => 'image/png',
        'webp' => 'image/webp',
    ];

    public function show(Request $request, string $category, string $filename): BinaryFileResponse
    {
        if (! in_array($category, SecureFileUpload::ALLOWED_CATEGORIES, true)) {
            SecurityLogger::log('path_traversal_blocked', 'Blocked media request to invalid category', 'high', null, $request, [
                'category' => $category,
            ]);
            abort(404);
        }

        if (! preg_match('/^[a-f0-9\-]{36}\.(jpg|jpeg|png|webp)$/i', $filename, $matches)) {
            SecurityLogger::log('path_traversal_blocked', 'Blocked invalid media filename pattern', 'high', null, $request, [
                'filename' => $filename,
            ]);
            abort(404);
        }

        $baseDir = realpath(storage_path('app/uploads/'.$category));
        if (! $baseDir) {
            abort(404);
        }

        $resolved = realpath($baseDir.DIRECTORY_SEPARATOR.$filename);
        if (! $resolved || ! str_starts_with($resolved, $baseDir.DIRECTORY_SEPARATOR) || ! is_file($resolved)) {
            abort(404);
        }

        $ext = strtolower($matches[1]);
        $mime = self::MIME_TYPES[$ext] ?? 'application/octet-stream';

        return response()->file($resolved, [
            'Content-Type' => $mime,
            'X-Content-Type-Options' => 'nosniff',
            'Cache-Control' => 'public, max-age=604800, immutable',
        ]);
    }
}

