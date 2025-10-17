<?php

namespace App\Enums;

enum ContentStatus: string
{
    case DRAFT = 'draft';               // Draft (not submitted)
    case PREPARATION = 'preparation';   // Preparation 
    case READY = 'ready';               // Ready for processing
    case WAITING = 'waiting';           // Waiting for generation
    case QUEUING = 'queuing';           // In queue
    case GENERATING = 'generating';     // Generating
    case SUCCESS = 'success';           // Generation successful
    case FAIL = 'fail';                 // Generation failed

    public function label(): string
    {
        return match ($this) {
            self::DRAFT => 'Draft',
            self::PREPARATION => 'Preparation',
            self::READY => 'Ready for processing',
            self::WAITING => 'Waiting for generation',
            self::QUEUING => 'In queue',
            self::GENERATING => 'Generating',
            self::SUCCESS => 'Generation successful',
            self::FAIL => 'Generation failed',
        };
    }

    public function color(): string
    {
        return match ($this) {
            self::DRAFT => 'zinc',
            self::PREPARATION => 'amber',
            self::READY => 'yellow',
            self::WAITING => 'orange',
            self::QUEUING => 'orange',
            self::GENERATING => 'violet',
            self::SUCCESS => 'green',
            self::FAIL => 'red',
        };
    }
}
