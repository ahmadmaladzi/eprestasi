<x-guest-layout>
    <div class="mb-7">
        <p class="text-[10px] font-bold uppercase tracking-[0.18em] text-[#2F6FED]">Reset password</p>
        <h1 class="mt-2 font-display text-[1.65rem] font-bold leading-tight tracking-tight text-[#0B1E38]">Lupa password?</h1>
        <p class="mt-2 text-[13px] leading-relaxed text-[#64748B]">Masukkan Gmail aktif yang terdaftar di akun kamu. Kami akan mengirimkan kode OTP 6 digit untuk reset password.</p>
    </div>

    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('password.email') }}" class="space-y-5">
        @csrf

        <div>
            <label for="email" class="field-label">Gmail Aktif</label>
            <div class="relative">
                <span class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3.5 text-[#94A3B8]">
                    <x-icon name="mail" :size="16" />
                </span>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="email"
                    class="block w-full rounded-lg border border-gray-200 bg-white py-2.5 pl-10 pr-4 text-[#0B1E38] placeholder:text-[#94A3B8] focus:border-[#2F6FED] focus:outline-none focus:ring-2 focus:ring-[#2F6FED]/20 transition-all"
                    placeholder="nama@gmail.com">
            </div>
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
            <p class="mt-1.5 text-[11px] leading-relaxed text-[#94A3B8]">Kode OTP akan dikirim ke inbox Gmail ini. Cek juga folder Spam atau Promosi jika belum terlihat.</p>
        </div>

        <div>
            <button type="submit" class="btn-primary w-full">
                Kirim kode OTP
            </button>
        </div>

        <div class="text-center">
            <a href="{{ route('login') }}" class="text-sm text-[#2F6FED] hover:text-[#1D5BD9] hover:underline transition-colors">
                Kembali ke halaman login
            </a>
        </div>
    </form>
</x-guest-layout>
