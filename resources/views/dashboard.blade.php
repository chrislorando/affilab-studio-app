<x-layouts.app :title="__('Dashboard')">
    <div class="flex flex-col gap-8">
        <!-- Header -->
        <div class="mb-2">
            <h1 class="text-3xl font-bold text-gray-900 dark:text-white">{{ __('Dashboard') }}</h1>
            <p class="mt-1 text-sm text-zinc-600 dark:text-zinc-400">{{ __('Welcome back! Here\'s your video generation overview.') }}</p>
        </div>

        <!-- Stats Cards -->
        <div>
            <livewire:dashboard.stats-cards />
        </div>

        <!-- Recent Ideas Grid -->
        <div>
            <livewire:dashboard.recent-ideas />
        </div>

        <!-- Generation Statistics -->
        <div>
            <livewire:dashboard.generation-stats />
        </div>
    </div>
</x-layouts.app>
