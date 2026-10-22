@props([
    'size' => 36,
    'variant' => 'full',
    'tone' => 'brand',
    'subtitle' => null,
    'subtitleClass' => null,
])

@php
    $isLight = $tone === 'light';
    $isMarkOnly = $variant === 'mark';
    $gradientId = 'brand-'.uniqid();
    $markSize = max(16, (int) $size);
    $wordmarkSize = max(12, (int) round($markSize * 0.42));
    $subtitleClass = $subtitleClass ?? ($isLight ? 'text-white/65' : 'text-[#64748B]');
@endphp

<span {{ $attributes->merge(['class' => 'inline-flex min-w-0 items-center gap-2.5']) }}
      @if($isMarkOnly) role="img" aria-label="E-Prestasi" @endif>
    <svg width="{{ $markSize }}" height="{{ $markSize }}" viewBox="0 0 64 64" fill="none" aria-hidden="true" class="shrink-0">
        <defs>
            <linearGradient id="{{ $gradientId }}" x1="8" y1="4" x2="56" y2="60" gradientUnits="userSpaceOnUse">
                <stop stop-color="#2F6FED"/>
                <stop offset="1" stop-color="#1B4FC4"/>
            </linearGradient>
        </defs>

        {{-- Badge dasar --}}
        <rect width="64" height="64" rx="17" fill="{{ $isLight ? 'rgba(255,255,255,0.14)' : 'url(#'.$gradientId.')' }}"/>
        <rect x="1" y="1" width="62" height="62" rx="16" stroke="white" stroke-opacity="{{ $isLight ? '0.24' : '0.16' }}"/>

        {{-- Shield: keamanan & kredibilitas --}}
        <path d="M32 13.5c4.8 1.9 9.8 3 15 3.4v10.3c0 9.2-5.8 16.4-15 21.3-9.2-4.9-15-12.1-15-21.3V16.9c5.2-.4 10.2-1.5 15-3.4Z"
              fill="white" fill-opacity="{{ $isLight ? '0.10' : '0.12' }}"
              stroke="white" stroke-width="2.4" stroke-linejoin="round"/>

        {{-- Centang: terverifikasi --}}
        <path d="m25 32 5 5 10-11" stroke="white" stroke-width="3.2" stroke-linecap="round" stroke-linejoin="round"/>

        {{-- Bintang: prestasi --}}
        <path d="M52 7.5l1.35 3.85L57.2 12.7l-3.85 1.35L52 17.9l-1.35-3.85L46.8 12.7l3.85-1.35L52 7.5Z" fill="#F97316"/>
    </svg>

    @if (!$isMarkOnly)
        <span class="min-w-0 leading-tight">
            <span class="block truncate font-display font-bold tracking-tight {{ $isLight ? 'text-white' : 'text-[#0B1E38]' }}"
                  style="font-size: {{ $wordmarkSize }}px;">E-Prestasi</span>
            @if ($subtitle)
                <span class="mt-0.5 block truncate text-[10px] {{ $subtitleClass }}">{{ $subtitle }}</span>
            @endif
        </span>
    @endif
</span>
