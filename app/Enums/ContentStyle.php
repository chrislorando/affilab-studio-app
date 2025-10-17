<?php

namespace App\Enums;

enum ContentStyle: string
{
    case Professional = 'professional';
    case Absurd = 'absurd';

    public function label(): string
    {
        return match($this) {
            self::Professional => 'Professional',
            self::Absurd => 'Absurd',
        };
    }

    public function color(): string
    {
        return match($this) {
            self::Professional => 'blue',
            self::Absurd => 'purple',
        };
    }

    public function icon(): string
    {
        return match($this) {
            self::Professional => 'briefcase',
            self::Absurd => 'sparkles',
        };
    }
}
