<?php

namespace App\Enums;

enum MedicationType: string
{
    case Pill = 'pill';
    case Painkiller = 'painkiller';
    case Supplement = 'supplement';

    public function label(): string
    {
        return match ($this) {
            self::Pill => 'Pil KB / Kontrasepsi',
            self::Painkiller => 'Pereda Nyeri Haid',
            self::Supplement => 'Vitamin / Zat Besi',
        };
    }
}
