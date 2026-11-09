<x-guest-layout>
    <div class="mb-7">
        <p class="text-[10px] font-bold uppercase tracking-[0.18em] text-[#2F6FED]">Verifikasi OTP</p>
        <h1 class="mt-2 font-display text-[1.65rem] font-bold leading-tight tracking-tight text-[#0B1E38]">Cek inbox Gmail kamu</h1>
        <p class="mt-2 text-[13px] leading-relaxed text-[#64748B]">
            Kami mengirim kode OTP 6 digit ke
            <span class="font-semibold text-[#0B1E38]">{{ $email }}</span>.
            Masukkan kode tersebut untuk melanjutkan.
        </p>
    </div>

    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('password.otp.verify') }}" class="space-y-5">
        @csrf

        <div>
            <label for="otp" class="field-label">Kode OTP</label>
            <input id="otp" type="text" name="otp" value="{{ old('otp') }}" required autofocus
                inputmode="numeric" pattern="[0-9]{6}" maxlength="6" autocomplete="one-time-code"
                class="block w-full rounded-lg border border-gray-200 bg-white px-4 py-3 text-center text-xl font-bold tracking-[0.45em] text-[#0B1E38] placeholder:text-[#CBD5E1] focus:border-[#2F6FED] focus:outline-none focus:ring-2 focus:ring-[#2F6FED]/20 transition-all"
                placeholder="000000">
            <x-input-error :messages="$errors->get('otp')" class="mt-2" />
            <p class="mt-1.5 text-center text-[11px] text-[#94A3B8]">Kode berlaku selama 10 menit.</p>
        </div>

        <div>
            <button type="submit" class="btn-primary w-full">
                Verifikasi kode
            </button>
        </div>
    </form>

    <div class="mt-5 space-y-3 text-center">
        <form method="POST" action="{{ route('password.otp.resend') }}">
            @csrf
            <button type="submit" class="text-sm font-semibold text-[#2F6FED] hover:text-[#1D5BD9] hover:underline transition-colors">
                Kirim ulang kode OTP
            </button>
        </form>

        <a href="{{ route('password.request') }}" class="block text-[13px] text-[#64748B] hover:text-[#2F6FED] hover:underline transition-colors">
            Ganti email
        </a>
    </div>
</x-guest-layout>
