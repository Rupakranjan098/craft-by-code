<?php

namespace Database\Seeders;

use App\Models\AgreementTemplate;
use Illuminate\Database\Seeder;

class AgreementTemplateSeeder extends Seeder
{
    public function run(): void
    {
        $templates = [
            [
                'name' => 'Master Software Development Agreement',
                'slug' => 'master-software-development-agreement',
                'category' => 'Software Development',
                'description' => 'Comprehensive enterprise contract for bespoke software engineering, milestone deliverables, IP assignment, warranties, and liability limitations.',
                'default_payment_terms' => "• 30% Initial Mobilization Deposit upon signature\n• 30% Upon Architecture, Core API & Alpha Sprint Sign-off\n• 30% Upon Staging Deployment & UAT Approval\n• 10% Upon Production Launch & Handover (Net 15 days)",
                'content' => "## 1. APPOINTMENT AND SCOPE OF WORK\nThe Company hereby engages CraftByCode to perform the design, engineering, testing, and deployment services detailed under the Scope of Work schedule for {{CLIENT_NAME}} ({{CLIENT_COMPANY}}).\n\n## 2. TIMELINE & DELIVERABLES\nCraftByCode will deliver software increments according to the mutually agreed Sprint Milestones commencing on {{START_DATE}} with scheduled completion by {{END_DATE}}.\n\n## 3. INTELLECTUAL PROPERTY & OWNERSHIP\nUpon receipt of full contract payment of {{CONTRACT_VALUE}}, CraftByCode unconditionally assigns and transfers to {{CLIENT_COMPANY}} all right, title, and intellectual property interest in the customized deliverables, custom codebase, schemas, and proprietary designs developed specifically for this engagement.\n\n## 4. CONFIDENTIALITY & TRADE SECRETS\nBoth parties agree to treat all proprietary source code, credentials, architecture diagrams, business data, and financial terms as strictly confidential for a minimum period of three (3) years from the effective date.\n\n## 5. WARRANTIES & DEFECT WARRANTY PERIOD\nCraftByCode warrants that the delivered codebase will perform substantially in conformance with agreed specifications. CraftByCode provides a thirty (30) day complimentary defect warranty period following production launch to rectify reproducible bugs without additional charges.\n\n## 6. GOVERNING LAW & JURISDICTION\nThis Agreement shall be governed by, construed, and enforced in accordance with the laws of the agreed jurisdiction.",
                'is_active' => true,
            ],
            [
                'name' => 'Startup MVP Sprint Contract',
                'slug' => 'startup-mvp-sprint-contract',
                'category' => 'MVP Development',
                'description' => 'Fixed-scope, rapid 4 to 8-week MVP sprint agreement designed for venture-backed startups and early-stage founders.',
                'default_payment_terms' => "• 50% Upfront Commitment upon project kickoff\n• 50% Upon Final MVP Production Deployment and Handover",
                'content' => "## 1. MVP OBJECTIVES & COMMITMENTS\nCraftByCode will engineer and launch a high-performance Minimum Viable Product (MVP) for {{CLIENT_NAME}} ({{CLIENT_COMPANY}}) focused on rapid market validation, scalable cloud architecture, and user conversion.\n\n## 2. PRODUCTION DELIVERABLES\nDeliverables encompass full-stack application development, database design, user authentication, third-party API integrations, and cloud deployment on AWS / DigitalOcean.\n\n## 3. COMMERCIAL TERMS\nThe total fixed engagement fee is {{CONTRACT_VALUE}}, payable in accordance with the agreed milestone schedule starting {{START_DATE}}.\n\n## 4. SOURCE CODE & REPOSITORY ACCESS\n{{CLIENT_COMPANY}} shall be granted full administrative ownership of the GitHub / GitLab repository upon final milestone settlement.\n\n## 5. POST-LAUNCH FOUNDER SUPPORT\nIncludes two (2) weeks of post-launch stabilization monitoring and priority advisory.",
                'is_active' => true,
            ],
            [
                'name' => 'Website Maintenance & SLA Retainer',
                'slug' => 'website-maintenance-sla-retainer',
                'category' => 'Maintenance & SLA',
                'description' => 'Service Level Agreement (SLA) for 24/7 uptime monitoring, security patching, cloud backups, and ongoing engineering retainers.',
                'default_payment_terms' => "• Recurring monthly retainer billed on the 1st of each calendar month via Automated Invoicing (Net 10).",
                'content' => "## 1. SCOPE OF ONGOING SERVICES\nCraftByCode provides proactive 24/7 infrastructure monitoring, database optimization, framework updates, security vulnerability patching, and continuous cloud backup verification for {{CLIENT_NAME}} ({{CLIENT_COMPANY}}).\n\n## 2. SERVICE LEVEL AGREEMENT (SLA) RESPONSE TIMES\n• Critical Severity 1 (Service Outage): Response within < 1 Hour\n• High Severity 2 (Major Feature Failure): Response within < 4 Hours\n• Normal Severity 3 (Routine Task / Content Update): Response within < 24 Hours\n\n## 3. RETAINER TERMS & RENEWAL\nThis Agreement commences on {{START_DATE}} for an initial term of twelve (12) months at a value of {{CONTRACT_VALUE}} per period.",
                'is_active' => true,
            ],
            [
                'name' => 'Mutual Non-Disclosure Agreement (NDA)',
                'slug' => 'mutual-nda-confidentiality',
                'category' => 'Legal & Compliance',
                'description' => 'Strict bilateral non-disclosure agreement protecting proprietary software architecture, startup business plans, and intellectual property.',
                'default_payment_terms' => "• Not Applicable (Zero Consideration Bilateral Legal Protection)",
                'content' => "## 1. PURPOSE & PROPRIETARY INFORMATION\nCraftByCode and {{CLIENT_COMPANY}} (represented by {{CLIENT_NAME}}) intend to explore or execute commercial technology collaboration and will exchange valuable confidential software specifications, business concepts, source code, and trade secrets.\n\n## 2. NON-DISCLOSURE OBLIGATIONS\nThe Receiving Party shall exercise the highest degree of reasonable care to prevent unauthorized dissemination, reverse-engineering, publication, or commercial exploitation of Confidential Information.\n\n## 3. NON-CIRCUMVENTION\nNeither party will utilize disclosed proprietary relationships, source code, or proprietary technical discoveries to bypass or compete directly with the Disclosing Party.\n\n## 4. TERM & ENFORCEABILITY\nObligations of confidentiality survive termination of talks or active agreements for five (5) consecutive years.",
                'is_active' => true,
            ],
        ];

        foreach ($templates as $t) {
            AgreementTemplate::updateOrCreate(['slug' => $t['slug']], $t);
        }
    }
}
