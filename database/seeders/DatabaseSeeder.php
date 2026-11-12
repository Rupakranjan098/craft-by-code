<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Service;
use App\Models\Project;
use App\Models\Testimonial;
use App\Models\WebsiteSetting;
use App\Models\AboutContent;
use App\Models\BlogPost;
use App\Models\ContactInquiry;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Admin User (never hardcode plaintext secrets; initialize only if missing)
        $initialPassword = env('ADMIN_INITIAL_PASSWORD');
        if (! is_string($initialPassword) || strlen($initialPassword) < 12) {
            $initialPassword = \Illuminate\Support\Str::password(20);
        }

        if (! User::where('email', 'admin@uppage.tech')->exists()) {
            $primaryAdmin = new User([
                'name' => 'Admin CraftByCode',
                'email' => 'admin@uppage.tech',
                'password' => Hash::make($initialPassword),
                'phone' => '+1 (555) 019-2834',
                'avatar' => null,
            ]);
            $primaryAdmin->role = 'admin';
            $primaryAdmin->is_active = true;
            $primaryAdmin->save();
        }

        if (! User::where('email', 'admin@craftbycode.com')->exists()) {
            $secondaryAdmin = new User([
                'name' => 'Lead Engineer',
                'email' => 'admin@craftbycode.com',
                'password' => Hash::make($initialPassword),
                'phone' => '+1 (555) 019-2835',
                'avatar' => null,
            ]);
            $secondaryAdmin->role = 'admin';
            $secondaryAdmin->is_active = true;
            $secondaryAdmin->save();
        }

        // 2. Services (11 required services)
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
                    'Enterprise CMS Solutions'
                ],
                'benefits' => [
                    'Lightning-fast load times boosting conversion rates',
                    'Clean, maintainable, and extensible code architecture',
                    'SEO-ready structure to maximize search visibility',
                    'Enterprise-grade security and data encryption'
                ],
                'tech_stack' => ['Laravel', 'PHP 8.4', 'Vue.js', 'React', 'Tailwind CSS', 'MySQL', 'Redis'],
                'order' => 1,
                'is_featured' => true,
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
                    'App Store & Play Store Publishing'
                ],
                'benefits' => [
                    'Single codebase reducing development costs by 40%',
                    'Smooth, native animations and ultra-responsive touch',
                    'Continuous real-time cloud analytics and crash reporting',
                    'Effortless scalability supporting millions of daily active users'
                ],
                'tech_stack' => ['Flutter', 'React Native', 'Swift', 'Kotlin', 'Firebase', 'RESTful API'],
                'order' => 2,
                'is_featured' => true,
            ],
            [
                'title' => 'UI/UX Design',
                'slug' => 'ui-ux-design',
                'icon' => 'palette',
                'badge' => 'Creative',
                'short_description' => 'Beautiful, user-centric designs that convert visitors into loyal, paying customers.',
                'full_description' => 'User experience is at the core of every digital product we construct. Our human-centered design approach marries user psychology, rigorous research, interactive prototyping, and pixel-perfect interface design to turn complex workflows into delightful user journeys.',
                'features' => [
                    'User Journey Mapping & Persona Research',
                    'Interactive Wireframing & Clickable Prototypes',
                    'Comprehensive Design Systems & Tokens',
                    'Micro-interactions & Motion Design',
                    'Accessibility (WCAG 2.1) Compliance',
                    'Usability Testing & Feedback Loops'
                ],
                'benefits' => [
                    'Dramatically increased user engagement and retention',
                    'Clear, conversion-focused user navigation journeys',
                    'Standardized design system speeding up frontend engineering',
                    'Modern, memorable brand impression that outshines competitors'
                ],
                'tech_stack' => ['Figma', 'Adobe XD', 'Protopie', 'Tailwind CSS', 'Storybook'],
                'order' => 3,
                'is_featured' => true,
            ],
            [
                'title' => 'AI Automation',
                'slug' => 'ai-automation',
                'icon' => 'cpu',
                'badge' => 'AI Powered',
                'short_description' => 'AI automation and smart tools for modern businesses looking to scale operations intelligently.',
                'full_description' => 'Harness the transformative power of generative AI, large language models, and automated machine workflows. We build intelligent agentic systems, predictive analytics, natural language assistants, and workflow automations that eliminate redundant manual operations.',
                'features' => [
                    'LLM Integration (OpenAI, Claude, Gemini)',
                    'Custom AI Knowledge Bases & RAG Systems',
                    'Autonomous Workflow & Task Automations',
                    'Intelligent Document & Data Extraction',
                    'Predictive Business Intelligence & Analytics',
                    'Smart AI Customer Support Agents'
                ],
                'benefits' => [
                    'Eliminate up to 70% of repetitive operational workloads',
                    '24/7 intelligent automated customer assistance',
                    'Actionable business foresight derived from unstructured data',
                    'Safe, private AI setups complying with data governance'
                ],
                'tech_stack' => ['Python', 'OpenAI API', 'LangChain', 'FastAPI', 'Vector DB', 'PyTorch'],
                'order' => 4,
                'is_featured' => true,
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
                    'Legacy System Modernization & Refactoring'
                ],
                'benefits' => [
                    '100% intellectual property ownership with zero vendor lock-in',
                    'Seamless fit with your proprietary business procedures',
                    'Built to scale seamlessly without recurring per-seat fees',
                    'Comprehensive documentation and developer handoff'
                ],
                'tech_stack' => ['Laravel', 'PostgreSQL', 'Docker', 'Kubernetes', 'GraphQL', 'AWS'],
                'order' => 5,
                'is_featured' => true,
            ],
            [
                'title' => 'API Integration',
                'slug' => 'api-integration',
                'icon' => 'git-merge',
                'badge' => 'Connectivity',
                'short_description' => 'Seamless third-party API integration and robust custom RESTful and GraphQL API development.',
                'full_description' => 'Connect fragmented software ecosystems into cohesive operational powerhouses. We architect secure, documented, and resilient APIs while connecting your platforms to external payment gateways, CRM systems, shipping providers, and marketing engines.',
                'features' => [
                    'RESTful & GraphQL API Architecture',
                    'Secure OAuth2 & JWT Authentication',
                    'Stripe, PayPal & Razorpay Payment Integrations',
                    'ERP, CRM & Webhook Automation',
                    'Rate Limiting & DDOS Throttling',
                    'Comprehensive OpenAPI / Swagger Documentation'
                ],
                'benefits' => [
                    'Eliminate data silos between software tools',
                    'Instant real-time data sync across platforms',
                    'High-throughput fault tolerance with queue retries',
                    'Developer-friendly developer portal and mock sandbox'
                ],
                'tech_stack' => ['REST', 'GraphQL', 'Webhooks', 'OAuth2', 'Stripe', 'Twilio', 'Zapier'],
                'order' => 6,
                'is_featured' => false,
            ],
            [
                'title' => 'Business Management Software',
                'slug' => 'business-management-software',
                'icon' => 'briefcase',
                'badge' => 'Enterprise',
                'short_description' => 'Integrated ERP, CRM, and inventory management systems designed for operational excellence.',
                'full_description' => 'Equip your leadership and departments with unified business intelligence and operational command. We design custom ERP, HRM, invoicing, inventory tracking, and client management systems tailored to streamline team collaboration.',
                'features' => [
                    'Custom CRM & Sales Pipeline Management',
                    'Multi-Warehouse Inventory & Supply Chain Tracking',
                    'Automated Invoicing & Financial Accounting',
                    'HRM, Payroll & Employee Attendance Portals',
                    'Executive Analytics & Real-Time Reporting',
                    'Multi-Branch & Multi-Currency Capability'
                ],
                'benefits' => [
                    'Consolidate 5+ fragmented apps into one unified dashboard',
                    'Drastically reduce human data entry errors',
                    'Real-time transparency on revenue, costs, and inventory',
                    'Automate recurring approvals and task assignments'
                ],
                'tech_stack' => ['Laravel', 'MySQL', 'Livewire', 'Tailwind CSS', 'Chart.js', 'Export Tools'],
                'order' => 7,
                'is_featured' => false,
            ],
            [
                'title' => 'E-commerce Development',
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
                    'Payment Gateway Integration (Stripe, Apple Pay, Google Pay)'
                ],
                'benefits' => [
                    'Significant reduction in shopping cart drop-offs',
                    'Sub-second product catalog search & faceted filters',
                    'Omnichannel inventory synchronization',
                    'PCI-DSS compliant payment processing security'
                ],
                'tech_stack' => ['Laravel', 'Shopify Plus', 'WooCommerce', 'Stripe', 'Tailwind CSS', 'Algolia'],
                'order' => 8,
                'is_featured' => false,
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
                    'Dedicated SLA Support & Feature Enhancements'
                ],
                'benefits' => [
                    '99.9% guaranteed uptime assurance',
                    'Zero business interruption from unexpected crashes',
                    'Guaranteed rapid response from senior engineers',
                    'Continuous optimization keeping your site ahead of curves'
                ],
                'tech_stack' => ['AWS CloudWatch', 'Sentry', 'Cloudflare', 'GitHub Actions', 'Docker'],
                'order' => 9,
                'is_featured' => false,
            ],
            [
                'title' => 'SaaS Platforms',
                'slug' => 'saas-platforms',
                'icon' => 'layers',
                'badge' => 'Enterprise',
                'short_description' => 'Multi-tenant cloud SaaS products with subscription billing, analytics, and elastic scalability.',
                'full_description' => 'Launch and scale revenue-generating Software-as-a-Service platforms engineered for security, multi-tenancy, and seamless onboarding. We build complete SaaS ecosystems featuring role-based access control, automated subscription billing, metered usage analytics, and tenant isolation.',
                'features' => [
                    'Multi-Tenant Database & App Architecture',
                    'Subscription Billing & Metered Usage (Stripe)',
                    'Self-Service Onboarding & Team Workspaces',
                    'Role-Based Access Control (RBAC) & SSO',
                    'Real-Time Analytics & Admin Control Planes',
                    'Webhook Pipelines & Public API Keys'
                ],
                'benefits' => [
                    'Launch recurring-revenue SaaS products faster',
                    'Serve thousands of isolated client organizations safely',
                    'Automated dunning, invoicing, and plan upgrades',
                    'Built-in telemetry to track activation and churn'
                ],
                'tech_stack' => ['Laravel', 'React', 'Vue.js', 'Stripe', 'Redis', 'PostgreSQL', 'Tailwind CSS'],
                'order' => 10,
                'is_featured' => false,
            ],
            [
                'title' => 'DevOps & Cloud',
                'slug' => 'devops-cloud',
                'icon' => 'cloud',
                'badge' => 'Cloud Native',
                'short_description' => 'Zero-downtime CI/CD pipelines, containerized Kubernetes clusters, and resilient cloud infrastructure.',
                'full_description' => 'Modernize deployments and guarantee high availability with automated cloud engineering. We design, migrate, and operate cloud-native infrastructure across AWS, Google Cloud, and DigitalOcean with Infrastructure-as-Code, Kubernetes orchestration, automated CI/CD, and 24/7 observability.',
                'features' => [
                    'AWS, GCP & DigitalOcean Cloud Architecture',
                    'Docker & Kubernetes Cluster Orchestration',
                    'Automated CI/CD Pipelines (GitHub Actions / GitLab)',
                    'Infrastructure as Code (Terraform / Ansible)',
                    'Auto-Scaling Load Balancers & Multi-AZ Failover',
                    'Centralized Logging & Observability Stack'
                ],
                'benefits' => [
                    '99.99% uptime with automated failover recovery',
                    'Deploy production releases safely in minutes',
                    'Optimize cloud spend and eliminate wasted compute',
                    'Hardened VPC networking, SSL, and secret vaults'
                ],
                'tech_stack' => ['AWS', 'Google Cloud', 'Docker', 'Kubernetes', 'Terraform', 'GitHub Actions', 'Nginx'],
                'order' => 11,
                'is_featured' => false,
            ],
        ];

        foreach ($services as $service) {
            Service::updateOrCreate(['slug' => $service['slug']], $service);
        }

        // 4. Featured Projects / Portfolio (Matches the 4 in design image + extra)
        $projects = [
            [
                'title' => 'Analytics Dashboard',
                'slug' => 'analytics-dashboard',
                'category' => 'Web Application',
                'client_name' => 'DataFlow Tech Ltd',
                'image' => '/assets/images/projects/project-analytics.jpg',
                'summary' => 'Real-time analytics dashboard for data-driven decisions.',
                'description' => 'A comprehensive, multi-tenant analytics dashboard giving enterprise clients real-time visibility into transactions, server health, user retention, and revenue funnels with sub-second chart rendering.',
                'challenge' => 'The client had disparate PostgreSQL and ClickHouse databases processing 50M events daily, causing slow query load times and fragmented reporting.',
                'solution' => 'We engineered a centralized aggregation pipeline with Redis caching, Laravel backend, and interactive Chart.js widgets that update via WebSockets.',
                'results' => 'Dashboard load time dropped from 8.4 seconds to 120 milliseconds; client user retention improved by 45%.',
                'technologies' => ['Laravel', 'Vue.js', 'Redis', 'PostgreSQL', 'Tailwind CSS', 'Chart.js'],
                'project_url' => 'https://analytics.example.com',
                'order' => 1,
                'is_featured' => true,
            ],
            [
                'title' => 'Fitness App',
                'slug' => 'fitness-app',
                'category' => 'Mobile App',
                'client_name' => 'FitPulse Global',
                'image' => '/assets/images/projects/project-fitness.jpg',
                'summary' => 'Cross-platform fitness app with tracking & analytics.',
                'description' => 'A sleek, cross-platform mobile application featuring interactive workout routines, heart-rate device pairing, calorie counters, and community social leaderboards.',
                'challenge' => 'Existing legacy app had frequent Bluetooth disconnects and poor offline synchronization during workouts.',
                'solution' => 'Re-architected the app with Flutter and an offline-first SQLite sync engine paired with a scalable Laravel API on AWS.',
                'results' => 'Achieved 4.9-star App Store rating with over 200,000 active monthly subscribers within six months of launch.',
                'technologies' => ['Flutter', 'Dart', 'Laravel API', 'Firebase', 'Stripe'],
                'project_url' => 'https://fitpulse.example.com',
                'order' => 2,
                'is_featured' => true,
            ],
            [
                'title' => 'Modern E-commerce',
                'slug' => 'modern-e-commerce',
                'category' => 'E-Commerce',
                'client_name' => 'Aura Living',
                'image' => '/assets/images/projects/project-ecommerce.jpg',
                'summary' => 'Full-stack e-commerce solution with seamless experience.',
                'description' => 'A high-converting direct-to-consumer lifestyle commerce platform featuring personalized recommendations, multi-currency pricing, and one-click checkout.',
                'challenge' => 'High checkout drop-off rates due to complicated checkout steps and slow image rendering during flash sales.',
                'solution' => 'Built an ultrafast headless store architecture with sub-second edge CDN caching, simplified checkout flow, and automated abandoned cart recovery.',
                'results' => 'Conversion rate jumped from 1.8% to 4.2%; cart abandonment dropped by 34%.',
                'technologies' => ['Laravel', 'Tailwind CSS', 'Alpine.js', 'Stripe', 'MySQL', 'Cloudflare'],
                'project_url' => 'https://auraliving.example.com',
                'order' => 3,
                'is_featured' => true,
            ],
            [
                'title' => 'Project Management Tool',
                'slug' => 'project-management-tool',
                'category' => 'SaaS Platform',
                'client_name' => 'SyncTask Inc',
                'image' => '/assets/images/projects/project-saas.jpg',
                'summary' => 'SaaS platform to manage projects, tasks and team efficiency.',
                'description' => 'An intuitive project management suite enabling agile squads to plan sprints, track time, automate approvals, and collaborate across global timezones.',
                'challenge' => 'Scaling WebSocket communication and Kanban drag-and-drop state across thousands of simultaneous remote team members.',
                'solution' => 'Implemented optimistic UI state handling, Redis Pub/Sub WebSocket event channels, and modular board architecture.',
                'results' => 'Adopted by 350+ technology agencies with 99.98% uptime SLA compliance.',
                'technologies' => ['Laravel', 'Vue.js', 'WebSockets', 'Tailwind CSS', 'Docker'],
                'project_url' => 'https://synctask.example.com',
                'order' => 4,
                'is_featured' => true,
            ],
            [
                'title' => 'AI Automated Customer Support',
                'slug' => 'ai-automated-customer-support',
                'category' => 'AI Automation',
                'client_name' => 'Nexus Cloud Care',
                'image' => '/assets/images/projects/project-ai.jpg',
                'summary' => 'Autonomous customer support agent resolving 65% tickets instantly.',
                'description' => 'Enterprise conversational AI agent integrated with Zendesk and internal knowledge bases to autonomously answer complex technical customer queries.',
                'challenge' => 'Support team overwhelmed by 5,000+ repetitive tier-1 tickets per week with slow first-response times.',
                'solution' => 'Developed custom RAG AI pipeline with vector embedding search, sentiment analysis, and intelligent human agent handoff.',
                'results' => 'First response time reduced from 4 hours to 12 seconds; ticket resolution satisfaction reached 94%.',
                'technologies' => ['Python', 'OpenAI', 'Laravel', 'LangChain', 'Pinecone'],
                'project_url' => 'https://nexuscare.example.com',
                'order' => 5,
                'is_featured' => false,
            ],
            [
                'title' => 'Enterprise Health Cloud',
                'slug' => 'enterprise-health-cloud',
                'category' => 'Web Application',
                'client_name' => 'MediCore Health',
                'image' => '/assets/images/projects/project-health.jpg',
                'summary' => 'HIPAA-compliant patient portal and telemedicine engine.',
                'description' => 'Secure telemedicine platform facilitating end-to-end video consultations, encrypted electronic medical records, and digital prescriptions.',
                'challenge' => 'Strict healthcare privacy compliance and low-latency video streaming in rural connectivity areas.',
                'solution' => 'Engineered end-to-end encrypted WebRTC streaming, audit-trailed database records, and automated SMS appointment reminders.',
                'results' => 'Safely processed over 150,000 patient tele-visits with 100% HIPAA audit compliance.',
                'technologies' => ['Laravel', 'WebRTC', 'MySQL', 'Tailwind CSS', 'AWS S3 Vault'],
                'project_url' => 'https://medicore.example.com',
                'order' => 6,
                'is_featured' => false,
            ]
        ];

        foreach ($projects as $proj) {
            Project::updateOrCreate(['slug' => $proj['slug']], $proj);
        }

        // 5. Testimonials (Matching the 3 cards in the design mock)
        $testimonials = [
            [
                'client_name' => 'Rohit Sharma',
                'designation' => 'CEO',
                'company' => 'D2C Startup',
                'avatar' => '/assets/images/testimonials/avatar-1.jpg',
                'rating' => 5,
                'content' => 'CraftByCode transformed our idea into a powerful digital product. Their team is professional, creative and super responsive. They delivered well ahead of schedule and the code quality is top-notch.',
                'order' => 1,
                'is_featured' => true,
            ],
            [
                'client_name' => 'Anjali Verma',
                'designation' => 'Product Manager',
                'company' => 'FinScale Systems',
                'avatar' => '/assets/images/testimonials/avatar-2.jpg',
                'rating' => 5,
                'content' => 'Amazing experience from start to finish. They delivered on time and the quality exceeded our expectations. The attention to detail in UX design and backend stability made all the difference.',
                'order' => 2,
                'is_featured' => true,
            ],
            [
                'client_name' => 'Vikram Patel',
                'designation' => 'Founder',
                'company' => 'SaaS Company',
                'avatar' => '/assets/images/testimonials/avatar-3.jpg',
                'rating' => 5,
                'content' => 'Their attention to detail and technical expertise is outstanding. Highly recommended! We have partnered with them on 4 consecutive product launches and each has been a major commercial success.',
                'order' => 3,
                'is_featured' => true,
            ],
            [
                'client_name' => 'Sarah Jenkins',
                'designation' => 'VP of Engineering',
                'company' => 'CloudScale Global',
                'avatar' => '/assets/images/testimonials/avatar-4.jpg',
                'rating' => 5,
                'content' => 'CraftByCode is the most dependable engineering partner we have ever contracted with. Clean Laravel architecture, prompt communication, and zero technical debt. Truly world-class.',
                'order' => 4,
                'is_featured' => false,
            ]
        ];

        foreach ($testimonials as $t) {
            Testimonial::updateOrCreate(['client_name' => $t['client_name']], $t);
        }

        // 6. Blog Posts (Matching the 3 in design mock)
        $blogs = [
            [
                'title' => '10 Best Practices for Clean Code in 2025',
                'slug' => '10-best-practices-for-clean-code',
                'category' => 'Development',
                'image' => '/assets/images/blog/blog-code.jpg',
                'excerpt' => 'Writing clean code is important for scalability, team speed, and long-term business success. Here are the 10 proven principles we practice every day.',
                'content' => '<p>Writing clean, maintainable code is not just an aesthetic preference—it is a critical business strategy. In fast-moving technology companies, software that is difficult to understand or modify rapidly becomes technical debt that slows feature velocity to a crawl.</p><h3>1. Meaningful Names</h3><p>Choose names that reveal intent. A variable, function, or class name should tell you why it exists, what it does, and how it is used without requiring additional comments.</p><h3>2. Functions Should Do One Thing</h3><p>Functions should be small and do one thing only, and do it well. When a function executes multiple operations, extracting them into separate helper methods dramatically improves testability.</p><h3>3. Keep Controllers Thin</h3><p>In modern MVC architectures like Laravel, push business logic into Services, Actions, or Domain models. This preserves controller clarity and keeps endpoints reusable across API and web requests.</p>',
                'read_time' => '5 min read',
                'author_name' => 'Alex Turner, Lead Architect',
                'published_at' => now()->subDays(5),
                'is_featured' => true,
            ],
            [
                'title' => 'UI/UX Trends to Watch: Designing for Conversions',
                'slug' => 'ui-ux-trends-to-watch',
                'category' => 'Design',
                'image' => '/assets/images/blog/blog-design.jpg',
                'excerpt' => 'Explore the latest UI/UX trends that are shaping the future of digital products, from spatial depth to hyper-personalized onboarding.',
                'content' => '<p>User experience is experiencing a renaissance. As users interact with dozens of web and mobile apps daily, tolerance for confusing navigation or sluggish loading has dropped to zero.</p><h3>Micro-Interactions that Delight</h3><p>Subtle hover animations, button feedback ripples, and fluid tab transitions provide immediate psychological feedback, assuring users their inputs are registered.</p><h3>Minimalist Contrast & Accessibility</h3><p>Clean whitespace paired with bold typography and high-contrast electric accents ensures your message cuts through noise while complying with modern WCAG accessibility criteria.</p>',
                'read_time' => '4 min read',
                'author_name' => 'Elena Rostova, Head of Design',
                'published_at' => now()->subDays(12),
                'is_featured' => true,
            ],
            [
                'title' => 'How AI is Transforming Modern Businesses & Workflows',
                'slug' => 'how-ai-is-transforming-businesses',
                'category' => 'AI',
                'image' => '/assets/images/blog/blog-ai.jpg',
                'excerpt' => 'AI automation tools are helping businesses save time, decrease overhead, and increase productivity tenfold. Discover how your team can leverage them.',
                'content' => '<p>Artificial intelligence has transitioned from academic labs into daily business operations. Companies deploying automated workflows and generative assistants are discovering unprecedented productivity gains.</p><h3>Retrieval-Augmented Generation (RAG)</h3><p>By connecting Large Language Models directly to proprietary internal company wikis and support databases, organizations eliminate repetitive tier-1 support queries without risking data leaks.</p><h3>Automating Tedious Data Pipelines</h3><p>From automated PDF invoice parsing to real-time sentiment analysis on incoming client leads, AI removes friction from high-volume operations.</p>',
                'read_time' => '6 min read',
                'author_name' => 'David Kim, AI Lead',
                'published_at' => now()->subDays(20),
                'is_featured' => true,
            ]
        ];

        foreach ($blogs as $b) {
            BlogPost::updateOrCreate(['slug' => $b['slug']], $b);
        }

        // 7. Website Settings
        $settings = [
            // General & Branding
            ['group' => 'general', 'key' => 'brand_name', 'value' => 'CraftByCode', 'type' => 'text', 'label' => 'Brand Name'],
            ['group' => 'general', 'key' => 'brand_tagline', 'value' => 'Building Digital Solutions. Empowering Businesses.', 'type' => 'text', 'label' => 'Brand Tagline'],
            ['group' => 'general', 'key' => 'site_description', 'value' => 'CraftByCode is a premium software development and digital solutions company crafting custom web applications, mobile apps, and AI automation for global enterprises.', 'type' => 'textarea', 'label' => 'Site Description'],
            ['group' => 'general', 'key' => 'brand_badge', 'value' => 'TRUSTED BY STARTUPS & BUSINESSES WORLDWIDE', 'type' => 'text', 'label' => 'Hero Badge Text'],

            // Hero Section
            ['group' => 'hero', 'key' => 'hero_headline_1', 'value' => 'WE DESIGN.', 'type' => 'text', 'label' => 'Hero Line 1'],
            ['group' => 'hero', 'key' => 'hero_headline_2', 'value' => 'WE CODE.', 'type' => 'text', 'label' => 'Hero Line 2'],
            ['group' => 'hero', 'key' => 'hero_headline_gradient', 'value' => 'WE INNOVATE.', 'type' => 'text', 'label' => 'Hero Highlight / Gradient Line'],
            ['group' => 'hero', 'key' => 'hero_subtitle', 'value' => 'We build custom digital products, AI automation tools, and MVPs that help startups and businesses grow faster.', 'type' => 'textarea', 'label' => 'Hero Subtitle'],
            ['group' => 'hero', 'key' => 'hero_cta_primary_text', 'value' => 'Explore Services', 'type' => 'text', 'label' => 'Hero Primary Button Text'],
            ['group' => 'hero', 'key' => 'hero_cta_primary_url', 'value' => '/services', 'type' => 'text', 'label' => 'Hero Primary Button Link'],
            ['group' => 'hero', 'key' => 'hero_cta_secondary_text', 'value' => "Let's Talk", 'type' => 'text', 'label' => 'Hero Secondary Button Text'],
            ['group' => 'hero', 'key' => 'hero_cta_secondary_url', 'value' => '/contact', 'type' => 'text', 'label' => 'Hero Secondary Button Link'],

            // Stats
            ['group' => 'stats', 'key' => 'stat_clients_count', 'value' => '50+', 'type' => 'text', 'label' => 'Happy Clients Count'],
            ['group' => 'stats', 'key' => 'stat_clients_label', 'value' => 'Happy Clients', 'type' => 'text', 'label' => 'Happy Clients Label'],
            ['group' => 'stats', 'key' => 'stat_projects_count', 'value' => '120+', 'type' => 'text', 'label' => 'Projects Completed Count'],
            ['group' => 'stats', 'key' => 'stat_projects_label', 'value' => 'Projects Completed', 'type' => 'text', 'label' => 'Projects Completed Label'],
            ['group' => 'stats', 'key' => 'stat_years_count', 'value' => '5+', 'type' => 'text', 'label' => 'Years Experience Count'],
            ['group' => 'stats', 'key' => 'stat_years_label', 'value' => 'Years Experience', 'type' => 'text', 'label' => 'Years Experience Label'],
            ['group' => 'stats', 'key' => 'stat_satisfaction_count', 'value' => '98%', 'type' => 'text', 'label' => 'Client Satisfaction Rate'],
            ['group' => 'stats', 'key' => 'stat_satisfaction_label', 'value' => 'Client Satisfaction', 'type' => 'text', 'label' => 'Client Satisfaction Label'],

            // Contact Info
            ['group' => 'contact', 'key' => 'contact_email', 'value' => 'hello@craftbycode.tech', 'type' => 'text', 'label' => 'Company Email'],
            ['group' => 'contact', 'key' => 'contact_phone', 'value' => '+1 (555) 019-2834', 'type' => 'text', 'label' => 'Company Phone'],
            ['group' => 'contact', 'key' => 'contact_address', 'value' => '100 Innovation Way, Suite 400, San Francisco, CA 94105', 'type' => 'text', 'label' => 'Company Address'],
            ['group' => 'contact', 'key' => 'contact_hours', 'value' => 'Monday - Friday: 9:00 AM - 6:00 PM EST', 'type' => 'text', 'label' => 'Working Hours'],
            ['group' => 'contact', 'key' => 'google_maps_url', 'value' => 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3153.0863816568285!2d-122.39997232348573!3d37.78802271168436!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x80858062828b8c73%3A0x6b63d91cf3241bc3!2sMarket%20St%2C%20San%20Francisco%2C%20CA!5e0!3m2!1sen!2sus!4v1710000000000!5m2!1sen!2sus', 'type' => 'textarea', 'label' => 'Google Maps Embed URL'],

            // Socials
            ['group' => 'social', 'key' => 'social_linkedin', 'value' => 'https://linkedin.com/company/craftbycode', 'type' => 'text', 'label' => 'LinkedIn URL'],
            ['group' => 'social', 'key' => 'social_twitter', 'value' => 'https://x.com/craftbycode', 'type' => 'text', 'label' => 'Twitter/X URL'],
            ['group' => 'social', 'key' => 'social_github', 'value' => 'https://github.com/craftbycode', 'type' => 'text', 'label' => 'GitHub URL'],
            ['group' => 'social', 'key' => 'social_facebook', 'value' => 'https://facebook.com/craftbycode', 'type' => 'text', 'label' => 'Facebook URL'],

            // CTA Banner
            ['group' => 'cta', 'key' => 'cta_title', 'value' => "Let's build something amazing together", 'type' => 'text', 'label' => 'Call To Action Title'],
            ['group' => 'cta', 'key' => 'cta_subtitle', 'value' => 'Have a project in mind? Let\'s turn your idea into reality.', 'type' => 'text', 'label' => 'Call To Action Subtitle'],
            ['group' => 'cta', 'key' => 'cta_button_text', 'value' => 'Start a Project', 'type' => 'text', 'label' => 'Call To Action Button Text'],
            ['group' => 'cta', 'key' => 'cta_button_url', 'value' => '/contact', 'type' => 'text', 'label' => 'Call To Action Button URL'],

            // SEO
            ['group' => 'seo', 'key' => 'meta_title_default', 'value' => 'CraftByCode | MVP, SaaS & Custom Software Development for Global Startups', 'type' => 'text', 'label' => 'Default Meta Title (Global Startups)'],
            ['group' => 'seo', 'key' => 'meta_description_default', 'value' => 'CraftByCode partners with global startups and scale-ups to design, build, and launch scalable SaaS platforms, MVPs, web & mobile apps, DevOps cloud infrastructure, and AI automation.', 'type' => 'textarea', 'label' => 'Default Meta Description'],
            ['group' => 'seo', 'key' => 'meta_keywords_default', 'value' => 'startup software development, MVP development agency, SaaS product engineering, custom web application development, DevOps cloud engineering, AI automation for startups', 'type' => 'text', 'label' => 'Default Target Keywords'],
            ['group' => 'seo', 'key' => 'google_site_verification', 'value' => '', 'type' => 'text', 'label' => 'Google Search Console Meta Verification Token (content attribute only)'],
            ['group' => 'seo', 'key' => 'ga4_measurement_id', 'value' => '', 'type' => 'text', 'label' => 'Google Analytics 4 Measurement ID (e.g. G-XXXXXXXXXX)'],
            ['group' => 'seo', 'key' => 'seo_og_image', 'value' => 'assets/images/logo-transparent.png', 'type' => 'text', 'label' => 'Default Open Graph Social Share Image Path or URL'],
        ];

        foreach ($settings as $s) {
            WebsiteSetting::updateOrCreate(['key' => $s['key']], $s);
        }

        // 8. About Contents
        $aboutSections = [
            [
                'section_key' => 'intro',
                'title' => 'Transforming Ideas Into World-Class Digital Solutions',
                'subtitle' => 'About CraftByCode',
                'content' => 'Founded with a passion for software craftsmanship, CraftByCode empowers startups and enterprises with high-velocity digital solutions. We bridge the gap between creative visual design and complex technical architecture to engineer digital products that solve real-world problems and generate measurable ROI.',
                'order' => 1,
            ],
            [
                'section_key' => 'story',
                'title' => 'Our Story: Born to Build Better',
                'subtitle' => 'How We Started',
                'content' => 'CraftByCode started as a tight-knit collective of seasoned engineers and product designers frustrated with bureaucratic agencies that overpromised and underdelivered. We resolved to construct an engineering firm centered on transparent communication, clean code craftsmanship, and relentless commitment to client success. Over the past 5+ years, we have grown into a trusted technology partner for startups, unicorns, and established businesses across North America, Europe, and Asia.',
                'order' => 2,
            ],
            [
                'section_key' => 'mission_vision',
                'title' => 'Mission & Vision',
                'subtitle' => 'Our Guiding Star',
                'content' => 'Our mission is to empower businesses with transformative software engineering and thoughtful design. Our vision is to be the premier global technology studio recognized for setting new standards in software reliability, elegant UX, and high-impact digital innovation.',
                'data' => [
                    'mission' => 'Empowering modern enterprises through bespoke digital solutions that drive operational agility, revenue growth, and unforgettable customer experiences.',
                    'vision' => 'To be the world’s most trusted software partner for innovators who refuse to compromise on quality, security, or design.'
                ],
                'order' => 3,
            ],
            [
                'section_key' => 'values',
                'title' => 'Core Values That Drive Every Line of Code',
                'subtitle' => 'What We Stand For',
                'content' => 'Our engineering culture is governed by four core pillars that guide every decision we make.',
                'data' => [
                    ['title' => 'Craftsmanship First', 'description' => 'We don’t cut corners. Every database query, API endpoint, and UI component is architected for clean readability and long-term durability.'],
                    ['title' => 'Radical Transparency', 'description' => 'Direct engineer-to-client communication with zero jargon. You always have full access to our git repositories and sprint progress.'],
                    ['title' => 'User-Centric Innovation', 'description' => 'Technology serves humans. We build software that is intuitive, empathetic, and effortless to adopt.'],
                    ['title' => 'Speed Without Compromise', 'description' => 'We launch high-velocity MVPs and features fast by leveraging modern tooling without sacrificing security or scalability.']
                ],
                'order' => 4,
            ],
            [
                'section_key' => 'process',
                'title' => 'Our 5-Step Development Process',
                'subtitle' => 'How We Work',
                'content' => 'A battle-tested agile methodology delivering predictable outcomes from day one.',
                'data' => [
                    ['step' => '01', 'title' => 'Discovery & Blueprinting', 'description' => 'We deep-dive into your business goals, target audience, technical constraints, and deliver an actionable architecture roadmap.'],
                    ['step' => '02', 'title' => 'UI/UX Prototyping', 'description' => 'Our designers create interactive Figma prototypes, conducting user flow validations before a single line of backend code is written.'],
                    ['step' => '03', 'title' => 'Agile Sprint Development', 'description' => 'We build in iterative two-week sprints with automated CI/CD pipelines, allowing you to preview live staging builds continuously.'],
                    ['step' => '04', 'title' => 'Rigorous QA & Security Audit', 'description' => 'Comprehensive automated unit testing, end-to-end browser tests, load testing, and security vulnerability patching.'],
                    ['step' => '05', 'title' => 'Deployment & 24/7 SLA Support', 'description' => 'Zero-downtime production launch with proactive performance monitoring, cloud backups, and ongoing feature enhancement.']
                ],
                'order' => 5,
            ],
            [
                'section_key' => 'why_trust',
                'title' => 'Why Fast-Growing Businesses Trust CraftByCode',
                'subtitle' => 'The CraftByCode Advantage',
                'content' => 'We are not just contractors; we become an extension of your leadership team.',
                'data' => [
                    ['highlight' => '100% IP Ownership', 'desc' => 'You own all code, repositories, design assets, and intellectual property from day one.'],
                    ['highlight' => 'Zero Technical Debt', 'desc' => 'We write strictly tested, standard-compliant PHP 8.4, Laravel, and modern JavaScript.'],
                    ['highlight' => 'Dedicated Project Managers', 'desc' => 'Your single point of contact keeps sprints synchronized with daily asynchronous updates.'],
                    ['highlight' => 'Scalable Infrastructure', 'desc' => 'Cloud architecture ready to handle sudden traffic surges without downtime or cost spikes.']
                ],
                'order' => 6,
            ],
            [
                'section_key' => 'team',
                'title' => 'Meet Our Core Leadership',
                'subtitle' => 'The People Behind the Code',
                'content' => 'Senior technologists, creative strategists, and solution architects passionate about your success.',
                'data' => [
                    ['name' => 'Alexander Hayes', 'role' => 'Founder & Chief Technology Officer', 'bio' => '12+ years building enterprise SaaS platforms and distributed cloud systems.', 'image' => '/assets/images/team/team-1.jpg'],
                    ['name' => 'Maya Lin', 'role' => 'Head of Product & UX Design', 'bio' => 'Former design lead at Silicon Valley scale-ups with a focus on conversion UI.', 'image' => '/assets/images/team/team-2.jpg'],
                    ['name' => 'Marcus Vance', 'role' => 'Lead Full-Stack Architect', 'bio' => 'Specializes in high-throughput Laravel APIs, database clustering, and security.', 'image' => '/assets/images/team/team-3.jpg'],
                    ['name' => 'Chloe Bennett', 'role' => 'AI & Cloud Infrastructure Lead', 'bio' => 'Expert in LLM integration, automated agent workflows, and Kubernetes clusters.', 'image' => '/assets/images/team/team-4.jpg']
                ],
                'order' => 7,
            ]
        ];

        foreach ($aboutSections as $sec) {
            AboutContent::updateOrCreate(['section_key' => $sec['section_key']], $sec);
        }

        // 9. Sample Contact Inquiries (To showcase admin dashboard)
        $inquiries = [
            [
                'name' => 'Michael Chen',
                'email' => 'mchen@innovatecorp.com',
                'phone' => '+1 (415) 890-1234',
                'subject' => 'Custom SaaS Platform Development',
                'message' => 'Hello UpPage team, we are seeking an engineering partner to develop an enterprise supply-chain management portal with real-time analytics. We would love to schedule an introductory call this week.',
                'service_interested' => 'Custom Software Development',
                'status' => 'new',
                'ip_address' => '127.0.0.1',
            ],
            [
                'name' => 'Sophia Taylor',
                'email' => 'sophia@retailpulse.io',
                'phone' => '+1 (212) 555-0199',
                'subject' => 'Mobile App for iOS & Android',
                'message' => 'We are launching a new consumer shopping app and need cross-platform mobile development with Flutter or React Native. Looking for MVP delivery within 3 months.',
                'service_interested' => 'Mobile App Development',
                'status' => 'read',
                'ip_address' => '127.0.0.1',
            ],
            [
                'name' => 'David Morales',
                'email' => 'david@aiworkflows.co',
                'phone' => '+1 (312) 777-8899',
                'subject' => 'AI Automation for Customer Support',
                'message' => 'We want to integrate automated AI agents to handle 50% of our tier-1 helpdesk inquiries. Can you provide a scope of work and timeline?',
                'service_interested' => 'AI Automation',
                'status' => 'in_progress',
                'admin_notes' => 'Sent initial technical questionnaire. Awaiting client reply.',
                'ip_address' => '127.0.0.1',
            ]
        ];

        foreach ($inquiries as $inq) {
            ContactInquiry::create($inq);
        }
    }
}
