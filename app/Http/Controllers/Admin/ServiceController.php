<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ServiceController extends Controller
{
    public function index(Request $request)
    {
        $query = Service::query();

        if ($request->filled('search')) {
            $s = $request->input('search');
            $query->where('title', 'like', "%{$s}%")->orWhere('short_description', 'like', "%{$s}%");
        }

        $services = $query->orderBy('order', 'asc')->paginate(10)->withQueryString();

        return view('admin.services.index', compact('services'));
    }

    public function create()
    {
        return view('admin.services.form', ['service' => new Service()]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:200',
            'slug' => 'nullable|string|max:200|unique:services,slug',
            'icon' => 'required|string|max:50',
            'badge' => 'nullable|string|max:50',
            'short_description' => 'required|string|max:500',
            'full_description' => 'required|string',
            'features' => 'nullable|string',
            'benefits' => 'nullable|string',
            'tech_stack' => 'nullable|string',
            'order' => 'nullable|integer',
            'is_featured' => 'nullable|boolean',
            'is_active' => 'nullable|boolean',
            'meta_title' => 'nullable|string|max:200',
            'meta_description' => 'nullable|string|max:500',
        ]);

        $validated['slug'] = !empty($validated['slug']) ? Str::slug($validated['slug']) : Str::slug($validated['title']);
        $validated['features'] = !empty($request->input('features')) ? array_filter(array_map('trim', explode("\n", $request->input('features')))) : [];
        $validated['benefits'] = !empty($request->input('benefits')) ? array_filter(array_map('trim', explode("\n", $request->input('benefits')))) : [];
        $validated['tech_stack'] = !empty($request->input('tech_stack')) ? array_filter(array_map('trim', explode(",", $request->input('tech_stack')))) : [];
        $validated['is_featured'] = $request->boolean('is_featured');
        $validated['is_active'] = $request->boolean('is_active');
        $validated['order'] = $validated['order'] ?? 0;

        Service::create($validated);

        return redirect()->route('admin.services.index')->with('success', 'Service created successfully.');
    }

    public function edit(Service $service)
    {
        return view('admin.services.form', compact('service'));
    }

    public function update(Request $request, Service $service)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:200',
            'slug' => 'nullable|string|max:200|unique:services,slug,' . $service->id,
            'icon' => 'required|string|max:50',
            'badge' => 'nullable|string|max:50',
            'short_description' => 'required|string|max:500',
            'full_description' => 'required|string',
            'features' => 'nullable|string',
            'benefits' => 'nullable|string',
            'tech_stack' => 'nullable|string',
            'order' => 'nullable|integer',
            'is_featured' => 'nullable|boolean',
            'is_active' => 'nullable|boolean',
            'meta_title' => 'nullable|string|max:200',
            'meta_description' => 'nullable|string|max:500',
        ]);

        $validated['slug'] = !empty($validated['slug']) ? Str::slug($validated['slug']) : Str::slug($validated['title']);
        $validated['features'] = !empty($request->input('features')) ? array_filter(array_map('trim', explode("\n", $request->input('features')))) : [];
        $validated['benefits'] = !empty($request->input('benefits')) ? array_filter(array_map('trim', explode("\n", $request->input('benefits')))) : [];
        $validated['tech_stack'] = !empty($request->input('tech_stack')) ? array_filter(array_map('trim', explode(",", $request->input('tech_stack')))) : [];
        $validated['is_featured'] = $request->boolean('is_featured');
        $validated['is_active'] = $request->boolean('is_active');
        $validated['order'] = $validated['order'] ?? 0;

        $service->update($validated);

        return redirect()->route('admin.services.index')->with('success', 'Service updated successfully.');
    }

    public function destroy(Service $service)
    {
        $service->delete();
        return redirect()->route('admin.services.index')->with('success', 'Service removed.');
    }
}

