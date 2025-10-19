<div wire:poll.15s="refreshTable">
    <!-- Search and New Idea Button Row -->
    <div class="flex gap-3 mb-6">
        <flux:input 
            wire:model.live="search"
            icon="magnifying-glass"
            placeholder="{{ __('Search ideas...') }}"
            type="search"
            class="flex-1"
        />
        <flux:modal.trigger name="form-content-modal">
            <flux:button variant="primary" icon="plus">
                ✨ {{ __('New Idea') }}
            </flux:button>
        </flux:modal.trigger>
        
        {{-- <flux:button 
            variant="ghost" 
            icon="bolt"
            wire:click="testWebhook"
            wire:loading.attr="disabled"
            wire:loading.class="opacity-50 cursor-not-allowed"
        >
            <span wire:loading.remove>🧪 Test Webhook</span>
            <span wire:loading>Testing...</span>
        </flux:button> --}}
    </div>

    <!-- Content Grid -->
    <div class="grid gap-6 grid-cols-1 md:grid-cols-2 lg:grid-cols-3">
        @forelse ($contents as $content)
            <div class="bg-white dark:bg-zinc-800 rounded-lg border border-zinc-200 dark:border-zinc-700 overflow-hidden hover:shadow-lg transition-shadow">
                <!-- Image -->
                <div class="relative h-48 overflow-hidden border-b border-zinc-200 dark:border-zinc-700">
                    @if ($content->image_ref)
                        <div class="absolute inset-0 bg-gradient-to-br from-zinc-50 to-zinc-100 dark:from-zinc-900 dark:to-zinc-800"></div>
                        <img 
                            src="{{ $content->image_url }}" 
                            alt="{{ $content->idea }}" 
                            class="relative w-full h-full object-contain hover:scale-105 transition duration-300"
                        >
                    @else
                        <div class="absolute inset-0 bg-gradient-to-br from-zinc-50 to-zinc-100 dark:from-zinc-900 dark:to-zinc-800 flex items-center justify-center">
                            <x-placeholder-pattern class="absolute inset-0 size-full stroke-gray-900/20 dark:stroke-neutral-100/20" />
                        </div>
                    @endif
                    
                    <!-- Status Badge -->
                    <div class="absolute top-3 right-3  rounded-full p-1 shadow-md">
                        <flux:badge variant="solid" :color="$content->status->color()" size="sm">
                            {{ $content->status->label() }} 
                        </flux:badge>
                    </div>
                </div>

                <!-- Content Info -->
                <div class="p-4 space-y-3">
                    <h3 class="font-semibold text-zinc-900 dark:text-white line-clamp-2">{{ $content->idea }}</h3>
                    
                    <div class="flex items-center justify-between text-xs text-zinc-500 dark:text-zinc-400">
                        <span>📐 {{ $content->aspect_ratio->label() }}</span>
                        <span>⏱️ {{ $content->duration ?? 15 }}s</span>
                    </div>

                    <div class="flex items-center justify-between text-xs text-zinc-500 dark:text-zinc-400">
                        <span></span>
                        <span>{{ $content->created_at->diffForHumans() }}</span>
                    </div>

                    <!-- Style Badge -->
                    <div>
                        <flux:badge variant="solid" :color="$content->style->color()" size="sm">
                            {{ $content->style->label() }}
                        </flux:badge>
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex gap-2 pt-3">
                        <flux:button 
                            wire:click="$dispatch('viewContent', { id: '{{ $content->id }}' })"
                            size="sm"
                            variant="primary"
                            icon="eye"
                            class="flex-1"
                        >
                            {{ __('View') }}
                        </flux:button>

                        @if($content->status->value === 'draft')
                        <flux:button 
                            wire:click="$dispatch('editDraft', { id: '{{ $content->id }}' })"
                            size="sm"
                            variant="primary" 
                            color="blue"
                            icon="pencil"
                        />
                        @endif
                        
                        <flux:button 
                            wire:click="confirmDelete('{{ $content->id }}')"
                            size="sm"
                            variant="danger"
                            icon="trash"
                        />
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-full">
                <div class="bg-white dark:bg-zinc-800 rounded-lg border border-zinc-200 dark:border-zinc-700 p-12 text-center">
                    <flux:icon.inbox class="mx-auto h-12 w-12 text-zinc-400 mb-4" />
                    <p class="text-zinc-600 dark:text-zinc-400">{{ __('No ideas yet. Create your first idea!') }} 🚀</p>
                </div>
            </div>
        @endforelse
    </div>

    <!-- Pagination -->
    <div class="mt-8">
        {{ $contents->links() }}
    </div>

    <!-- Delete Confirm Modal -->
    <flux:modal name="delete-content-modal" wire:model.self="showDeleteConfirm" variant="danger">
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
                    wire:click="deleteContent('{{ $deleteContentId }}')"
                    variant="danger"
                    icon="trash"
                    wire:loading.attr="disabled"
                    wire:loading.class="opacity-50 cursor-not-allowed"
                >
                    <span wire:loading.remove>{{ __('Delete') }}</span>
                    <span wire:loading class="flex items-center gap-2">
                        <svg class="animate-spin h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        {{ __('Deleting...') }}
                    </span>
                </flux:button>
            </div>
        </div>
    </flux:modal>
</div>
