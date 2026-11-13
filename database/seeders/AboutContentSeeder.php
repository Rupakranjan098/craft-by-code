<?php

namespace Database\Seeders;

use App\Models\AboutContent;
use Illuminate\Database\Seeder;

class AboutContentSeeder extends Seeder
{
    public function run(): void
    {
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
                    'vision' => 'To be the world’s most trusted software partner for innovators who refuse to compromise on quality, security, or design.',
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
                    ['title' => 'Speed Without Compromise', 'description' => 'We launch high-velocity MVPs and features fast by leveraging modern tooling without sacrificing security or scalability.'],
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
                    ['step' => '05', 'title' => 'Deployment & 24/7 SLA Support', 'description' => 'Zero-downtime production launch with proactive performance monitoring, cloud backups, and ongoing feature enhancement.'],
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
                    ['highlight' => 'Scalable Infrastructure', 'desc' => 'Cloud architecture ready to handle sudden traffic surges without downtime or cost spikes.'],
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
                    ['name' => 'Chloe Bennett', 'role' => 'AI & Cloud Infrastructure Lead', 'bio' => 'Expert in LLM integration, automated agent workflows, and Kubernetes clusters.', 'image' => '/assets/images/team/team-4.jpg'],
                ],
                'order' => 7,
            ],
        ];

        foreach ($aboutSections as $sec) {
            AboutContent::updateOrCreate(['section_key' => $sec['section_key']], $sec);
        }
    }
}

