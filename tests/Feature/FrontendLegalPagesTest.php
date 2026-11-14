<?php

namespace Tests\Feature;

use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class FrontendLegalPagesTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(DatabaseSeeder::class);
    }
    /**
     * Test Privacy Policy page is publicly accessible and contains required information
     */
    public function test_privacy_policy_page_is_publicly_accessible(): void
    {
        $response = $this->get(route('legal.privacy'));

        $response->assertStatus(200);
        $response->assertSee('Privacy Policy');
        $response->assertSee('contact@craftbycode.in');
        $response->assertSee('Effective:');
        $response->assertSee('Last Updated:');
        $response->assertDontSee('100 Innovation Way');
    }

    /**
     * Test Terms & Conditions page is publicly accessible and contains required information
     */
    public function test_terms_and_conditions_page_is_publicly_accessible(): void
    {
        $response = $this->get(route('legal.terms'));

        $response->assertStatus(200);
        $response->assertSee('Terms &amp; Conditions', false);
        $response->assertSee('contact@craftbycode.in');
        $response->assertSee('Master Services Agreement');
        $response->assertSee('Effective:');
        $response->assertSee('Last Updated:');
        $response->assertDontSee('100 Innovation Way');
    }

    /**
     * Test Data Security Policy page is publicly accessible and contains technical details
     */
    public function test_data_security_policy_page_is_publicly_accessible(): void
    {
        $response = $this->get(route('legal.security'));

        $response->assertStatus(200);
        $response->assertSee('Data Security Policy');
        $response->assertSee('TLS 1.3');
        $response->assertSee('AES-256');
        $response->assertSee('contact@craftbycode.in');
        $response->assertSee('Effective:');
        $response->assertSee('Last Updated:');
        $response->assertDontSee('100 Innovation Way');
    }

    /**
     * Test Data Deletion & Data Retention Policy page is publicly accessible
     */
    public function test_data_retention_policy_page_is_publicly_accessible(): void
    {
        $response = $this->get(route('legal.retention'));

        $response->assertStatus(200);
        $response->assertSee('Data Deletion &amp; Retention Policy', false);
        $response->assertSee('Retention Window');
        $response->assertSee('Right to Erasure');
        $response->assertSee('contact@craftbycode.in');
        $response->assertSee('Effective:');
        $response->assertSee('Last Updated:');
        $response->assertDontSee('100 Innovation Way');
    }

    /**
     * Test Grievance Officer & Contact Information page is publicly accessible
     */
    public function test_grievance_officer_page_is_publicly_accessible(): void
    {
        $response = $this->get(route('legal.grievance'));

        $response->assertStatus(200);
        $response->assertSee('Grievance Officer &amp; Contact Information', false);
        $response->assertSee('Grievance &amp; Compliance Officer', false);
        $response->assertSee('contact@craftbycode.in');
        $response->assertSee('Phase 1: Acknowledgment');
        $response->assertSee('Within 15 Working Days');
        $response->assertSee('Effective:');
        $response->assertSee('Last Updated:');
        $response->assertDontSee('100 Innovation Way');
    }

    /**
     * Test common legal URL aliases redirect to official pages
     */
    public function test_legal_url_aliases_redirect_properly(): void
    {
        $this->get('/privacy')->assertRedirect('/privacy-policy');
        $this->get('/terms')->assertRedirect('/terms-and-conditions');
        $this->get('/data-security')->assertRedirect('/data-security-policy');
        $this->get('/data-deletion-policy')->assertRedirect('/data-retention-policy');
    }

    /**
     * Test website footer links to all five legal pages
     */
    public function test_website_footer_contains_all_five_legal_links(): void
    {
        $response = $this->get(route('home'));

        $response->assertStatus(200);
        $response->assertSee(route('legal.privacy'));
        $response->assertSee(route('legal.terms'));
        $response->assertSee(route('legal.security'));
        $response->assertSee(route('legal.retention'));
        $response->assertSee(route('legal.grievance'));
        $response->assertSee('contact@craftbycode.in');
        $response->assertDontSee('100 Innovation Way');
    }

    /**
     * Test public users cannot access any private agreement management routes
     */
    public function test_public_users_cannot_access_private_agreement_management(): void
    {
        // Unauthenticated guests attempting to access agreement routes must be blocked
        $this->get(route('admin.agreements.index'))->assertRedirect(route('admin.login'));
        $this->get(route('admin.agreements.create'))->assertRedirect(route('admin.login'));
        $this->get(route('admin.agreements.archive'))->assertRedirect(route('admin.login'));
        $this->get(route('admin.agreements.templates.index'))->assertRedirect(route('admin.login'));
    }

    /**
     * Test sitemap.xml includes all five legal pages
     */
    public function test_sitemap_xml_includes_all_legal_pages(): void
    {
        $response = $this->get(route('sitemap'));

        $response->assertStatus(200);
        $response->assertHeader('Content-Type', 'application/xml; charset=UTF-8');
        $response->assertSee(route('legal.privacy'));
        $response->assertSee(route('legal.terms'));
        $response->assertSee(route('legal.security'));
        $response->assertSee(route('legal.retention'));
        $response->assertSee(route('legal.grievance'));
    }
}
