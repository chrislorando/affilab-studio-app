<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\Content;
use App\Services\S3UploadService;
use App\Services\WebhookService;
use App\Enums\ContentStatus;

class TriggerN8nWebhook implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $contentId;
    
    public $tries = 5;
    public $backoff = [10, 30, 60, 120, 300]; // seconds

    public function __construct($contentId)
    {
        $this->contentId = $contentId;
    }

    public function handle()
    {
        $content = Content::find($this->contentId);
        
        if (!$content) {
            \Log::error('Content not found: ' . $this->contentId);
            // Release job back to queue untuk retry
            $this->release(10);
            return;
        }

        // Jangan jalankan jika sedang processing
        if (!$content->isProcessing()) {
            \Log::error('Content: ' . $content->isProcessing());
            $content->update(['status' => ContentStatus::DRAFT]);
            $this->fail();
            return;
        }

        // Update status ke preparation
        // $content->update(['status' => ContentStatus::PREPARATION]);

        try {
            // Trigger N8N Webhook
            app(WebhookService::class)->triggerN8nWorkflow($content->id, [
                'idea' => $content->idea,
                'aspect_ratio' => $content->aspect_ratio->value,
                'style' => $content->style->value,
                'duration' => $content->duration->value,
                'image_ref' => $content->image_ref,
                'user_id' => $content->user_id,
                'status' => $content->status->value,
            ]);

            // Update status ke generating
            // $content->update(['status' => ContentStatus::GENERATING]);

        } catch (\Exception $e) {
            \Log::error('TriggerN8nWebhook Error: ' . $e->getMessage());
            $content->update(['status' => ContentStatus::DRAFT]);
            $this->fail($e);
        }
    }
}
