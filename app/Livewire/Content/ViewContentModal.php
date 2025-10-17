<?php

namespace App\Livewire\Content;

use Livewire\Component;
use Livewire\Attributes\On;
use App\Models\Content;
use App\Enums\ContentStatus;

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

    public function render()
    {
        return view('livewire.content.view-content-modal', [
            'content' => $this->content,
        ]);
    }
}
