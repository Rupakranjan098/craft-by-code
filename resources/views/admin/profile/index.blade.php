@extends('layouts.admin')

@section('title', 'Admin Profile & Security')
@section('header_title', 'Account & Security')

@section('content')
    <div class="max-w-4xl space-y-8">
        <div>
            <h1 class="text-2xl font-bold text-slate-900">Admin Account Settings</h1>
            <p class="text-xs text-slate-500">Update administrative profile info, email address, and secure password</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <!-- Profile Info Card -->
            <form action="{{ route('admin.profile.update') }}" method="POST" class="bg-white p-8 rounded-3xl border border-slate-200/80 shadow-sm space-y-5">
                @csrf
                @method('PUT')

                <div class="flex items-center gap-3 border-b border-slate-100 pb-4">
                    <div class="w-10 h-10 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center">
                        <x-icon name="shield-check" class="w-5 h-5" />
                    </div>
                    <div>
                        <h2 class="text-base font-bold text-slate-900">Profile Information</h2>
                        <p class="text-xs text-slate-400">Update your account name and email</p>
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Full Name *</label>
                    <input type="text" name="name" required value="{{ old('name', $user->name) }}"
                           class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-600">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Email Address *</label>
                    <input type="email" name="email" required value="{{ old('email', $user->email) }}"
                           class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-600">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Phone Number</label>
                    <input type="text" name="phone" value="{{ old('phone', $user->phone) }}" placeholder="+1 (555) 000-0000"
                           class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-600">
                </div>

                <div class="pt-3">
                    <button type="submit" class="w-full py-3 px-4 rounded-xl bg-slate-900 hover:bg-blue-600 text-white font-bold text-xs uppercase tracking-wider transition shadow">
                        Save Profile Details
                    </button>
                </div>
            </form>

            <!-- Change Password Card -->
            <form action="{{ route('admin.profile.password') }}" method="POST" class="bg-white p-8 rounded-3xl border border-slate-200/80 shadow-sm space-y-5">
                @csrf
                @method('PUT')

                <div class="flex items-center gap-3 border-b border-slate-100 pb-4">
                    <div class="w-10 h-10 rounded-xl bg-purple-50 text-purple-600 flex items-center justify-center">
                        <x-icon name="shield" class="w-5 h-5" />
                    </div>
                    <div>
                        <h2 class="text-base font-bold text-slate-900">Change Password</h2>
                        <p class="text-xs text-slate-400">Ensure account security with a strong password</p>
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Current Password *</label>
                    <input type="password" name="current_password" required placeholder="••••••••"
                           class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-600">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">New Password (min 8 chars) *</label>
                    <input type="password" name="password" required placeholder="••••••••"
                           class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-600">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Confirm New Password *</label>
                    <input type="password" name="password_confirmation" required placeholder="••••••••"
                           class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-600">
                </div>

                <div class="pt-3">
                    <button type="submit" class="w-full py-3 px-4 rounded-xl bg-blue-600 hover:bg-blue-500 text-white font-bold text-xs uppercase tracking-wider transition shadow">
                        Update Password
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection

