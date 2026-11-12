<?php

namespace App\Http\Controllers;

use App\Models\BlogPost;
use App\Models\ContactInquiry;
use App\Models\Project;
use App\Models\Service;
use App\Models\WebsiteSetting;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

class ChatbotController extends Controller
{
    public function message(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'message' => ['required', 'string', 'min:1', 'max:500'],
        ]);

        $raw = trim($validated['message']);
        $q = Str::lower($raw);

        $brand = 'CraftByCode';
        $email = 'hello@craftbycode.tech';
        $phone = '+1 (555) 019-2834';
        $hours = 'Monday - Friday: 9:00 AM - 6:00 PM EST';

        try {
            if (Schema::hasTable('website_settings')) {
                $brand = (string) WebsiteSetting::get('brand_name', $brand);
                $email = (string) WebsiteSetting::get('contact_email', $email);
                $phone = (string) WebsiteSetting::get('contact_phone', $phone);
                $hours = (string) WebsiteSetting::get('contact_hours', $hours);
            }
        } catch (\Throwable $e) {
            // Fall back safely to default branding when DB settings are empty
        }

        $matchedService = $this->findMatchingService($q);
        if ($matchedService) {
            return response()->json([
                'reply' => "{$matchedService->title}: {$matchedService->short_description} Our engineering team delivers production-ready builds tailored for startups and growing businesses.",
                'links' => [
                    ['label' => "View {$matchedService->title}", 'url' => route('services.show', $matchedService->slug, false)],
                    ['label' => 'Request a Proposal', 'url' => route('contact', [], false)],
                ],
                'suggestions' => ['Pricing & Timeline', 'Book Discovery Call', 'See Portfolio'],
                'show_lead_form' => false,
            ]);
        }

        if ($this->matchesAny($q, ['hi', 'hello', 'hey', 'good morning', 'good afternoon', 'good evening', 'hola'])) {
            return response()->json([
                'reply' => "Hello! Welcome to {$brand}. I can help you explore our MVP builds, SaaS platforms, DevOps & Cloud setup, AI automation, case studies, or schedule a discovery call.",
                'links' => [],
                'suggestions' => ['Explore Services', 'MVP & Pricing', 'SaaS & DevOps', 'Book Discovery Call'],
                'show_lead_form' => false,
            ]);
        }

        if ($this->matchesAny($q, ['price', 'pricing', 'cost', 'budget', 'quote', 'estimate', 'how much', 'timeline', 'how long'])) {
            return response()->json([
                'reply' => 'Startup MVP sprints typically launch in 4–8 weeks, while full SaaS platforms or custom cloud builds scale to scope. Share your goals below or in our quick form and our lead architects will send a tailored breakdown within 24 hours.',
                'links' => [
                    ['label' => 'Full Contact Page', 'url' => route('contact', [], false)],
                ],
                'suggestions' => ['Book Discovery Call', 'Explore Services', 'Tech Stack'],
                'show_lead_form' => true,
            ]);
        }

        if ($this->matchesAny($q, ['book', 'call', 'contact', 'hire', 'talk', 'start project', 'discovery', 'consultation', 'inquiry', 'lead'])) {
            return response()->json([
                'reply' => "You can submit your project details right here in chat, or reach our engineering leads directly at {$email} ({$phone}, {$hours}).",
                'links' => [
                    ['label' => 'Open Contact Page', 'url' => route('contact', [], false)],
                ],
                'suggestions' => ['Explore Services', 'Portfolio Work'],
                'show_lead_form' => true,
            ]);
        }

        if ($this->matchesAny($q, ['saas', 'mvp', 'startup', 'cloud', 'devops', 'aws', 'kubernetes', 'ci/cd'])) {
            return response()->json([
                'reply' => "{$brand} specializes in startup-ready SaaS Platforms (multi-tenant architecture, billing, RBAC) and DevOps & Cloud engineering (AWS, Docker/Kubernetes, CI/CD, security hardening) built to scale from day one.",
                'links' => [
                    ['label' => 'Explore Services', 'url' => route('services.index', [], false)],
                    ['label' => 'Book Discovery Call', 'url' => route('contact', [], false)],
                ],
                'suggestions' => ['MVP & Pricing', 'AI Automation', 'Book Discovery Call'],
                'show_lead_form' => false,
            ]);
        }

        if ($this->matchesAny($q, ['ai', 'automation', 'llm', 'gpt', 'gemini', 'chatbot', 'rag', 'agent'])) {
            return response()->json([
                'reply' => 'We engineer custom AI automation workflows, RAG knowledge bases, autonomous internal tools, and intelligent customer assistants using OpenAI, Gemini, and Claude APIs with enterprise data controls.',
                'links' => [
                    ['label' => 'Explore Services', 'url' => route('services.index', [], false)],
                    ['label' => 'Discuss AI Project', 'url' => route('contact', [], false)],
                ],
                'suggestions' => ['SaaS & DevOps', 'MVP & Pricing', 'Book Discovery Call'],
                'show_lead_form' => false,
            ]);
        }

        if ($this->matchesAny($q, ['service', 'what do you do', 'offer', 'build', 'web', 'mobile', 'ui', 'ux', 'ecommerce', 'software'])) {
            $serviceNames = $this->getActiveServiceTitles();
            $list = ! empty($serviceNames)
                ? implode(', ', $serviceNames)
                : 'SaaS Platforms, MVP Engineering, DevOps & Cloud, AI Automation, Web & Mobile Apps, UI/UX Design, and E-commerce';

            return response()->json([
                'reply' => "Our core capabilities cover: {$list}. Which area are you planning to launch or scale?",
                'links' => [
                    ['label' => 'Browse All Services', 'url' => route('services.index', [], false)],
                ],
                'suggestions' => ['SaaS & DevOps', 'AI Automation', 'MVP & Pricing', 'Portfolio Work'],
                'show_lead_form' => false,
            ]);
        }

        if ($this->matchesAny($q, ['portfolio', 'project', 'work', 'case stud', 'client', 'example'])) {
            $count = 0;
            try {
                if (Schema::hasTable('projects')) {
                    $count = Project::active()->count();
                }
            } catch (\Throwable $e) {
                $count = 0;
            }
            $intro = $count > 0
                ? "We currently showcase {$count} live case studies across web platforms, mobile products, and cloud systems."
                : 'Explore our portfolio showcase covering custom SaaS platforms, startup MVPs, mobile apps, and cloud engineering case studies.';

            return response()->json([
                'reply' => $intro,
                'links' => [
                    ['label' => 'View Portfolio', 'url' => route('portfolio.index', [], false)],
                ],
                'suggestions' => ['Tech Stack', 'MVP & Pricing', 'Book Discovery Call'],
                'show_lead_form' => false,
            ]);
        }

        if ($this->matchesAny($q, ['blog', 'article', 'insight', 'guide', 'news'])) {
            $postCount = 0;
            try {
                if (Schema::hasTable('blog_posts')) {
                    $postCount = BlogPost::published()->count();
                }
            } catch (\Throwable $e) {
                $postCount = 0;
            }

            return response()->json([
                'reply' => $postCount > 0
                    ? "We have {$postCount} engineering insights and practical architecture guides published in our blog."
                    : 'Visit our Insights & Blog section for guides on MVP architecture, SaaS scalability, UI/UX, and AI engineering.',
                'links' => [
                    ['label' => 'Read Blog', 'url' => route('blog.index', [], false)],
                ],
                'suggestions' => ['Explore Services', 'Book Discovery Call'],
                'show_lead_form' => false,
            ]);
        }

        if ($this->matchesAny($q, ['tech', 'stack', 'laravel', 'react', 'vue', 'flutter', 'node', 'python', 'security'])) {
            return response()->json([
                'reply' => 'Our production stack includes Laravel/PHP 8.3+, React/Next.js, Vue/Alpine, Tailwind CSS, Flutter/React Native, Python/AI pipelines, MySQL/PostgreSQL/Redis, and AWS/Docker/Kubernetes — all built with OWASP security hardening.',
                'links' => [
                    ['label' => 'About Our Team', 'url' => route('about', [], false)],
                    ['label' => 'Explore Services', 'url' => route('services.index', [], false)],
                ],
                'suggestions' => ['MVP & Pricing', 'Book Discovery Call'],
                'show_lead_form' => false,
            ]);
        }

        return response()->json([
            'reply' => "Great question! At {$brand}, we help global startups and businesses design, build, and scale custom software, SaaS platforms, DevOps & Cloud infrastructure, and AI automation. Ask me about pricing, timelines, tech stack, or drop your project inquiry directly.",
            'links' => [
                ['label' => 'Explore Services', 'url' => route('services.index', [], false)],
                ['label' => 'Contact Us', 'url' => route('contact', [], false)],
            ],
            'suggestions' => ['Explore Services', 'MVP & Pricing', 'SaaS & DevOps', 'Book Discovery Call'],
            'show_lead_form' => false,
        ]);
    }

    public function lead(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:120'],
            'email' => ['required', 'email:rfc', 'max:180'],
            'message' => ['required', 'string', 'min:5', 'max:2000'],
        ]);

        ContactInquiry::create([
            'name' => strip_tags(trim($validated['name'])),
            'email' => trim($validated['email']),
            'subject' => 'Chatbot Discovery Request',
            'message' => strip_tags(trim($validated['message'])),
            'service_interested' => 'General Startup Consultation',
            'status' => 'new',
            'ip_address' => $request->ip(),
        ]);

        return response()->json([
            'status' => 'ok',
            'reply' => 'Thank you! Your inquiry has been sent to our engineering team. We will follow up at '.$validated['email'].' within 24 hours.',
        ]);
    }

    private function findMatchingService(string $query): ?Service
    {
        try {
            if (! Schema::hasTable('services')) {
                return null;
            }

            foreach (Service::active()->get(['title', 'slug', 'short_description']) as $service) {
                $needle = Str::lower($service->title);
                if (str_contains($query, $needle) || str_contains($query, str_replace('-', ' ', $service->slug))) {
                    return $service;
                }
            }
        } catch (\Throwable $e) {
            return null;
        }

        return null;
    }

    /**
     * @return list<string>
     */
    private function getActiveServiceTitles(): array
    {
        try {
            if (! Schema::hasTable('services')) {
                return [];
            }

            return Service::active()->take(8)->pluck('title')->all();
        } catch (\Throwable $e) {
            return [];
        }
    }

    /**
     * @param  list<string>  $keywords
     */
    private function matchesAny(string $text, array $keywords): bool
    {
        foreach ($keywords as $keyword) {
            if (str_contains($text, $keyword)) {
                return true;
            }
        }

        return false;
    }
}

