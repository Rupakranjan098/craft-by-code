<?php

namespace Database\Seeders;

use App\Models\BlogPost;
use Illuminate\Database\Seeder;

class BlogPostSeeder extends Seeder
{
    public function run(): void
    {
        $blogs = [
            [
                'title' => '10 Best Practices for Clean Code in 2025',
                'slug' => '10-best-practices-for-clean-code',
                'category' => 'Development',
                'image' => '/assets/images/blog/blog-code.jpg',
                'excerpt' => 'Writing clean code is essential for scalability, velocity, and long-term business success. Here are the 10 proven principles our engineering team practices every day.',
                'content' => '<p>Writing clean, maintainable code is not just an aesthetic preference—it is a critical business strategy. In fast-moving technology companies, software that is difficult to understand or modify rapidly becomes technical debt that slows feature velocity to a crawl.</p>
<h3>1. Meaningful Names</h3>
<p>Choose names that reveal intent. A variable, function, or class name should tell you why it exists, what it does, and how it is used without requiring additional comments.</p>
<h3>2. Functions Should Do One Thing</h3>
<p>Functions should be small and do one thing only, and do it well. When a function executes multiple operations, extracting them into separate helper methods dramatically improves testability.</p>
<h3>3. Keep Controllers Thin</h3>
<p>In modern MVC architectures like Laravel, push business logic into Services, Actions, or Domain models. This preserves controller clarity and keeps endpoints reusable across API and web requests.</p>
<h3>4. Eliminate Duplicate Logic (DRY)</h3>
<p>Every piece of knowledge must have a single, unambiguous, authoritative representation within a system. Extract shared helpers and avoid copy-pasting code blocks.</p>
<h3>5. Test What Matters</h3>
<p>Automated tests give developers confidence to refactor aggressively. Focus on feature integration tests and security boundary tests to protect core business value.</p>',
                'read_time' => '5 min read',
                'author_name' => 'Alex Turner, Lead Architect',
                'published_at' => now()->subDays(3),
                'is_featured' => true,
                'is_published' => true,
            ],
            [
                'title' => 'UI/UX Trends to Watch: Designing for Conversions',
                'slug' => 'ui-ux-trends-to-watch',
                'category' => 'Design',
                'image' => '/assets/images/blog/blog-design.jpg',
                'excerpt' => 'Explore the latest UI/UX trends shaping high-converting digital products, from micro-interactions to accessible dark mode design.',
                'content' => '<p>User experience is experiencing a renaissance. As users interact with dozens of web and mobile apps daily, tolerance for confusing navigation or sluggish loading has dropped to zero.</p>
<h3>Micro-Interactions that Delight</h3>
<p>Subtle hover animations, button feedback ripples, and fluid tab transitions provide immediate psychological feedback, assuring users their inputs are registered.</p>
<h3>Minimalist Contrast & Accessibility</h3>
<p>Clean whitespace paired with bold typography and high-contrast electric accents ensures your message cuts through noise while complying with modern WCAG accessibility criteria.</p>
<h3>Performance as a UX Pillar</h3>
<p>A beautiful design that loads slowly is a failed design. Modern interfaces prioritize sub-second Core Web Vitals, skeleton states, and optimistic UI updates.</p>',
                'read_time' => '4 min read',
                'author_name' => 'Elena Rostova, Head of Design',
                'published_at' => now()->subDays(7),
                'is_featured' => true,
                'is_published' => true,
            ],
            [
                'title' => 'How AI is Transforming Modern Businesses & Workflows',
                'slug' => 'how-ai-is-transforming-businesses',
                'category' => 'AI',
                'image' => '/assets/images/blog/blog-ai.jpg',
                'excerpt' => 'AI automation tools are helping businesses reduce manual overhead and increase productivity tenfold. Discover practical ways your team can leverage them.',
                'content' => '<p>Artificial intelligence has transitioned from research labs into daily business operations. Companies deploying automated workflows and generative assistants are discovering unprecedented productivity gains.</p>
<h3>Retrieval-Augmented Generation (RAG)</h3>
<p>By connecting Large Language Models directly to proprietary internal company wikis and support databases, organizations eliminate repetitive tier-1 support queries without risking data leaks.</p>
<h3>Automating Tedious Data Pipelines</h3>
<p>From automated PDF invoice parsing to real-time sentiment analysis on incoming client leads, AI removes friction from high-volume operations.</p>
<h3>Human-in-the-Loop Safeguards</h3>
<p>The most resilient AI implementations treat machine learning models as high-speed copilots with human validation safeguards on critical financial and security operations.</p>',
                'read_time' => '6 min read',
                'author_name' => 'David Kim, AI Lead',
                'published_at' => now()->subDays(12),
                'is_featured' => true,
                'is_published' => true,
            ],
            [
                'title' => 'Cross-Platform Mobile App Architecture with Flutter & React Native',
                'slug' => 'cross-platform-mobile-app-architecture',
                'category' => 'Mobile',
                'image' => '/assets/images/blog/blog-mobile.jpg',
                'excerpt' => 'A strategic comparison of Flutter and React Native for startups looking to launch on iOS and Android with maximum performance and minimal overhead.',
                'content' => '<p>Choosing the right mobile framework is one of the most critical early decisions for a startup. Building separate native codebases for iOS and Android often doubles development costs without doubling value.</p>
<h3>Single Codebase, Native Performance</h3>
<p>Modern cross-platform frameworks achieve 60fps rendering, hardware-accelerated animations, and direct access to native device APIs including biometric authentication and camera sensors.</p>
<h3>State Management Best Practices</h3>
<p>Whether using Riverpod in Flutter or Redux Toolkit / Zustand in React Native, predictable unidirectional data flow guarantees offline data synchronization and zero screen flickering.</p>
<h3>Automated App Store CI/CD</h3>
<p>Fastlane and GitHub Actions automate testing, code signing, and release deployments directly to TestFlight and Google Play Internal tracks.</p>',
                'read_time' => '7 min read',
                'author_name' => 'Marcus Vance, Principal Mobile Engineer',
                'published_at' => now()->subDays(16),
                'is_featured' => true,
                'is_published' => true,
            ],
            [
                'title' => 'Scaling Modern E-Commerce Platforms for Peak Traffic',
                'slug' => 'scaling-modern-ecommerce-platforms',
                'category' => 'E-Commerce',
                'image' => '/assets/images/blog/blog-ecommerce.jpg',
                'excerpt' => 'How we architect e-commerce systems to handle flash sales, complex inventory locks, and international payments without downtime.',
                'content' => '<p>During high-volume sales events, sudden traffic surges can crash unprepared checkouts, resulting in abandoned carts and lost revenue. Architecture must be resilient before the traffic hits.</p>
<h3>Redis Atomic Inventory Locks</h3>
<p>Prevent overselling during flash promotions by leveraging distributed atomic locks in Redis. Inventory is reserved momentarily during checkout and returned instantly if payment expires.</p>
<h3>Edge Caching & Headless Storefronts</h3>
<p>By decoupling frontend catalog presentation from backend transactional databases, static product descriptions load instantly from worldwide CDN edge points.</p>
<h3>Payment Gateway Redundancy</h3>
<p>Implementing smart payment routing across Stripe, PayPal, and regional gateways prevents checkout failures during localized banking outages.</p>',
                'read_time' => '6 min read',
                'author_name' => 'Sophia Chen, Cloud Infrastructure Lead',
                'published_at' => now()->subDays(22),
                'is_featured' => false,
                'is_published' => true,
            ],
            [
                'title' => 'Building Resilient Backend APIs with Laravel & Microservices',
                'slug' => 'building-resilient-backend-apis',
                'category' => 'Backend',
                'image' => '/assets/images/blog/blog-backend.jpg',
                'excerpt' => 'Architectural patterns for high-throughput REST and GraphQL APIs, featuring database sharding, rate limiting, and zero-downtime deployments.',
                'content' => '<p>Modern software platforms rely on robust APIs that must remain available 24/7/365 under variable network conditions and fluctuating query volumes.</p>
<h3>Idempotency & Resilient Retries</h3>
<p>Equipping API mutations with unique idempotency keys prevents duplicate billing and database race conditions when mobile clients retry dropped connections.</p>
<h3>Tiered Rate Limiting & Throttling</h3>
<p>Rate limiters protect critical endpoints from brute-force attempts and denial-of-service spikes while providing authenticated customers higher guaranteed throughput.</p>
<h3>Structured Logging & Tracing</h3>
<p>Distributed tracing across asynchronous queues and background workers enables engineering teams to diagnose latency bottlenecks within seconds.</p>',
                'read_time' => '8 min read',
                'author_name' => 'Alex Turner, Lead Architect',
                'published_at' => now()->subDays(28),
                'is_featured' => false,
                'is_published' => true,
            ],
        ];

        foreach ($blogs as $b) {
            BlogPost::updateOrCreate(['slug' => $b['slug']], $b);
        }
    }
}

