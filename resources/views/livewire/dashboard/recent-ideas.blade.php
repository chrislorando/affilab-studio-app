<div>
    <div class="mb-4">
        <h2 class="text-lg font-semibold text-zinc-900 dark:text-white">{{ __('Recent Ideas') }}</h2>
        <p class="text-sm text-zinc-600 dark:text-zinc-400">{{ __('Your latest video ideas') }}</p>
    </div>

    @if($ideas->count() > 0)
        <div class="grid gap-4 md:grid-cols-3">
            @foreach($ideas as $idea)
                <div class="group relative overflow-hidden rounded-lg border border-zinc-200 dark:border-zinc-700 bg-white dark:bg-zinc-900 transition hover:border-zinc-300 dark:hover:border-zinc-600">
                    <!-- Image -->
                    <div class="relative aspect-video overflow-hidden bg-zinc-100 dark:bg-zinc-800">
                        @if($idea->image_ref)
                            <img 
                                src="{{ $idea->image_url }}" 
                                alt="{{ $idea->idea }}" 
                                class="h-full w-full object-cover transition group-hover:scale-105"
                            />
                        @else
                            <div class="flex h-full items-center justify-center">
                                <x-placeholder-pattern class="size-full stroke-gray-900/10 dark:stroke-neutral-100/10" />
                            </div>
                        @endif

                        <!-- Status Badge -->
                        <div class="absolute top-2 right-2">
                            <flux:badge 
                                variant="solid" 
                                :color="$idea->status->color()" 
                                size="sm"
                            >
                                {{ $idea->status->label() }}
                            </flux:badge>
                        </div>

                        <!-- Overlay Actions -->
                        <div class="absolute inset-0 flex items-center justify-center gap-2 bg-black/50 opacity-0 transition group-hover:opacity-100">
                            <button 
                                wire:click="$dispatch('viewContent', { id: '{{ $idea->id }}' })"
                                class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-white dark:bg-zinc-800 text-zinc-900 dark:text-white hover:bg-zinc-100 dark:hover:bg-zinc-700 transition"
                                title="{{ __('View') }}"
                            >
                                <flux:icon.eye class="w-5 h-5" />
                            </button>
                            @if($idea->status->value === 'draft' || $idea->status->value === 'preparation')
                                <button 
                                    wire:click="$dispatch('editDraft', { id: '{{ $idea->id }}' })"
                                    class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-white dark:bg-zinc-800 text-zinc-900 dark:text-white hover:bg-zinc-100 dark:hover:bg-zinc-700 transition"
                                    title="{{ __('Edit') }}"
                                >
                                    <flux:icon.pencil class="w-5 h-5" />
                                </button>
                            @endif
                            <button 
                                wire:click="$dispatch('deleteIdea', { id: '{{ $idea->id }}' })"
                                class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-red-600 text-white hover:bg-red-700 transition"
                                title="{{ __('Delete') }}"
                            >
                                <flux:icon.trash class="w-5 h-5" />
                            </button>
                        </div>
                    </div>

                    <!-- Content -->
                    <div class="p-3">
                        <!-- Title or Idea -->
                        <p class="text-sm font-semibold text-zinc-900 dark:text-white truncate">
                            {{ $idea->title ?? Str::limit($idea->idea, 40) }}
                        </p>

                        <!-- Meta Info -->
                        <div class="mt-2 flex items-center justify-between text-xs text-zinc-500 dark:text-zinc-400">
                            <span>{{ $idea->aspect_ratio->label() }}</span>
                            <span>{{ $idea->created_at->diffForHumans() }}</span>
                        </div>

                        <!-- Style Badge -->
                        <div class="mt-2">
                            <flux:badge 
                                variant="outline" 
                                :color="$idea->style->color()" 
                                size="sm"
                            >
                                {{ $idea->style->label() }}
                            </flux:badge>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="flex flex-col items-center justify-center py-12 text-center">
            <flux:icon.inbox class="mb-4 h-12 w-12 text-zinc-400" />
            <p class="text-sm font-medium text-zinc-600 dark:text-zinc-400">{{ __('No ideas yet') }}</p>
            <p class="mt-1 text-xs text-zinc-500 dark:text-zinc-500">{{ __('Create your first video idea to get started') }}</p>
        </div>
    @endif
</div>
