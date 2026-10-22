<x-app-layout title="Keamanan Akun">
    @php
        $user = auth()->user();
        $backUrl = $user->isKesiswaan() ? route('kesiswaan.profil') : route('dashboard');
    @endphp

    <div class="max-w-2xl">
        <a href="{{ $backUrl }}" class="mb-5 inline-flex items-center gap-1.5 text-sm font-medium text-[#0B1E38]/50 transition hover:text-[#0B1E38]">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                <path d="M19 12H5M5 12l7 7M5 12l7-7" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
            Kembali
        </a>

        @include('partials.password-form')
    </div>
</x-app-layout>
