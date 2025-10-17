<div>
    <div class="flex flex-col gap-4">
        <!-- Header Section -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-zinc-900 dark:text-white">🎬 {{ __('Your Ideas') }}</h1>
            <p class="mt-1 text-sm text-zinc-600 dark:text-zinc-400">{{ __('Transform your creative visions into videos') }}</p>
        </div>

        <!-- Flash Messages -->
        @if (session('success'))
            <div class="mb-6 p-4 bg-green-50 dark:bg-green-950/20 border border-green-200 dark:border-green-900 rounded-lg flex items-center gap-3">
                <flux:icon.check-circle class="h-5 w-5 text-green-600 dark:text-green-400" />
                <p class="text-sm text-green-700 dark:text-green-300">{{ session('success') }}</p>
            </div>
        @endif

        @if (session('error'))
            <div class="mb-6 p-4 bg-red-50 dark:bg-red-950/20 border border-red-200 dark:border-red-900 rounded-lg flex items-center gap-3">
                <flux:icon.x-circle class="h-5 w-5 text-red-600 dark:text-red-400" />
                <p class="text-sm text-red-700 dark:text-red-300">{{ session('error') }}</p>
            </div>
        @endif

        <!-- Table Content Component with Poll -->
        <livewire:content.table-content wire:poll-5000="$refresh" />
    </div>

    <!-- Modals -->
    <livewire:content.form-content-modal />
    <livewire:content.view-content-modal />
</div>
