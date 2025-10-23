<?php

namespace App\Livewire\Content;

use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\Attributes\On;
use App\Models\Content;
use App\Services\S3UploadService;
use App\Jobs\TriggerN8nWebhook;
use App\Enums\ContentStatus;
use App\Enums\AspectRatio;
use App\Enums\ContentStyle;
use App\Enums\VideoDuration;
use Illuminate\Validation\Rule;

class FormContentModal extends Component
{
    use WithFileUploads;

    public $showModal = false;
    public $contentId = null;
    public $idea = '';
    public $videoPrompt = '';
    public $image;
    public $aspectRatio = 'landscape';
    public $style = 'professional';
    public $duration = 15;
    public $isLoading = false;
    public $isEditing = false;
    public $oldImageRef = null;

    public function rules()
    {
        return [
            'idea' => 'required|string|max:255',
            // 'videoPrompt' => 'required|string|max:500',
            'aspectRatio' => ['required', Rule::enum(AspectRatio::class)],
            'style' => ['required', Rule::enum(ContentStyle::class)],
            'duration' => ['required', Rule::enum(VideoDuration::class)],
            'image' => 'required|image|max:5120',
        ];
    }

    public function openForEdit($contentId)
    {
        $content = Content::where('id', $contentId)
            ->where('user_id', auth()->user()->id)
            ->where('status', ContentStatus::DRAFT)
            ->firstOrFail();

        $this->contentId = $contentId;
        $this->idea = $content->idea;
        // $this->videoPrompt = $content->video_prompt;
        $this->aspectRatio = $content->aspect_ratio;
        $this->style = $content->style->value;
        $this->duration = $content->duration ?? 15;
        $this->oldImageRef = $content->image_ref;
        $this->isEditing = true;
        $this->showModal = true;
    }

    #[On('openFormForEdit')]
    public function handleEditDraft($id)
    {
        $this->openForEdit($id);
    }

    public function cancelModal()
    {
        $this->reset([
            'idea', 
            // 'videoPrompt', 
            'image', 
            'aspectRatio', 
            'style',
            'duration',
            'contentId', 
            'isEditing', 
            'oldImageRef'
        ]);
        $this->duration = 15;
        $this->showModal = false;
    }

    public function saveIdea()
    {
        $user = auth()->user();
        if($user->quota <= 0) {
            session()->flash('error', 'You have reached your quota limit. Please upgrade your plan to create more content.');
            return;
        }

        if ($this->isEditing) {
            $this->validate([
                'idea' => 'required|string|max:255',
                // 'videoPrompt' => 'required|string|max:500',
                'aspectRatio' => ['required', Rule::enum(AspectRatio::class)],
                'style' => ['required', Rule::enum(ContentStyle::class)],
                'duration' => ['required', Rule::enum(VideoDuration::class)],
            ]);
            // Jika old image tidak ada dan image baru tidak ada, error
            if (!$this->oldImageRef && !$this->image) {
                session()->flash('error', 'Image is required!');
                $this->isLoading = false;
                return;
            }
        } else {
            $this->validate($this->rules());
        }

        $this->isLoading = true;

        try {
            if ($this->isEditing) {
                // Update draft to PREPARATION status
                $content = Content::where('id', $this->contentId)->firstOrFail();
                
                // Upload new image if changed
                if ($this->image) {
                    $s3Service = app(S3UploadService::class);
                    // Delete old image
                    if ($this->oldImageRef) {
                        $s3Service->deleteImage($this->oldImageRef);
                    }
                    $upload = $s3Service->uploadImage($this->image, auth()->id());
                    $content->image_ref = $upload['url'];
                }

                $content->update([
                    'idea' => $this->idea,
                    // 'video_prompt' => $this->videoPrompt,
                    'aspect_ratio' => $this->aspectRatio,
                    'style' => $this->style,
                    'duration' => $this->duration,
                    'status' => ContentStatus::PREPARATION,
                ]);

                // Dispatch Job ke Queue
                TriggerN8nWebhook::dispatch($content->id);

                // Decrement user quota
                $user->decrement('quota');

                session()->flash('success', 'Draft updated and queued for processing!');
            } else {
                // Create new idea with PREPARATION status
                // 1. Upload image to S3
                $s3Service = app(S3UploadService::class);
                $upload = $s3Service->uploadImage($this->image, auth()->id());

                // 2. Save to Database with PREPARATION status
                $content = Content::create([
                    'user_id' => auth()->user()->id,
                    'idea' => $this->idea,
                    // 'video_prompt' => $this->videoPrompt,
                    'aspect_ratio' => $this->aspectRatio,
                    'style' => $this->style,
                    'duration' => $this->duration,
                    'image_ref' => $upload['url'],
                    'status' => ContentStatus::PREPARATION,
                ]);

                // 4. Dispatch Job ke Queue
                TriggerN8nWebhook::dispatch($content->id);

                // Decrement user quota
                $user->decrement('quota');

                session()->flash('success', 'Idea saved and queued for processing!');
            }

            // Emit event to parent
            $this->dispatch('contentSaved');
            $this->cancelModal();

        } catch (\Exception $e) {
            \Log::error('SaveIdea Error: ' . $e->getMessage());
            session()->flash('error', 'Failed to save idea: ' . $e->getMessage());
        } finally {
            $this->isLoading = false;
        }
    }

    public function saveDraft()
    {
        // Validasi idea dan aspect ratio saja
        $this->validate([
            'idea' => 'required|string|max:255',
            // 'videoPrompt' => 'required|string|max:500',
            'aspectRatio' => ['required', Rule::enum(AspectRatio::class)],
            'style' => ['required', Rule::enum(ContentStyle::class)],
            'duration' => ['required', Rule::enum(VideoDuration::class)],
        ]);

        // Jika edit draft dan image kosong (old image didelete), require image baru
        if ($this->isEditing && !$this->oldImageRef && !$this->image) {
            session()->flash('error', 'Image is required!');
            return;
        }

        // Jika create new draft, image required
        if (!$this->isEditing && !$this->image) {
            session()->flash('error', 'Image is required!');
            return;
        }

        $this->isLoading = true;

        try {
            if ($this->isEditing) {
                // Update existing draft
                $content = Content::where('id', $this->contentId)->firstOrFail();
                
                // Upload new image if changed
                if ($this->image) {
                    $s3Service = app(S3UploadService::class);
                    // Delete old image
                    if ($this->oldImageRef) {
                        $s3Service->deleteImage($this->oldImageRef);
                    }
                    $upload = $s3Service->uploadImage($this->image, auth()->id());
                    $content->image_ref = $upload['url'];
                }

                $content->update([
                    'idea' => $this->idea,
                    // 'video_prompt' => $this->videoPrompt,
                    'aspect_ratio' => $this->aspectRatio,
                    'style' => $this->style,
                    'duration' => $this->duration,
                ]);

                session()->flash('success', 'Draft updated successfully!');
            } else {
                // Create new draft
                // 1. Upload image to S3
                $s3Service = app(S3UploadService::class);
                $upload = $s3Service->uploadImage($this->image, auth()->id());

                // 2. Save to Database with DRAFT status (no queue)
                $content = Content::create([
                    'user_id' => auth()->user()->id,
                    'idea' => $this->idea,
                    // 'video_prompt' => $this->videoPrompt,
                    'aspect_ratio' => $this->aspectRatio,
                    'style' => $this->style,
                    'duration' => $this->duration,
                    'image_ref' => $upload['url'],
                    'status' => ContentStatus::DRAFT,
                ]);

                session()->flash('success', 'Idea saved as draft!');
            }

            // Emit event to parent
            $this->dispatch('contentSaved');
            $this->cancelModal();
            
        } catch (\Exception $e) {
            \Log::error('SaveDraft Error: ' . $e->getMessage());
            session()->flash('error', 'Failed to save draft: ' . $e->getMessage());
        } finally {
            $this->isLoading = false;
        }
    }

    /**
     * Get all aspect ratios from enum
     */
    public function getAspectRatios()
    {
        return AspectRatio::cases();
    }

    /**
     * Get all styles from enum
     */
    public function getStyles()
    {
        return ContentStyle::cases();
    }

    /**
     * Get available durations from enum
     */
    public function getDurations()
    {
        return VideoDuration::cases();
    }

    public function render()
    {
        return view('livewire.content.form-content-modal', [
            'aspectRatios' => $this->getAspectRatios(),
            'styles' => $this->getStyles(),
            'durations' => $this->getDurations(),
        ]);
    }
}
