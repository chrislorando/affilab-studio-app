<?php

namespace App\Livewire\Dashboard;

use Livewire\Component;
use App\Models\Content;

class RecentIdeas extends Component
{
    public $ideas = [];

    public function mount()
    {
        $this->loadIdeas();
    }

    public function loadIdeas()
    {
        $this->ideas = Content::where('user_id', auth()->id())
            ->latest()
            ->take(4)
            ->get();
    }

    #[\Livewire\Attributes\On('contentSaved')]
    public function refresh()
    {
        $this->loadIdeas();
    }

    public function render()
    {
        return view('livewire.dashboard.recent-ideas');
    }
}
