<?php

namespace App\Livewire\Content;

use Livewire\Component;
use Livewire\Attributes\On;
use App\Models\Content;
use App\Enums\ContentStatus;
use App\Services\S3UploadService;

class ViewContentModal extends Component
{
    public $showModal = false;
    public $contentId = null;
    public $content = null;
    public $showDeleteConfirm = false;
    public $contentUpdatedAt = null;

    #[On('viewContent')]
    public function openModal($id)
    {
        $this->contentId = $id;
        $this->loadContent();
        $this->showModal = true;
    }

    #[On('editDraft')]
    public function editDraft($id)
    {
        $this->closeModal();
        $this->dispatch('openFormForEdit', id: $id);
    }

    public function loadContent()
    {
        if (!$this->contentId) return;

        $this->content = Content::findOrFail($this->contentId);
        
        if ($this->content->user_id !== auth()->id()) {
            abort(403);
        }
        
        // Track updates to trigger reactivity
        $this->contentUpdatedAt = $this->content->updated_at?->timestamp;
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->showDeleteConfirm = false;
        $this->reset(['contentId', 'content']);
    }

    public function confirmDelete()
    {
        $this->showDeleteConfirm = true;
    }

    public function cancelDelete()
    {
        $this->showDeleteConfirm = false;
    }

    public function deleteContent()
    {
        if (!$this->content) return;

        // if ($this->content->image_ref) {
        //     app(\App\Services\S3UploadService::class)->deleteImage($this->content->image_ref);
        // }

        $this->content->delete();
        session()->flash('success', 'Content deleted successfully!');
        $this->dispatch('contentSaved');
        $this->closeModal();
    }

    public function duplicateContent()
    {
        if (!$this->content) return;

        try {
            // Create a new content with same data as original
            $newContent = $this->content->replicate();
            $newContent->status = ContentStatus::DRAFT;
            $newContent->video_output = null; // Don't copy video output
            
            // Copy image to new URL if image exists
            if ($this->content->image_ref) {
                try {
                    // Generate new image URL by copying from original
                    $s3Service = app(S3UploadService::class);
                    
                    // Download original image and re-upload as new
                    $imageContent = file_get_contents($this->content->image_url);
                    if ($imageContent) {
                        $tempFile = tempnam(sys_get_temp_dir(), 'img_');
                        file_put_contents($tempFile, $imageContent);
                        
                        // Create UploadedFile from temp file
                        $uploadedFile = new \Illuminate\Http\UploadedFile(
                            $tempFile,
                            basename($this->content->image_ref),
                            mime_content_type($tempFile),
                            null,
                            true
                        );
                        
                        $upload = $s3Service->uploadImage($uploadedFile, auth()->id());
                        $newContent->image_ref = $upload['url'];
                        
                        // Cleanup temp file
                        @unlink($tempFile);
                    }
                } catch (\Exception $e) {
                    \Log::warning('Failed to copy image during duplicate: ' . $e->getMessage());
                    // Continue without copying image, just reference the same one
                }
            }
            
            $newContent->save();

            session()->flash('success', 'Idea duplicated successfully!');
            $this->dispatch('contentSaved');
            $this->closeModal();
        } catch (\Exception $e) {
            \Log::error('Duplicate Content Error: ' . $e->getMessage());
            session()->flash('error', 'Failed to duplicate idea: ' . $e->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.content.view-content-modal', [
            'content' => $this->content,
        ]);
    }
}
