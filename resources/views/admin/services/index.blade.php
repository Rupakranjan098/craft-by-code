@extends('layouts.admin')

@section('title', 'Manage Services')
@section('header_title', 'Services Management')

@section('content')
    <div class="space-y-6">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <h1 class="text-2xl font-bold text-slate-900">Services Catalog</h1>
                <p class="text-xs text-slate-500">Configure offerings displayed on the website and services detail pages</p>
            </div>
            <a href="{{ route('admin.services.create') }}" 
               class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-blue-600 hover:bg-blue-500 text-white font-bold text-xs transition shadow">
                <x-icon name="plus" class="w-4 h-4" />
                <span>Add New Service</span>
            </a>
        </div>

        <!-- Filter bar -->
        <div class="bg-white p-4 rounded-2xl border border-slate-200/80 shadow-sm flex items-center justify-between gap-4">
            <form action="{{ route('admin.services.index') }}" method="GET" class="flex-1 max-w-sm relative">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Search services..."
                       class="w-full pl-9 pr-4 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-900 focus:outline-none focus:ring-2 focus:ring-blue-600">
                <div class="absolute left-3 top-2.5 text-slate-400">
                    <x-icon name="search" class="w-3.5 h-3.5" />
                </div>
            </form>
            <div class="text-xs font-semibold text-slate-500">
                Showing {{ $services->total() }} services
            </div>
        </div>

        <!-- Services Table -->
        <div class="bg-white rounded-3xl border border-slate-200/80 shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs text-slate-600">
                    <thead class="bg-slate-50/70 text-slate-400 font-bold uppercase tracking-wider text-[10px] border-b border-slate-100">
                        <tr>
                            <th class="py-3 px-6">Order</th>
                            <th class="py-3 px-6">Service</th>
                            <th class="py-3 px-6">Icon</th>
                            <th class="py-3 px-6">Badge</th>
                            <th class="py-3 px-6">Featured</th>
                            <th class="py-3 px-6">Status</th>
                            <th class="py-3 px-6 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 font-medium">
                        @forelse($services as $serv)
                            <tr class="hover:bg-slate-50/50 transition">
                                <td class="py-4 px-6 text-slate-400 font-mono">{{ $serv->order }}</td>
                                <td class="py-4 px-6">
                                    <div class="font-bold text-slate-900 text-sm">{{ $serv->title }}</div>
                                    <div class="text-[11px] text-slate-400">/services/{{ $serv->slug }}</div>
                                </td>
                                <td class="py-4 px-6">
                                    <div class="w-8 h-8 rounded-lg bg-blue-50 text-blue-600 flex items-center justify-center">
                                        <x-icon :name="$serv->icon" class="w-4 h-4" />
                                    </div>
                                </td>
                                <td class="py-4 px-6">
                                    @if($serv->badge)
                                        <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-blue-50 text-blue-700 border border-blue-100">
                                            {{ $serv->badge }}
                                        </span>
                                    @else
                                        <span class="text-slate-400">—</span>
                                    @endif
                                </td>
                                <td class="py-4 px-6">
                                    @if($serv->is_featured)
                                        <span class="px-2 py-0.5 rounded-md text-[10px] font-bold bg-amber-50 text-amber-700">★ Featured</span>
                                    @else
                                        <span class="text-slate-400">Regular</span>
                                    @endif
                                </td>
                                <td class="py-4 px-6">
                                    @if($serv->is_active)
                                        <span class="px-2.5 py-1 rounded-full text-[10px] font-bold bg-emerald-50 text-emerald-600 border border-emerald-200">Active</span>
                                    @else
                                        <span class="px-2.5 py-1 rounded-full text-[10px] font-bold bg-slate-100 text-slate-400">Inactive</span>
                                    @endif
                                </td>
                                <td class="py-4 px-6 text-right">
                                    <div class="flex items-center justify-end gap-2">
                                        <a href="{{ route('services.show', $serv->slug) }}" target="_blank" class="p-1.5 text-slate-400 hover:text-blue-600 transition" title="Preview Live">
                                            <x-icon name="eye" class="w-4 h-4" />
                                        </a>
                                        <a href="{{ route('admin.services.edit', $serv->id) }}" class="p-1.5 text-slate-400 hover:text-indigo-600 transition" title="Edit">
                                            <x-icon name="edit" class="w-4 h-4" />
                                        </a>
                                        <form action="{{ route('admin.services.destroy', $serv->id) }}" method="POST" onsubmit="return confirm('Delete this service?');" class="inline">
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
                                <td colspan="7" class="py-8 text-center text-slate-400">
                                    No services found.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="p-4 border-t border-slate-100">
                {{ $services->links() }}
            </div>
        </div>
    </div>
@endsection

