@props(['status'])

@if ($status)
    <div {{ $attributes->merge(['class' => 'flex items-start gap-2.5 rounded-xl border border-[#BBF7D0] bg-[#F0FDF4] px-3.5 py-3 text-[12px] font-medium leading-relaxed text-[#15803D]']) }}>
        <x-icon name="check" :size="14" class="mt-0.5 shrink-0" />
        <span>{{ $status }}</span>
    </div>
@endif
