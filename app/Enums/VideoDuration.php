<?php

namespace App\Enums;

enum VideoDuration: int
{
    case TEN_SECONDS = 10;
    case FIFTEEN_SECONDS = 15;

    public function label(): string
    {
        return match ($this) {
            self::TEN_SECONDS => '10 seconds',
            self::FIFTEEN_SECONDS => '15 seconds',
        };
    }

    public function icon(): string
    {
        return match ($this) {
            self::TEN_SECONDS => '⏱️',
            self::FIFTEEN_SECONDS => '⏲️',
        };
    }
}
