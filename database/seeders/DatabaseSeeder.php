<?php

namespace Database\Seeders;

use App\Models\ContactInquiry;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Initial Admin Accounts (Only create if missing; never overwrite existing passwords or MFA)
        $initialPassword = env('ADMIN_INITIAL_PASSWORD');
        if (empty($initialPassword)) {
            $initialPassword = app()->environment('local', 'testing') ? 'Admin@123456!' : bin2hex(random_bytes(16));
        }

        if (! User::where('email', 'admin@craftbycode.tech')->exists()) {
            $primaryAdmin = new User([
                'name' => 'Root Administrator',
                'email' => 'admin@craftbycode.tech',
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

        // 2. Services (6 official services via standalone ServiceSeeder)
        $this->call(ServiceSeeder::class);

        // 3. Featured Projects / Portfolio
        $this->call(ProjectSeeder::class);

        // 4. Testimonials
        $this->call(TestimonialSeeder::class);

        // 5. Blog Posts ("From Our Blog / Latest insights & updates")
        $this->call(BlogPostSeeder::class);

        // 6. Website Settings & Branding (General, Hero, Stats, Contact, Social, CTA, SEO)
        $this->call(WebsiteSettingSeeder::class);

        // 7. About Us Page Sections
        $this->call(AboutContentSeeder::class);

        // 8. Sample Contact Inquiries (To showcase admin dashboard if table empty)
        if (ContactInquiry::count() === 0) {
            $inquiries = [
                [
                    'name' => 'Michael Chen',
                    'email' => 'mchen@innovatecorp.com',
                    'phone' => '+1 (415) 890-1234',
                    'subject' => 'Custom SaaS Platform Development',
                    'message' => 'Hello CraftByCode team, we are seeking an engineering partner to develop an enterprise supply-chain management portal with real-time analytics. We would love to schedule an introductory call this week.',
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
                    'service_interested' => 'Custom Software Development',
                    'status' => 'in_progress',
                    'admin_notes' => 'Sent initial technical questionnaire. Awaiting client reply.',
                    'ip_address' => '127.0.0.1',
                ],
            ];

            foreach ($inquiries as $inq) {
                ContactInquiry::create($inq);
            }
        }
    }
}
