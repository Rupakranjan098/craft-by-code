<?php

namespace Database\Seeders;

use App\Models\Service;
use Illuminate\Database\Seeder;

class ServiceSeeder extends Seeder
{
    public function run(): void
    {
        $services = [
            [
                'title' => 'Web Development',
                'slug' => 'web-development',
                'icon' => 'globe',
                'badge' => 'Most Popular',
                'short_description' => 'Fast, responsive and scalable web applications built for growth and seamless user experience.',
                'full_description' => 'We engineer high-performance web applications that combine stunning visual aesthetics with scalable architecture. From modern single-page applications to enterprise web platforms, our team leverages cutting-edge frameworks like Laravel, Vue, React, and Tailwind CSS to create responsive, secure, and SEO-optimized solutions.',
                'features' => [
                    'Custom Full-Stack Development',
                    'Single Page Applications (SPA)',
                    'Progressive Web Apps (PWA)',
                    'Responsive UI Across All Devices',
                    'Performance & Speed Optimization',
                    'Enterprise CMS Solutions',
                ],
                'benefits' => [
                    'Lightning-fast load times boosting conversion rates',
                    'Clean, maintainable, and extensible code architecture',
                    'SEO-ready structure to maximize search visibility',
                    'Enterprise-grade security and data encryption',
                ],
                'tech_stack' => ['Laravel', 'PHP 8.4', 'Vue.js', 'React', 'Tailwind CSS', 'MySQL', 'Redis'],
                'order' => 1,
                'is_featured' => true,
                'is_active' => true,
            ],
            [
                'title' => 'Mobile App Development',
                'slug' => 'mobile-app-development',
                'icon' => 'smartphone',
                'badge' => 'Trending',
                'short_description' => 'Cross-platform mobile apps for Android & iOS that users love and engage with daily.',
                'full_description' => 'Transform your mobile presence with robust, native-feel iOS and Android applications. We deliver end-to-end mobile engineering from intuitive UX wireframing to App Store and Google Play deployment, utilizing modern cross-platform technologies to cut time-to-market while delivering 60fps performance.',
                'features' => [
                    'iOS & Android Cross-Platform Apps',
                    'Native Performance & Hardware Integration',
                    'Offline Mode & Local Data Sync',
                    'Push Notifications & User Re-engagement',
                    'Biometric Authentication & In-App Purchases',
                    'App Store & Play Store Publishing',
                ],
                'benefits' => [
                    'Single codebase reducing development costs by 40%',
                    'Smooth, native animations and ultra-responsive touch',
                    'Continuous real-time cloud analytics and crash reporting',
                    'Effortless scalability supporting millions of daily active users',
                ],
                'tech_stack' => ['Flutter', 'React Native', 'Swift', 'Kotlin', 'Firebase', 'RESTful API'],
                'order' => 2,
                'is_featured' => true,
                'is_active' => true,
            ],
            [
                'title' => 'Custom Software Development',
                'slug' => 'custom-software-development',
                'icon' => 'code',
                'badge' => 'Core',
                'short_description' => 'Tailored software solutions built from the ground up to solve your unique operational challenges.',
                'full_description' => 'Off-the-shelf software rarely addresses the nuanced operational requirements of growing enterprises. We engineer custom bespoke software tailored precisely to your internal processes, compliance constraints, and long-term vision.',
                'features' => [
                    'Tailored Architecture & Domain Modeling',
                    'Microservices & Modular Monoliths',
                    'Role-Based Access Control (RBAC)',
                    'Auditing, Logging & Security Hardening',
                    'Database Optimization & Scalability Planning',
                    'Legacy System Modernization & Refactoring',
                ],
                'benefits' => [
                    '100% intellectual property ownership with zero vendor lock-in',
                    'Seamless fit with your proprietary business procedures',
                    'Built to scale seamlessly without recurring per-seat fees',
                    'Comprehensive documentation and developer handoff',
                ],
                'tech_stack' => ['Laravel', 'PostgreSQL', 'Docker', 'Kubernetes', 'GraphQL', 'AWS'],
                'order' => 3,
                'is_featured' => true,
                'is_active' => true,
            ],
            [
                'title' => 'E-Commerce Development',
                'slug' => 'e-commerce-development',
                'icon' => 'shopping-cart',
                'badge' => 'High ROI',
                'short_description' => 'Full-stack e-commerce solutions with frictionless checkout, inventory sync, and maximum conversions.',
                'full_description' => 'Build high-converting digital storefronts crafted for speed, trust, and frictionless mobile purchasing. From bespoke multi-vendor marketplaces to custom WooCommerce and Shopify Plus extensions, we ensure each click drives revenue.',
                'features' => [
                    'Frictionless One-Click Checkout Architecture',
                    'Multi-Currency & Multilingual Localization',
                    'Inventory Sync & Order Fulfillment Automation',
                    'Discount Engines & Customer Loyalty Programs',
                    'Abandoned Cart Recovery Automation',
                    'Payment Gateway Integration (Stripe, Apple Pay, Google Pay)',
                ],
                'benefits' => [
                    'Significant reduction in shopping cart drop-offs',
                    'Sub-second product catalog search & faceted filters',
                    'Omnichannel inventory synchronization',
                    'PCI-DSS compliant payment processing security',
                ],
                'tech_stack' => ['Laravel', 'Shopify Plus', 'WooCommerce', 'Stripe', 'Tailwind CSS', 'Algolia'],
                'order' => 4,
                'is_featured' => true,
                'is_active' => true,
            ],
            [
                'title' => 'Backend & API Development',
                'slug' => 'backend-api-development',
                'icon' => 'git-merge',
                'badge' => 'Scalable Core',
                'short_description' => 'High-throughput backend systems, secure RESTful & GraphQL APIs, and seamless third-party integrations.',
                'full_description' => 'Power your web, mobile, and SaaS applications with resilient backend engineering and clean APIs. We design scalable microservices, database architectures, OAuth2/JWT authentication, payment webhooks, and real-time integrations built for security and speed.',
                'features' => [
                    'RESTful & GraphQL API Architecture',
                    'Secure OAuth2, Sanctum & JWT Authentication',
                    'Stripe, PayPal & Razorpay Payment Integrations',
                    'CRM, ERP & Third-Party Webhook Automation',
                    'Queue Processing, Caching & Rate Limiting',
                    'OpenAPI / Swagger Documentation',
                ],
                'benefits' => [
                    'Fast, reliable data flow across web and mobile apps',
                    'Enterprise-grade API authorization and DDoS throttling',
                    'Fault-tolerant background jobs and automatic retries',
                    'Clean, documented endpoints built to scale effortlessly',
                ],
                'tech_stack' => ['Laravel', 'Node.js', 'REST', 'GraphQL', 'Redis', 'PostgreSQL', 'OAuth2'],
                'order' => 5,
                'is_featured' => false,
                'is_active' => true,
            ],
            [
                'title' => 'Website Maintenance & Support',
                'slug' => 'website-maintenance-support',
                'icon' => 'shield-check',
                'badge' => '24/7 Support',
                'short_description' => 'Proactive monitoring, security patching, cloud backups, and performance fine-tuning.',
                'full_description' => 'Keep your digital flagship operating at peak performance around the clock. Our dedicated maintenance engineers provide proactive uptime monitoring, automated cloud backups, SSL certification, vulnerability patching, and SLA-backed emergency responses.',
                'features' => [
                    '24/7 Automated Uptime & Error Alerting',
                    'Daily Encrypted Off-Site Backups',
                    'Core Framework & Security Patch Updates',
                    'Database Performance Tuning & Indexing',
                    'Malware Scanning & Web Application Firewall',
                    'Dedicated SLA Support & Feature Enhancements',
                ],
                'benefits' => [
                    '99.9% guaranteed uptime assurance',
                    'Zero business interruption from unexpected crashes',
                    'Guaranteed rapid response from senior engineers',
                    'Continuous optimization keeping your site ahead of curves',
                ],
                'tech_stack' => ['AWS CloudWatch', 'Sentry', 'Cloudflare', 'GitHub Actions', 'Docker'],
                'order' => 6,
                'is_featured' => false,
                'is_active' => true,
            ],
        ];

        $slugs = array_column($services, 'slug');
        Service::whereNotIn('slug', $slugs)->delete();

        foreach ($services as $service) {
            Service::updateOrCreate(['slug' => $service['slug']], $service);
        }
    }
}
