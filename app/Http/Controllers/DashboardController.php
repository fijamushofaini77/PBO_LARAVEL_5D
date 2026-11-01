<?php

namespace App\Http\Controllers;

use App\Enums\CyclePhase;
use App\Models\Cycle;
use App\Models\Medication;
use App\Models\Periode;
use App\Models\Reminder;
use App\Models\Symptom;
use App\Models\SymptomLog;
use App\Models\User;
use App\Services\CyclePredictionService;
use Carbon\Carbon;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function __construct(
        protected CyclePredictionService $predictionService
    ) {}

    /**
     * Tampilkan halaman utama Dashboard Admin Red Menstruasi (shadcn dashboard-01 pink).
     */
    public function index(): View
    {
        $user = User::first() ?? User::factory()->create([
            'name' => 'Fija Mushofaini',
            'email' => 'fijamushofaini77@gmail.com',
        ]);

        $today = Carbon::today();

        // 1. Prediksi & Metrik Siklus
        $avgCycleLength = $this->predictionService->averageCycleLength($user);
        $avgPeriodLength = $this->predictionService->averagePeriodLength($user);
        $nextPeriodDate = $this->predictionService->predictNextPeriodStart($user);
        $ovulationDate = $this->predictionService->predictOvulationDate($user);
        $fertileWindow = $this->predictionService->predictFertileWindow($user);
        $currentPhase = $this->predictionService->phaseOn($user, $today) ?? CyclePhase::Luteal;

        // Hari ke berapa dalam siklus saat ini
        $latestCycle = $user->cycles()->latest('start_date')->first();
        $dayOfCycle = $latestCycle ? $latestCycle->start_date->diffInDays($today) + 1 : 1;
        $daysUntilNextPeriod = $nextPeriodDate ? (int) $today->diffInDays($nextPeriodDate, false) : 0;

        // 2. Data Siklus & Log Haid Terkini
        $recentCycles = $user->cycles()
            ->with('periodLogs')
            ->latest('start_date')
            ->take(5)
            ->get();

        // 3. Gejala Populer & Log Terkini
        $recentSymptomLogs = SymptomLog::with('symptom')
            ->where('user_id', $user->id)
            ->latest('log_date')
            ->take(6)
            ->get();

        // 4. Obat & Pengingat Aktif
        $activeMedications = Medication::where('user_id', $user->id)
            ->where('is_active', true)
            ->get();

        $activeReminders = Reminder::where('user_id', $user->id)
            ->where('is_enabled', true)
            ->with('medication')
            ->take(4)
            ->get();

        // 5. Statistik Master Data
        $totalPeriodes = Periode::count();
        $totalSymptoms = Symptom::count();
        $totalCycles = Cycle::where('user_id', $user->id)->count();

        return view('dashboard', compact(
            'user',
            'today',
            'avgCycleLength',
            'avgPeriodLength',
            'nextPeriodDate',
            'ovulationDate',
            'fertileWindow',
            'currentPhase',
            'dayOfCycle',
            'daysUntilNextPeriod',
            'recentCycles',
            'recentSymptomLogs',
            'activeMedications',
            'activeReminders',
            'totalPeriodes',
            'totalSymptoms',
            'totalCycles'
        ));
    }
}
