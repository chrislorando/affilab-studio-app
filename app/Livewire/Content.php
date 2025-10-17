<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\On;

class Content extends Component
{
    public $showFormModal = false;
    public $showViewModal = false;
    public $selectedContentId = null;

    protected $listeners = ['contentSaved' => 'handleContentSaved'];

    public function openFormModal()
    {
        $this->showFormModal = true;
    }

    public function handleContentSaved()
    {
        $this->showFormModal = false;
        $this->showViewModal = false;
        $this->selectedContentId = null;
        $this->dispatch('contentSaved');
    }

    public function closeModals()
    {
        $this->showFormModal = false;
        $this->showViewModal = false;
        $this->selectedContentId = null;
    }

    public function render()
    {
        return view('livewire.content');
    }
}
