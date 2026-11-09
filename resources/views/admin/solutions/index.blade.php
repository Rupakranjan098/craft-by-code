@extends('layouts.admin')

@section('title', 'Manage Digital Solutions')
@section('header_title', 'Digital Solutions')

@section('content')
    <div class="space-y-6">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <h1 class="text-2xl font-bold text-slate-900">Digital Solutions</h1>
                <p class="text-xs text-slate-500">Manage enterprise architectures, automation suites, and custom business platforms</p>
            </div>
            <a href="{{ route('admin.solutions.create') }}" 
               class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-blue-600 hover:bg-blue-500 text-white font-bold text-xs transition shadow">
                <x-icon name="plus" class="w-4 h-4" />
                <span>Add Solution</span>
            </a>
        </div>

        <div class="bg-white rounded-3xl border border-slate-200/80 shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs text-slate-600">
                    <thead class="bg-slate-50/70 text-slate-400 font-bold uppercase tracking-wider text-[10px] border-b border-slate-100">
                        <tr>
                            <th class="py-3 px-6">Order</th>
                            <th class="py-3 px-6">Title</th>
                            <th class="py-3 px-6">Category</th>
                            <th class="py-3 px-6">Icon</th>
                            <th class="py-3 px-6">Status</th>
                            <th class="py-3 px-6 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 font-medium">
                        @forelse($solutions as $sol)
                            <tr class="hover:bg-slate-50/50 transition">
                                <td class="py-4 px-6 text-slate-400 font-mono">{{ $sol->order }}</td>
                                <td class="py-4 px-6">
                                    <div class="font-bold text-slate-900 text-sm">{{ $sol->title }}</div>
                                    <div class="text-[11px] text-slate-400">/digital-solutions/{{ $sol->slug }}</div>
                                </td>
                                <td class="py-4 px-6">
                                    <span class="px-2.5 py-1 rounded-md bg-blue-50 text-blue-700 text-[11px] font-semibold">
                                        {{ $sol->category ?? 'Enterprise' }}
                                    </span>
                                </td>
                                <td class="py-4 px-6">
                                    <div class="w-8 h-8 rounded-lg bg-blue-50 text-blue-600 flex items-center justify-center">
                                        <x-icon :name="$sol->icon" class="w-4 h-4" />
                                    </div>
                                </td>
                                <td class="py-4 px-6">
                                    @if($sol->is_active)
                                        <span class="px-2.5 py-1 rounded-full text-[10px] font-bold bg-emerald-50 text-emerald-600 border border-emerald-200">Active</span>
                                    @else
                                        <span class="px-2.5 py-1 rounded-full text-[10px] font-bold bg-slate-100 text-slate-400">Inactive</span>
                                    @endif
                                </td>
                                <td class="py-4 px-6 text-right">
                                    <div class="flex items-center justify-end gap-2">
                                        <a href="{{ route('solutions.show', $sol->slug) }}" target="_blank" class="p-1.5 text-slate-400 hover:text-blue-600 transition" title="Preview">
                                            <x-icon name="eye" class="w-4 h-4" />
                                        </a>
                                        <a href="{{ route('admin.solutions.edit', $sol->id) }}" class="p-1.5 text-slate-400 hover:text-indigo-600 transition" title="Edit">
                                            <x-icon name="edit" class="w-4 h-4" />
                                        </a>
                                        <form action="{{ route('admin.solutions.destroy', $sol->id) }}" method="POST" onsubmit="return confirm('Delete this digital solution?');" class="inline">
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
                                    No digital solutions created yet.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="p-4 border-t border-slate-100">
                {{ $solutions->links() }}
            </div>
        </div>
    </div>
@endsection

