<?php

namespace Database\Seeders;

use App\Enums\CycleGoal;
use App\Enums\FlowLevel;
use App\Enums\MedicationType;
use App\Enums\ReminderType;
use App\Models\Cycle;
use App\Models\DailyLog;
use App\Models\JournalEntry;
use App\Models\Medication;
use App\Models\MoodEntry;
use App\Models\PeriodLog;
use App\Models\Profile;
use App\Models\Reminder;
use App\Models\Symptom;
use App\Models\SymptomLog;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Seed Master Periode (Modul Perkuliahan)
        $this->call(PeriodeSeeder::class);

        // 2. Seed Master Gejala (SymptomSeeder)
        $this->call(SymptomSeeder::class);

        // 3. User Admin: Fija Mushofaini (2410010375)
        $user = User::updateOrCreate(
            ['email' => 'fijamushofaini77@gmail.com'],
            [
                'name' => 'Fija Mushofaini',
                'password' => Hash::make('password'),
            ]
        );

        // 4. Profil User
        Profile::updateOrCreate(
            ['user_id' => $user->id],
            [
                'birth_date' => '2004-05-14',
                'goal' => CycleGoal::TrackCycle,
                'avg_cycle_length' => 28,
                'avg_period_length' => 5,
                'avatar' => null,
                'timezone' => 'Asia/Makassar',
            ]
        );

        // 5. Data Siklus & Log Haid Realistis (4 Siklus)
        $cyclesData = [
            [
                'start' => Carbon::parse('2026-07-10'),
                'end' => Carbon::parse('2026-08-06'),
                'cycle_length' => 28,
                'period_length' => 5,
            ],
            [
                'start' => Carbon::parse('2026-08-07'),
                'end' => Carbon::parse('2026-09-04'),
                'cycle_length' => 29,
                'period_length' => 5,
            ],
            [
                'start' => Carbon::parse('2026-09-05'),
                'end' => Carbon::parse('2026-10-02'),
                'cycle_length' => 28,
                'period_length' => 5,
            ],
            [
                'start' => Carbon::parse('2026-10-03'),
                'end' => null, // Siklus aktif saat ini
                'cycle_length' => null,
                'period_length' => 5,
            ],
        ];

        foreach ($cyclesData as $c) {
            $cycle = Cycle::updateOrCreate(
                [
                    'user_id' => $user->id,
                    'start_date' => $c['start']->format('Y-m-d'),
                ],
                [
                    'end_date' => $c['end']?->format('Y-m-d'),
                    'cycle_length' => $c['cycle_length'],
                    'period_length' => $c['period_length'],
                ]
            );

            // Log harian haid selama 5 hari pertama siklus
            $flows = [FlowLevel::Medium, FlowLevel::Heavy, FlowLevel::Heavy, FlowLevel::Medium, FlowLevel::Light];
            foreach ($flows as $dayOffset => $flow) {
                $logDate = (clone $c['start'])->addDays($dayOffset)->format('Y-m-d');
                PeriodLog::updateOrCreate(
                    [
                        'user_id' => $user->id,
                        'log_date' => $logDate,
                    ],
                    [
                        'cycle_id' => $cycle->id,
                        'flow_level' => $flow,
                    ]
                );
            }
        }

        // 6. Log Gejala Realistis
        $symptoms = Symptom::all();
        if ($symptoms->isNotEmpty()) {
            $sampleDates = [
                Carbon::parse('2026-10-03')->format('Y-m-d'),
                Carbon::parse('2026-10-04')->format('Y-m-d'),
                Carbon::parse('2026-10-17')->format('Y-m-d'),
                Carbon::parse('2026-10-30')->format('Y-m-d'),
            ];

            foreach ($sampleDates as $idx => $sDate) {
                $symptom = $symptoms[$idx % $symptoms->count()];
                SymptomLog::updateOrCreate(
                    [
                        'user_id' => $user->id,
                        'symptom_id' => $symptom->id,
                        'log_date' => $sDate,
                    ],
                    [
                        'severity' => ($idx % 3) + 1,
                    ]
                );
            }
        }

        // 7. Mood & Journal Entries
        $mood1 = MoodEntry::updateOrCreate(
            ['user_id' => $user->id, 'entry_date' => '2026-10-03'],
            ['mood_level' => 2, 'note' => 'Hari pertama haid, kram perut lumayan terasa']
        );
        JournalEntry::updateOrCreate(
            ['user_id' => $user->id, 'entry_date' => '2026-10-03'],
            [
                'mood_entry_id' => $mood1->id,
                'title' => 'Awal Siklus Baru',
                'content' => 'Istirahat lebih awal, minum teh chamomile hangat untuk meredakan nyeri kram.',
            ]
        );

        $mood2 = MoodEntry::updateOrCreate(
            ['user_id' => $user->id, 'entry_date' => '2026-10-18'],
            ['mood_level' => 5, 'note' => 'Energi tinggi di fase ovulasi!']
        );
        JournalEntry::updateOrCreate(
            ['user_id' => $user->id, 'entry_date' => '2026-10-18'],
            [
                'mood_entry_id' => $mood2->id,
                'title' => 'Produktif & Berenergi',
                'content' => 'Menyelesaikan modul praktikum PBO 5 dengan lancar. Suasana hati sangat baik.',
            ]
        );

        // 8. Log Harian (Flo Style Daily Logs)
        DailyLog::updateOrCreate(
            ['user_id' => $user->id, 'log_date' => '2026-10-30'],
            [
                'basal_temp' => 36.6,
                'discharge' => 'creamy',
                'sex_activity' => 'none',
                'ovulation_test' => 'negative',
                'pregnancy_test' => null,
                'weight' => 52.5,
                'water_ml' => 2000,
                'sleep_hours' => 7.5,
            ]
        );

        DailyLog::updateOrCreate(
            ['user_id' => $user->id, 'log_date' => '2026-10-31'],
            [
                'basal_temp' => 36.7,
                'discharge' => 'dry',
                'sex_activity' => 'none',
                'ovulation_test' => 'negative',
                'pregnancy_test' => null,
                'weight' => 52.4,
                'water_ml' => 2200,
                'sleep_hours' => 8.0,
            ]
        );

        // 9. Obat & Suplemen
        $med1 = Medication::updateOrCreate(
            ['user_id' => $user->id, 'name' => 'Sangobion (Zat Besi)'],
            [
                'type' => MedicationType::Supplement,
                'dosage' => '1 kapsul / hari',
                'is_active' => true,
            ]
        );

        $med2 = Medication::updateOrCreate(
            ['user_id' => $user->id, 'name' => 'Ibuprofen 400mg'],
            [
                'type' => MedicationType::Painkiller,
                'dosage' => 'Saat kram haid',
                'is_active' => true,
            ]
        );

        // 10. Pengingat
        Reminder::updateOrCreate(
            ['user_id' => $user->id, 'type' => ReminderType::PeriodSoon],
            [
                'medication_id' => null,
                'days_before' => 2,
                'remind_at' => '08:00:00',
                'is_enabled' => true,
            ]
        );

        Reminder::updateOrCreate(
            ['user_id' => $user->id, 'type' => ReminderType::Pill, 'medication_id' => $med1->id],
            [
                'days_before' => null,
                'remind_at' => '20:00:00',
                'is_enabled' => true,
            ]
        );
    }
}
