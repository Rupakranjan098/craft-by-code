<?php

namespace Tests\Feature;

use App\Models\ApiToken;
use App\Models\BlogPost;
use App\Models\SecurityLog;
use App\Models\Service;
use App\Models\User;
use App\Models\WebsiteSetting;
use App\Security\HtmlSanitizer;
use App\Security\SecurityLogger;
use App\Security\TotpService;
use App\Security\UrlValidator;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Tests\TestCase;

class SecurityHardeningTest extends TestCase
{
    use RefreshDatabase;

    private function createBackofficeUser(string $role = 'admin', string $password = 'Str0ng!Pass#2026'): User
    {
        $user = new User([
            'name' => 'Security Test User',
            'email' => uniqid($role.'_').'@craftbycode.test',
            'password' => Hash::make($password),
        ]);
        $user->role = $role;
        $user->is_active = true;
        $user->save();

        return $user;
    }

    public function test_security_headers_and_csp_are_enforced_and_credentials_are_not_in_login_view(): void
    {
        $home = $this->get('/');
        $home->assertOk();
        $home->assertHeader('X-Frame-Options', 'DENY');
        $home->assertHeader('X-Content-Type-Options', 'nosniff');
        $home->assertHeader('Referrer-Policy', 'strict-origin-when-cross-origin');
        $home->assertHeader('Cross-Origin-Opener-Policy', 'same-origin');
        $home->assertHeader('Cross-Origin-Resource-Policy', 'same-origin');

        $csp = (string) $home->headers->get('Content-Security-Policy');
        $this->assertStringContainsString("frame-ancestors 'none'", $csp);
        $this->assertStringContainsString("object-src 'none'", $csp);
        preg_match('/script-src\s+([^;]+)/', $csp, $scriptDirective);
        $this->assertNotEmpty($scriptDirective[1] ?? '');
        $this->assertStringNotContainsString("'unsafe-inline'", $scriptDirective[1]);

        $login = $this->get('/admin/login');
        $login->assertOk();
        $this->assertStringContainsString('no-store', (string) $login->headers->get('Cache-Control'));
        $login->assertDontSee('admin123');
        $login->assertDontSee('Default Admin Credentials');
    }

    public function test_user_mass_assignment_protects_role_and_privilege_fields(): void
    {
        $user = new User([
            'name' => 'Attacker',
            'email' => 'attacker@example.com',
            'password' => Hash::make('Str0ng!Pass#2026'),
            'role' => 'super_admin',
            'is_active' => false,
            'permissions' => ['*'],
        ]);

        $this->assertNull($user->role);
        $this->assertNull($user->permissions);
    }

    public function test_brute_force_login_locks_account_and_blocks_even_valid_password(): void
    {
        $admin = $this->createBackofficeUser('admin', 'Str0ng!Pass#2026');

        for ($i = 0; $i < 5; $i++) {
            $this->post('/admin/login', [
                'email' => $admin->email,
                'password' => 'WrongPassword!1',
            ])->assertRedirect();
        }

        $admin->refresh();
        $this->assertTrue($admin->isLockedOut());
        $this->assertGreaterThanOrEqual(5, $admin->failed_login_attempts);

        // Even the real password must be blocked while locked out
        $this->post('/admin/login', [
            'email' => $admin->email,
            'password' => 'Str0ng!Pass#2026',
        ]);
        $this->assertGuest();

        $this->assertDatabaseHas('security_logs', [
            'user_id' => $admin->id,
            'event_type' => 'account_locked',
        ]);
    }

    public function test_unknown_email_and_legacy_bcrypt_login_work_without_argon2id_runtime_exception(): void
    {
        // Unknown email must return invalid credential error cleanly without throwing
        $unknown = $this->post('/admin/login', [
            'email' => 'nonexistent@craftbycode.test',
            'password' => 'SomeRandomPass!1',
        ]);
        $unknown->assertRedirect();
        $unknown->assertSessionHas('error', 'The provided credentials do not match our records.');
        $this->assertGuest();

        // Legacy bcrypt user row in DB must authenticate and transparently upgrade to Argon2id
        $legacy = new User([
            'name' => 'Legacy Bcrypt Admin',
            'email' => 'legacy@craftbycode.test',
            'password' => Hash::make('Str0ng!Pass#2026'),
        ]);
        $legacy->role = 'admin';
        $legacy->is_active = true;
        $legacy->save();

        DB::table('users')
            ->where('id', $legacy->id)
            ->update(['password' => password_hash('LegacyBcrypt!2026', PASSWORD_BCRYPT, ['cost' => 10])]);
        $legacy->refresh();

        $this->assertStringStartsWith('$2y$', $legacy->password);

        $response = $this->post('/admin/login', [
            'email' => $legacy->email,
            'password' => 'LegacyBcrypt!2026',
        ]);

        $response->assertRedirect(route('admin.dashboard', absolute: false));
        $this->assertAuthenticatedAs($legacy);

        $legacy->refresh();
        $this->assertStringStartsWith('$argon2id$', $legacy->password);
    }

    public function test_login_form_uses_relative_action_and_proxy_https_headers_behave_safely(): void
    {
        $page = $this->get('/admin/login');
        $page->assertOk();
        $page->assertSee('action="/admin/login"', false);

        // Failed login without Referer must redirect explicitly back to /admin/login with flash error
        $failed = $this->post('/admin/login', [
            'email' => 'missing-referer@craftbycode.test',
            'password' => 'WrongPass!123',
        ]);
        $failed->assertRedirect('/admin/login');
        $failed->assertSessionHas('error', 'The provided credentials do not match our records.');

        // Behind TLS-terminating proxy, trusted proxy headers trigger HSTS & upgrade-insecure-requests
        $proxied = $this->withServerVariables(['HTTP_X_FORWARDED_PROTO' => 'https'])
            ->get('/admin/login');
        $proxied->assertOk();
        $proxied->assertHeader('Strict-Transport-Security');
        $this->assertStringContainsString('upgrade-insecure-requests', (string) $proxied->headers->get('Content-Security-Policy'));
    }

    public function test_open_redirect_on_intended_url_is_blocked_after_login(): void
    {
        $admin = $this->createBackofficeUser('admin', 'Str0ng!Pass#2026');

        $response = $this->withSession(['url.intended' => 'https://evil-phishing.example/steal'])
            ->post('/admin/login', [
                'email' => $admin->email,
                'password' => 'Str0ng!Pass#2026',
            ]);

        $response->assertRedirect(route('admin.dashboard', absolute: false));
        $this->assertDatabaseHas('security_logs', [
            'user_id' => $admin->id,
            'event_type' => 'open_redirect_blocked',
        ]);
    }

    public function test_strong_password_policy_enforced_on_profile_change(): void
    {
        $admin = $this->createBackofficeUser('admin', 'Str0ng!Pass#2026');

        $this->actingAs($admin)
            ->put('/admin/profile/password', [
                'current_password' => 'Str0ng!Pass#2026',
                'password' => 'weakpass',
                'password_confirmation' => 'weakpass',
            ])
            ->assertSessionHasErrors(['password']);

        $this->actingAs($admin)
            ->put('/admin/profile/password', [
                'current_password' => 'Str0ng!Pass#2026',
                'password' => 'N3wEnt3rprise!Pass',
                'password_confirmation' => 'N3wEnt3rprise!Pass',
            ])
            ->assertSessionHasNoErrors();

        $this->assertTrue(Hash::check('N3wEnt3rprise!Pass', $admin->fresh()->password));
    }

    public function test_two_factor_enrollment_login_challenge_replay_protection_and_recovery_codes(): void
    {
        $admin = $this->createBackofficeUser('admin', 'Str0ng!Pass#2026');
        $totp = app(TotpService::class);

        $this->actingAs($admin)->post('/admin/profile/two-factor/setup')->assertRedirect(route('admin.profile.index'));
        $secret = session('2fa_setup_secret');
        $this->assertNotEmpty($secret);

        $slice = (int) floor(time() / 30);
        $validCode = $totp->generateTotpAtSlice($secret, $slice);

        $confirm = $this->actingAs($admin)->post('/admin/profile/two-factor/confirm', [
            'current_password' => 'Str0ng!Pass#2026',
            'code' => $validCode,
        ]);
        $confirm->assertRedirect(route('admin.profile.index'));
        $recoveryPlain = session('recovery_codes_plain');
        $this->assertCount(8, $recoveryPlain);

        $this->actingAs($admin)->post('/admin/logout');
        $this->assertGuest();

        // Primary login stops at 2FA challenge rather than logging straight in
        $login = $this->post('/admin/login', [
            'email' => $admin->email,
            'password' => 'Str0ng!Pass#2026',
        ]);
        $login->assertRedirect(route('admin.two-factor.challenge'));
        $this->assertGuest();

        // Replaying the exact same TOTP code in the same slice must fail
        $this->post('/admin/two-factor-challenge', ['code' => $validCode])
            ->assertSessionHasErrors(['code']);
        $this->assertGuest();

        // Using a recovery code succeeds once and invalidates that recovery code
        $recoveryAttempt = $this->post('/admin/two-factor-challenge', [
            'recovery_code' => $recoveryPlain[0],
        ]);
        $recoveryAttempt->assertRedirect(route('admin.dashboard', absolute: false));
        $this->assertAuthenticatedAs($admin);
        $this->assertCount(7, $admin->fresh()->two_factor_recovery_codes);
    }

    public function test_expiring_password_reset_token_workflow(): void
    {
        $admin = $this->createBackofficeUser('admin', 'Str0ng!Pass#2026');

        $this->post('/admin/forgot-password', ['email' => $admin->email])
            ->assertSessionHas('success');

        $this->assertDatabaseHas('password_reset_tokens', ['email' => $admin->email]);

        $token = Password::broker()->createToken($admin);

        $this->post('/admin/reset-password', [
            'token' => $token,
            'email' => $admin->email,
            'password' => 'Reset!Str0ng#2026',
            'password_confirmation' => 'Reset!Str0ng#2026',
        ])->assertRedirect(route('admin.login'));

        $this->assertTrue(Hash::check('Reset!Str0ng#2026', $admin->fresh()->password));
    }

    public function test_rbac_blocks_standard_user_and_restricts_viewer_role(): void
    {
        $regularUser = $this->createBackofficeUser('user', 'Str0ng!Pass#2026');
        $this->actingAs($regularUser)->get('/admin/dashboard')->assertRedirect(route('admin.login'));

        $viewer = $this->createBackofficeUser('viewer', 'Str0ng!Pass#2026');
        $this->actingAs($viewer)->get('/admin/inquiries')->assertOk();
        $this->actingAs($viewer)->get('/admin/security')->assertForbidden();
        $this->actingAs($viewer)->get('/admin/services')->assertForbidden();
    }

    public function test_file_upload_blocks_php_and_svg_and_stores_valid_png_outside_public_root(): void
    {
        $admin = $this->createBackofficeUser('admin', 'Str0ng!Pass#2026');

        // Block SVG upload attempting script XSS
        $svgUpload = UploadedFile::fake()->createWithContent(
            'xss.svg',
            '<svg xmlns="http://www.w3.org/2000/svg"><script>alert(1)</script></svg>'
        );

        $this->actingAs($admin)
            ->post('/admin/blog', [
                'title' => 'Malicious SVG Test',
                'category' => 'Security',
                'excerpt' => 'Testing blocked upload.',
                'content' => '<p>Body</p>',
                'image_file' => $svgUpload,
            ])
            ->assertSessionHasErrors(['image_file']);

        // Valid PNG stored inside storage/app/uploads/blog (never public/) and served safely via /media/
        $validPng = UploadedFile::fake()->image('cover.png', 120, 80);

        $this->actingAs($admin)
            ->post('/admin/blog', [
                'title' => 'Safe PNG Upload',
                'category' => 'Engineering',
                'excerpt' => 'Testing clean storage upload.',
                'content' => '<p>Clean article content</p>',
                'is_published' => 1,
                'image_file' => $validPng,
            ])
            ->assertRedirect(route('admin.blog.index'));

        $post = BlogPost::where('title', 'Safe PNG Upload')->firstOrFail();
        $this->assertStringStartsWith('/media/blog/', $post->image);

        $mediaResponse = $this->get($post->image);
        $mediaResponse->assertOk();
        $mediaResponse->assertHeader('X-Content-Type-Options', 'nosniff');

        // Cleanup uploaded test file
        @unlink(storage_path('app/uploads/blog/'.basename($post->image)));

        // Path traversal requests blocked cleanly
        $this->get('/media/blog/../../.env')->assertNotFound();
        $this->get('/media/branding/shell.php')->assertNotFound();
    }

    public function test_html_xss_and_unsafe_url_schemes_are_blocked(): void
    {
        $dirty = '<p>Safe <strong>Text</strong></p><script>alert(1)</script><img src="/assets/images/logo.png" onerror="fetch(1)"><a href="javascript:alert(2)" target="_blank">Click</a>';
        $clean = HtmlSanitizer::sanitize($dirty);

        $this->assertStringContainsString('<p>Safe <strong>Text</strong></p>', $clean);
        $this->assertStringNotContainsString('<script', $clean);
        $this->assertStringNotContainsString('onerror', $clean);
        $this->assertStringNotContainsString('javascript:', $clean);

        $admin = $this->createBackofficeUser('admin', 'Str0ng!Pass#2026');
        WebsiteSetting::set('google_maps_embed', 'https://www.google.com/maps/embed?pb=test', 'contact');
        WebsiteSetting::set('social_github', 'https://github.com/test', 'social');

        $this->actingAs($admin)
            ->post('/admin/settings', [
                'group' => 'contact',
                'google_maps_embed' => 'https://evil-phish.example/embed',
            ])
            ->assertSessionHasErrors(['google_maps_embed']);

        $this->assertSame('100\\%\\_safe', UrlValidator::escapeLike('100%_safe'));
    }

    public function test_scoped_api_bearer_tokens_and_secret_redaction_in_logs(): void
    {
        $admin = $this->createBackofficeUser('admin', 'Str0ng!Pass#2026');
        Service::create([
            'title' => 'Security Audit API',
            'slug' => 'security-audit-api',
            'icon' => 'shield',
            'short_description' => 'Service API test.',
            'full_description' => 'Details.',
            'is_active' => true,
            'order' => 1,
        ]);

        // Unauthenticated API access denied
        $this->getJson('/api/v1/services')->assertStatus(401);

        $plainToken = 'cbc_live_testtoken_1234567890';
        ApiToken::create([
            'user_id' => $admin->id,
            'name' => 'Services Reader',
            'token_hash' => hash('sha256', $plainToken),
            'abilities' => ['services.read'],
            'expires_at' => now()->addDays(7),
        ]);

        // Authorized scope succeeds, unauthorized scope gets 403
        $this->withToken($plainToken)->getJson('/api/v1/services')
            ->assertOk()
            ->assertJsonFragment(['title' => 'Security Audit API']);

        $this->withToken($plainToken)->getJson('/api/v1/inquiries')
            ->assertStatus(403);

        // Audit logs must redact secrets
        SecurityLogger::log('secret_check', 'Verifying redaction', 'info', $admin, null, [
            'password' => 'MyPlainPassword!',
            'api_token' => $plainToken,
            'safe_note' => 'ok',
        ]);

        $entry = SecurityLog::where('event_type', 'secret_check')->latest('id')->firstOrFail();
        $this->assertSame('[REDACTED]', $entry->metadata['password']);
        $this->assertSame('[REDACTED]', $entry->metadata['api_token']);
        $this->assertSame('ok', $entry->metadata['safe_note']);
    }

    public function test_encrypted_database_backup_and_verify_only_restore(): void
    {
        $beforeFiles = collect(File::exists(storage_path('app/private/backups')) ? File::files(storage_path('app/private/backups')) : [])
            ->map(fn ($f) => $f->getFilename())
            ->all();

        $backupExit = Artisan::call('security:backup');
        $this->assertSame(0, $backupExit);

        $afterFiles = collect(File::files(storage_path('app/private/backups')))
            ->map(fn ($f) => $f->getFilename())
            ->all();

        $created = array_values(array_diff($afterFiles, $beforeFiles));
        $this->assertNotEmpty($created);

        $latestFile = $created[0];
        $rawCipher = File::get(storage_path('app/private/backups/'.$latestFile));
        $this->assertStringNotContainsString('website_settings', $rawCipher);

        $verifyExit = Artisan::call('security:restore', [
            'file' => $latestFile,
            '--verify-only' => true,
        ]);
        $this->assertSame(0, $verifyExit);

        // Cleanup test-created sqlite snapshot from backup folder
        @unlink(storage_path('app/private/backups/'.$latestFile));
    }
}
