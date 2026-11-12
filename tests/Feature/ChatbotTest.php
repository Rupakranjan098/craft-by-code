<?php

namespace Tests\Feature;

use App\Models\ContactInquiry;
use App\Models\Service;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ChatbotTest extends TestCase
{
    use RefreshDatabase;

    public function test_public_pages_render_chatbot_widget(): void
    {
        $this->seed(DatabaseSeeder::class);

        $response = $this->get('/');

        $response->assertOk();
        $response->assertSee('craftChatbot(', false);
        $response->assertSee('/chatbot/message', false);
        $response->assertSee('/chatbot/lead', false);
        $response->assertSee('Chat with Us', false);
    }

    public function test_chatbot_endpoint_responds_to_service_and_startup_queries(): void
    {
        $this->seed(DatabaseSeeder::class);

        $service = Service::where('is_active', true)->firstOrFail();

        $res = $this->postJson('/chatbot/message', [
            'message' => 'Tell me about '.$service->title,
        ]);

        $res->assertOk()
            ->assertJsonStructure(['reply', 'links', 'suggestions', 'show_lead_form']);
        $this->assertStringContainsString($service->title, (string) $res->json('reply'));

        $pricing = $this->postJson('/chatbot/message', [
            'message' => 'What is the pricing for an MVP?',
        ]);

        $pricing->assertOk()
            ->assertJson(['show_lead_form' => true]);

        $invalid = $this->postJson('/chatbot/message', ['message' => '']);
        $invalid->assertStatus(422);
    }

    public function test_chatbot_lead_submission_validates_and_saves_contact_inquiry(): void
    {
        $this->seed(DatabaseSeeder::class);

        $bad = $this->postJson('/chatbot/lead', [
            'name' => 'Test',
            'email' => 'not-an-email',
            'message' => 'Hi',
        ]);
        $bad->assertStatus(422);

        $ok = $this->postJson('/chatbot/lead', [
            'name' => '<b>Founder Jane</b>',
            'email' => 'jane@startup.io',
            'message' => 'We need an MVP SaaS platform launched in 6 weeks.',
        ]);

        $ok->assertOk()->assertJson(['status' => 'ok']);

        $this->assertDatabaseHas('contact_inquiries', [
            'name' => 'Founder Jane',
            'email' => 'jane@startup.io',
            'subject' => 'Chatbot Discovery Request',
            'status' => 'new',
        ]);
        $this->assertSame(1, ContactInquiry::where('email', 'jane@startup.io')->count());
    }
}

