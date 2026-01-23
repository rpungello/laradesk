@props([
    'compact' => false
])
<div {{ $attributes->merge(['class' => 'bg-neutral-800 dark:bg-neutral-100 text-neutral-100 dark:text-neutral-800 rounded-md']) }}>
    <flux:icon name="headset" :class="$compact ? '' : 'w-full h-full px-2 py-1'"/>
</div>
