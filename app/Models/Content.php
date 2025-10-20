<?php

namespace App\Models;

use App\Enums\AspectRatio;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Enums\ContentStatus;
use App\Enums\ContentStyle;
use App\Enums\VideoDuration;
use App\Services\S3UploadService;

class Content extends Model
{
    use SoftDeletes;

    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'user_id',
        'idea',
        'title',
        'caption',
        'video_prompt',
        'image_ref',
        'aspect_ratio',
        'style',
        'status',
        'video_output',
        'duration',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
        'status' => ContentStatus::class,
        'style' => ContentStyle::class,
        'aspect_ratio' => AspectRatio::class,
        'duration' => VideoDuration::class,
    ];

    /**
     * Boot method to generate UUID on create
     */
    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            if (empty($model->id)) {
                $model->id = \Illuminate\Support\Str::uuid();
            }
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function getImageUrlAttribute()
    {
        if (!$this->image_ref) return null;
        return $this->image_ref;
    }

    public function getVideoUrlAttribute()
    {
        if (!$this->video_output) return null;
        return $this->video_output;
    }

    public function isProcessing(): bool
    {
        return in_array($this->status, [
            ContentStatus::PREPARATION,
            ContentStatus::READY,
            ContentStatus::WAITING,
            ContentStatus::QUEUING,
            ContentStatus::GENERATING,
        ]);
    }

    public function canQueue(): bool
    {
        return $this->status === ContentStatus::PREPARATION;
    }
}
