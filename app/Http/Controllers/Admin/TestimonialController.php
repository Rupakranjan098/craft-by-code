<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Testimonial;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class TestimonialController extends Controller
{
    public function index()
    {
        $testimonials = Testimonial::orderBy('order', 'asc')->paginate(10);
        return view('admin.testimonials.index', compact('testimonials'));
    }

    public function create()
    {
        return view('admin.testimonials.form', ['testimonial' => new Testimonial()]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'client_name' => 'required|string|max:150',
            'designation' => 'required|string|max:100',
            'company' => 'required|string|max:150',
            'rating' => 'required|integer|min:1|max:5',
            'content' => 'required|string|max:1000',
            'avatar_file' => 'nullable|image|max:2048',
            'avatar' => 'nullable|string',
            'order' => 'nullable|integer',
            'is_featured' => 'nullable|boolean',
            'is_active' => 'nullable|boolean',
        ]);

        if ($request->hasFile('avatar_file')) {
            $file = $request->file('avatar_file');
            $filename = time() . '_' . Str::slug($request->input('client_name')) . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('assets/images/testimonials'), $filename);
            $validated['avatar'] = '/assets/images/testimonials/' . $filename;
        } elseif (empty($validated['avatar'])) {
            $validated['avatar'] = '/assets/images/testimonials/avatar-1.jpg';
        }

        $validated['is_featured'] = $request->boolean('is_featured');
        $validated['is_active'] = $request->boolean('is_active');
        $validated['order'] = $validated['order'] ?? 0;

        Testimonial::create($validated);

        return redirect()->route('admin.testimonials.index')->with('success', 'Testimonial added.');
    }

    public function edit(Testimonial $testimonial)
    {
        return view('admin.testimonials.form', compact('testimonial'));
    }

    public function update(Request $request, Testimonial $testimonial)
    {
        $validated = $request->validate([
            'client_name' => 'required|string|max:150',
            'designation' => 'required|string|max:100',
            'company' => 'required|string|max:150',
            'rating' => 'required|integer|min:1|max:5',
            'content' => 'required|string|max:1000',
            'avatar_file' => 'nullable|image|max:2048',
            'avatar' => 'nullable|string',
            'order' => 'nullable|integer',
            'is_featured' => 'nullable|boolean',
            'is_active' => 'nullable|boolean',
        ]);

        if ($request->hasFile('avatar_file')) {
            $file = $request->file('avatar_file');
            $filename = time() . '_' . Str::slug($request->input('client_name')) . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('assets/images/testimonials'), $filename);
            $validated['avatar'] = '/assets/images/testimonials/' . $filename;
        }

        $validated['is_featured'] = $request->boolean('is_featured');
        $validated['is_active'] = $request->boolean('is_active');
        $validated['order'] = $validated['order'] ?? 0;

        $testimonial->update($validated);

        return redirect()->route('admin.testimonials.index')->with('success', 'Testimonial updated.');
    }

    public function destroy(Testimonial $testimonial)
    {
        $testimonial->delete();
        return redirect()->route('admin.testimonials.index')->with('success', 'Testimonial removed.');
    }
}

