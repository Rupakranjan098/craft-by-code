<?php

namespace App\Security;

class UrlValidator
{
    /**
     * Ensures redirect target is a strict internal application path (defeats Open Redirect / phishing).
     */
    public static function isSafeInternalRedirect(?string $target): bool
    {
        if (! is_string($target)) {
            return false;
        }

        $trimmed = trim($target);
        if ($trimmed === '' || preg_match('/[\x00-\x1F\x7F\\\\]/', $trimmed)) {
            return false;
        }

        if (! str_starts_with($trimmed, '/') || str_starts_with($trimmed, '//')) {
            return false;
        }

        $parsed = parse_url($trimmed);
        if ($parsed === false || isset($parsed['scheme']) || isset($parsed['host']) || isset($parsed['user'])) {
            return false;
        }

        return true;
    }

    public static function sanitizeInternalRedirect(?string $target, string $fallback): string
    {
        return self::isSafeInternalRedirect($target) ? trim((string) $target) : $fallback;
    }

    /**
     * Validates external or contact URLs, strictly blocking javascript:/data:/vbscript:/file:.
     */
    public static function isSafeHttpUrl(?string $url, bool $allowMailtoTel = false): bool
    {
        if (! is_string($url)) {
            return false;
        }

        $trimmed = trim($url);
        if ($trimmed === '' || preg_match('/[\x00-\x1F\x7F]/', $trimmed)) {
            return false;
        }

        $parsed = parse_url($trimmed);
        if ($parsed === false || empty($parsed['scheme'])) {
            return false;
        }

        $scheme = strtolower($parsed['scheme']);
        $allowed = $allowMailtoTel ? ['https', 'http', 'mailto', 'tel'] : ['https', 'http'];

        if (! in_array($scheme, $allowed, true)) {
            return false;
        }

        if (in_array($scheme, ['http', 'https'], true)) {
            return ! empty($parsed['host']);
        }

        return true;
    }

    public static function isSafeMediaPath(?string $url): bool
    {
        if (! is_string($url)) {
            return false;
        }

        $trimmed = trim($url);
        if ($trimmed === '' || preg_match('/[\x00-\x1F\x7F\\\\]/', $trimmed)) {
            return false;
        }

        if (str_starts_with($trimmed, '/') && ! str_starts_with($trimmed, '//')) {
            return true;
        }

        return self::isSafeHttpUrl($trimmed, false);
    }

    public static function isSafeDisplayLink(?string $url): bool
    {
        if (! is_string($url)) {
            return false;
        }

        $trimmed = trim($url);
        if ($trimmed === '' || preg_match('/[\x00-\x1F\x7F\\\\]/', $trimmed)) {
            return false;
        }

        if (str_starts_with($trimmed, '#')) {
            return true;
        }

        if (str_starts_with($trimmed, '/') && ! str_starts_with($trimmed, '//')) {
            return true;
        }

        return self::isSafeHttpUrl($trimmed, true);
    }

    /**
     * Restricts map iframe sources exclusively to official HTTPS Google Maps embed URLs.
     */
    public static function isSafeGoogleMapsEmbedUrl(?string $url): bool
    {
        if (! is_string($url)) {
            return false;
        }

        $trimmed = trim($url);
        $parsed = parse_url($trimmed);
        if ($parsed === false || strtolower((string) ($parsed['scheme'] ?? '')) !== 'https') {
            return false;
        }

        $host = strtolower((string) ($parsed['host'] ?? ''));
        if (! in_array($host, ['www.google.com', 'maps.google.com'], true)) {
            return false;
        }

        $path = (string) ($parsed['path'] ?? '');
        $query = (string) ($parsed['query'] ?? '');

        return str_starts_with($path, '/maps/embed')
            || (str_starts_with($path, '/maps') && str_contains($query, 'output=embed'));
    }

    /**
     * Escapes LIKE pattern wildcards before binding in parameterized SQL LIKE queries.
     */
    public static function escapeLike(string $term): string
    {
        return addcslashes($term, "\\%_");
    }
}

