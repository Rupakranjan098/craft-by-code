<?php

namespace Tests\Feature;

use App\Models\BlogPost;
use App\Models\Project;
use App\Models\Service;
use App\Models\User;
use App\Models\WebsiteSetting;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class SeoOptimizationTest extends TestCase
{
    use RefreshDatabase;

    public function test_sitemap_xml_lists_public_routes_and_excludes_admin_and_inactive_entries(): void
    {
        $this->seed(DatabaseSeeder::class);

        $inactiveService = Service::create([
            'title' => 'Hidden Draft Service',
            'slug' => 'hidden-draft-service',
            'short_description' => 'Hidden',
            'full_description' => 'Hidden service',
            'is_active' => false,
        ]);

        $response = $this->get('/sitemap.xml');

        $response->assertOk();
        $this->assertStringContainsString('application/xml', (string) $response->headers->get('Content-Type'));
        $response->assertSee('<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">', false);
        $response->assertSee(route('home'), false);
        $response->assertSee(route('services.index'), false);
        $response->assertSee(route('portfolio.index'), false);
        $response->assertSee(route('blog.index'), false);
        $response->assertDontSee('/admin', false);
        $response->assertDontSee($inactiveService->slug, false);

        $xml = simplexml_load_string($response->getContent());
        $this->assertNotFalse($xml);
    }

    public function test_public_pages_include_canonical_open_graph_twitter_and_schema_markup(): void
    {
        $this->seed(DatabaseSeeder::class);

        $service = Service::where('is_active', true)->firstOrFail();
        $project = Project::where('is_active', true)->firstOrFail();
        $post = BlogPost::where('is_published', true)->firstOrFail();

        $home = $this->get('/');
        $home->assertOk();
        $home->assertSee('<link rel="canonical" href="'.route('home').'">', false);
        $home->assertSee('<meta property="og:site_name"', false);
        $home->assertSee('<meta name="twitter:card" content="summary_large_image">', false);
        $home->assertSee('"@type":"Organization"', false);
        $home->assertSee('"@type":"WebSite"', false);

        $svc = $this->get(route('services.show', $service->slug));
        $svc->assertOk();
        $svc->assertSee('"@type":"Service"', false);
        $svc->assertSee('"@type":"BreadcrumbList"', false);

        $proj = $this->get(route('portfolio.show', $project->slug));
        $proj->assertOk();
        $proj->assertSee('"@type":"CreativeWork"', false);

        $blog = $this->get(route('blog.show', $post->slug));
        $blog->assertOk();
        $blog->assertSee('"@type":"BlogPosting"', false);
        $blog->assertSee('<meta property="og:type" content="article">', false);

        $filtered = $this->get('/services?search=saas');
        $filtered->assertOk();
        $filtered->assertSee('<link rel="canonical" href="'.route('services.index').'">', false);
        $filtered->assertSee('<meta name="robots" content="noindex, follow">', false);
    }

    public function test_admin_routes_emit_noindex_headers_and_gsc_ga4_settings_validate_and_render_safely(): void
    {
        $this->seed(DatabaseSeeder::class);

        $loginResp = $this->get('/admin/login');
        $loginResp->assertOk();
        $this->assertStringContainsString('noindex', (string) $loginResp->headers->get('X-Robots-Tag'));

        $admin = new User([
            'name' => 'SEO Admin',
            'email' => 'seo-admin@craftbycode.test',
            'password' => Hash::make('StrongPass#2026!'),
        ]);
        $admin->role = 'admin';
        $admin->is_active = true;
        $admin->save();

        $this->post('/admin/login', [
            'email' => 'seo-admin@craftbycode.test',
            'password' => 'StrongPass#2026!',
        ])->assertRedirect('/admin/dashboard');

        // Reject invalid GA4 Measurement ID
        $invalidResp = $this->post('/admin/seo', [
            'ga4_measurement_id' => 'invalid-script-tag',
        ]);
        $invalidResp->assertSessionHasErrors('ga4_measurement_id');

        // Save valid GSC token + GA4 ID
        $validResp = $this->post('/admin/seo', [
            'google_site_verification' => 'abc123XYZ_verifToken99',
            'ga4_measurement_id' => 'G-TEST123456',
        ]);
        $validResp->assertSessionHasNoErrors();

        WebsiteSetting::clearSettingCache();

        $publicResp = $this->get('/');
        $publicResp->assertOk();
        $publicResp->assertSee('<meta name="google-site-verification" content="abc123XYZ_verifToken99">', false);
        $publicResp->assertSee('https://www.googletagmanager.com/gtag/js?id=G-TEST123456', false);
        $publicResp->assertSee('logo-horizontal.webp', false);
        $publicResp->assertSee('favicon-48.png', false);
        $this->assertGreaterThan(1000, filesize(public_path('favicon.ico')));
        $this->assertTrue(is_file(public_path('assets/images/logo-transparent.webp')));
        $this->assertStringContainsString('https://www.googletagmanager.com', (string) $publicResp->headers->get('Content-Security-Policy'));
    }
}
