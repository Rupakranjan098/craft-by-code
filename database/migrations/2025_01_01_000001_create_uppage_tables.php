<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // 1. Services Table
        Schema::create('services', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->string('icon')->default('code'); // SVG/Lucide icon name
            $table->string('badge')->nullable(); // e.g. "Popular", "Enterprise"
            $table->text('short_description');
            $table->longText('full_description');
            $table->json('features')->nullable();
            $table->json('benefits')->nullable();
            $table->json('tech_stack')->nullable();
            $table->integer('order')->default(0);
            $table->boolean('is_featured')->default(false);
            $table->boolean('is_active')->default(true);
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            $table->timestamps();
        });

        // 2. Digital Solutions Table
        Schema::create('digital_solutions', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->string('icon')->default('layers');
            $table->string('category')->nullable();
            $table->text('short_description');
            $table->longText('full_description');
            $table->json('features')->nullable();
            $table->json('benefits')->nullable();
            $table->json('technologies')->nullable();
            $table->integer('order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        // 3. Projects / Portfolio Table
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->string('category'); // Web Application, Mobile App, E-Commerce, SaaS Platform, AI Integration
            $table->string('client_name')->nullable();
            $table->string('image')->nullable();
            $table->text('summary');
            $table->longText('description')->nullable();
            $table->text('challenge')->nullable();
            $table->text('solution')->nullable();
            $table->text('results')->nullable();
            $table->json('technologies')->nullable();
            $table->string('project_url')->nullable();
            $table->integer('order')->default(0);
            $table->boolean('is_featured')->default(true);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        // 4. Testimonials Table
        Schema::create('testimonials', function (Blueprint $table) {
            $table->id();
            $table->string('client_name');
            $table->string('designation');
            $table->string('company');
            $table->string('avatar')->nullable();
            $table->integer('rating')->default(5);
            $table->text('content');
            $table->integer('order')->default(0);
            $table->boolean('is_featured')->default(true);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        // 5. Contact Inquiries Table
        Schema::create('contact_inquiries', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email');
            $table->string('phone')->nullable();
            $table->string('subject')->nullable();
            $table->text('message');
            $table->string('service_interested')->nullable();
            $table->string('status')->default('new'); // new, read, in_progress, resolved
            $table->text('admin_notes')->nullable();
            $table->string('ip_address')->nullable();
            $table->timestamps();
        });

        // 6. Website Settings Table
        Schema::create('website_settings', function (Blueprint $table) {
            $table->id();
            $table->string('group')->default('general'); // general, hero, contact, stats, seo, social
            $table->string('key')->unique();
            $table->longText('value')->nullable();
            $table->string('type')->default('text'); // text, textarea, boolean, image, number
            $table->string('label');
            $table->text('description')->nullable();
            $table->timestamps();
        });

        // 7. About Contents Table
        Schema::create('about_contents', function (Blueprint $table) {
            $table->id();
            $table->string('section_key'); // intro, story, mission, vision, values, process, team, why_trust
            $table->string('title');
            $table->string('subtitle')->nullable();
            $table->longText('content')->nullable();
            $table->json('data')->nullable(); // structured data such as process steps, values list, team members
            $table->integer('order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        // 8. Blog Posts Table
        Schema::create('blog_posts', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->string('category');
            $table->string('image')->nullable();
            $table->text('excerpt');
            $table->longText('content');
            $table->string('read_time')->default('5 min read');
            $table->string('author_name')->default('UpPage Team');
            $table->timestamp('published_at')->nullable();
            $table->boolean('is_featured')->default(false);
            $table->boolean('is_published')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('blog_posts');
        Schema::dropIfExists('about_contents');
        Schema::dropIfExists('website_settings');
        Schema::dropIfExists('contact_inquiries');
        Schema::dropIfExists('testimonials');
        Schema::dropIfExists('projects');
        Schema::dropIfExists('digital_solutions');
        Schema::dropIfExists('services');
    }
};

