<?php

namespace Tests\Feature;

use App\Models\ContactInquiry;
use App\Models\Service;
use App\Models\User;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class ServicesAndInquiryWorkflowTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(DatabaseSeeder::class);
    }

    public function test_all_six_services_have_dedicated_multi_pages_directly_accessible(): void
    {
        $expectedSlugs = [
            'web-development',
            'mobile-app-development',
            'custom-software-development',
            'e-commerce-development',
            'backend-api-development',
            'website-maintenance-support',
        ];

        foreach ($expectedSlugs as $slug) {
            $response = $this->get('/services/'.$slug);
            $response->assertOk();

            $service = Service::where('slug', $slug)->firstOrFail();
            $response->assertSee(e($service->title), false);
            $response->assertSee('inquire-form', false);
            $response->assertSee('Inquire About '.e($service->title), false);
            $response->assertSee(route('contact.submit'), false);
        }
    }

    public function test_navbar_and_homepage_expose_direct_links_to_all_services(): void
    {
        $homeResponse = $this->get('/');
        $homeResponse->assertOk();

        $expectedSlugs = [
            'web-development',
            'mobile-app-development',
            'custom-software-development',
            'e-commerce-development',
            'backend-api-development',
            'website-maintenance-support',
        ];

        foreach ($expectedSlugs as $slug) {
            $homeResponse->assertSee('/services/'.$slug, false);
        }

        $servicesResponse = $this->get('/services');
        $servicesResponse->assertOk();
        foreach ($expectedSlugs as $slug) {
            $servicesResponse->assertSee('/services/'.$slug, false);
        }
    }

    public function test_visitor_can_submit_inquiry_and_it_shows_in_database_backend(): void
    {
        $payload = [
            'name' => 'Jordan Vance',
            'email' => 'jordan@startuphub.io',
            'phone' => '+1 (555) 234-5678',
            'subject' => 'Inquiry for Web Development',
            'service_interested' => 'Web Development',
            'message' => 'We want to develop a multi-tenant client portal with real-time billing.',
        ];

        $response = $this->post(route('contact.submit'), $payload);
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('contact_inquiries', [
            'name' => 'Jordan Vance',
            'email' => 'jordan@startuphub.io',
            'service_interested' => 'Web Development',
            'status' => 'new',
        ]);

        $inquiry = ContactInquiry::where('email', 'jordan@startuphub.io')->firstOrFail();
        $this->assertEquals('new', $inquiry->status);

        // Authenticate as Admin and inspect the admin backend
        $admin = new User([
            'name' => 'Backend Admin',
            'email' => 'admin-test@craftbycode.test',
            'password' => Hash::make('SecretPass123!'),
        ]);
        $admin->role = 'admin';
        $admin->is_active = true;
        $admin->save();

        $adminDashboard = $this->actingAs($admin)->get(route('admin.dashboard'));
        $adminDashboard->assertOk();
        $adminDashboard->assertSee('Jordan Vance', false);
        $adminDashboard->assertSee('Web Development', false);

        $adminInquiries = $this->actingAs($admin)->get(route('admin.inquiries.index'));
        $adminInquiries->assertOk();
        $adminInquiries->assertSee('Jordan Vance', false);
        $adminInquiries->assertSee('jordan@startuphub.io', false);

        // Open details
        $adminShow = $this->actingAs($admin)->get(route('admin.inquiries.show', $inquiry->id));
        $adminShow->assertOk();
        $inquiry->refresh();
        $this->assertEquals('read', $inquiry->status);

        // Update Status and Notes
        $updateResponse = $this->actingAs($admin)->put(route('admin.inquiries.status', $inquiry->id), [
            'status' => 'in_progress',
            'admin_notes' => 'Called client on phone. Discovery call scheduled.',
        ]);
        $updateResponse->assertSessionHas('success');

        $inquiry->refresh();
        $this->assertEquals('in_progress', $inquiry->status);
        $this->assertEquals('Called client on phone. Discovery call scheduled.', $inquiry->admin_notes);
    }

    public function test_chatbot_lead_submission_saves_to_database_and_appears_in_backend(): void
    {
        $payload = [
            'name' => 'Sara Connor',
            'email' => 'sara@skytech.co',
            'phone' => '+1 (555) 987-6543',
            'service' => 'Mobile App Development',
            'message' => 'Need an iOS & Android app built for warehouse operations.',
        ];

        $response = $this->postJson(route('chatbot.lead'), $payload);
        $response->assertOk();
        $response->assertJson(['status' => 'ok']);

        $this->assertDatabaseHas('contact_inquiries', [
            'name' => 'Sara Connor',
            'email' => 'sara@skytech.co',
            'service_interested' => 'Mobile App Development',
            'status' => 'new',
        ]);
    }
}
