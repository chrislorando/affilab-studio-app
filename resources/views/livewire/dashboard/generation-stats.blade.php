<div>
    <div class="mb-4">
        <h2 class="text-lg font-semibold text-zinc-900 dark:text-white">{{ __('Generation Statistics') }}</h2>
        <p class="text-sm text-zinc-600 dark:text-zinc-400">{{ __('Overview of your video generations') }}</p>
    </div>

    <div class="grid gap-6 md:grid-cols-3">
        <!-- Status Stats -->
        <div class="rounded-lg border border-zinc-200 dark:border-zinc-700 bg-white dark:bg-zinc-900 p-6">
            <h3 class="mb-4 text-sm font-semibold text-zinc-900 dark:text-white">{{ __('Generation Status') }}</h3>
            <div class="space-y-3">
                <!-- Success -->
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-2">
                        <div class="flex h-3 w-3 items-center justify-center rounded-full bg-green-500"></div>
                        <span class="text-sm text-zinc-600 dark:text-zinc-400">{{ __('Successful') }}</span>
                    </div>
                    <span class="font-semibold text-zinc-900 dark:text-white">{{ $stats['status']['success'] ?? 0 }}</span>
                </div>

                <!-- Failed -->
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-2">
                        <div class="flex h-3 w-3 items-center justify-center rounded-full bg-red-500"></div>
                        <span class="text-sm text-zinc-600 dark:text-zinc-400">{{ __('Failed') }}</span>
                    </div>
                    <span class="font-semibold text-zinc-900 dark:text-white">{{ $stats['status']['failed'] ?? 0 }}</span>
                </div>

                <!-- Progress Bar -->
                @php
                    $total = ($stats['status']['success'] ?? 0) + ($stats['status']['failed'] ?? 0);
                    $successPercent = $total > 0 ? (($stats['status']['success'] ?? 0) / $total) * 100 : 0;
                @endphp
                <div class="mt-4 h-2 overflow-hidden rounded-full bg-zinc-200 dark:bg-zinc-800">
                    <div 
                        class="h-full bg-green-500 transition-all duration-300"
                        style="width: {{ $successPercent }}%"
                    ></div>
                </div>
                <p class="text-xs text-zinc-500 dark:text-zinc-400">
                    {{ number_format($successPercent, 1) }}% {{ __('success rate') }}
                </p>
            </div>
        </div>

        <!-- Style Distribution -->
        <div class="rounded-lg border border-zinc-200 dark:border-zinc-700 bg-white dark:bg-zinc-900 p-6">
            <h3 class="mb-4 text-sm font-semibold text-zinc-900 dark:text-white">{{ __('By Style') }}</h3>
            <div class="space-y-3">
                <!-- Professional -->
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-2">
                        <div class="flex h-3 w-3 items-center justify-center rounded-full bg-blue-500"></div>
                        <span class="text-sm text-zinc-600 dark:text-zinc-400">{{ __('Professional') }}</span>
                    </div>
                    <span class="font-semibold text-zinc-900 dark:text-white">{{ $stats['styles']['professional'] ?? 0 }}</span>
                </div>

                <!-- Absurd -->
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-2">
                        <div class="flex h-3 w-3 items-center justify-center rounded-full bg-purple-500"></div>
                        <span class="text-sm text-zinc-600 dark:text-zinc-400">{{ __('Absurd') }}</span>
                    </div>
                    <span class="font-semibold text-zinc-900 dark:text-white">{{ $stats['styles']['absurd'] ?? 0 }}</span>
                </div>

                <!-- Pie representation -->
                @php
                    $stylTotal = ($stats['styles']['professional'] ?? 0) + ($stats['styles']['absurd'] ?? 0);
                    $profPercent = $stylTotal > 0 ? (($stats['styles']['professional'] ?? 0) / $stylTotal) * 100 : 0;
                @endphp
                @if($stylTotal > 0)
                    <div class="mt-4 h-2 overflow-hidden rounded-full bg-zinc-200 dark:bg-zinc-800 flex">
                        <div 
                            class="h-full bg-blue-500"
                            style="width: {{ $profPercent }}%"
                        ></div>
                        <div 
                            class="h-full bg-purple-500"
                            style="width: {{ 100 - $profPercent }}%"
                        ></div>
                    </div>
                @endif
            </div>
        </div>

        <!-- Aspect Ratio Distribution -->
        <div class="rounded-lg border border-zinc-200 dark:border-zinc-700 bg-white dark:bg-zinc-900 p-6">
            <h3 class="mb-4 text-sm font-semibold text-zinc-900 dark:text-white">{{ __('By Aspect Ratio') }}</h3>
            <div class="space-y-3">
                <!-- Landscape -->
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-2">
                        <div class="flex h-3 w-3 items-center justify-center rounded-full bg-amber-500"></div>
                        <span class="text-sm text-zinc-600 dark:text-zinc-400">{{ __('Landscape') }}</span>
                    </div>
                    <span class="font-semibold text-zinc-900 dark:text-white">{{ $stats['ratios']['landscape'] ?? 0 }}</span>
                </div>

                <!-- Portrait -->
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-2">
                        <div class="flex h-3 w-3 items-center justify-center rounded-full bg-cyan-500"></div>
                        <span class="text-sm text-zinc-600 dark:text-zinc-400">{{ __('Portrait') }}</span>
                    </div>
                    <span class="font-semibold text-zinc-900 dark:text-white">{{ $stats['ratios']['portrait'] ?? 0 }}</span>
                </div>

            </div>
        </div>
    </div>
</div>
