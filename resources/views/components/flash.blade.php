<div x-data="{ show: true }" x-show="show" x-transition:leave="transition ease-in duration-300 transform opacity-0 translate-y-2" class="fixed bottom-5 right-5 z-50 max-w-md w-full">
    @if(session('success'))
        <div class="flex items-start p-4 bg-emerald-900/90 backdrop-blur-md text-emerald-100 rounded-xl shadow-2xl border border-emerald-500/30">
            <div class="flex-shrink-0 text-emerald-400 mt-0.5">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
            </div>
            <div class="ml-3 flex-1 text-sm font-medium">
                {{ session('success') }}
            </div>
            <button @click="show = false" type="button" class="ml-auto text-emerald-400 hover:text-white transition">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M18 6 6 18"/><path d="m6 6 12 12"/></svg>
            </button>
        </div>
    @endif

    @if(session('error'))
        <div class="flex items-start p-4 bg-rose-900/90 backdrop-blur-md text-rose-100 rounded-xl shadow-2xl border border-rose-500/30">
            <div class="flex-shrink-0 text-rose-400 mt-0.5">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
            </div>
            <div class="ml-3 flex-1 text-sm font-medium">
                {{ session('error') }}
            </div>
            <button @click="show = false" type="button" class="ml-auto text-rose-400 hover:text-white transition">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M18 6 6 18"/><path d="m6 6 12 12"/></svg>
            </button>
        </div>
    @endif

    @if($errors->any())
        <div class="flex items-start p-4 bg-amber-900/95 backdrop-blur-md text-amber-100 rounded-xl shadow-2xl border border-amber-500/30">
            <div class="flex-shrink-0 text-amber-400 mt-0.5">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="m21.73 18-8-14a2 2 0 0 0-3.48 0l-8 14A2 2 0 0 0 4 21h16a2 2 0 0 0 1.73-3Z"/><line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg>
            </div>
            <div class="ml-3 flex-1 text-sm">
                <div class="font-semibold mb-1">Please correct the following:</div>
                <ul class="list-disc list-inside space-y-0.5 text-xs text-amber-200">
                    @foreach($errors->all() as $err)
                        <li>{{ $err }}</li>
                    @endforeach
                </ul>
            </div>
            <button @click="show = false" type="button" class="ml-auto text-amber-400 hover:text-white transition">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M18 6 6 18"/><path d="m6 6 12 12"/></svg>
            </button>
        </div>
    @endif
</div>

