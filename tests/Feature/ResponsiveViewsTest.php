<?php

namespace Tests\Feature;

use App\Models\BlogPost;
use App\Models\Project;
use App\Models\Service;
use App\Models\User;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class ResponsiveViewsTest extends TestCase
{
    use RefreshDatabase;

    public function test_all_public_pages_render_with_day_night_toggle_and_responsive_layout(): void
    {
        $this->seed(DatabaseSeeder::class);

        $service = Service::where('is_active', true)->firstOrFail();
        $project = Project::where('is_active', true)->firstOrFail();
        $post = BlogPost::where('is_published', true)->firstOrFail();

        $routes = [
            '/',
            '/about',
            '/services',
            '/services/'.$service->slug,
            '/portfolio',
            '/portfolio/'.$project->slug,
            '/blog',
            '/blog/'.$post->slug,
            '/contact',
        ];

        foreach ($routes as $uri) {
            $response = $this->get($uri);
            $response->assertOk();
            $response->assertSee('data-theme-toggle', false);
            $response->assertSee('cbc_theme', false);
            $response->assertSee('overflow-x-clip', false);
        }
    }

    public function test_admin_pages_render_with_day_night_toggle_and_security_center(): void
    {
        $this->seed(DatabaseSeeder::class);

        $admin = new User([
            'name' => 'Admin Reviewer',
            'email' => 'reviewer@craftbycode.test',
            'password' => Hash::make('Str0ng!Pass#2026'),
        ]);
        $admin->role = 'admin';
        $admin->is_active = true;
        $admin->save();

        $publicAuthRoutes = ['/admin/login', '/admin/forgot-password'];
        foreach ($publicAuthRoutes as $uri) {
            $res = $this->get($uri);
            $res->assertOk();
            $res->assertSee('data-theme-toggle', false);
        }

        $protectedRoutes = [
            '/admin/dashboard',
            '/admin/services',
            '/admin/projects',
            '/admin/testimonials',
            '/admin/blog',
            '/admin/inquiries',
            '/admin/settings',
            '/admin/about-content',
            '/admin/seo',
            '/admin/profile',
            '/admin/security',
        ];

        foreach ($protectedRoutes as $uri) {
            $res = $this->actingAs($admin)->get($uri);
            $res->assertOk();
            $res->assertSee('data-theme-toggle', false);
            $res->assertSee('admin-shell', false);
        }
    }

    public function test_admin_resource_show_routes_redirect_to_edit_cleanly(): void
    {
        $this->seed(DatabaseSeeder::class);

        $admin = User::where('role', 'admin')->firstOrFail();
        $project = Project::firstOrFail();
        $post = BlogPost::firstOrFail();
        $service = Service::firstOrFail();

        $this->actingAs($admin)
            ->get('/admin/projects/'.$project->id)
            ->assertRedirect(route('admin.projects.edit', $project->id));

        $this->actingAs($admin)
            ->get('/admin/blog/'.$post->id)
            ->assertRedirect(route('admin.blog.edit', $post->id));

        $this->actingAs($admin)
            ->get('/admin/services/'.$service->id)
            ->assertRedirect(route('admin.services.edit', $service->id));
    }
}

