<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BlogPost;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class BlogPostController extends Controller
{
    public function index(Request $request)
    {
        $query = BlogPost::query();
        if ($request->filled('search')) {
            $s = $request->input('search');
            $query->where('title', 'like', "%{$s}%")->orWhere('category', 'like', "%{$s}%");
        }
        $posts = $query->latest('published_at')->paginate(10)->withQueryString();
        return view('admin.blog.index', compact('posts'));
    }

    public function create()
    {
        return view('admin.blog.form', ['post' => new BlogPost()]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:200',
            'slug' => 'nullable|string|max:200|unique:blog_posts,slug',
            'category' => 'required|string|max:50',
            'image_file' => 'nullable|image|max:3072',
            'image' => 'nullable|string',
            'excerpt' => 'required|string|max:500',
            'content' => 'required|string',
            'read_time' => 'nullable|string|max:30',
            'author_name' => 'nullable|string|max:100',
            'is_featured' => 'nullable|boolean',
            'is_published' => 'nullable|boolean',
        ]);

        if ($request->hasFile('image_file')) {
            $file = $request->file('image_file');
            $filename = time() . '_' . Str::slug($request->input('title')) . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('assets/images/blog'), $filename);
            $validated['image'] = '/assets/images/blog/' . $filename;
        } elseif (empty($validated['image'])) {
            $validated['image'] = '/assets/images/blog/blog-code.jpg';
        }

        $validated['slug'] = !empty($validated['slug']) ? Str::slug($validated['slug']) : Str::slug($validated['title']);
        $validated['is_featured'] = $request->boolean('is_featured');
        $validated['is_published'] = $request->boolean('is_published');
        $validated['published_at'] = now();

        BlogPost::create($validated);

        return redirect()->route('admin.blog.index')->with('success', 'Article published successfully.');
    }

    public function edit(BlogPost $post)
    {
        return view('admin.blog.form', compact('post'));
    }

    public function update(Request $request, BlogPost $post)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:200',
            'slug' => 'nullable|string|max:200|unique:blog_posts,slug,' . $post->id,
            'category' => 'required|string|max:50',
            'image_file' => 'nullable|image|max:3072',
            'image' => 'nullable|string',
            'excerpt' => 'required|string|max:500',
            'content' => 'required|string',
            'read_time' => 'nullable|string|max:30',
            'author_name' => 'nullable|string|max:100',
            'is_featured' => 'nullable|boolean',
            'is_published' => 'nullable|boolean',
        ]);

        if ($request->hasFile('image_file')) {
            $file = $request->file('image_file');
            $filename = time() . '_' . Str::slug($request->input('title')) . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('assets/images/blog'), $filename);
            $validated['image'] = '/assets/images/blog/' . $filename;
        }

        $validated['slug'] = !empty($validated['slug']) ? Str::slug($validated['slug']) : Str::slug($validated['title']);
        $validated['is_featured'] = $request->boolean('is_featured');
        $validated['is_published'] = $request->boolean('is_published');

        $post->update($validated);

        return redirect()->route('admin.blog.index')->with('success', 'Article updated.');
    }

    public function destroy(BlogPost $post)
    {
        $post->delete();
        return redirect()->route('admin.blog.index')->with('success', 'Article removed.');
    }
}

