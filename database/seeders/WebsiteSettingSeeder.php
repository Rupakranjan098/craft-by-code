<?php

namespace Database\Seeders;

use App\Models\WebsiteSetting;
use Illuminate\Database\Seeder;

class WebsiteSettingSeeder extends Seeder
{
    public function run(): void
    {
        $settings = [
            // General & Branding
            ['group' => 'general', 'key' => 'brand_name', 'value' => 'CraftByCode', 'type' => 'text', 'label' => 'Brand Name'],
            ['group' => 'general', 'key' => 'brand_tagline', 'value' => 'Building Digital Solutions. Empowering Businesses.', 'type' => 'text', 'label' => 'Brand Tagline'],
            ['group' => 'general', 'key' => 'brand_sub_tagline', 'value' => 'UI/UX • DEVELOPMENT • CREATIVE SOLUTIONS', 'type' => 'text', 'label' => 'Sub-Tagline / Specializations'],
            ['group' => 'general', 'key' => 'brand_badge', 'value' => 'TRUSTED BY STARTUPS & BUSINESSES WORLDWIDE', 'type' => 'text', 'label' => 'Hero Badge Text'],
            ['group' => 'general', 'key' => 'site_description', 'value' => 'CraftByCode is a premium software development and digital solutions company crafting custom web applications, mobile apps, and AI automation for global enterprises.', 'type' => 'textarea', 'label' => 'Site Description'],
            ['group' => 'general', 'key' => 'logo_display_mode', 'value' => 'horizontal_logo', 'type' => 'select', 'label' => 'Logo Display Mode'],
            ['group' => 'general', 'key' => 'site_logo', 'value' => '/assets/images/logo-horizontal.png', 'type' => 'image', 'label' => 'Primary Website Logo'],
            ['group' => 'general', 'key' => 'site_logo_dark', 'value' => '/assets/images/logo-horizontal-dark.png', 'type' => 'image', 'label' => 'Dark Mode Logo'],
            ['group' => 'general', 'key' => 'site_logo_icon', 'value' => '/assets/images/logo-icon-transparent.png', 'type' => 'image', 'label' => 'Logo Icon / Favicon'],
            ['group' => 'general', 'key' => 'site_logo_full', 'value' => '/assets/images/logo.png', 'type' => 'image', 'label' => 'Full Graphic Logo Badge'],

            // Hero Section
            ['group' => 'hero', 'key' => 'hero_headline_1', 'value' => 'WE DESIGN.', 'type' => 'text', 'label' => 'Hero Line 1'],
            ['group' => 'hero', 'key' => 'hero_headline_2', 'value' => 'WE CODE.', 'type' => 'text', 'label' => 'Hero Line 2'],
            ['group' => 'hero', 'key' => 'hero_headline_gradient', 'value' => 'WE INNOVATE.', 'type' => 'text', 'label' => 'Hero Highlight / Gradient Line'],
            ['group' => 'hero', 'key' => 'hero_subtitle', 'value' => 'We build custom digital products, AI automation tools, and MVPs that help startups and businesses grow faster.', 'type' => 'textarea', 'label' => 'Hero Subtitle'],
            ['group' => 'hero', 'key' => 'hero_cta_primary_text', 'value' => 'Explore Services', 'type' => 'text', 'label' => 'Hero Primary Button Text'],
            ['group' => 'hero', 'key' => 'hero_cta_primary_url', 'value' => '/services', 'type' => 'text', 'label' => 'Hero Primary Button Link'],
            ['group' => 'hero', 'key' => 'hero_cta_secondary_text', 'value' => "Let's Talk", 'type' => 'text', 'label' => 'Hero Secondary Button Text'],
            ['group' => 'hero', 'key' => 'hero_cta_secondary_url', 'value' => '/contact', 'type' => 'text', 'label' => 'Hero Secondary Button Link'],

            // Company Statistics
            ['group' => 'stats', 'key' => 'stat_clients_count', 'value' => '50+', 'type' => 'text', 'label' => 'Happy Clients Count'],
            ['group' => 'stats', 'key' => 'stat_clients_label', 'value' => 'Happy Clients', 'type' => 'text', 'label' => 'Happy Clients Label'],
            ['group' => 'stats', 'key' => 'stat_projects_count', 'value' => '120+', 'type' => 'text', 'label' => 'Projects Completed Count'],
            ['group' => 'stats', 'key' => 'stat_projects_label', 'value' => 'Projects Completed', 'type' => 'text', 'label' => 'Projects Completed Label'],
            ['group' => 'stats', 'key' => 'stat_years_count', 'value' => '5+', 'type' => 'text', 'label' => 'Years Experience Count'],
            ['group' => 'stats', 'key' => 'stat_years_label', 'value' => 'Years Experience', 'type' => 'text', 'label' => 'Years Experience Label'],
            ['group' => 'stats', 'key' => 'stat_satisfaction_count', 'value' => '98%', 'type' => 'text', 'label' => 'Client Satisfaction Rate'],
            ['group' => 'stats', 'key' => 'stat_satisfaction_label', 'value' => 'Client Satisfaction', 'type' => 'text', 'label' => 'Client Satisfaction Label'],

            // Company Contact Info
            ['group' => 'contact', 'key' => 'contact_email', 'value' => 'contact@craftbycode.in', 'type' => 'text', 'label' => 'Company Email'],
            ['group' => 'contact', 'key' => 'contact_phone', 'value' => '+91 (Operating Remotely)', 'type' => 'text', 'label' => 'Company Phone'],
            ['group' => 'contact', 'key' => 'contact_address', 'value' => '', 'type' => 'text', 'label' => 'Company Address'],
            ['group' => 'contact', 'key' => 'contact_hours', 'value' => 'Monday - Friday: 9:30 AM - 6:30 PM IST', 'type' => 'text', 'label' => 'Working Hours'],
            ['group' => 'contact', 'key' => 'google_maps_url', 'value' => 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3153.0863816568285!2d-122.39997232348573!3d37.78802271168436!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x80858062828b8c73%3A0x6b63d91cf3241bc3!2sMarket%20St%2C%20San%20Francisco%2C%20CA!5e0!3m2!1sen!2sus!4v1710000000000!5m2!1sen!2sus', 'type' => 'textarea', 'label' => 'Google Maps Embed URL'],

            // Social Media Links
            ['group' => 'social', 'key' => 'social_linkedin', 'value' => 'https://linkedin.com/company/craftbycode', 'type' => 'text', 'label' => 'LinkedIn URL'],
            ['group' => 'social', 'key' => 'social_twitter', 'value' => 'https://x.com/craftbycode', 'type' => 'text', 'label' => 'Twitter/X URL'],
            ['group' => 'social', 'key' => 'social_github', 'value' => 'https://github.com/craftbycode', 'type' => 'text', 'label' => 'GitHub URL'],
            ['group' => 'social', 'key' => 'social_facebook', 'value' => 'https://facebook.com/craftbycode', 'type' => 'text', 'label' => 'Facebook URL'],

            // Call To Action Banner
            ['group' => 'cta', 'key' => 'cta_title', 'value' => "Let's build something amazing together", 'type' => 'text', 'label' => 'Call To Action Title'],
            ['group' => 'cta', 'key' => 'cta_subtitle', 'value' => "Have a project in mind? Let's turn your idea into reality.", 'type' => 'text', 'label' => 'Call To Action Subtitle'],
            ['group' => 'cta', 'key' => 'cta_button_text', 'value' => 'Start a Project', 'type' => 'text', 'label' => 'Call To Action Button Text'],
            ['group' => 'cta', 'key' => 'cta_button_url', 'value' => '/contact', 'type' => 'text', 'label' => 'Call To Action Button URL'],

            // SEO & Meta
            ['group' => 'seo', 'key' => 'meta_title_default', 'value' => 'CraftByCode | MVP, SaaS & Custom Software Development for Global Startups', 'type' => 'text', 'label' => 'Default Meta Title'],
            ['group' => 'seo', 'key' => 'meta_description_default', 'value' => 'CraftByCode partners with global startups and scale-ups to design, build, and launch scalable SaaS platforms, MVPs, web & mobile apps, DevOps cloud infrastructure, and AI automation.', 'type' => 'textarea', 'label' => 'Default Meta Description'],
            ['group' => 'seo', 'key' => 'meta_keywords_default', 'value' => 'startup software development, MVP development agency, SaaS product engineering, custom web application development, DevOps cloud engineering, AI automation for startups', 'type' => 'text', 'label' => 'Default Target Keywords'],
            ['group' => 'seo', 'key' => 'google_site_verification', 'value' => '', 'type' => 'text', 'label' => 'Google Search Console Verification Token'],
            ['group' => 'seo', 'key' => 'ga4_measurement_id', 'value' => '', 'type' => 'text', 'label' => 'Google Analytics 4 Measurement ID'],
            ['group' => 'seo', 'key' => 'seo_og_image', 'value' => 'assets/images/logo-transparent.png', 'type' => 'text', 'label' => 'Default Social Share Image'],
        ];

        foreach ($settings as $s) {
            WebsiteSetting::updateOrCreate(['key' => $s['key']], $s);
        }

        WebsiteSetting::clearSettingCache();
    }
}

