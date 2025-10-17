<?php

namespace App\Livewire\Dashboard;

use Livewire\Component;
use App\Models\Content;

class StatsCards extends Component
{
    public $stats = [];

    public function mount()
    {
        $this->loadStats();
    }

    public function loadStats()
    {
        $userId = auth()->id();
        
        $this->stats = [
            'total_ideas' => Content::where('user_id', $userId)->count(),
            'generated' => Content::where('user_id', $userId)
                ->where('status', 'success')
                ->count(),
            'failed' => Content::where('user_id', $userId)
                ->where('status', 'fail')
                ->count(),
            'pending' => Content::where('user_id', $userId)
                ->whereIn('status', ['preparation', 'generating'])
                ->count(),
        ];
    }

    public function render()
    {
        return view('livewire.dashboard.stats-cards');
    }
}
