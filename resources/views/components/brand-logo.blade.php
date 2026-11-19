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
    $markSize = max(16, (int) $size);
    $wordmarkSize = max(12, (int) round($markSize * 0.42));
    $subtitleClass = $subtitleClass ?? ($isLight ? 'text-white/65' : 'text-[#64748B]');
@endphp

<span {{ $attributes->merge(['class' => 'inline-flex min-w-0 items-center gap-2.5']) }}
      @if($isMarkOnly) role="img" aria-label="SMK Negeri 11 Bandung" @endif>
    <img src="{{ asset('images/smk11-crest-192.png') }}"
         width="{{ $markSize }}" height="{{ $markSize }}"
         alt="Logo SMK Negeri 11 Bandung"
         class="shrink-0 object-contain"
         style="width: {{ $markSize }}px; height: {{ $markSize }}px;">

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
