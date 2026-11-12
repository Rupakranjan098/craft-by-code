<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules\Password;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        if ($this->app->environment('production')
            && str_starts_with((string) config('app.url'), 'https://')
            && (! $this->app->runningInConsole() && request()->isSecure())) {
            URL::forceScheme('https');
        }

        Password::defaults(function () {
            return Password::min(12)
                ->mixedCase()
                ->numbers()
                ->symbols();
        });

        RateLimiter::for('login', function (Request $request) {
            $email = Str::lower((string) $request->input('email', ''));

            return [
                Limit::perMinute(5)->by($email.'|'.$request->ip()),
                Limit::perMinute(20)->by('login-ip:'.$request->ip()),
            ];
        });

        RateLimiter::for('two-factor', function (Request $request) {
            $pending = (string) ($request->session()->get('2fa_pending_user_id') ?? 'anon');

            return Limit::perMinute(5)->by($pending.'|'.$request->ip());
        });

        RateLimiter::for('password-reset', function (Request $request) {
            $email = Str::lower((string) $request->input('email', ''));

            return [
                Limit::perMinutes(15, 5)->by('reset:'.$request->ip()),
                Limit::perMinutes(15, 3)->by('reset-email:'.$email.'|'.$request->ip()),
            ];
        });

        RateLimiter::for('contact', function (Request $request) {
            return Limit::perMinute(5)->by('contact:'.$request->ip());
        });

        RateLimiter::for('newsletter', function (Request $request) {
            return Limit::perMinute(5)->by('newsletter:'.$request->ip());
        });

        RateLimiter::for('chatbot', function (Request $request) {
            return Limit::perMinute(30)->by('chatbot:'.$request->ip());
        });

        RateLimiter::for('api', function (Request $request) {
            $token = $request->bearerToken();
            $key = $token ? hash('sha256', $token) : $request->ip();

            return Limit::perMinute(60)->by('api:'.$key);
        });
    }
}
