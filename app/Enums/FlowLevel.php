<?php

namespace App\Enums;

enum FlowLevel: string
{
    case Spotting = 'spotting';
    case Light = 'light';
    case Medium = 'medium';
    case Heavy = 'heavy';

    public function label(): string
    {
        return match ($this) {
            self::Spotting => 'Flek / Spotting',
            self::Light => 'Aliran Ringan',
            self::Medium => 'Aliran Sedang',
            self::Heavy => 'Aliran Deras',
        };
    }

    public function badgeClasses(): string
    {
        return match ($this) {
            self::Spotting => 'bg-amber-50 text-amber-700 border-amber-200',
            self::Light => 'bg-rose-50 text-rose-600 border-rose-200',
            self::Medium => 'bg-rose-100 text-rose-700 border-rose-300 font-semibold',
            self::Heavy => 'bg-rose-600 text-white border-rose-600 font-bold',
        };
    }
}
