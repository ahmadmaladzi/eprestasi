@php
    $isDisetujui = $prestasi->status === 'Disetujui';
    $isRevisi = $prestasi->status === 'Ditolak' && $prestasi->perlu_revisi;
    $isDitolak = $prestasi->status === 'Ditolak' && ! $prestasi->perlu_revisi;

    $tone = $isDisetujui
        ? 'bg-[#22C55E]/10 text-[#15803D] ring-[#22C55E]/25'
        : ($isDitolak
            ? 'bg-red-50 text-red-600 ring-red-200'
            : 'bg-[#F59E0B]/10 text-[#B45309] ring-[#F59E0B]/25');

    $size = $size ?? 'sm';
    $sizeClass = $size === 'md' ? 'px-3 py-1.5 text-xs' : 'px-2.5 py-1 text-[11px]';
    $iconSize = $size === 'md' ? 13 : 11;
@endphp

<span class="inline-flex items-center gap-1.5 whitespace-nowrap rounded-full font-semibold ring-1 ring-inset {{ $tone }} {{ $sizeClass }}">
    <svg width="{{ $iconSize }}" height="{{ $iconSize }}" viewBox="0 0 24 24" fill="none" aria-hidden="true" class="shrink-0">
        @if($isDisetujui)
            <path d="M20 6 9 17l-5-5" stroke="currentColor" stroke-width="2.6" stroke-linecap="round" stroke-linejoin="round"/>
        @elseif($isRevisi)
            <circle cx="12" cy="12" r="9" stroke="currentColor" stroke-width="1.9"/>
            <path d="M12 7.5v5" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
            <circle cx="12" cy="16.5" r="1.1" fill="currentColor"/>
        @elseif($isDitolak)
            <path d="M18 6 6 18M6 6l12 12" stroke="currentColor" stroke-width="2.4" stroke-linecap="round"/>
        @else
            <circle cx="12" cy="12" r="9" stroke="currentColor" stroke-width="1.9"/>
            <path d="M12 7.5V12l3 2" stroke="currentColor" stroke-width="1.9" stroke-linecap="round" stroke-linejoin="round"/>
        @endif
    </svg>
    {{ $prestasi->label_status }}
</span>
