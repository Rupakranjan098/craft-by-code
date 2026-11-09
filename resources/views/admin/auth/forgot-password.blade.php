<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Forgot Password | UpPage Technology</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="icon" type="image/png" href="{{ asset(ltrim(\App\Models\WebsiteSetting::get('site_logo_icon', 'assets/images/logo-icon-transparent.png'), '/')) }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-[#080D19] text-slate-100 min-h-screen flex items-center justify-center p-4">
    <div class="w-full max-w-md">
        <div class="text-center mb-8">
            <x-logo size="lg" dark="true" />
            <p class="text-xs text-slate-400 mt-2">Password Recovery</p>
        </div>

        <div class="bg-slate-900/80 backdrop-blur-xl border border-slate-800 rounded-3xl p-8 shadow-2xl">
            <h2 class="text-xl font-bold text-white mb-2">Reset Password</h2>
            <p class="text-xs text-slate-400 mb-6">Enter your email address and we'll send instructions to reset your account password.</p>

            @if(session('success'))
                <div class="p-3.5 mb-5 rounded-xl bg-emerald-950/60 border border-emerald-500/30 text-emerald-300 text-xs">
                    {{ session('success') }}
                </div>
            @endif

            <form action="{{ route('admin.password.email') }}" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-xs font-semibold text-slate-300 uppercase tracking-wider mb-1.5">Email Address</label>
                    <input type="email" name="email" required placeholder="admin@uppage.tech"
                           class="w-full px-4 py-3 bg-slate-950 border border-slate-700 rounded-xl text-sm text-white focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>

                <button type="submit" class="w-full py-3.5 px-4 rounded-xl bg-blue-600 hover:bg-blue-500 text-white font-bold text-sm transition">
                    Send Password Reset Link
                </button>
            </form>

            <div class="mt-6 text-center">
                <a href="{{ route('admin.login') }}" class="text-xs text-blue-400 hover:text-blue-300 transition">Return to login</a>
            </div>
        </div>
    </div>
</body>
</html>

