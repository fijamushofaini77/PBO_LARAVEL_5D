<?php

namespace App\Http\Controllers;

use App\Enums\FlowLevel;
use App\Models\Cycle;
use App\Models\PeriodLog;
use App\Models\User;
use App\Services\CyclePredictionService;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CycleController extends Controller
{
    public function __construct(
        protected CyclePredictionService $predictionService
    ) {}

    public function index(): View
    {
        $user = User::first() ?? User::factory()->create();
        $cycles = Cycle::where('user_id', $user->id)
            ->with('periodLogs')
            ->orderBy('start_date', 'desc')
            ->get();

        return view('cycles.index', compact('cycles'));
    }

    public function create(): View
    {
        return view('cycles.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $user = User::first() ?? User::factory()->create();

        $request->validate([
            'start_date' => ['required', 'date'],
            'period_length' => ['nullable', 'integer', 'min:1', 'max:15'],
        ], [
            'start_date.required' => 'Tanggal mulai siklus wajib diisi.',
            'start_date.date' => 'Format tanggal tidak valid.',
        ]);

        $startDate = Carbon::parse($request->input('start_date'));
        $cycle = $this->predictionService->recordPeriodStart($user, $startDate);

        $periodLength = $request->input('period_length', 5);
        $cycle->update(['period_length' => $periodLength]);

        // Catat period log awal secara otomatis
        for ($i = 0; $i < $periodLength; $i++) {
            $logDate = (clone $startDate)->addDays($i)->format('Y-m-d');
            PeriodLog::updateOrCreate(
                ['user_id' => $user->id, 'log_date' => $logDate],
                ['cycle_id' => $cycle->id, 'flow_level' => $i === 0 || $i === 1 ? FlowLevel::Heavy : FlowLevel::Medium]
            );
        }

        return redirect()->route('cycles.index')
            ->with('success', 'Siklus baru berhasil dicatat.');
    }

    public function edit(Cycle $cycle): View
    {
        return view('cycles.edit', compact('cycle'));
    }

    public function update(Request $request, Cycle $cycle): RedirectResponse
    {
        $data = $request->validate([
            'start_date' => ['required', 'date'],
            'end_date' => ['nullable', 'date', 'after_or_equal:start_date'],
            'cycle_length' => ['nullable', 'integer', 'min:15', 'max:60'],
            'period_length' => ['nullable', 'integer', 'min:1', 'max:15'],
        ]);

        $cycle->update($data);

        return redirect()->route('cycles.index')
            ->with('success', 'Data siklus berhasil diperbarui.');
    }

    public function destroy(Cycle $cycle): RedirectResponse
    {
        $cycle->delete();

        return redirect()->route('cycles.index')
            ->with('success', 'Data siklus berhasil dihapus.');
    }
}
