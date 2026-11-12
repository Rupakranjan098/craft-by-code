import Alpine from 'alpinejs';

window.craftChatbot = function (messageUrl, leadUrl, brandName) {
    const storageKey = 'cbc_chat_history';
    const welcome = {
        role: 'bot',
        text: `Hi there! I'm the ${brandName} assistant. Ask me about startup MVPs, SaaS platforms, DevOps & Cloud, AI automation, timelines, or book a discovery call.`,
        links: [],
    };

    return {
        open: false,
        loading: false,
        input: '',
        brandName: brandName || 'CraftByCode',
        messages: [welcome],
        suggestions: ['Explore Services', 'MVP & Pricing', 'SaaS & DevOps', 'Book Discovery Call'],
        showLeadForm: false,
        leadSubmitting: false,
        leadError: '',
        lead: { name: '', email: '', message: '' },

        init() {
            try {
                const saved = sessionStorage.getItem(storageKey);
                if (saved) {
                    const parsed = JSON.parse(saved);
                    if (Array.isArray(parsed) && parsed.length > 0) {
                        this.messages = parsed.slice(-20);
                    }
                }
            } catch (e) {}
        },

        toggle() {
            this.open = !this.open;
            if (this.open) {
                this.$nextTick(() => this.scrollBottom());
            }
        },

        persist() {
            try {
                sessionStorage.setItem(storageKey, JSON.stringify(this.messages.slice(-20)));
            } catch (e) {}
        },

        scrollBottom() {
            if (this.$refs.chatBody) {
                this.$refs.chatBody.scrollTop = this.$refs.chatBody.scrollHeight;
            }
        },

        resetChat() {
            this.messages = [welcome];
            this.suggestions = ['Explore Services', 'MVP & Pricing', 'SaaS & DevOps', 'Book Discovery Call'];
            this.showLeadForm = false;
            this.leadError = '';
            this.persist();
        },

        sendQuick(text) {
            this.input = text;
            this.send();
        },

        async send() {
            const text = (this.input || '').trim();
            if (!text || this.loading) return;

            this.messages.push({ role: 'user', text, links: [] });
            this.input = '';
            this.loading = true;
            this.persist();
            this.$nextTick(() => this.scrollBottom());

            try {
                const csrf = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';
                const res = await fetch(messageUrl, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': csrf,
                    },
                    body: JSON.stringify({ message: text }),
                });

                if (res.status === 429) {
                    this.messages.push({ role: 'bot', text: 'You are sending messages too fast. Please wait a few seconds and try again.', links: [] });
                } else if (!res.ok) {
                    this.messages.push({ role: 'bot', text: 'Sorry, I could not process that right now. Please try again or visit our Contact page.', links: [] });
                } else {
                    const data = await res.json();
                    this.messages.push({
                        role: 'bot',
                        text: data.reply || 'Thanks for reaching out!',
                        links: Array.isArray(data.links) ? data.links : [],
                    });
                    if (Array.isArray(data.suggestions)) {
                        this.suggestions = data.suggestions;
                    }
                    if (data.show_lead_form) {
                        this.showLeadForm = true;
                    }
                }
            } catch (e) {
                this.messages.push({ role: 'bot', text: 'Connection issue detected. Please check your internet connection or use our Contact page.', links: [] });
            } finally {
                this.loading = false;
                this.persist();
                this.$nextTick(() => this.scrollBottom());
            }
        },

        async submitLead() {
            if (this.leadSubmitting) return;
            this.leadSubmitting = true;
            this.leadError = '';

            try {
                const csrf = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';
                const res = await fetch(leadUrl, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': csrf,
                    },
                    body: JSON.stringify(this.lead),
                });

                const data = await res.json().catch(() => ({}));
                if (!res.ok) {
                    const firstErr = data?.errors ? Object.values(data.errors)[0]?.[0] : null;
                    this.leadError = firstErr || data.message || 'Please enter a valid name, email, and project message.';
                    return;
                }

                this.showLeadForm = false;
                this.lead = { name: '', email: '', message: '' };
                this.messages.push({ role: 'bot', text: data.reply || 'Your request has been submitted!', links: [] });
                this.persist();
                this.$nextTick(() => this.scrollBottom());
            } catch (e) {
                this.leadError = 'Unable to send request right now. Please try the Contact page.';
            } finally {
                this.leadSubmitting = false;
            }
        },
    };
};

window.Alpine = Alpine;
Alpine.start();
