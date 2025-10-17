<div class="grid gap-4 md:grid-cols-4">
    <!-- Total Ideas -->
    <div class="rounded-lg border border-zinc-200 dark:border-zinc-700 bg-white dark:bg-zinc-900 p-4">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-zinc-600 dark:text-zinc-400">{{ __('Total Ideas') }}</p>
                <p class="text-2xl font-bold text-zinc-900 dark:text-white mt-1">{{ $stats['total_ideas'] ?? 0 }}</p>
            </div>
            <div class="flex items-center justify-center w-12 h-12 rounded-lg bg-blue-100 dark:bg-blue-900/30">
                <flux:icon.sparkles class="w-6 h-6 text-blue-600 dark:text-blue-400" />
            </div>
        </div>
    </div>

    <!-- Videos Generated -->
    <div class="rounded-lg border border-zinc-200 dark:border-zinc-700 bg-white dark:bg-zinc-900 p-4">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-zinc-600 dark:text-zinc-400">{{ __('Generated') }}</p>
                <p class="text-2xl font-bold text-green-600 dark:text-green-400 mt-1">{{ $stats['generated'] ?? 0 }}</p>
            </div>
            <div class="flex items-center justify-center w-12 h-12 rounded-lg bg-green-100 dark:bg-green-900/30">
                <flux:icon.check-circle class="w-6 h-6 text-green-600 dark:text-green-400" />
            </div>
        </div>
    </div>

    <!-- Failed -->
    <div class="rounded-lg border border-zinc-200 dark:border-zinc-700 bg-white dark:bg-zinc-900 p-4">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-zinc-600 dark:text-zinc-400">{{ __('Failed') }}</p>
                <p class="text-2xl font-bold text-red-600 dark:text-red-400 mt-1">{{ $stats['failed'] ?? 0 }}</p>
            </div>
            <div class="flex items-center justify-center w-12 h-12 rounded-lg bg-red-100 dark:bg-red-900/30">
                <flux:icon.x-circle class="w-6 h-6 text-red-600 dark:text-red-400" />
            </div>
        </div>
    </div>

    <!-- Pending -->
    <div class="rounded-lg border border-zinc-200 dark:border-zinc-700 bg-white dark:bg-zinc-900 p-4">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-zinc-600 dark:text-zinc-400">{{ __('Pending') }}</p>
                <p class="text-2xl font-bold text-amber-600 dark:text-amber-400 mt-1">{{ $stats['pending'] ?? 0 }}</p>
            </div>
            <div class="flex items-center justify-center w-12 h-12 rounded-lg bg-amber-100 dark:bg-amber-900/30">
                <flux:icon.clock class="w-6 h-6 text-amber-600 dark:text-amber-400" />
            </div>
        </div>
    </div>
</div>
