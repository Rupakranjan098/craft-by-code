<?php

namespace Database\Seeders;

use App\Models\Project;
use Illuminate\Database\Seeder;

class ProjectSeeder extends Seeder
{
    public function run(): void
    {
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
            ],
        ];

        foreach ($projects as $proj) {
            Project::updateOrCreate(['slug' => $proj['slug']], $proj);
        }
    }
}

