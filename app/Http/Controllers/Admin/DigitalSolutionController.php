<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DigitalSolution;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class DigitalSolutionController extends Controller
{
    public function index(Request $request)
    {
        $query = DigitalSolution::query();
        if ($request->filled('search')) {
            $s = $request->input('search');
            $query->where('title', 'like', "%{$s}%")->orWhere('short_description', 'like', "%{$s}%");
        }
        $solutions = $query->orderBy('order', 'asc')->paginate(10)->withQueryString();
        return view('admin.solutions.index', compact('solutions'));
    }

    public function create()
    {
        return view('admin.solutions.form', ['solution' => new DigitalSolution()]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:200',
            'slug' => 'nullable|string|max:200|unique:digital_solutions,slug',
            'icon' => 'required|string|max:50',
            'category' => 'nullable|string|max:100',
            'short_description' => 'required|string|max:500',
            'full_description' => 'required|string',
            'features' => 'nullable|string',
            'benefits' => 'nullable|string',
            'technologies' => 'nullable|string',
            'order' => 'nullable|integer',
            'is_active' => 'nullable|boolean',
        ]);

        $validated['slug'] = !empty($validated['slug']) ? Str::slug($validated['slug']) : Str::slug($validated['title']);
        $validated['features'] = !empty($request->input('features')) ? array_filter(array_map('trim', explode("\n", $request->input('features')))) : [];
        $validated['benefits'] = !empty($request->input('benefits')) ? array_filter(array_map('trim', explode("\n", $request->input('benefits')))) : [];
        $validated['technologies'] = !empty($request->input('technologies')) ? array_filter(array_map('trim', explode(",", $request->input('technologies')))) : [];
        $validated['is_active'] = $request->boolean('is_active');
        $validated['order'] = $validated['order'] ?? 0;

        DigitalSolution::create($validated);

        return redirect()->route('admin.solutions.index')->with('success', 'Digital Solution created successfully.');
    }

    public function edit(DigitalSolution $solution)
    {
        return view('admin.solutions.form', compact('solution'));
    }

    public function update(Request $request, DigitalSolution $solution)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:200',
            'slug' => 'nullable|string|max:200|unique:digital_solutions,slug,' . $solution->id,
            'icon' => 'required|string|max:50',
            'category' => 'nullable|string|max:100',
            'short_description' => 'required|string|max:500',
            'full_description' => 'required|string',
            'features' => 'nullable|string',
            'benefits' => 'nullable|string',
            'technologies' => 'nullable|string',
            'order' => 'nullable|integer',
            'is_active' => 'nullable|boolean',
        ]);

        $validated['slug'] = !empty($validated['slug']) ? Str::slug($validated['slug']) : Str::slug($validated['title']);
        $validated['features'] = !empty($request->input('features')) ? array_filter(array_map('trim', explode("\n", $request->input('features')))) : [];
        $validated['benefits'] = !empty($request->input('benefits')) ? array_filter(array_map('trim', explode("\n", $request->input('benefits')))) : [];
        $validated['technologies'] = !empty($request->input('technologies')) ? array_filter(array_map('trim', explode(",", $request->input('technologies')))) : [];
        $validated['is_active'] = $request->boolean('is_active');
        $validated['order'] = $validated['order'] ?? 0;

        $solution->update($validated);

        return redirect()->route('admin.solutions.index')->with('success', 'Digital Solution updated.');
    }

    public function destroy(DigitalSolution $solution)
    {
        $solution->delete();
        return redirect()->route('admin.solutions.index')->with('success', 'Digital Solution removed.');
    }
}

