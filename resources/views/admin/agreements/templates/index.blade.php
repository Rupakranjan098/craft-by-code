@extends('layouts.admin')

@section('title', 'Agreement Templates')
@section('header_title', 'Agreement Templates')

@section('content')
<div class="space-y-6">

    <!-- Header Navigation -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <a href="{{ route('admin.agreements.index') }}" class="text-xs font-semibold text-slate-500 hover:text-slate-800 dark:hover:text-white transition flex items-center gap-1 mb-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="m15 18-6-6 6-6"/></svg>
                <span>Back to Agreements Dashboard</span>
            </a>
            <h1 class="text-2xl font-bold text-slate-900 dark:text-white">Contract &amp; Agreement Templates</h1>
            <p class="text-xs text-slate-500 dark:text-slate-400">Manage standard commercial boilerplate, milestone structures, and legal covenants.</p>
        </div>

        <a href="{{ route('admin.agreements.templates.create') }}" 
           class="inline-flex items-center gap-1.5 px-4 py-2 rounded-xl bg-blue-600 hover:bg-blue-500 text-xs font-bold text-white transition shadow-sm hover:shadow">
            <x-icon name="plus" class="w-3.5 h-3.5" />
            <span>Create New Template</span>
        </a>
    </div>

    <!-- Templates Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        @foreach($templates as $tpl)
            <div class="p-6 rounded-3xl bg-white dark:bg-slate-900 border border-slate-200/80 dark:border-slate-800 shadow-sm flex flex-col justify-between space-y-4">
                <div>
                    <div class="flex items-center justify-between mb-2">
                        <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-blue-50 dark:bg-blue-950/60 text-blue-700 dark:text-blue-300 border border-blue-200 dark:border-blue-800 uppercase tracking-wider">
                            {{ $tpl->category }}
                        </span>
                        <span class="text-xs text-slate-400">{{ $tpl->agreements_count }} contracts generated</span>
                    </div>

                    <h3 class="text-base font-bold text-slate-900 dark:text-white mb-2">{{ $tpl->name }}</h3>
                    <p class="text-xs text-slate-500 dark:text-slate-400 line-clamp-2 leading-relaxed mb-4">
                        {{ $tpl->description }}
                    </p>

                    <div class="p-3 rounded-2xl bg-slate-50 dark:bg-slate-950/60 border border-slate-100 dark:border-slate-800 font-mono text-[10px] text-slate-600 dark:text-slate-400 max-h-24 overflow-hidden">
                        {{ substr($tpl->content, 0, 200) }}...
                    </div>
                </div>

                <div class="pt-4 border-t border-slate-100 dark:border-slate-800 flex items-center justify-between">
                    <a href="{{ route('admin.agreements.create', ['template_id' => $tpl->id]) }}" 
                       class="text-xs font-bold text-blue-600 dark:text-blue-400 hover:underline flex items-center gap-1">
                        <span>Use This Template &rarr;</span>
                    </a>

                    <div class="flex items-center gap-2">
                        <a href="{{ route('admin.agreements.templates.edit', $tpl->id) }}" 
                           class="p-1.5 text-slate-400 hover:text-slate-800 dark:hover:text-white transition" title="Edit Template">
                            <x-icon name="edit" class="w-4 h-4" />
                        </a>

                        @if($tpl->agreements_count === 0)
                            <form action="{{ route('admin.agreements.templates.destroy', $tpl->id) }}" method="POST" onsubmit="return confirm('Delete this contract template?');" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="p-1.5 text-slate-400 hover:text-rose-600 transition" title="Delete Template">
                                    <x-icon name="trash" class="w-4 h-4" />
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection

