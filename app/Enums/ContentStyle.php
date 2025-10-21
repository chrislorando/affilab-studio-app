<?php

namespace App\Enums;

enum ContentStyle: string
{
    case Professional = 'professional';
    case Absurd = 'absurd';
    case Cinematic = 'cinematic';
    case Testimony = 'testimony';

    public function label(): string
    {
        return match($this) {
            self::Professional => 'Professional',
            self::Absurd => 'Absurd',
            self::Cinematic => 'Cinematic',
            self::Testimony => 'Testimony',
        };
    }

    public function color(): string
    {
        return match($this) {
            self::Professional => 'blue',
            self::Absurd => 'purple',
            self::Cinematic => 'gray',
            self::Testimony => 'green',
        };
    }

    public function icon(): string
    {
        return match($this) {
            self::Professional => 'briefcase',
            self::Absurd => 'sparkles',
            self::Cinematic => 'sparkles',
            self::Testimony => 'book-open',
        };
    }
}
