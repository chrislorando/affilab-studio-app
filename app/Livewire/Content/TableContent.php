<?php

namespace App\Livewire\Content;

use App\Enums\ContentStatus;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Content as ContentModel;

class TableContent extends Component
{
    use WithPagination;

    public $search = '';
    public $showDeleteConfirm = false;
    public $deleteContentId = null;

    protected $listeners = ['contentSaved' => 'refreshTable'];

    public function refreshTable()
    {
        $this->resetPage();
    }

    public function confirmDelete($contentId)
    {
        $this->deleteContentId = $contentId;
        $this->showDeleteConfirm = true;
    }

    public function cancelDelete()
    {
        $this->showDeleteConfirm = false;
        $this->deleteContentId = null;
    }

    public function deleteContent($contentId)
    {
        $content = ContentModel::findOrFail($contentId);
        
        if ($content->user_id !== auth()->user()->id) {
            abort(403);
        }

        // if ($content->image_ref) {
        //     app(\App\Services\S3UploadService::class)->deleteImage($content->image_ref);
        // }

        $content->delete();
        session()->flash('success', 'Content deleted successfully!');
        $this->cancelDelete();
        $this->refreshTable();
    }

    public function testWebhook()
    {
        \Log::info('testWebhook method called');
        
        try {
            \Log::info('Creating webhook service');
            $webhookService = app(\App\Services\WebhookService::class);

            ContentModel::where('id', '44968062-3aba-4335-99c8-16c5063ecaa5')->where('status', ContentStatus::DRAFT)->update(['status' => ContentStatus::PREPARATION]);
            
            \Log::info('Calling triggerN8nWorkflow');
            $webhookService->triggerN8nWorkflow('44968062-3aba-4335-99c8-16c5063ecaa5', [
                'idea' => 'Iklan jaket parka | Untuk motoran biar ga masuk angin | Tahan badai | Cowok',
                'aspect_ratio' => 'portrait',
                'style' => 'professional',
                'image_ref' => 'https://s3.demolite.my.id/gen-reel/daf17c66-0c20-47c3-a76f-841f3ee2fa83/1373f6ea-b619-4b4e-9286-572facb72e80.jpg',
                'user_id' => auth()->id(),
                'status' => ContentStatus::PREPARATION
            ]);
            
            \Log::info('Webhook test sent successfully');
            session()->flash('success', 'Webhook test sent successfully!');
            
        } catch (\Exception $e) {
            \Log::error('Webhook Test Error: ' . $e->getMessage());
            \Log::error('Stack trace: ' . $e->getTraceAsString());
            session()->flash('error', 'Webhook test failed: ' . $e->getMessage());
        }
    }

    #[On('editDraft')]
    public function editDraft($id)
    {
        $this->dispatch('openFormForEdit', id: $id);
    }

    public function render()
    {
        $contents = ContentModel::where('user_id', auth()->user()->id)
            ->when($this->search, function ($query) {
                $query->where('idea', 'like', '%' . $this->search . '%');
            })
            ->orderByDesc('created_at')
            ->paginate(10);

        return view('livewire.content.table-content', [
            'contents' => $contents,
        ]);
    }
}
