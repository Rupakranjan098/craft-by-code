@props([
    'compact' => false,
    'label' => false,
])

<button type="button"
        data-theme-toggle
        aria-label="Toggle Day and Night mode"
        title="Switch between Day & Night theme"
        {{ $attributes->merge([
            'class' => $compact
                ? 'inline-flex items-center justify-center w-9 h-9 rounded-full border border-slate-200/80 dark:border-slate-700 bg-slate-100/80 dark:bg-slate-800/90 text-slate-700 dark:text-amber-300 hover:bg-slate-200 dark:hover:bg-slate-700 transition focus:outline-none focus:ring-2 focus:ring-blue-500 cursor-pointer flex-shrink-0'
                : 'inline-flex items-center justify-center gap-2 px-3.5 py-2 rounded-full border border-slate-200 dark:border-slate-700 bg-slate-100 dark:bg-slate-800 text-slate-700 dark:text-amber-300 hover:bg-slate-200 dark:hover:bg-slate-700 text-xs font-semibold transition focus:outline-none focus:ring-2 focus:ring-blue-500 cursor-pointer'
        ]) }}>
    {{-- Shown in Day/Light mode -> click to switch to Night --}}
    <svg class="w-4 h-4 block dark:hidden" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true">
        <path stroke-linecap="round" stroke-linejoin="round" d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z"/>
    </svg>
    {{-- Shown in Night/Dark mode -> click to switch to Day --}}
    <svg class="w-4 h-4 hidden dark:block" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true">
        <circle cx="12" cy="12" r="4"/>
        <path stroke-linecap="round" d="M12 2v2M12 20v2M4.93 4.93l1.41 1.41M17.66 17.66l1.41 1.41M2 12h2M20 12h2M6.34 17.66l-1.41 1.41M19.07 4.93l-1.41 1.41"/>
    </svg>

    @if($label)
        <span class="block dark:hidden text-slate-700">Night Mode</span>
        <span class="hidden dark:inline text-slate-200">Day Mode</span>
    @endif
</button>

