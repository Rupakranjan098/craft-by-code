<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\WebsiteSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class WebsiteSettingController extends Controller
{
    /**
     * Display settings list by group
     */
    public function index(Request $request)
    {
        $group = $request->input('group', 'general');
        $settings = WebsiteSetting::where('group', $group)->get()->keyBy('key');
        $allGroups = ['general', 'hero', 'stats', 'contact', 'social', 'cta'];

        return view('admin.settings.index', compact('settings', 'group', 'allGroups'));
    }

    /**
     * Update website settings & branding assets
     */
    public function update(Request $request)
    {
        $group = $request->input('group', 'general');

        // Handle Branding file uploads if on 'general' group
        if ($group === 'general') {
            $uploadMap = [
                'site_logo_file' => 'site_logo',
                'site_logo_dark_file' => 'site_logo_dark',
                'site_logo_icon_file' => 'site_logo_icon',
                'site_logo_full_file' => 'site_logo_full',
            ];

            foreach ($uploadMap as $fileField => $settingKey) {
                if ($request->hasFile($fileField)) {
                    $file = $request->file($fileField);
                    $filename = Str::slug($settingKey) . '_' . time() . '.' . $file->getClientOriginalExtension();
                    $destinationPath = public_path('uploads/branding');
                    
                    if (!file_exists($destinationPath)) {
                        mkdir($destinationPath, 0755, true);
                    }

                    $file->move($destinationPath, $filename);
                    $assetUrl = '/uploads/branding/' . $filename;
                    WebsiteSetting::set($settingKey, $assetUrl, 'general', null, 'image');
                }
            }
        }

        // Process all other input fields
        $excludedKeys = [
            '_token',
            'group',
            'site_logo_file',
            'site_logo_dark_file',
            'site_logo_icon_file',
            'site_logo_full_file'
        ];

        $data = $request->except($excludedKeys);

        foreach ($data as $key => $value) {
            // Determine type if not already known
            $type = strlen($value) > 120 ? 'textarea' : 'text';
            if ($key === 'logo_display_mode') {
                $type = 'select';
            }
            WebsiteSetting::set($key, $value, $group, null, $type);
        }

        WebsiteSetting::clearSettingCache();

        return redirect()->route('admin.settings.index', ['group' => $group])
            ->with('success', 'Website settings & branding updated dynamically.');
    }

    /**
     * Reset logo branding to default system assets
     */
    public function resetLogo()
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

        return redirect()->route('admin.settings.index', ['group' => 'general'])
            ->with('success', 'Logo branding restored to default official design.');
    }
}
