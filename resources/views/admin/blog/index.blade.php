@extends('layouts.admin')

@section('title', 'Manage Blog & Articles')
@section('header_title', 'Blog Articles')

@section('content')
    <div class="space-y-6">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <h1 class="text-2xl font-bold text-slate-900">Articles & Insights</h1>
                <p class="text-xs text-slate-500">Manage published articles, engineering guides, and company news</p>
            </div>
            <a href="{{ route('admin.blog.create') }}" 
               class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-blue-600 hover:bg-blue-500 text-white font-bold text-xs transition shadow">
                <x-icon name="plus" class="w-4 h-4" />
                <span>New Article</span>
            </a>
        </div>

        <div class="bg-white rounded-3xl border border-slate-200/80 shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs text-slate-600">
                    <thead class="bg-slate-50/70 text-slate-400 font-bold uppercase tracking-wider text-[10px] border-b border-slate-100">
                        <tr>
                            <th class="py-3 px-6">Image</th>
                            <th class="py-3 px-6">Title</th>
                            <th class="py-3 px-6">Category</th>
                            <th class="py-3 px-6">Author</th>
                            <th class="py-3 px-6">Published</th>
                            <th class="py-3 px-6 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 font-medium">
                        @forelse($posts as $post)
                            <tr class="hover:bg-slate-50/50 transition">
                                <td class="py-4 px-6">
                                    <img src="{{ $post->image }}" alt="" class="w-14 h-9 object-cover rounded-lg border border-slate-200">
                                </td>
                                <td class="py-4 px-6">
                                    <div class="font-bold text-slate-900 text-sm">{{ $post->title }}</div>
                                    <div class="text-[11px] text-slate-400">/blog/{{ $post->slug }}</div>
                                </td>
                                <td class="py-4 px-6">
                                    <span class="px-2.5 py-1 rounded-md bg-blue-50 text-blue-700 text-[11px] font-semibold">
                                        {{ $post->category }}
                                    </span>
                                </td>
                                <td class="py-4 px-6 text-slate-700 font-medium">
                                    {{ $post->author_name }}
                                </td>
                                <td class="py-4 px-6 text-slate-400 text-[11px]">
                                    {{ $post->published_at ? $post->published_at->format('M d, Y') : 'Draft' }}
                                </td>
                                <td class="py-4 px-6 text-right">
                                    <div class="flex items-center justify-end gap-2">
                                        <a href="{{ route('blog.show', $post->slug) }}" target="_blank" class="p-1.5 text-slate-400 hover:text-blue-600 transition" title="Preview">
                                            <x-icon name="eye" class="w-4 h-4" />
                                        </a>
                                        <a href="{{ route('admin.blog.edit', $post->id) }}" class="p-1.5 text-slate-400 hover:text-indigo-600 transition" title="Edit">
                                            <x-icon name="edit" class="w-4 h-4" />
                                        </a>
                                        <form action="{{ route('admin.blog.destroy', $post->id) }}" method="POST" onsubmit="return confirm('Delete this article?');" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="p-1.5 text-slate-400 hover:text-rose-600 transition" title="Delete">
                                                <x-icon name="trash" class="w-4 h-4" />
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="py-8 text-center text-slate-400">
                                    No articles written yet.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="p-4 border-t border-slate-100">
                {{ $posts->links() }}
            </div>
        </div>
    </div>
@endsection

