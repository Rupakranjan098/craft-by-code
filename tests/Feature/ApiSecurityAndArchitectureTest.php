<?php

namespace Tests\Feature;

use App\Models\Agreement;
use App\Models\ApiToken;
use App\Models\ContactInquiry;
use App\Models\SecurityLog;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class ApiSecurityAndArchitectureTest extends TestCase
{
    use RefreshDatabase;

    private User $adminUser;
    private User $staffUser;
    private User $otherUser;

    protected function setUp(): void
    {
        parent::setUp();

        $this->adminUser = User::create([
            'name' => 'Admin Craft By Code',
            'email' => 'admin@craftbycode.in',
            'password' => Hash::make('AdminPass@123456!'),
            'role' => 'admin',
            'is_active' => true,
        ]);

        $this->staffUser = User::create([
            'name' => 'Editor Staff',
            'email' => 'editor@craftbycode.in',
            'password' => Hash::make('EditorPass@123456!'),
            'role' => 'editor',
            'is_active' => true,
        ]);
        $this->staffUser->forceFill(['role' => 'editor'])->save();

        $this->otherUser = User::create([
            'name' => 'Viewer Staff',
            'email' => 'viewer@craftbycode.in',
            'password' => Hash::make('ViewerPass@123456!'),
            'role' => 'viewer',
            'is_active' => true,
        ]);
        $this->otherUser->forceFill(['role' => 'viewer'])->save();
    }

    private function generateTokenFor(User $user, array $abilities = ['*']): string
    {
        $plainToken = 'cbc_test_' . bin2hex(random_bytes(24));
        ApiToken::create([
            'user_id' => $user->id,
            'name' => 'Test Token',
            'token_hash' => hash('sha256', $plainToken),
            'abilities' => $abilities,
            'expires_at' => now()->addDays(7),
        ]);

        return $plainToken;
    }

    // ==========================================
    // 1. Dynamic API Login & Token Lifecycle
    // ==========================================

    public function test_api_login_success_issues_bearer_token_and_sanitized_user(): void
    {
        $response = $this->postJson('/api/v1/auth/login', [
            'email' => 'admin@craftbycode.in',
            'password' => 'AdminPass@123456!',
            'token_name' => 'MacBook Pro CLI',
        ], ['User-Agent' => 'CraftByCodeClient/1.0']);

        $response->assertOk()
            ->assertJsonPath('status', 'success')
            ->assertJsonPath('data.token_type', 'Bearer')
            ->assertJsonStructure([
                'status',
                'message',
                'data' => [
                    'token_type',
                    'access_token',
                    'expires_at',
                    'user' => ['id', 'name', 'email', 'role', 'is_active', 'created_at'],
                    'abilities',
                ],
            ]);

        // Sensitive fields MUST NOT be in response
        $response->assertJsonMissingPath('data.user.password');
        $response->assertJsonMissingPath('data.user.two_factor_secret');
        $response->assertJsonMissingPath('data.user.remember_token');

        $this->assertDatabaseHas('security_logs', [
            'event_type' => 'api_login_success',
            'user_id' => $this->adminUser->id,
        ]);
    }

    public function test_api_login_fails_with_invalid_credentials_and_audits(): void
    {
        $response = $this->postJson('/api/v1/auth/login', [
            'email' => 'admin@craftbycode.in',
            'password' => 'WrongPassword!',
        ], ['User-Agent' => 'CraftByCodeClient/1.0']);

        $response->assertStatus(401)
            ->assertJsonPath('code', 'INVALID_CREDENTIALS');

        $this->assertDatabaseHas('security_logs', [
            'event_type' => 'api_login_failed',
            'user_id' => $this->adminUser->id,
        ]);
    }

    public function test_api_token_introspection_me_endpoint(): void
    {
        $token = $this->generateTokenFor($this->adminUser, ['*']);

        $response = $this->withToken($token)
            ->getJson('/api/v1/auth/me', ['User-Agent' => 'CraftByCodeClient/1.0']);

        $response->assertOk()
            ->assertJsonPath('status', 'success')
            ->assertJsonPath('data.user.email', 'admin@craftbycode.in')
            ->assertJsonPath('data.token.abilities', ['*']);
    }

    public function test_api_token_rotation_refresh(): void
    {
        $oldToken = $this->generateTokenFor($this->adminUser, ['*']);

        $response = $this->withToken($oldToken)
            ->postJson('/api/v1/auth/refresh', [], ['User-Agent' => 'CraftByCodeClient/1.0']);

        $response->assertOk()
            ->assertJsonPath('status', 'success')
            ->assertJsonStructure(['data' => ['access_token', 'expires_at']]);

        $newToken = $response->json('data.access_token');
        $this->assertNotEmpty($newToken);

        // Old token is revoked
        $this->withToken($oldToken)
            ->getJson('/api/v1/auth/me', ['User-Agent' => 'CraftByCodeClient/1.0'])
            ->assertStatus(401);

        // New token works
        $this->withToken($newToken)
            ->getJson('/api/v1/auth/me', ['User-Agent' => 'CraftByCodeClient/1.0'])
            ->assertOk();
    }

    public function test_api_token_logout_revokes_token(): void
    {
        $token = $this->generateTokenFor($this->adminUser, ['*']);

        $response = $this->withToken($token)
            ->postJson('/api/v1/auth/logout', [], ['User-Agent' => 'CraftByCodeClient/1.0']);

        $response->assertOk()
            ->assertJsonPath('status', 'success');

        // Subsequent requests must fail
        $this->withToken($token)
            ->getJson('/api/v1/auth/me', ['User-Agent' => 'CraftByCodeClient/1.0'])
            ->assertStatus(401);
    }

    // ==========================================
    // 2. Object Ownership (BOLA / IDOR Defense)
    // ==========================================

    public function test_bola_prevented_user_cannot_access_other_users_agreement(): void
    {
        // Agreement created by Staff User
        $staffAgreement = Agreement::create([
            'agreement_number' => 'AGR-2026-9001',
            'title' => 'Staff Secret Agreement',
            'client_name' => 'Private Client',
            'client_email' => 'client@secret.io',
            'contract_value' => 50000.00,
            'currency' => 'USD',
            'status' => 'draft',
            'content' => 'Classified scope.',
            'created_by' => $this->staffUser->id,
        ]);

        // Other user (viewer) possesses agreement viewing ability, but does NOT own this agreement
        $this->otherUser->forceFill(['permissions' => ['agreements.view']])->save();
        $viewerToken = $this->generateTokenFor($this->otherUser, ['agreements.view']);

        $response = $this->withToken($viewerToken)
            ->getJson("/api/v1/agreements/{$staffAgreement->id}", ['User-Agent' => 'CraftByCodeClient/1.0']);

        // Must be blocked with 403 Forbidden
        $response->assertStatus(403)
            ->assertJsonPath('code', 'FORBIDDEN');

        // BOLA violation must be recorded in security audit logs
        $this->assertDatabaseHas('security_logs', [
            'event_type' => 'api_bola_blocked',
            'user_id' => $this->otherUser->id,
        ]);
    }

    public function test_bola_prevented_user_cannot_modify_other_users_agreement(): void
    {
        $staffAgreement = Agreement::create([
            'agreement_number' => 'AGR-2026-9002',
            'title' => 'Immutable Agreement',
            'client_name' => 'Private Client',
            'client_email' => 'client@secret.io',
            'contract_value' => 50000.00,
            'currency' => 'USD',
            'status' => 'draft',
            'content' => 'Scope.',
            'created_by' => $this->staffUser->id,
        ]);

        $this->otherUser->forceFill(['permissions' => ['agreements.manage']])->save();
        $viewerToken = $this->generateTokenFor($this->otherUser, ['agreements.manage']);

        $response = $this->withToken($viewerToken)
            ->putJson("/api/v1/agreements/{$staffAgreement->id}", [
                'title' => 'Maliciously Tampered Title',
            ], ['User-Agent' => 'CraftByCodeClient/1.0']);

        $response->assertStatus(403)
            ->assertJsonPath('code', 'FORBIDDEN');

        $this->assertEquals('Immutable Agreement', $staffAgreement->fresh()->title);
    }

    public function test_admin_has_elevated_access_to_all_agreements(): void
    {
        $staffAgreement = Agreement::create([
            'agreement_number' => 'AGR-2026-9003',
            'title' => 'Staff Project Agreement',
            'client_name' => 'Client',
            'client_email' => 'c@test.io',
            'contract_value' => 10000.00,
            'currency' => 'USD',
            'status' => 'draft',
            'content' => 'Scope.',
            'created_by' => $this->staffUser->id,
        ]);

        $adminToken = $this->generateTokenFor($this->adminUser, ['*']);

        $response = $this->withToken($adminToken)
            ->getJson("/api/v1/agreements/{$staffAgreement->id}", ['User-Agent' => 'CraftByCodeClient/1.0']);

        $response->assertOk()
            ->assertJsonPath('data.title', 'Staff Project Agreement');
    }

    public function test_bola_prevented_token_revocation_by_another_user(): void
    {
        $staffTokenRecord = ApiToken::create([
            'user_id' => $this->staffUser->id,
            'name' => 'Staff Private Token',
            'token_hash' => hash('sha256', 'staff_secret_123'),
            'abilities' => ['*'],
        ]);

        $viewerToken = $this->generateTokenFor($this->otherUser, ['api.tokens.manage']);

        $response = $this->withToken($viewerToken)
            ->deleteJson("/api/v1/tokens/{$staffTokenRecord->id}", [], ['User-Agent' => 'CraftByCodeClient/1.0']);

        $response->assertStatus(403)
            ->assertJsonPath('code', 'FORBIDDEN');

        $this->assertNull($staffTokenRecord->fresh()->revoked_at);
    }

    // ==========================================
    // 3. Role Permissions (BFLA Defense)
    // ==========================================

    public function test_bfla_prevented_token_lacking_ability_is_forbidden(): void
    {
        // Token has only services.read, attempts to access inquiries
        $limitedToken = $this->generateTokenFor($this->adminUser, ['services.read']);

        $response = $this->withToken($limitedToken)
            ->getJson('/api/v1/inquiries', ['User-Agent' => 'CraftByCodeClient/1.0']);

        $response->assertStatus(403)
            ->assertJsonPath('code', 'FORBIDDEN');
    }

    // ==========================================
    // 4. Sensitive Field Filtering
    // ==========================================

    public function test_sensitive_fields_strictly_filtered_in_resources(): void
    {
        $agr = Agreement::create([
            'agreement_number' => 'AGR-2026-9004',
            'title' => 'Full Disclosure Test',
            'client_name' => 'Client Org',
            'client_email' => 'client@org.io',
            'contract_value' => 25000.00,
            'currency' => 'USD',
            'status' => 'draft',
            'content' => 'Scope details.',
            'pdf_path' => 'private/agreements/pdfs/secret_server_file.pdf',
            'digital_signature_hash' => 'super_secret_sha256_hash',
            'created_by' => $this->adminUser->id,
        ]);

        $adminToken = $this->generateTokenFor($this->adminUser, ['*']);

        $response = $this->withToken($adminToken)
            ->getJson("/api/v1/agreements/{$agr->id}", ['User-Agent' => 'CraftByCodeClient/1.0']);

        $response->assertOk();
        // Server file storage path must NEVER be exposed
        $response->assertJsonMissingPath('data.pdf_path');
        $response->assertJsonMissingPath('data.digital_signature_hash');
    }

    // ==========================================
    // 5. Rate Limiting & Bot/Scanner Defense
    // ==========================================

    public function test_malicious_security_scanners_blocked(): void
    {
        $scanners = ['sqlmap/1.5.2#stable', 'Mozilla/5.0 (Nikto 2.1.6)', 'Acunetix Web Vulnerability Scanner', 'wpscan v3.8.22'];

        foreach ($scanners as $scanner) {
            $response = $this->getJson('/api/v1/health', [
                'User-Agent' => $scanner,
            ]);

            $response->assertStatus(403)
                ->assertJsonPath('code', 'MALICIOUS_BOT_BLOCKED');
        }

        $this->assertDatabaseHas('security_logs', [
            'event_type' => 'malicious_bot_blocked',
        ]);
    }

    public function test_exploit_payloads_in_uri_blocked(): void
    {
        $payloads = [
            '/api/v1/health?param=../../etc/passwd',
            '/api/v1/health?search=1%20UNION%20SELECT%20null,null--',
            '/api/v1/health?q=%3Cscript%3Ealert(1)%3C/script%3E',
        ];

        foreach ($payloads as $uri) {
            $response = $this->getJson($uri, ['User-Agent' => 'ValidBrowser/1.0']);
            $response->assertStatus(400)
                ->assertJsonPath('code', 'EXPLOIT_PAYLOAD_DETECTED');
        }
    }

    public function test_mutation_without_user_agent_blocked(): void
    {
        $response = $this->postJson('/api/v1/auth/login', [
            'email' => 'admin@craftbycode.in',
            'password' => 'AdminPass@123456!',
        ], ['User-Agent' => '']);

        $response->assertStatus(400)
            ->assertJsonPath('code', 'USER_AGENT_REQUIRED');
    }

    // ==========================================
    // 6. Input Sanitization
    // ==========================================

    public function test_input_sanitization_strips_script_tags_and_null_bytes(): void
    {
        $adminToken = $this->generateTokenFor($this->adminUser, ['*']);

        $response = $this->withToken($adminToken)
            ->postJson('/api/v1/agreements', [
                'title' => "Clean Project\0Title",
                'client_name' => 'John <script>alert("xss")</script>Doe',
                'client_email' => 'john.doe@example.com',
                'contract_value' => 15000,
                'currency' => 'USD',
                'content' => 'Safe text with <iframe src="evil.com"></iframe> stripped.',
            ], ['User-Agent' => 'CraftByCodeClient/1.0']);

        $response->assertStatus(201);

        $created = Agreement::latest()->first();
        $this->assertStringNotContainsString("\0", $created->title);
        $this->assertStringNotContainsString('<script>', $created->client_name);
        $this->assertStringNotContainsString('<iframe>', $created->content);
        $this->assertEquals('John Doe', $created->client_name);
    }

    // ==========================================
    // 7. Security Headers & TLS/HTTPS Enforcement
    // ==========================================

    public function test_api_security_headers_present_on_all_responses(): void
    {
        $response = $this->getJson('/api/v1/health', ['User-Agent' => 'CraftByCodeClient/1.0']);

        $response->assertOk()
            ->assertHeader('X-Content-Type-Options', 'nosniff')
            ->assertHeader('X-Frame-Options', 'DENY')
            ->assertHeader('Referrer-Policy', 'strict-origin-when-cross-origin')
            ->assertHeaderMissing('X-Powered-By');

        $cacheControl = (string) $response->headers->get('Cache-Control');
        $this->assertStringContainsString('no-store', $cacheControl);
        $this->assertStringContainsString('no-cache', $cacheControl);
    }

    // ==========================================
    // 8. Shadow API Retirement & Strict Fallback
    // ==========================================

    public function test_retired_and_shadow_api_endpoints_return_clean_json_404(): void
    {
        $shadowEndpoints = [
            '/api/legacy/users',
            '/api/v0/agreements',
            '/api/debug/dump',
            '/api/test',
            '/api/admin/secret',
        ];

        foreach ($shadowEndpoints as $endpoint) {
            $response = $this->getJson($endpoint, ['User-Agent' => 'CraftByCodeClient/1.0']);
            $response->assertStatus(404)
                ->assertJsonPath('status', 'error')
                ->assertJsonPath('code', 'ENDPOINT_NOT_FOUND');
        }
    }
}
