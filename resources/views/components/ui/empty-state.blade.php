@props([
    'icon' => 'clipboard',
    'title' => 'Belum ada data',
    'description' => null,
])

<div {{ $attributes->merge(['class' => 'flex flex-col items-center justify-center px-6 py-12 text-center']) }}>
    <span class="flex h-12 w-12 items-center justify-center rounded-2xl bg-[#F5F7FB] text-[#94A3B8]">
        <x-icon :name="$icon" :size="20" />
    </span>
    <p class="mt-3 text-sm font-semibold text-[#0B1E38]">{{ $title }}</p>
    @if($description)
        <p class="mt-1 max-w-sm text-xs text-[#94A3B8]">{{ $description }}</p>
    @endif
    @if(! $slot->isEmpty())
        <div class="mt-4">{{ $slot }}</div>
    @endif
</div>
