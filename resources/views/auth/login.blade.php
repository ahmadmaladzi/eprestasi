<x-guest-layout>
    <div class="mb-8">
        <h1 class="text-2xl font-bold text-slate-900">Masuk ke akun kamu</h1>
        <p class="text-sm text-slate-500 mt-1">Gunakan akun yang telah didaftarkan oleh admin sekolah.</p>
    </div>

    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="space-y-5">
        @csrf

        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1.5 w-full rounded-md" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="password" :value="__('Password')" />
            <x-text-input id="password" class="block mt-1.5 w-full rounded-md" type="password" name="password" required autocomplete="current-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div class="flex items-center justify-between">
            <label class="flex items-center gap-2">
                <input id="remember_me" type="checkbox" class="rounded border-slate-300 text-[#0F2540] shadow-sm" name="remember">
                <span class="text-sm text-slate-600">{{ __('Ingat saya') }}</span>
            </label>
            @if (Route::has('password.request'))
                <a class="text-sm text-slate-500 hover:text-slate-700 underline" href="{{ route('password.request') }}">
                    {{ __('Lupa password?') }}
                </a>
            @endif
        </div>

        <button type="submit" class="w-full bg-[#0F2540] text-white py-2.5 rounded-md text-sm font-semibold hover:bg-[#16324f] transition">
            {{ __('Masuk') }}
        </button>
    </form>
</x-guest-layout>