<?php

namespace App\Enums;

enum ContentStyle: string
{
    case Professional = 'professional';
    case Absurd = 'absurd';
    case Cinematic = 'cinematic';
    case Documentary = 'documentary';
    case Unboxing = 'unboxing';

    case TipsAndTricks = 'tips_and_tricks';

    public function label(): string
    {
        return match($this) {
            self::Professional => 'Professional',
            self::Absurd => 'Absurd',
            self::Cinematic => 'Cinematic',
            self::Documentary => 'Documentary',
            self::Unboxing => 'Unboxing',
            self::TipsAndTricks => 'Tips and Tricks',
        };
    }

    public function color(): string
    {
        return match($this) {
            self::Professional => 'blue',
            self::Absurd => 'purple',
            self::Cinematic => 'gray',
            self::Documentary => 'green',
            self::Unboxing => 'orange',
            self::TipsAndTricks => 'teal',
        };
    }

    public function icon(): string
    {
        return match($this) {
            self::Professional => 'briefcase',
            self::Absurd => 'sparkles',
            self::Cinematic => 'sparkles',
            self::Documentary => 'book-open',
            self::Unboxing => 'gift',
            self::TipsAndTricks => 'lightbulb',
        };
    }
}
