<x-guest-layout>
    <div class="mb-7">
        <p class="text-[10px] font-bold uppercase tracking-[0.18em] text-[#2F6FED]">Reset password</p>
        <h1 class="mt-2 font-display text-[1.65rem] font-bold leading-tight tracking-tight text-[#0B1E38]">Buat password baru</h1>
        <p class="mt-2 text-[13px] leading-relaxed text-[#64748B]">Silakan masukkan password baru kamu di bawah ini.</p>
    </div>

    <form method="POST" action="{{ route('password.store') }}" class="space-y-5">
        @csrf

        <!-- Password Reset Token -->
        <input type="hidden" name="token" value="{{ $request->route('token') }}">

        <!-- Email Address -->
        <div>
            <label for="email" class="field-label">Email</label>
            <div class="relative">
                <span class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3.5 text-[#94A3B8]">
                    <x-icon name="mail" :size="16" />
                </span>
                <input id="email" type="email" name="email" value="{{ old('email', $request->email) }}" required autofocus autocomplete="username"
                    class="block w-full rounded-lg border border-gray-200 bg-white py-2.5 pl-10 pr-4 text-[#0B1E38] placeholder:text-[#94A3B8] focus:border-[#2F6FED] focus:outline-none focus:ring-2 focus:ring-[#2F6FED]/20 transition-all">
            </div>
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div>
            <label for="password" class="field-label">Password Baru</label>
            <div class="relative">
                <span class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3.5 text-[#94A3B8]">
                    <x-icon name="lock" :size="16" />
                </span>
                <input id="password" type="password" name="password" required autocomplete="new-password"
                    class="block w-full rounded-lg border border-gray-200 bg-white py-2.5 pl-10 pr-4 text-[#0B1E38] placeholder:text-[#94A3B8] focus:border-[#2F6FED] focus:outline-none focus:ring-2 focus:ring-[#2F6FED]/20 transition-all">
            </div>
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div>
            <label for="password_confirmation" class="field-label">Konfirmasi Password Baru</label>
            <div class="relative">
                <span class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3.5 text-[#94A3B8]">
                    <x-icon name="lock" :size="16" />
                </span>
                <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password"
                    class="block w-full rounded-lg border border-gray-200 bg-white py-2.5 pl-10 pr-4 text-[#0B1E38] placeholder:text-[#94A3B8] focus:border-[#2F6FED] focus:outline-none focus:ring-2 focus:ring-[#2F6FED]/20 transition-all">
            </div>
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div>
            <button type="submit" class="btn-primary w-full">
                Reset Password
            </button>
        </div>
    </form>
</x-guest-layout>
