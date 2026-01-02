<div class="flex aspect-square size-8 items-center justify-center rounded-md bg-accent-content text-accent-foreground">
    <x-app-logo-icon class="size-5 fill-current text-white dark:text-black" />
</div>
<div class="ms-1 grid flex-1 text-start text-sm">
    <flux:text variant="strong">{{ config('app.name') }}</flux:text>
    <flux:text variant="subtle">v{{ config('app.version') }}</flux:text>
</div>
