@props([
    'label',
    'value',
    'icon' => 'chart',
    'tone' => 'bg-[#EEF4FF] text-[#2F6FED]',
    'hint' => null,
])

<div {{ $attributes->merge(['class' => 'rounded-2xl border border-[#E8EDF5] bg-white p-4 sm:p-5']) }}>
    <div class="flex items-start justify-between gap-3">
        <div class="min-w-0">
            <p class="text-[10.5px] font-semibold uppercase tracking-[0.08em] text-[#94A3B8]">{{ $label }}</p>
            <p class="mt-1.5 font-display text-2xl font-bold leading-none tabular-nums text-[#0B1E38]">{{ $value }}</p>
            @if($hint)
                <p class="mt-1.5 truncate text-[10.5px] text-[#94A3B8]">{{ $hint }}</p>
            @endif
        </div>
        <span class="flex h-9 w-9 shrink-0 items-center justify-center rounded-xl {{ $tone }}">
            <x-icon :name="$icon" :size="16" />
        </span>
    </div>
</div>
