<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class S3UploadService
{
    public function uploadImage(UploadedFile $file, $userId): array
    {
        $filename = Str::uuid() . '.' . $file->getClientOriginalExtension();
        $path = "{$userId}/" . $filename;
        
        // Use Laravel's built-in store method which handles temporary files correctly
        $file->storeAs($userId, $filename, 's3');
        
        return [
            'path' => $path,
            'url' => $this->getPublicUrl($path),
        ];
    }

    public function getPublicUrl($path): string
    {
        // Build S3 URL from config
        $endpoint = config('filesystems.disks.s3.endpoint') ?? config('filesystems.disks.s3.url');
        $bucket = config('filesystems.disks.s3.bucket');
        return "{$endpoint}/{$bucket}/{$path}";
    }

    public function deleteImage($path): bool
    {
        return Storage::disk('s3')->delete($path);
    }
}
