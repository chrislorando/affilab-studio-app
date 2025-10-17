<?php

namespace App\Enums;

enum AspectRatio: string
{
    case LANDSCAPE = 'landscape';
    case PORTRAIT = 'portrait';

    public function label(): string
    {
        return match ($this) {
            self::LANDSCAPE => 'Landscape',
            self::PORTRAIT => 'Portrait',
        };
    }

    public function icon(): string
    {
        return match ($this) {
            self::LANDSCAPE => '📺',
            self::PORTRAIT => '📱',
        };
    }

    /**
     * Get all cases as associative array for use in forms
     */
    public static function options(): array
    {
        return array_reduce(self::cases(), function ($carry, $case) {
            $carry[$case->value] = $case->label();
            return $carry;
        }, []);
    }
}
