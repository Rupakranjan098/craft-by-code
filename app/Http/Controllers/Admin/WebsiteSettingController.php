<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\WebsiteSetting;
use App\Security\SecureFileUpload;
use App\Security\SecurityLogger;
use App\Security\UrlValidator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WebsiteSettingController extends Controller
{
    private const ALLOWED_GROUPS = ['general', 'hero', 'stats', 'contact', 'social', 'cta'];

    private const GENERAL_ALLOWLIST = [
        'brand_name',
        'logo_display_mode',
        'brand_tagline',
        'brand_sub_tagline',
        'brand_badge',
        'site_description',
    ];

    /**
     * Display settings list by group
     */
    public function index(Request $request)
    {
        $requestedGroup = (string) $request->input('group', 'general');
        $group = in_array($requestedGroup, self::ALLOWED_GROUPS, true) ? $requestedGroup : 'general';

        $settings = WebsiteSetting::where('group', $group)->get()->keyBy('key');
        $allGroups = self::ALLOWED_GROUPS;

        return view('admin.settings.index', compact('settings', 'group', 'allGroups'));
    }

    /**
     * Update allowlisted website settings & securely uploaded branding assets
     */
    public function update(Request $request)
    {
        $requestedGroup = (string) $request->input('group', 'general');
        if (! in_array($requestedGroup, self::ALLOWED_GROUPS, true)) {
            abort(403, 'Invalid settings group.');
        }

        $group = $requestedGroup;

        if ($group === 'general') {
            $request->validate([
                'site_logo_file' => 'nullable|file|max:2048|mimes:jpg,jpeg,png,webp',
                'site_logo_dark_file' => 'nullable|file|max:2048|mimes:jpg,jpeg,png,webp',
                'site_logo_icon_file' => 'nullable|file|max:2048|mimes:jpg,jpeg,png,webp',
                'site_logo_full_file' => 'nullable|file|max:2048|mimes:jpg,jpeg,png,webp',
            ]);

            $uploadMap = [
                'site_logo_file' => 'site_logo',
                'site_logo_dark_file' => 'site_logo_dark',
                'site_logo_icon_file' => 'site_logo_icon',
                'site_logo_full_file' => 'site_logo_full',
            ];

            foreach ($uploadMap as $fileField => $settingKey) {
                if ($request->hasFile($fileField)) {
                    $previous = WebsiteSetting::get($settingKey);
                    $assetUrl = SecureFileUpload::storeImage($request->file($fileField), 'branding', 2048);
                    WebsiteSetting::set($settingKey, $assetUrl, 'general', null, 'image');
                    SecureFileUpload::deleteManagedFile(is_string($previous) ? $previous : null);
                }
            }
        }

        $allowedKeys = WebsiteSetting::where('group', $group)->pluck('key')->all();
        if ($group === 'general') {
            $allowedKeys = array_values(array_unique(array_merge($allowedKeys, self::GENERAL_ALLOWLIST)));
        }

        foreach ($allowedKeys as $key) {
            if (! $request->has($key)) {
                continue;
            }

            $rawValue = $request->input($key);
            if (! is_string($rawValue) && $rawValue !== null) {
                continue;
            }

            $value = $rawValue !== null ? trim($rawValue) : '';

            if (mb_strlen($value) > 4000) {
                return back()->withInput()->withErrors([$key => "The {$key} value exceeds the maximum allowed length."]);
            }

            if ($key === 'logo_display_mode' && ! in_array($value, ['horizontal_logo', 'icon_only', 'text_only', 'icon_and_text'], true)) {
                return back()->withInput()->withErrors([$key => 'Invalid logo display mode selected.']);
            }

            if ($key === 'google_maps_embed' && $value !== '' && ! UrlValidator::isSafeGoogleMapsEmbedUrl($value)) {
                SecurityLogger::log('unsafe_url_blocked', 'Blocked untrusted iframe URL in google_maps_embed setting', 'high', Auth::user(), $request);

                return back()->withInput()->withErrors([$key => 'Google Maps embed URL must use HTTPS and originate from www.google.com or maps.google.com.']);
            }

            if ((str_starts_with($key, 'social_') || str_ends_with($key, '_url')) && $value !== '' && ! UrlValidator::isSafeDisplayLink($value)) {
                SecurityLogger::log('unsafe_url_blocked', "Blocked unsafe URL scheme in setting '{$key}'", 'high', Auth::user(), $request);

                return back()->withInput()->withErrors([$key => 'URL must use a safe http://, https://, or relative application path.']);
            }

            $type = mb_strlen($value) > 120 ? 'textarea' : 'text';
            if ($key === 'logo_display_mode') {
                $type = 'select';
            }

            WebsiteSetting::set($key, $value, $group, null, $type);
        }

        WebsiteSetting::clearSettingCache();
        SecurityLogger::log('settings_updated', "Updated website settings group '{$group}'", 'info', Auth::user(), $request);

        return redirect()->route('admin.settings.index', ['group' => $group])
            ->with('success', 'Website settings & branding updated dynamically.');
    }

    /**
     * Reset logo branding to default system assets
     */
    public function resetLogo(Request $request)
    {
        WebsiteSetting::set('site_logo', '/assets/images/logo-horizontal.png', 'general', 'Primary Website Logo', 'image');
        WebsiteSetting::set('site_logo_dark', '/assets/images/logo-horizontal-dark.png', 'general', 'Dark Mode Logo', 'image');
        WebsiteSetting::set('site_logo_icon', '/assets/images/logo-icon-transparent.png', 'general', 'Logo Icon / Favicon', 'image');
        WebsiteSetting::set('site_logo_full', '/assets/images/logo.png', 'general', 'Full Graphic Logo Badge', 'image');
        WebsiteSetting::set('brand_name', 'craft by code', 'general', 'Company Brand Name', 'text');
        WebsiteSetting::set('brand_tagline', 'CODE • DESIGN • SOLVE • INNOVATE', 'general', 'Primary Brand Tagline', 'text');
        WebsiteSetting::set('brand_sub_tagline', 'UI/UX • DEVELOPMENT • CREATIVE SOLUTIONS', 'general', 'Sub-Tagline / Specializations', 'text');
        WebsiteSetting::set('logo_display_mode', 'horizontal_logo', 'general', 'Logo Display Mode', 'select');

        WebsiteSetting::clearSettingCache();
        SecurityLogger::log('branding_reset', 'Reset website branding assets to defaults', 'warning', Auth::user(), $request);

        return redirect()->route('admin.settings.index', ['group' => 'general'])
            ->with('success', 'Logo branding restored to default official design.');
    }
}
