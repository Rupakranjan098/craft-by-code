<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AboutContent;
use Illuminate\Http\Request;

class AboutContentController extends Controller
{
    public function index()
    {
        $sections = AboutContent::orderBy('order', 'asc')->get();
        return view('admin.about.index', compact('sections'));
    }

    public function edit(AboutContent $about)
    {
        return view('admin.about.form', compact('about'));
    }

    public function update(Request $request, AboutContent $about)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:200',
            'subtitle' => 'nullable|string|max:200',
            'content' => 'nullable|string',
            'is_active' => 'nullable|boolean',
        ]);

        $validated['is_active'] = $request->boolean('is_active');

        // Check if structured data is provided as JSON
        if ($request->filled('data_json')) {
            $decoded = json_decode($request->input('data_json'), true);
            if (json_last_error() === JSON_ERROR_NONE) {
                $validated['data'] = $decoded;
            }
        }

        $about->update($validated);

        return redirect()->route('admin.about.index')->with('success', 'About Us section updated successfully.');
    }
}

