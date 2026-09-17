<x-guest-layout>
    <div class="mb-8">
        <div class="w-11 h-11 rounded-xl bg-gradient-to-br from-[#2F6FED] to-[#1B4FC4] flex items-center justify-center mb-5 shadow-lg shadow-[#2F6FED]/25">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none"><path d="M4 4H20V17L12 21L4 17V4Z" stroke="white" stroke-width="1.6" stroke-linejoin="round"/><path d="M9 11L11 13L15 9" stroke="white" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/></svg>
        </div>
        <h1 class="text-2xl font-extrabold text-slate-900">Masuk ke akun kamu</h1>
        <p class="text-sm text-slate-500 mt-1.5">Gunakan akun yang telah didaftarkan oleh admin sekolah.</p>
    </div>

    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="space-y-5">
        @csrf

        <div>
            <label for="email" class="block text-xs font-semibold text-slate-600 mb-1.5">{{ __('Email') }}</label>
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none"><path d="M4 6H20V18H4V6Z" stroke="#94A3B8" stroke-width="1.6" stroke-linejoin="round"/><path d="M4 6L12 13L20 6" stroke="#94A3B8" stroke-width="1.6" stroke-linejoin="round"/></svg>
                </div>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username"
                       class="block w-full rounded-xl border-slate-200 bg-white pl-10 py-3 text-sm shadow-sm focus:border-[#2F6FED] focus:ring-2 focus:ring-[#2F6FED]/20 transition"
                       placeholder="nama@sekolah.test">
            </div>
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div>
            <label for="password" class="block text-xs font-semibold text-slate-600 mb-1.5">{{ __('Password') }}</label>
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none"><rect x="5" y="10" width="14" height="10" rx="2" stroke="#94A3B8" stroke-width="1.6"/><path d="M8 10V7a4 4 0 118 0v3" stroke="#94A3B8" stroke-width="1.6"/></svg>
                </div>
                <input id="password" type="password" name="password" required autocomplete="current-password"
                       class="block w-full rounded-xl border-slate-200 bg-white pl-10 py-3 text-sm shadow-sm focus:border-[#2F6FED] focus:ring-2 focus:ring-[#2F6FED]/20 transition"
                       placeholder="••••••••">
            </div>
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div class="flex items-center justify-between">
            <label class="flex items-center gap-2 cursor-pointer">
                <input id="remember_me" type="checkbox" class="rounded border-slate-300 text-[#2F6FED] shadow-sm focus:ring-[#2F6FED]/30" name="remember">
                <span class="text-sm text-slate-600">{{ __('Ingat saya') }}</span>
            </label>
            @if (Route::has('password.request'))
                <a class="text-sm text-[#2F6FED] hover:text-[#1B4FC4] font-medium" href="{{ route('password.request') }}">
                    {{ __('Lupa password?') }}
                </a>
            @endif
        </div>

        <button type="submit" class="w-full inline-flex items-center justify-center gap-2 bg-gradient-to-r from-[#2F6FED] to-[#1B4FC4] text-white py-3.5 rounded-xl text-sm font-semibold hover:opacity-90 active:scale-[0.99] transition shadow-lg shadow-[#2F6FED]/25">
            {{ __('Masuk') }}
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none"><path d="M5 12H19M19 12L13 6M19 12L13 18" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
        </button>
    </form>
</x-guest-layout>