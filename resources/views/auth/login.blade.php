<x-guest-layout>
    <div class="mb-7">
        <p class="text-[10px] font-bold uppercase tracking-[0.18em] text-[#2F6FED]">Selamat datang kembali</p>
        <h1 class="mt-2 font-display text-[1.65rem] font-bold leading-tight tracking-tight text-[#0B1E38]">Masuk ke akun kamu</h1>
        <p class="mt-2 text-[13px] leading-relaxed text-[#64748B]">Gunakan email, NIS, atau NIP yang sudah didaftarkan admin sekolah.</p>
    </div>

    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="space-y-5"
          x-data="{ showPassword: false, loading: false }" @submit="loading = true">
        @csrf

        <div>
            <label for="login" class="field-label">{{ __('Email / NIS / NIP') }}</label>
            <div class="relative">
                <span class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3.5 text-[#94A3B8]">
                    <x-icon name="user" :size="16" />
                </span>
                <input id="login" type="text" name="login" value="{{ old('login') }}" required autofocus autocomplete="username"
                       aria-invalid="{{ $errors->has('login') ? 'true' : 'false' }}"
                       class="input py-3 pl-10"
                       placeholder="nama@sekolah.test / NIS / NIP">
            </div>
            <x-input-error :messages="$errors->get('login')" class="mt-2" />
        </div>

        <div>
            <label for="password" class="field-label">{{ __('Password') }}</label>
            <div class="relative">
                <span class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3.5 text-[#94A3B8]">
                    <x-icon name="lock" :size="16" />
                </span>
                <input id="password" type="password" name="password" required autocomplete="current-password"
                       aria-invalid="{{ $errors->has('password') ? 'true' : 'false' }}"
                       x-bind:type="showPassword ? 'text' : 'password'"
                       class="input py-3 pl-10 pr-11"
                       placeholder="••••••••">
                <button type="button" @click="showPassword = !showPassword"
                        :aria-label="showPassword ? 'Sembunyikan password' : 'Tampilkan password'"
                        :aria-pressed="showPassword ? 'true' : 'false'"
                        class="absolute inset-y-0 right-0 flex w-11 items-center justify-center rounded-r-xl text-[#94A3B8] transition hover:text-[#2F6FED] focus:outline-none focus-visible:ring-2 focus-visible:ring-inset focus-visible:ring-[#2F6FED]/30">
                    <x-icon name="eye" :size="16" />
                </button>
            </div>
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div class="flex items-center justify-between gap-3">
            <label class="flex cursor-pointer items-center gap-2">
                <input id="remember_me" type="checkbox" class="h-4 w-4 rounded border-[#CBD5E1] text-[#2F6FED] shadow-sm focus:ring-[#2F6FED]/30" name="remember">
                <span class="text-[12.5px] font-medium text-[#64748B]">{{ __('Ingat saya') }}</span>
            </label>
            @if (Route::has('password.request'))
                <a class="text-[12.5px] font-semibold text-[#2F6FED] transition hover:text-[#1B4FC4]" href="{{ route('password.request') }}">
                    {{ __('Lupa password?') }}
                </a>
            @endif
        </div>

        <button type="submit" :disabled="loading"
                class="group flex w-full items-center justify-center gap-2 rounded-xl bg-gradient-to-r from-[#2F6FED] to-[#1B4FC4] px-4 py-3.5 text-sm font-semibold text-white shadow-lg shadow-[#2F6FED]/25 transition hover:opacity-95 focus:outline-none focus-visible:ring-2 focus-visible:ring-[#2F6FED] focus-visible:ring-offset-2 active:scale-[0.99] disabled:cursor-not-allowed disabled:opacity-70">
            <span x-show="!loading" class="inline-flex items-center gap-2">
                {{ __('Masuk') }}
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" aria-hidden="true" class="transition group-hover:translate-x-0.5">
                    <path d="M5 12H19M19 12L13 6M19 12L13 18" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </span>
            <span x-show="loading" x-cloak class="inline-flex items-center gap-2">
                <svg class="h-4 w-4 animate-spin" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                    <circle cx="12" cy="12" r="9" stroke="currentColor" stroke-width="2.5" class="opacity-25"/>
                    <path d="M21 12a9 9 0 0 1-9 9" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"/>
                </svg>
                {{ __('Memproses...') }}
            </span>
        </button>
    </form>

    <div class="mt-6 flex items-start gap-2.5 rounded-xl border border-[#E8EDF5] bg-[#F8FAFC] px-3.5 py-3">
        <x-icon name="shield" :size="15" class="mt-0.5 shrink-0 text-[#2F6FED]" />
        <p class="text-[11.5px] leading-relaxed text-[#64748B]">
            <span class="font-semibold text-[#0B1E38]">Akun dibuat oleh admin sekolah.</span>
            Siswa dan kesiswaan tidak perlu mendaftar sendiri.
        </p>
    </div>
</x-guest-layout>
