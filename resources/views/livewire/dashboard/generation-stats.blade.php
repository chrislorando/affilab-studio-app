<div>
    <div class="mb-4">
        <h2 class="text-lg font-semibold text-zinc-900 dark:text-white">{{ __('Generation Statistics') }}</h2>
        <p class="text-sm text-zinc-600 dark:text-zinc-400">{{ __('Overview of your video generations') }}</p>
    </div>

    <div class="grid gap-6 md:grid-cols-4">
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
                @forelse ($stats['styles'] as $styleKey => $styleData)
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-2">
                            @php
                                $colorMap = [
                                    'blue' => 'bg-blue-500',
                                    'purple' => 'bg-purple-500',
                                    'gray' => 'bg-gray-500',
                                    'green' => 'bg-green-500',
                                    'orange' => 'bg-orange-500',
                                    'teal' => 'bg-teal-500',
                                ];
                                $bgColor = $colorMap[$styleData['color']] ?? 'bg-gray-500';
                            @endphp
                            <div class="flex h-3 w-3 items-center justify-center rounded-full {{ $bgColor }}"></div>
                            <span class="text-sm text-zinc-600 dark:text-zinc-400">{{ $styleData['label'] }}</span>
                        </div>
                        <span class="font-semibold text-zinc-900 dark:text-white">{{ $styleData['count'] }}</span>
                    </div>
                @empty
                    <p class="text-sm text-zinc-500 dark:text-zinc-400">{{ __('No data available') }}</p>
                @endforelse

                <!-- Pie representation -->
                @php
                    $totalStyles = collect($stats['styles'])->sum('count');
                @endphp
                @if($totalStyles > 0)
                    <div class="mt-4 h-2 overflow-hidden rounded-full bg-zinc-200 dark:bg-zinc-800 flex">
                        @foreach ($stats['styles'] as $styleData)
                            @php
                                $percentage = ($styleData['count'] / $totalStyles) * 100;
                                $colorMap = [
                                    'blue' => 'bg-blue-500',
                                    'purple' => 'bg-purple-500',
                                    'gray' => 'bg-gray-500',
                                    'green' => 'bg-green-500',
                                    'orange' => 'bg-orange-500',
                                    'teal' => 'bg-teal-500',
                                ];
                                $bgColor = $colorMap[$styleData['color']] ?? 'bg-gray-500';
                            @endphp
                            <div 
                                class="h-full {{ $bgColor }}"
                                style="width: {{ $percentage }}%"
                            ></div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>

        <!-- Aspect Ratio Distribution -->
        <div class="rounded-lg border border-zinc-200 dark:border-zinc-700 bg-white dark:bg-zinc-900 p-6">
            <h3 class="mb-4 text-sm font-semibold text-zinc-900 dark:text-white">{{ __('By Aspect Ratio') }}</h3>
            <div class="space-y-3">
                @forelse ($stats['ratios'] as $ratioKey => $ratioData)
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-2">
                            @php
                                $ratioColorMap = [
                                    'landscape' => 'bg-amber-500',
                                    'portrait' => 'bg-cyan-500',
                                ];
                                $bgColor = $ratioColorMap[$ratioKey] ?? 'bg-gray-500';
                            @endphp
                            <div class="flex h-3 w-3 items-center justify-center rounded-full {{ $bgColor }}"></div>
                            <span class="text-sm text-zinc-600 dark:text-zinc-400">{{ $ratioData['label'] }}</span>
                        </div>
                        <span class="font-semibold text-zinc-900 dark:text-white">{{ $ratioData['count'] }}</span>
                    </div>
                @empty
                    <p class="text-sm text-zinc-500 dark:text-zinc-400">{{ __('No data available') }}</p>
                @endforelse
            </div>
        </div>

        <!-- Duration Distribution -->
        <div class="rounded-lg border border-zinc-200 dark:border-zinc-700 bg-white dark:bg-zinc-900 p-6">
            <h3 class="mb-4 text-sm font-semibold text-zinc-900 dark:text-white">{{ __('By Duration') }}</h3>
            <div class="space-y-3">
                @forelse ($stats['durations'] as $durationKey => $durationData)
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-2">
                            <span class="text-lg">{{ $durationData['icon'] }}</span>
                            <span class="text-sm text-zinc-600 dark:text-zinc-400">{{ $durationData['label'] }}</span>
                        </div>
                        <span class="font-semibold text-zinc-900 dark:text-white">{{ $durationData['count'] }}</span>
                    </div>
                @empty
                    <p class="text-sm text-zinc-500 dark:text-zinc-400">{{ __('No data available') }}</p>
                @endforelse
            </div>
        </div>
    </div>
</div>
