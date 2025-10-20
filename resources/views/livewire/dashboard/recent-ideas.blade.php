<div>
    <div class="mb-4">
        <h2 class="text-lg font-semibold text-zinc-900 dark:text-white">{{ __('Recent Ideas') }}</h2>
        <p class="text-sm text-zinc-600 dark:text-zinc-400">{{ __('Your latest video ideas') }}</p>
    </div>

    @if($ideas->count() > 0)
        <div class="grid gap-4 grid-cols-2 sm:grid-cols-3 lg:grid-cols-4">
            @foreach($ideas as $idea)
                <div class="bg-white dark:bg-zinc-800 rounded-lg border border-zinc-200 dark:border-zinc-700 overflow-hidden hover:shadow-md transition-shadow">
                    <!-- Image -->
                    <div class="relative h-32 overflow-hidden bg-gradient-to-br from-zinc-50 to-zinc-100 dark:from-zinc-900 dark:to-zinc-800">
                        @if ($idea->image_ref)
                            <img 
                                src="{{ $idea->image_url }}" 
                                alt="{{ $idea->idea }}" 
                                class="w-full h-full object-contain hover:scale-110 transition duration-300"
                            >
                        @else
                            <x-placeholder-pattern class="absolute inset-0 size-full stroke-gray-900/20 dark:stroke-neutral-100/20" />
                        @endif
                        
                        <!-- Status Badge -->
                        <div class="absolute top-2 right-2">
                            <flux:badge variant="solid" :color="$idea->status->color()" size="xs">
                                {{ $idea->status->label() }} 
                            </flux:badge>
                        </div>
                    </div>

                    <!-- Content -->
                    <div class="p-3 space-y-2">
                        <h3 class="font-semibold text-sm text-zinc-900 dark:text-white line-clamp-2">{{ $idea->idea }}</h3>
                        
                        <div class="flex items-center gap-2 text-xs text-zinc-500 dark:text-zinc-400">
                            <span>{{ $idea->aspect_ratio->icon() }}</span>
                            <span>{{ $idea->duration->icon() }}</span>
                            <flux:badge variant="solid" :color="$idea->style->color()" size="xs">
                                {{ $idea->style->label() }}
                            </flux:badge>
                        </div>

                        <div class="text-xs text-zinc-400 dark:text-zinc-500">
                            {{ $idea->created_at->diffForHumans() }}
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="flex flex-col items-center justify-center py-8 text-center">
            <flux:icon.inbox class="mb-2 h-8 w-8 text-zinc-400" />
            <p class="text-xs font-medium text-zinc-600 dark:text-zinc-400">{{ __('No ideas yet') }}</p>
        </div>
    @endif
</div>
