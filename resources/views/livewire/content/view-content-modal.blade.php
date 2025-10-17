<div>
    <flux:modal name="view-content-modal" wire:model.self="showModal" class="w-full max-w-4xl">
        @if($content)
            <div class="space-y-6" wire:poll.10s="loadContent" wire:key="content-{{ $content->id }}-{{ $contentUpdatedAt }}">
                <!-- Header -->
                <div>
                    <flux:heading size="lg">{{ __('Idea Details') }}</flux:heading>
                    <flux:text class="mt-2">{{ $content->created_at->diffForHumans() }}</flux:text>
                </div>

                <!-- Image & Video Side by Side -->
                <div class="grid grid-cols-2 gap-4">
                    <!-- Image -->
                    <div>
                        <flux:label>{{ __('Reference Image') }}</flux:label>
                        <div class="mt-2 relative rounded-lg overflow-hidden h-64 border border-zinc-200 dark:border-zinc-700">
                            @if ($content->image_ref)
                                <div class="absolute inset-0 bg-gradient-to-br from-zinc-50 to-zinc-100 dark:from-zinc-900 dark:to-zinc-800"></div>
                                <img 
                                    src="{{ $content->image_url }}" 
                                    alt="{{ $content->idea }}" 
                                    class="relative w-full h-64 object-contain"
                                />
                            @else
                                <div class="absolute inset-0 bg-gradient-to-br from-zinc-50 to-zinc-100 dark:from-zinc-900 dark:to-zinc-800"></div>
                                <x-placeholder-pattern class="relative inset-0 size-full stroke-gray-900/20 dark:stroke-neutral-100/20" />
                            @endif
                        </div>
                    </div>

                    <!-- Video -->
                    <div>
                        <flux:label>{{ __('Generated Video') }}</flux:label>
                        <div class="mt-2 relative rounded-lg overflow-hidden h-64 border border-zinc-200 dark:border-zinc-700 bg-zinc-900">
                            @if ($content->video_output && $content->status->value === 'success')
                                <video width="100%" controls class="w-full h-64">
                                    <source src="{{ $content->video_url }}" type="video/mp4">
                                </video>
                            @elseif($content->status->value === 'generating')
                                <div class="absolute inset-0 flex items-center justify-center bg-gradient-to-br from-zinc-800 to-zinc-900">
                                    <div class="flex flex-col items-center gap-2">
                                        <span class="text-4xl animate-spin">⏳</span>
                                        <p class="text-xs text-zinc-400">Generating...</p>
                                    </div>
                                </div>
                            @elseif($content->status->value === 'fail')
                                <div class="absolute inset-0 flex items-center justify-center bg-gradient-to-br from-red-950 to-red-900">
                                    <div class="flex flex-col items-center gap-2">
                                        <flux:icon.x-circle class="h-8 w-8 text-red-400" />
                                        <p class="text-xs text-red-300">Generation failed</p>
                                    </div>
                                </div>
                            @else
                                <div class="absolute inset-0 bg-gradient-to-br from-zinc-800 to-zinc-900"></div>
                                <x-placeholder-pattern class="relative inset-0 size-full stroke-gray-900/20 dark:stroke-neutral-100/20" />
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Status & Meta Info -->
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <flux:label>{{ __('Status') }}</flux:label>
                        <p>
                            <flux:badge variant="solid" :color="$content->status->color()" size="lg" class="mt-2">
                                {{ ucfirst($content->status->label()) }}
                            </flux:badge>
                        </p>
                    </div>
                    <div>
                        <flux:label>{{ __('Aspect Ratio') }}</flux:label>
                        <p class="mt-2 text-sm font-medium text-zinc-900 dark:text-white">{{ $content->aspect_ratio->label() }}</p>
                    </div>
                </div>

                <!-- Style -->
                <div>
                    <flux:label>{{ __('Style') }}</flux:label>
                    <p>
                        <flux:badge variant="solid" :color="$content->style->color()" size="lg" class="mt-2">
                            {{ $content->style->label() }}
                        </flux:badge>
                    </p>
                </div>

                <!-- Idea Text -->
                <div>
                    <flux:label>{{ __('Idea') }}</flux:label>
                    <p class="mt-2 text-sm text-zinc-700 dark:text-zinc-300 leading-relaxed">{{ $content->idea }}</p>
                </div>

                <!-- Title -->
                <div>
                    <flux:label>{{ __('Title') }}</flux:label>
                    <p class="mt-2 text-sm font-semibold text-zinc-900 dark:text-white">{{ $content->title ?? '-' }}</p>
                </div>

                <!-- Caption -->
                <div>
                    <flux:label>{{ __('Caption') }}</flux:label>
                    <p class="mt-2 text-sm text-zinc-700 dark:text-zinc-300 leading-relaxed">{{ $content->caption ?? '-' }}</p>
                </div>

                <!-- Video Prompt -->
                <div>
                    <flux:label>{{ __('Video Prompt') }}</flux:label>
                    <p class="mt-2 text-sm text-zinc-700 dark:text-zinc-300 leading-relaxed">{{ $content->video_prompt ?? '-' }}</p>
                </div>

                <!-- Timestamps -->
                <div class="grid grid-cols-2 gap-4 pt-4 border-t border-zinc-200 dark:border-zinc-700">
                    <div>
                        <flux:label class="text-xs">{{ __('Created') }}</flux:label>
                        <p class="mt-1 text-xs text-zinc-500 dark:text-zinc-400">{{ $content->created_at->format('d M Y, H:i') }}</p>
                    </div>
                    <div>
                        <flux:label class="text-xs">{{ __('Updated') }}</flux:label>
                        <p class="mt-1 text-xs text-zinc-500 dark:text-zinc-400">{{ $content->updated_at->format('d M Y, H:i') }}</p>
                    </div>
                </div>

                <!-- Video Section -->
                @if ($content->video_output)
                    <div>
                        <flux:label>{{ __('Video File') }}</flux:label>
                        <p class="mt-2 text-xs text-zinc-500 dark:text-zinc-400 break-all font-mono">{{ $content->video_output }}</p>
                    </div>
                @endif

                <!-- Action Buttons -->
                <div class="flex gap-3 pt-6 justify-end border-t border-zinc-200 dark:border-zinc-700">
                     @if($content->status->value === 'success' && $content->video_output)
                        <flux:button
                            variant="primary"
                            icon="arrow-down"
                        >
                            {{ __('Download') }}
                        </flux:button>
                    @endif

                    @if($content->status->value === 'draft')
                        <flux:button
                            wire:click="$dispatch('editDraft', { id: '{{ $content->id }}' })"
                            variant="primary"
                            color="blue"
                            icon="pencil"
                        >
                            {{ __('Edit') }}
                        </flux:button>
                    @endif

                    <flux:button
                        wire:click="confirmDelete"
                        variant="danger"
                        icon="trash"
                    >
                        {{ __('Delete') }}
                    </flux:button>

                    <flux:modal.close>
                        <flux:button variant="ghost">{{ __('Close') }}</flux:button>
                    </flux:modal.close>
                   
                </div>
            </div>
        @endif
    </flux:modal>

    <!-- Delete Confirm Modal -->
    <flux:modal name="delete-confirm-modal" wire:model.self="showDeleteConfirm" variant="danger">
        <div class="space-y-4">
            <div class="flex items-start gap-4">
                <div class="flex items-center justify-center w-12 h-12 rounded-full bg-red-100 dark:bg-red-950/30">
                    <flux:icon.trash class="w-6 h-6 text-red-600 dark:text-red-400" />
                </div>
                <div>
                    <flux:heading size="md">{{ __('Delete Idea') }}</flux:heading>
                    <flux:text class="mt-1 text-sm text-zinc-600 dark:text-zinc-400">
                        {{ __('Are you sure you want to delete this idea? This action cannot be undone.') }}
                    </flux:text>
                </div>
            </div>

            <div class="flex gap-3 justify-end pt-4 border-t border-zinc-200 dark:border-zinc-700">
                <flux:button
                    wire:click="cancelDelete"
                    variant="ghost"
                >
                    {{ __('Cancel') }}
                </flux:button>
                <flux:button
                    wire:click="deleteContent"
                    variant="danger"
                    icon="trash"
                >
                    {{ __('Delete') }}
                </flux:button>
            </div>
        </div>
    </flux:modal>
</div>
