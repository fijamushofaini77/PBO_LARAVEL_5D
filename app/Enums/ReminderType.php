<?php

namespace App\Enums;

enum ReminderType: string
{
    case PeriodSoon = 'period_soon';
    case Fertile = 'fertile';
    case Pill = 'pill';
    case DailyLog = 'daily_log';

    public function label(): string
    {
        return match ($this) {
            self::PeriodSoon => 'Haid Segera Datang',
            self::Fertile => 'Masa Subur / Ovulasi',
            self::Pill => 'Minum Pil / Obat',
            self::DailyLog => 'Catat Log Harian',
        };
    }
}
