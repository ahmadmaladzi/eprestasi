@php
    $passwordError = $errors->hasAny(['current_password', 'password']);
@endphp

<div class="bg-white rounded-2xl border border-[#E8EDF5] overflow-hidden">
    <div class="flex items-center gap-3 px-5 sm:px-7 py-4 border-b border-[#E8EDF5]">
        <span class="w-9 h-9 rounded-xl bg-[#EEF4FF] text-[#2F6FED] flex items-center justify-center shrink-0">
            <svg width="17" height="17" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                <rect x="5" y="10" width="14" height="10" rx="2.5" stroke="currentColor" stroke-width="1.7"/>
                <path d="M8 10V7a4 4 0 1 1 8 0v3" stroke="currentColor" stroke-width="1.7" stroke-linecap="round"/>
            </svg>
        </span>
        <div class="min-w-0">
            <h2 class="font-display text-sm font-semibold text-[#0B1E38]">Ganti Password</h2>
            <p class="text-xs text-[#64748B]">Gunakan password yang kuat dan tidak dipakai di akun lain.</p>
        </div>
    </div>

    <form method="POST" action="{{ route('akunpassword.update') }}" class="p-5 sm:p-7 space-y-5" x-data="{ show: false }">
        @csrf
        @method('PUT')

        @if($passwordError)
            <div class="rounded-xl border border-red-200 bg-red-50 px-4 py-3.5">
                <p class="text-xs font-semibold text-red-700 mb-1.5">Password gagal diubah</p>
                <ul class="list-disc list-inside space-y-0.5 text-xs text-red-600">
                    @foreach($errors->get('current_password') as $message)
                        <li>{{ $message }}</li>
                    @endforeach
                    @foreach($errors->get('password') as $message)
                        <li>{{ $message }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div>
            <label for="current_password" class="block text-xs font-semibold text-[#64748B] mb-1.5">Password Saat Ini</label>
            <div class="relative">
                <span class="pointer-events-none absolute left-3.5 top-1/2 -translate-y-1/2 text-[#94A3B8]">
                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                        <circle cx="8" cy="15" r="4" stroke="currentColor" stroke-width="1.7"/>
                        <path d="M11 12l8-8M17 4l3 3M14 7l3 3" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </span>
                <input id="current_password" name="current_password" type="password" :type="show ? 'text' : 'password'"
                       autocomplete="current-password" required
                       class="block w-full rounded-xl border bg-white pl-10 pr-3.5 py-2.5 text-sm text-[#0B1E38] shadow-sm transition focus:border-[#2F6FED] focus:ring-2 focus:ring-[#2F6FED]/20 {{ $errors->has('current_password') ? 'border-red-300' : 'border-[#E2E8F0]' }}">
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
            <div>
                <label for="password" class="block text-xs font-semibold text-[#64748B] mb-1.5">Password Baru</label>
                <input id="password" name="password" type="password" :type="show ? 'text' : 'password'"
                       autocomplete="new-password" required
                       class="block w-full rounded-xl border bg-white px-3.5 py-2.5 text-sm text-[#0B1E38] shadow-sm transition focus:border-[#2F6FED] focus:ring-2 focus:ring-[#2F6FED]/20 {{ $errors->has('password') ? 'border-red-300' : 'border-[#E2E8F0]' }}">
                <p class="mt-1.5 text-[11px] text-[#94A3B8]">Minimal 8 karakter.</p>
            </div>
            <div>
                <label for="password_confirmation" class="block text-xs font-semibold text-[#64748B] mb-1.5">Konfirmasi Password Baru</label>
                <input id="password_confirmation" name="password_confirmation" type="password" :type="show ? 'text' : 'password'"
                       autocomplete="new-password" required
                       class="block w-full rounded-xl border border-[#E2E8F0] bg-white px-3.5 py-2.5 text-sm text-[#0B1E38] shadow-sm transition focus:border-[#2F6FED] focus:ring-2 focus:ring-[#2F6FED]/20">
            </div>
        </div>

        <label class="inline-flex items-center gap-2 text-xs font-medium text-[#64748B] cursor-pointer select-none">
            <input type="checkbox" x-model="show" class="rounded border-[#CBD5E1] text-[#2F6FED] focus:ring-[#2F6FED]/30">
            Tampilkan password
        </label>

        <div class="flex flex-wrap items-center gap-3 border-t border-[#E8EDF5] pt-5">
            <button type="submit" class="inline-flex items-center gap-2 rounded-xl bg-gradient-to-r from-[#2F6FED] to-[#1B4FC4] px-5 py-2.5 text-sm font-semibold text-white shadow-lg shadow-[#2F6FED]/25 transition hover:opacity-90 focus:outline-none focus-visible:ring-2 focus-visible:ring-[#2F6FED] focus-visible:ring-offset-2">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                    <path d="M20 6L9 17L4 12" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
                Simpan Password Baru
            </button>
        </div>
    </form>
</div>
