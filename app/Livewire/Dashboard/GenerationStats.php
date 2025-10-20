<?php

namespace App\Livewire\Dashboard;

use Livewire\Component;
use App\Models\Content;
use App\Enums\ContentStatus;
use App\Enums\ContentStyle;
use App\Enums\AspectRatio;
use App\Enums\VideoDuration;

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

        // Success vs Failed - Using Enum
        $this->stats['status'] = [
            'success' => $contents->where('status', ContentStatus::SUCCESS->value)->count(),
            'failed' => $contents->where('status', ContentStatus::FAIL->value)->count(),
        ];

        // Styles - Dynamically generate from enum
        $this->stats['styles'] = [];
        foreach (ContentStyle::cases() as $style) {
            $this->stats['styles'][$style->value] = [
                'label' => $style->label(),
                'count' => $contents->where('style', $style->value)->count(),
                'color' => $style->color(),
            ];
        }

        // Aspect Ratios - Dynamically generate from enum
        $this->stats['ratios'] = [];
        foreach (AspectRatio::cases() as $ratio) {
            $this->stats['ratios'][$ratio->value] = [
                'label' => $ratio->label(),
                'count' => $contents->where('aspect_ratio', $ratio->value)->count(),
            ];
        }

        // Durations - Dynamically generate from enum
        $this->stats['durations'] = [];
        foreach (VideoDuration::cases() as $duration) {
            $this->stats['durations'][$duration->value] = [
                'label' => $duration->label(),
                'count' => $contents->where('duration', $duration->value)->count(),
                'icon' => $duration->icon(),
            ];
        }
    }

    public function render()
    {
        return view('livewire.dashboard.generation-stats');
    }
}
