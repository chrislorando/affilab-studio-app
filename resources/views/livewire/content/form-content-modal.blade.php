<flux:modal name="form-content-modal" wire:model.self="showModal" class="w-full max-w-2xl" :dismissible="false">
    <!-- Header -->
    <div>
        @if ($isEditing)
            <flux:heading size="lg">{{ __('Edit Draft') }}</flux:heading>
            <flux:text class="mt-2">{{ __('Update your draft idea') }}</flux:text>
        @else
            <flux:heading size="lg">{{ __('Create New Idea') }}</flux:heading>
            <flux:text class="mt-2">{{ __('Share your creative vision') }}</flux:text>
        @endif
    </div>

    <!-- Form -->
    <form wire:submit="saveIdea" class="space-y-4 mt-4">
                <!-- Idea Input -->
                <div>
                    <flux:textarea
                        label="{{ __('Your Idea') }}"
                        wire:model="idea"
                        placeholder="Ex : Iklan jaket parka | Untuk motoran biar ga masuk angin | Anti diterjang badai | Cowok"
                        rows="4"
                        description="Format : Iklan [Ide] | Untuk [Masalah] | [CTA] | [Karakter]"
                    />
                </div>

                 <!-- Prompt Input -->
                {{-- <div>
                    <flux:textarea
                        label="{{ __('Video Prompt') }}"
                        wire:model="videoPrompt"
                        rows="10"
                    />
                </div> --}}

                <!-- Aspect Ratio -->
                <div>
                    <flux:radio.group wire:model="aspectRatio" label="Aspect Ratio" variant="segmented">
                        <flux:radio label="Landscape" value="landscape" />
                        <flux:radio label="Portrait" value="portrait" />
                    </flux:radio.group>
                </div>

                <!-- Style -->
                <div>
                    <flux:radio.group wire:model="style" label="Style" variant="segmented">
                        <flux:radio label="Professional" value="professional" />
                        <flux:radio label="Absurd" value="absurd" />
                    </flux:radio.group>
                </div>

                <!-- Image Upload -->
                <div>
                    <flux:field>
                        <flux:label>{{ __('Upload Image') }}</flux:label>
        
                        @if ($isEditing && $oldImageRef)
                            <div class="mb-4">
                                <p class="text-xs text-zinc-500 dark:text-zinc-400 mb-2">{{ __('Current Image') }}</p>
                                <div class="relative rounded-lg overflow-hidden h-40 border border-zinc-200 dark:border-zinc-600">
                                    <div class="absolute inset-0 bg-gradient-to-br from-zinc-50 to-zinc-100 dark:from-zinc-900 dark:to-zinc-800"></div>
                                    <img 
                                        src="{{ $oldImageRef }}"
                                        alt="Current"
                                        class="relative w-full h-40 object-contain"
                                    />
                                </div>
                            </div>
                        @endif

                        <!-- Preview Image -->
                        @if ($image)
                            <div class="mb-4 relative rounded-lg overflow-hidden h-48 border border-zinc-200 dark:border-zinc-600">
                                <div class="absolute inset-0 bg-gradient-to-br from-zinc-50 to-zinc-100 dark:from-zinc-900 dark:to-zinc-800"></div>
                                <img 
                                    src="{{ $image->temporaryUrl() }}"
                                    alt="Preview"
                                    class="relative w-full h-48 object-contain"
                                />
                                <button
                                    type="button"
                                    wire:click="$set('image', null)"
                                    class="absolute top-2 right-2 bg-red-500 hover:bg-red-600 text-white rounded-full p-1 transition shadow-md"
                                >
                                    <flux:icon.x-circle class="w-5 h-5" />
                                </button>
                            </div>
                        @endif

                        <!-- Flux File Input with Custom Styling -->
                        <div 
                            x-data="{
                                uploading: false,
                                progress: 0
                            }"
                            x-on:livewire-upload-start="uploading = true"
                            x-on:livewire-upload-finish="uploading = false"
                            x-on:livewire-upload-cancel="uploading = false"
                            x-on:livewire-upload-error="uploading = false"
                            x-on:livewire-upload-progress="progress = $event.detail.progress"
                            wire:loading.class="opacity-50"
                        >
                        
                            <flux:input 
                                type="file"
                                wire:model="image"
                                accept="image/*"
                                class="hidden"
                                id="imageInput"
                            />
                    
                            
                            <!-- Custom Upload Area (Drag & Drop Style) -->
                            <label 
                                for="imageInput"
                                class="flex items-center justify-center w-full px-4 py-8 border-2 border-dashed border-zinc-300 dark:border-zinc-600 rounded-lg cursor-pointer hover:border-blue-500 hover:bg-blue-50 dark:hover:bg-blue-950/30 transition"
                            >
                                @if($image)
                                    <div class="text-center">
                                        <flux:icon.check-circle class="mx-auto h-8 w-8 text-green-500 mb-2" />
                                        <p class="text-sm font-medium text-green-600 dark:text-green-400">{{ __('Image selected') }}</p>
                                        <p class="text-xs text-zinc-500 dark:text-zinc-400">{{ $image->getClientOriginalName() }}</p>
                                    </div>
                                @else
                                    <div class="text-center">
                                        <span class="text-4xl mb-2 block">📤</span>
                                        <p class="text-sm text-zinc-600 dark:text-zinc-400">{{ __('Drag or click to upload image') }}</p>
                                    </div>
                                @endif
                            </label>

                            <!-- Progress Bar -->
                            <div x-show="uploading" class="mt-4">
                                <div class="flex items-center justify-between mb-2">
                                    <p class="text-sm text-zinc-600 dark:text-zinc-400">{{ __('Uploading...') }}</p>
                                    <p class="text-sm font-medium text-zinc-900 dark:text-white" x-text="`${progress}%`"></p>
                                </div>
                                <div class="w-full h-2 bg-zinc-200 dark:bg-zinc-700 rounded-full overflow-hidden">
                                    <div 
                                        class="h-full bg-blue-500 transition-all duration-300 rounded-full"
                                        :style="`width: ${progress}%`"
                                    ></div>
                                </div>
                            </div>
                        </div>

                        <flux:error name="image" />

                    </flux:field>
                </div>

                <!-- Action Buttons -->
                <div class="flex gap-3 pt-6 justify-between border-t border-zinc-200 dark:border-zinc-700">
                    <flux:modal.close>
                        <flux:button variant="ghost">
                            {{ __('Cancel') }}
                        </flux:button>
                    </flux:modal.close>
                    <div class="flex gap-2">
                        <flux:button
                            type="button"
                            wire:click="saveDraft"
                            variant="outline"
                            icon="document"
                            wire:loading.attr="disabled"
                        >
                            {{ __('Save as Draft') }}
                        </flux:button>
                        <flux:button
                            type="submit"
                            variant="primary"
                            wire:loading.attr="disabled"
                            class="flex items-center gap-2"
                        >
                            <span wire:loading.remove>💾 {{ __('Save & Process') }}</span>
                            <span wire:loading class="flex items-center gap-2">
                                <svg class="animate-spin h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                                {{ __('Processing...') }}
                            </span>
                        </flux:button>
                    </div>
                </div>
            </form>
</flux:modal>
