<?php

namespace App\Http\Controllers;

use App\Models\BlogPost;
use App\Models\Project;
use App\Models\Service;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Schema;

class SeoPublicController extends Controller
{
    public function sitemap(): Response
    {
        $urls = [
            ['loc' => route('home'), 'priority' => '1.0', 'changefreq' => 'weekly', 'lastmod' => null],
            ['loc' => route('services.index'), 'priority' => '0.9', 'changefreq' => 'weekly', 'lastmod' => null],
            ['loc' => route('portfolio.index'), 'priority' => '0.9', 'changefreq' => 'weekly', 'lastmod' => null],
            ['loc' => route('blog.index'), 'priority' => '0.8', 'changefreq' => 'weekly', 'lastmod' => null],
            ['loc' => route('about'), 'priority' => '0.7', 'changefreq' => 'monthly', 'lastmod' => null],
            ['loc' => route('contact'), 'priority' => '0.8', 'changefreq' => 'monthly', 'lastmod' => null],
            ['loc' => route('legal.privacy'), 'priority' => '0.5', 'changefreq' => 'monthly', 'lastmod' => '2026-11-14T00:00:00+00:00'],
            ['loc' => route('legal.terms'), 'priority' => '0.5', 'changefreq' => 'monthly', 'lastmod' => '2026-11-14T00:00:00+00:00'],
            ['loc' => route('legal.security'), 'priority' => '0.5', 'changefreq' => 'monthly', 'lastmod' => '2026-11-14T00:00:00+00:00'],
            ['loc' => route('legal.retention'), 'priority' => '0.5', 'changefreq' => 'monthly', 'lastmod' => '2026-11-14T00:00:00+00:00'],
            ['loc' => route('legal.grievance'), 'priority' => '0.5', 'changefreq' => 'monthly', 'lastmod' => '2026-11-14T00:00:00+00:00'],
        ];

        try {
            if (Schema::hasTable('services')) {
                foreach (Service::active()->get(['slug', 'updated_at']) as $service) {
                    $urls[] = [
                        'loc' => route('services.show', $service->slug),
                        'priority' => '0.8',
                        'changefreq' => 'monthly',
                        'lastmod' => optional($service->updated_at)->toAtomString(),
                    ];
                }
            }

            if (Schema::hasTable('projects')) {
                foreach (Project::active()->get(['slug', 'updated_at']) as $project) {
                    $urls[] = [
                        'loc' => route('portfolio.show', $project->slug),
                        'priority' => '0.7',
                        'changefreq' => 'monthly',
                        'lastmod' => optional($project->updated_at)->toAtomString(),
                    ];
                }
            }

            if (Schema::hasTable('blog_posts')) {
                foreach (BlogPost::published()->get(['slug', 'published_at', 'updated_at']) as $post) {
                    $urls[] = [
                        'loc' => route('blog.show', $post->slug),
                        'priority' => '0.7',
                        'changefreq' => 'weekly',
                        'lastmod' => optional($post->updated_at ?? $post->published_at)->toAtomString(),
                    ];
                }
            }
        } catch (\Throwable $e) {
            // Keep static core routes valid even before database migrations complete
        }

        $xml = "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n";
        $xml .= "<urlset xmlns=\"http://www.sitemaps.org/schemas/sitemap/0.9\">\n";

        foreach ($urls as $item) {
            $loc = htmlspecialchars($item['loc'], ENT_XML1 | ENT_COMPAT, 'UTF-8');
            $xml .= "  <url>\n";
            $xml .= "    <loc>{$loc}</loc>\n";
            if (! empty($item['lastmod'])) {
                $lastmod = htmlspecialchars($item['lastmod'], ENT_XML1 | ENT_COMPAT, 'UTF-8');
                $xml .= "    <lastmod>{$lastmod}</lastmod>\n";
            }
            $xml .= "    <changefreq>{$item['changefreq']}</changefreq>\n";
            $xml .= "    <priority>{$item['priority']}</priority>\n";
            $xml .= "  </url>\n";
        }

        $xml .= "</urlset>\n";

        return response($xml, 200, [
            'Content-Type' => 'application/xml; charset=UTF-8',
            'Cache-Control' => 'public, max-age=3600',
        ]);
    }
}

