<?php

namespace App\Services;

use App\Enums\ContentStatus;
use GuzzleHttp\Client;

class WebhookService
{
    private $client;

    public function __construct()
    {
        $this->client = new Client();
    }

    public function triggerN8nWorkflow($contentId, $data): void
    {
        try {
            $this->client->post(config('services.n8n.webhook_url'), [
                'json' => [
                    'content_id' => $contentId,
                    'idea' => $data['idea'],
                    'aspect_ratio' => $data['aspect_ratio'],
                    'style' => $data['style'],
                    'image_ref' => $data['image_ref'],
                    'user_id' => $data['user_id'],
                    'timestamp' => now()->toIso8601String(),
                    'status' => $data['status'],
                ],
                'timeout' => 10,
                'verify' => false,
            ]);
            \Log::info('N8N Webhook triggered successfully for content: ' . $contentId);
        } catch (\Exception $e) {
            \Log::error('N8N Webhook Error: ' . $e->getMessage());
            throw $e;
        }
    }
}
