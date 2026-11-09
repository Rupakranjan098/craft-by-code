<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\WebsiteSetting;
use Illuminate\Http\Request;

class SeoController extends Controller
{
    public function index()
    {
        $settings = WebsiteSetting::where('group', 'seo')->get();
        return view('admin.seo.index', compact('settings'));
    }

    public function update(Request $request)
    {
        $data = $request->except(['_token']);
        foreach ($data as $key => $value) {
            WebsiteSetting::set($key, $value, 'seo');
        }
        WebsiteSetting::clearSettingCache();

        return back()->with('success', 'SEO settings updated successfully.');
    }
}

