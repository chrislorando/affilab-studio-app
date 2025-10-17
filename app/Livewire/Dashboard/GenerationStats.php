<?php

namespace App\Livewire\Dashboard;

use Livewire\Component;
use App\Models\Content;
use App\Enums\ContentStatus;

class GenerationStats extends Component
{
    public $stats = [];

    public function mount()
    {
        $this->loadStats();
    }

    public function loadStats()
    {
        $userId = auth()->id();
        $contents = Content::where('user_id', $userId)->get();

        // Success vs Failed
        $this->stats['status'] = [
            'success' => $contents->where('status', ContentStatus::SUCCESS)->count(),
            'failed' => $contents->where('status', ContentStatus::FAIL)->count(),
        ];

        // Styles
        $this->stats['styles'] = [
            'professional' => $contents->where('style', 'professional')->count(),
            'absurd' => $contents->where('style', 'absurd')->count(),
        ];

        // Aspect Ratios
        $this->stats['ratios'] = [
            'landscape' => $contents->where('aspect_ratio', 'landscape')->count(),
            'portrait' => $contents->where('aspect_ratio', 'portrait')->count(),
        ];
    }

    public function render()
    {
        return view('livewire.dashboard.generation-stats');
    }
}
