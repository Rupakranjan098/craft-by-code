@php
    $brandName = \App\Models\WebsiteSetting::get('brand_name', 'craft by code');
@endphp

<div x-data="craftChatbot('{{ route('chatbot.message', [], false) }}', '{{ route('chatbot.lead', [], false) }}', @js($brandName))"
     x-init="init()"
     class="fixed bottom-4 right-4 sm:bottom-6 sm:right-6 z-50 flex flex-col items-end">

    <!-- Chat Drawer Panel -->
    <div x-show="open"
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0 translate-y-4 scale-95"
         x-transition:enter-end="opacity-100 translate-y-0 scale-100"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100 translate-y-0 scale-100"
         x-transition:leave-end="opacity-0 translate-y-4 scale-95"
         x-cloak
         role="dialog"
         aria-label="CraftByCode Assistant Chat"
         class="mb-3 w-[calc(100vw-2rem)] sm:w-[390px] max-h-[82vh] flex flex-col rounded-3xl bg-white dark:bg-slate-900 border border-slate-200/90 dark:border-slate-800 shadow-2xl shadow-slate-900/20 dark:shadow-black/60 overflow-hidden">

        <!-- Header -->
        <div class="px-5 py-4 bg-gradient-to-r from-[#0B172A] via-slate-900 to-blue-950 text-white flex items-center justify-between gap-3">
            <div class="flex items-center gap-3 min-w-0">
                <div class="w-9 h-9 rounded-2xl bg-gradient-to-br from-blue-500 to-purple-600 flex items-center justify-center shadow-md flex-shrink-0">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2h-5l-5 4v-4Z"/>
                    </svg>
                </div>
                <div class="min-w-0">
                    <p class="text-sm font-bold truncate" x-text="brandName + ' Assistant'"></p>
                    <p class="text-[11px] text-emerald-300 flex items-center gap-1.5">
                        <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                        <span>Online • Startup &amp; Tech Guide</span>
                    </p>
                </div>
            </div>

            <div class="flex items-center gap-1 flex-shrink-0">
                <button type="button"
                        @click="resetChat()"
                        title="Clear conversation"
                        aria-label="Reset chat"
                        class="p-1.5 rounded-lg text-slate-300 hover:text-white hover:bg-white/10 transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 12a9 9 0 1 0 3-6.7L3 8m0-5v5h5"/>
                    </svg>
                </button>
                <button type="button"
                        @click="open = false"
                        title="Close chat"
                        aria-label="Close chat"
                        class="p-1.5 rounded-lg text-slate-300 hover:text-white hover:bg-white/10 transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
        </div>

        <!-- Messages Area -->
        <div x-ref="chatBody" class="flex-1 overflow-y-auto px-4 py-4 space-y-3.5 bg-slate-50/70 dark:bg-slate-950/60 max-h-[420px]">
            <template x-for="(item, idx) in messages" :key="idx">
                <div :class="item.role === 'user' ? 'flex justify-end' : 'flex justify-start'">
                    <div :class="item.role === 'user'
                            ? 'max-w-[85%] rounded-2xl rounded-br-sm bg-blue-600 text-white px-3.5 py-2.5 text-xs sm:text-[13px] leading-relaxed shadow-sm'
                            : 'max-w-[88%] rounded-2xl rounded-bl-sm bg-white dark:bg-slate-900 border border-slate-200/80 dark:border-slate-800 text-slate-700 dark:text-slate-200 px-3.5 py-2.5 text-xs sm:text-[13px] leading-relaxed shadow-sm'">
                        <p class="whitespace-pre-line break-words" x-text="item.text"></p>

                        <!-- Action Links -->
                        <template x-if="item.links && item.links.length > 0">
                            <div class="mt-2.5 flex flex-wrap gap-1.5">
                                <template x-for="(lnk, lIdx) in item.links" :key="lIdx">
                                    <a :href="lnk.url"
                                       class="inline-flex items-center gap-1 px-2.5 py-1 rounded-lg bg-blue-50 dark:bg-blue-950/70 hover:bg-blue-100 dark:hover:bg-blue-900/80 text-blue-700 dark:text-blue-300 font-semibold text-[11px] border border-blue-100 dark:border-blue-800/80 transition">
                                        <span x-text="lnk.label"></span>
                                        <span aria-hidden="true">→</span>
                                    </a>
                                </template>
                            </div>
                        </template>
                    </div>
                </div>
            </template>

            <!-- Typing Indicator -->
            <div x-show="loading" class="flex justify-start">
                <div class="rounded-2xl rounded-bl-sm bg-white dark:bg-slate-900 border border-slate-200/80 dark:border-slate-800 px-4 py-2.5 shadow-sm flex items-center gap-1.5">
                    <span class="w-1.5 h-1.5 rounded-full bg-slate-400 animate-bounce"></span>
                    <span class="w-1.5 h-1.5 rounded-full bg-slate-400 animate-bounce" style="animation-delay: 0.15s"></span>
                    <span class="w-1.5 h-1.5 rounded-full bg-slate-400 animate-bounce" style="animation-delay: 0.3s"></span>
                </div>
            </div>

            <!-- Quick Lead Form -->
            <div x-show="showLeadForm" x-cloak class="p-3.5 rounded-2xl bg-white dark:bg-slate-900 border border-blue-200 dark:border-blue-900/70 shadow-sm space-y-2.5">
                <div class="flex items-center justify-between">
                    <span class="text-xs font-bold text-slate-900 dark:text-white">Quick Project Request</span>
                    <button type="button" @click="showLeadForm = false" class="text-[11px] text-slate-400 hover:text-slate-600 dark:hover:text-slate-300">Hide</button>
                </div>
                <form @submit.prevent="submitLead()" class="space-y-2">
                    <input type="text" x-model="lead.name" required maxlength="120" placeholder="Your name"
                           class="w-full px-3 py-2 rounded-xl bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-700 text-xs text-slate-900 dark:text-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <input type="email" x-model="lead.email" required maxlength="180" placeholder="Work email"
                           class="w-full px-3 py-2 rounded-xl bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-700 text-xs text-slate-900 dark:text-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <textarea x-model="lead.message" required rows="2" maxlength="1000" placeholder="What are you building (MVP, SaaS, Cloud, AI)?"
                              class="w-full px-3 py-2 rounded-xl bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-700 text-xs text-slate-900 dark:text-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-500"></textarea>
                    <p x-show="leadError" x-text="leadError" class="text-[11px] text-red-600 dark:text-red-400"></p>
                    <button type="submit" :disabled="leadSubmitting"
                            class="w-full py-2 rounded-xl bg-blue-600 hover:bg-blue-500 disabled:opacity-60 text-white text-xs font-bold transition">
                        <span x-text="leadSubmitting ? 'Sending...' : 'Send Request'"></span>
                    </button>
                </form>
            </div>
        </div>

        <!-- Suggested Quick Replies -->
        <div x-show="suggestions.length > 0" class="px-4 py-2 bg-white dark:bg-slate-900 border-t border-slate-100 dark:border-slate-800 flex flex-wrap gap-1.5">
            <template x-for="(chip, cIdx) in suggestions" :key="cIdx">
                <button type="button"
                        @click="sendQuick(chip)"
                        class="px-2.5 py-1 rounded-full text-[11px] font-semibold bg-slate-100 dark:bg-slate-800 hover:bg-blue-50 dark:hover:bg-blue-950/80 text-slate-700 dark:text-slate-200 hover:text-blue-700 dark:hover:text-blue-300 border border-slate-200/80 dark:border-slate-700 transition">
                    <span x-text="chip"></span>
                </button>
            </template>
        </div>

        <!-- Input Bar -->
        <form @submit.prevent="send()" class="p-3 bg-white dark:bg-slate-900 border-t border-slate-100 dark:border-slate-800 flex items-center gap-2">
            <input type="text"
                   x-model="input"
                   maxlength="500"
                   placeholder="Ask about MVP, SaaS, pricing, stack..."
                   aria-label="Chat message"
                   class="flex-1 px-3.5 py-2.5 rounded-xl bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-700 text-xs sm:text-sm text-slate-900 dark:text-white placeholder-slate-400 dark:placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-blue-500">
            <button type="submit"
                    :disabled="loading || !input.trim()"
                    aria-label="Send message"
                    class="w-10 h-10 rounded-xl bg-blue-600 hover:bg-blue-500 disabled:opacity-50 text-white flex items-center justify-center transition shadow-sm flex-shrink-0">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m22 2-7 20-4-9-9-4Z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" d="M22 2 11 13"/>
                </svg>
            </button>
        </form>
    </div>

    <!-- Floating Trigger Button -->
    <button type="button"
            @click="toggle()"
            :aria-expanded="open"
            aria-label="Toggle AI Assistant Chat"
            class="group relative inline-flex items-center gap-2.5 px-4 py-3.5 rounded-full bg-gradient-to-r from-blue-600 via-indigo-600 to-purple-600 hover:from-blue-500 hover:to-purple-500 text-white font-semibold text-sm shadow-xl shadow-blue-600/30 hover:shadow-blue-600/45 transition-all duration-200 hover:scale-[1.03] cursor-pointer">
        <span class="relative flex h-2.5 w-2.5" x-show="!open">
            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-300 opacity-75"></span>
            <span class="relative inline-flex rounded-full h-2.5 w-2.5 bg-emerald-400"></span>
        </span>
        <svg x-show="!open" class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2h-5l-5 4v-4Z"/>
        </svg>
        <svg x-show="open" x-cloak class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12"/>
        </svg>
        <span class="hidden sm:inline" x-text="open ? 'Close Chat' : 'Chat with Us'"></span>
    </button>
</div>

