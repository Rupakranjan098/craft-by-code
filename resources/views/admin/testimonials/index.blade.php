@extends('layouts.admin')

@section('title', 'Manage Testimonials')
@section('header_title', 'Client Testimonials')

@section('content')
    <div class="space-y-6">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <h1 class="text-2xl font-bold text-slate-900">Client Testimonials</h1>
                <p class="text-xs text-slate-500">Manage client reviews, ratings, and feedback displayed on the homepage</p>
            </div>
            <a href="{{ route('admin.testimonials.create') }}" 
               class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-blue-600 hover:bg-blue-500 text-white font-bold text-xs transition shadow">
                <x-icon name="plus" class="w-4 h-4" />
                <span>Add Testimonial</span>
            </a>
        </div>

        <div class="bg-white rounded-3xl border border-slate-200/80 shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs text-slate-600">
                    <thead class="bg-slate-50/70 text-slate-400 font-bold uppercase tracking-wider text-[10px] border-b border-slate-100">
                        <tr>
                            <th class="py-3 px-6">Client</th>
                            <th class="py-3 px-6">Company / Role</th>
                            <th class="py-3 px-6">Rating</th>
                            <th class="py-3 px-6">Review Excerpt</th>
                            <th class="py-3 px-6">Featured</th>
                            <th class="py-3 px-6 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 font-medium">
                        @forelse($testimonials as $t)
                            <tr class="hover:bg-slate-50/50 transition">
                                <td class="py-4 px-6 flex items-center gap-3">
                                    <img src="{{ $t->avatar ?? '/assets/images/testimonials/avatar-1.jpg' }}" alt="{{ $t->client_name }}" class="w-9 h-9 rounded-full object-cover">
                                    <span class="font-bold text-slate-900 text-sm">{{ $t->client_name }}</span>
                                </td>
                                <td class="py-4 px-6">
                                    <div class="text-slate-800 font-semibold">{{ $t->designation }}</div>
                                    <div class="text-slate-400 text-[11px]">{{ $t->company }}</div>
                                </td>
                                <td class="py-4 px-6">
                                    <div class="flex items-center text-amber-400">
                                        @for($i = 0; $i < $t->rating; $i++)
                                            ★
                                        @endfor
                                    </div>
                                </td>
                                <td class="py-4 px-6 max-w-xs truncate text-slate-500">
                                    "{{ $t->content }}"
                                </td>
                                <td class="py-4 px-6">
                                    @if($t->is_featured)
                                        <span class="px-2 py-0.5 rounded-md text-[10px] font-bold bg-amber-50 text-amber-700">★ Homepage</span>
                                    @else
                                        <span class="text-slate-400">No</span>
                                    @endif
                                </td>
                                <td class="py-4 px-6 text-right">
                                    <div class="flex items-center justify-end gap-2">
                                        <a href="{{ route('admin.testimonials.edit', $t->id) }}" class="p-1.5 text-slate-400 hover:text-indigo-600 transition" title="Edit">
                                            <x-icon name="edit" class="w-4 h-4" />
                                        </a>
                                        <form action="{{ route('admin.testimonials.destroy', $t->id) }}" method="POST" onsubmit="return confirm('Delete this testimonial?');" class="inline">
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
                                    No testimonials added yet.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="p-4 border-t border-slate-100">
                {{ $testimonials->links() }}
            </div>
        </div>
    </div>
@endsection

