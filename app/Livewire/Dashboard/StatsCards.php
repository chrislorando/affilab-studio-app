<?php

namespace App\Livewire\Dashboard;

use Livewire\Component;
use App\Models\Content;
use App\Enums\ContentStatus;

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
                ->where('status', ContentStatus::SUCCESS->value)
                ->count(),
            'failed' => Content::where('user_id', $userId)
                ->where('status', ContentStatus::FAIL->value)
                ->count(),
            'pending' => Content::where('user_id', $userId)
                ->whereIn('status', [
                    ContentStatus::PREPARATION->value,
                    ContentStatus::GENERATING->value,
                    ContentStatus::QUEUING->value,
                    ContentStatus::WAITING->value,
                ])
                ->count(),
        ];
    }

    public function render()
    {
        return view('livewire.dashboard.stats-cards');
    }
}
