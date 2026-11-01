<?php

namespace App\Enums;

enum CyclePhase: string
{
    case Menstruation = 'menstruation';
    case Follicular = 'follicular';
    case Ovulation = 'ovulation';
    case Luteal = 'luteal';

    public function label(): string
    {
        return match ($this) {
            self::Menstruation => 'Fase Menstruasi',
            self::Follicular => 'Fase Folikular',
            self::Ovulation => 'Fase Ovulasi',
            self::Luteal => 'Fase Luteal',
        };
    }

    public function description(): string
    {
        return match ($this) {
            self::Menstruation => 'Pelepasan dinding rahim & aliran haid (Hari 1–5)',
            self::Follicular => 'Pematangan sel telur & energi mulai meningkat (Hari 6–13)',
            self::Ovulation => 'Pelepasan sel telur, puncak kesuburan (Hari 14)',
            self::Luteal => 'Produksi progesteron & persiapan siklus berikutnya (Hari 15–28)',
        };
    }

    public function badgeClasses(): string
    {
        return match ($this) {
            self::Menstruation => 'bg-rose-100 text-rose-800 border-rose-300',
            self::Follicular => 'bg-amber-100 text-amber-800 border-amber-300',
            self::Ovulation => 'bg-emerald-100 text-emerald-800 border-emerald-300',
            self::Luteal => 'bg-purple-100 text-purple-800 border-purple-300',
        };
    }
}
