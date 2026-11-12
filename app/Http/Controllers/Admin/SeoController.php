<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\WebsiteSetting;
use App\Security\SecurityLogger;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SeoController extends Controller
{
    public function index()
    {
        $settings = WebsiteSetting::where('group', 'seo')->get();

        return view('admin.seo.index', compact('settings'));
    }

    public function update(Request $request)
    {
        $allowedKeys = WebsiteSetting::where('group', 'seo')->pluck('key')->all();

        foreach ($allowedKeys as $key) {
            if (! $request->has($key)) {
                continue;
            }

            $value = $request->input($key);
            if (! is_string($value) && $value !== null) {
                continue;
            }

            $clean = trim((string) ($value ?? ''));
            if (mb_strlen($clean) > 1000) {
                return back()->withInput()->withErrors([$key => 'SEO setting value is too long (max 1000 characters).']);
            }

            WebsiteSetting::set($key, $clean, 'seo');
        }

        WebsiteSetting::clearSettingCache();
        SecurityLogger::log('seo_updated', 'Updated SEO settings', 'info', Auth::user(), $request);

        return back()->with('success', 'SEO settings updated successfully.');
    }
}
