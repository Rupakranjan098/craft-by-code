<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Testimonial;
use App\Security\SecureFileUpload;
use App\Security\UrlValidator;
use Illuminate\Http\Request;

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

    public function show(Testimonial $testimonial)
    {
        return redirect()->route('admin.testimonials.edit', $testimonial->id);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'client_name' => 'required|string|max:150',
            'designation' => 'required|string|max:100',
            'company' => 'required|string|max:150',
            'rating' => 'required|integer|min:1|max:5',
            'content' => 'required|string|max:1000',
            'avatar_file' => 'nullable|file|max:4096|mimes:jpg,jpeg,png,webp',
            'avatar' => 'nullable|string|max:500',
            'order' => 'nullable|integer',
            'is_featured' => 'nullable|boolean',
            'is_active' => 'nullable|boolean',
        ]);

        if (! empty($validated['avatar']) && ! UrlValidator::isSafeMediaPath($validated['avatar'])) {
            return back()->withInput()->withErrors(['avatar' => 'Avatar URL must be a valid http/https URL or relative media path.']);
        }

        if ($request->hasFile('avatar_file')) {
            try {
                $validated['avatar'] = SecureFileUpload::storeImage($request->file('avatar_file'), 'testimonials', 4096);
            } catch (\Illuminate\Validation\ValidationException $e) {
                return back()->withInput()->withErrors($e->errors());
            } catch (\Throwable $e) {
                \Illuminate\Support\Facades\Log::error('Testimonial avatar upload failed: '.$e->getMessage());

                return back()->withInput()->withErrors(['avatar_file' => 'Failed to save avatar image: '.$e->getMessage()]);
            }
        } elseif (! empty($request->input('avatar'))) {
            $validated['avatar'] = trim($request->input('avatar'));
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
            'avatar_file' => 'nullable|file|max:4096|mimes:jpg,jpeg,png,webp',
            'avatar' => 'nullable|string|max:500',
            'order' => 'nullable|integer',
            'is_featured' => 'nullable|boolean',
            'is_active' => 'nullable|boolean',
        ]);

        if (! empty($validated['avatar']) && ! UrlValidator::isSafeMediaPath($validated['avatar'])) {
            return back()->withInput()->withErrors(['avatar' => 'Avatar URL must be a valid http/https URL or relative media path.']);
        }

        if ($request->hasFile('avatar_file')) {
            try {
                $previous = $testimonial->avatar;
                $validated['avatar'] = SecureFileUpload::storeImage($request->file('avatar_file'), 'testimonials', 4096);
                SecureFileUpload::deleteManagedFile($previous);
            } catch (\Illuminate\Validation\ValidationException $e) {
                return back()->withInput()->withErrors($e->errors());
            } catch (\Throwable $e) {
                \Illuminate\Support\Facades\Log::error('Testimonial avatar upload failed: '.$e->getMessage());

                return back()->withInput()->withErrors(['avatar_file' => 'Failed to save avatar image: '.$e->getMessage()]);
            }
        } elseif (! empty($request->input('avatar'))) {
            $validated['avatar'] = trim($request->input('avatar'));
        }

        $validated['is_featured'] = $request->boolean('is_featured');
        $validated['is_active'] = $request->boolean('is_active');
        $validated['order'] = $validated['order'] ?? 0;

        $testimonial->update($validated);

        return redirect()->route('admin.testimonials.index')->with('success', 'Testimonial updated.');
    }

    public function destroy(Testimonial $testimonial)
    {
        SecureFileUpload::deleteManagedFile($testimonial->avatar);
        $testimonial->delete();

        return redirect()->route('admin.testimonials.index')->with('success', 'Testimonial removed.');
    }
}
