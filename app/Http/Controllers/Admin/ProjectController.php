<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProjectController extends Controller
{
    public function index(Request $request)
    {
        $query = Project::query();
        if ($request->filled('search')) {
            $s = $request->input('search');
            $query->where('title', 'like', "%{$s}%")->orWhere('category', 'like', "%{$s}%");
        }
        $projects = $query->orderBy('order', 'asc')->paginate(10)->withQueryString();
        return view('admin.projects.index', compact('projects'));
    }

    public function create()
    {
        return view('admin.projects.form', ['project' => new Project()]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:200',
            'slug' => 'nullable|string|max:200|unique:projects,slug',
            'category' => 'required|string|max:100',
            'client_name' => 'nullable|string|max:150',
            'image_file' => 'nullable|image|max:4096',
            'image' => 'nullable|string',
            'summary' => 'required|string|max:500',
            'description' => 'nullable|string',
            'challenge' => 'nullable|string',
            'solution' => 'nullable|string',
            'results' => 'nullable|string',
            'technologies' => 'nullable|string',
            'project_url' => 'nullable|string|max:255',
            'order' => 'nullable|integer',
            'is_featured' => 'nullable|boolean',
            'is_active' => 'nullable|boolean',
        ]);

        if ($request->hasFile('image_file')) {
            $file = $request->file('image_file');
            $filename = time() . '_' . Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME)) . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('assets/images/projects'), $filename);
            $validated['image'] = '/assets/images/projects/' . $filename;
        } elseif (empty($validated['image'])) {
            $validated['image'] = '/assets/images/projects/project-analytics.jpg';
        }

        $validated['slug'] = !empty($validated['slug']) ? Str::slug($validated['slug']) : Str::slug($validated['title']);
        $validated['technologies'] = !empty($request->input('technologies')) ? array_filter(array_map('trim', explode(",", $request->input('technologies')))) : [];
        $validated['is_featured'] = $request->boolean('is_featured');
        $validated['is_active'] = $request->boolean('is_active');
        $validated['order'] = $validated['order'] ?? 0;

        Project::create($validated);

        return redirect()->route('admin.projects.index')->with('success', 'Project created successfully.');
    }

    public function edit(Project $project)
    {
        return view('admin.projects.form', compact('project'));
    }

    public function update(Request $request, Project $project)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:200',
            'slug' => 'nullable|string|max:200|unique:projects,slug,' . $project->id,
            'category' => 'required|string|max:100',
            'client_name' => 'nullable|string|max:150',
            'image_file' => 'nullable|image|max:4096',
            'image' => 'nullable|string',
            'summary' => 'required|string|max:500',
            'description' => 'nullable|string',
            'challenge' => 'nullable|string',
            'solution' => 'nullable|string',
            'results' => 'nullable|string',
            'technologies' => 'nullable|string',
            'project_url' => 'nullable|string|max:255',
            'order' => 'nullable|integer',
            'is_featured' => 'nullable|boolean',
            'is_active' => 'nullable|boolean',
        ]);

        if ($request->hasFile('image_file')) {
            $file = $request->file('image_file');
            $filename = time() . '_' . Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME)) . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('assets/images/projects'), $filename);
            $validated['image'] = '/assets/images/projects/' . $filename;
        }

        $validated['slug'] = !empty($validated['slug']) ? Str::slug($validated['slug']) : Str::slug($validated['title']);
        $validated['technologies'] = !empty($request->input('technologies')) ? array_filter(array_map('trim', explode(",", $request->input('technologies')))) : [];
        $validated['is_featured'] = $request->boolean('is_featured');
        $validated['is_active'] = $request->boolean('is_active');
        $validated['order'] = $validated['order'] ?? 0;

        $project->update($validated);

        return redirect()->route('admin.projects.index')->with('success', 'Project updated successfully.');
    }

    public function destroy(Project $project)
    {
        $project->delete();
        return redirect()->route('admin.projects.index')->with('success', 'Project removed.');
    }
}

