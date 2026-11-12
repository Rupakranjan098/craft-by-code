<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\WebsiteSetting;
use App\Security\SecurityLogger;
use App\Security\UrlValidator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SeoController extends Controller
{
    public const DEFAULT_FIELDS = [
        'meta_title_default' => [
            'value' => 'CraftByCode | MVP, SaaS & Custom Software Development for Global Startups',
            'type' => 'text',
            'label' => 'Default Meta Title (Global Startups)',
        ],
        'meta_description_default' => [
            'value' => 'CraftByCode partners with global startups and scale-ups to design, build, and launch scalable SaaS platforms, MVPs, web & mobile apps, DevOps cloud infrastructure, and AI automation.',
            'type' => 'textarea',
            'label' => 'Default Meta Description',
        ],
        'meta_keywords_default' => [
            'value' => 'startup software development, MVP development agency, SaaS product engineering, custom web application development, DevOps cloud engineering, AI automation for startups',
            'type' => 'text',
            'label' => 'Default Target Keywords',
        ],
        'google_site_verification' => [
            'value' => '',
            'type' => 'text',
            'label' => 'Google Search Console Meta Verification Token (content attribute only)',
        ],
        'ga4_measurement_id' => [
            'value' => '',
            'type' => 'text',
            'label' => 'Google Analytics 4 Measurement ID (e.g. G-XXXXXXXXXX)',
        ],
        'seo_og_image' => [
            'value' => 'assets/images/logo-transparent.png',
            'type' => 'text',
            'label' => 'Default Open Graph Social Share Image Path or URL',
        ],
    ];

    public function index()
    {
        $existing = WebsiteSetting::where('group', 'seo')->get()->keyBy('key');
        $settings = collect();

        foreach (self::DEFAULT_FIELDS as $key => $meta) {
            if ($existing->has($key)) {
                $settings->push($existing->get($key));
            } else {
                $settings->push(new WebsiteSetting([
                    'group' => 'seo',
                    'key' => $key,
                    'value' => $meta['value'],
                    'type' => $meta['type'],
                    'label' => $meta['label'],
                ]));
            }
        }

        foreach ($existing as $key => $item) {
            if (! array_key_exists($key, self::DEFAULT_FIELDS)) {
                $settings->push($item);
            }
        }

        return view('admin.seo.index', compact('settings'));
    }

    public function update(Request $request)
    {
        $allowedKeys = array_unique(array_merge(
            array_keys(self::DEFAULT_FIELDS),
            WebsiteSetting::where('group', 'seo')->pluck('key')->all()
        ));

        foreach ($allowedKeys as $key) {
            if (! $request->has($key)) {
                continue;
            }

            $value = $request->input($key);
            if (! is_string($value) && $value !== null) {
                continue;
            }

            $clean = trim((string) ($value ?? ''));

            if ($key === 'google_site_verification' && $clean !== '' && ! preg_match('/^[A-Za-z0-9_\-]{10,128}$/', $clean)) {
                return back()->withInput()->withErrors([
                    $key => 'Enter only the Google Search Console verification token string (letters, numbers, "_" or "-"), not the full <meta> tag.',
                ]);
            }

            if ($key === 'ga4_measurement_id' && $clean !== '') {
                $clean = strtoupper($clean);
                if (! preg_match('/^G-[A-Z0-9]{6,20}$/', $clean)) {
                    return back()->withInput()->withErrors([
                        $key => 'Google Analytics 4 Measurement ID must match format G-XXXXXXXXXX.',
                    ]);
                }
            }

            if ($key === 'seo_og_image' && $clean !== '') {
                $isRelative = str_starts_with($clean, '/') || str_starts_with($clean, 'assets/') || str_starts_with($clean, 'media/');
                if (! $isRelative && ! UrlValidator::isSafeHttpUrl($clean)) {
                    return back()->withInput()->withErrors([
                        $key => 'Open Graph image must be a valid local path or safe http(s) URL.',
                    ]);
                }
            }

            if (mb_strlen($clean) > 1000) {
                return back()->withInput()->withErrors([$key => 'SEO setting value is too long (max 1000 characters).']);
            }

            $meta = self::DEFAULT_FIELDS[$key] ?? null;
            WebsiteSetting::updateOrCreate(
                ['key' => $key],
                [
                    'group' => 'seo',
                    'value' => $clean,
                    'type' => $meta['type'] ?? 'text',
                    'label' => $meta['label'] ?? ucwords(str_replace('_', ' ', $key)),
                ]
            );
        }

        WebsiteSetting::clearSettingCache();
        SecurityLogger::log('seo_updated', 'Updated SEO settings', 'info', Auth::user(), $request);

        return back()->with('success', 'SEO settings updated successfully.');
    }
}
