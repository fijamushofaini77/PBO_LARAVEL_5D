<?php

namespace App\Http\Controllers;

use App\Enums\MedicationType;
use App\Models\Medication;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules\Enum;
use Illuminate\View\View;

class MedicationController extends Controller
{
    public function index(): View
    {
        $user = User::first() ?? User::factory()->create();
        $medications = Medication::where('user_id', $user->id)
            ->withCount('medicationLogs')
            ->get();

        return view('medications.index', compact('medications'));
    }

    public function create(): View
    {
        return view('medications.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $user = User::first() ?? User::factory()->create();

        $data = $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'type' => ['required', new Enum(MedicationType::class)],
            'dosage' => ['required', 'string', 'max:50'],
        ], [
            'name.required' => 'Nama obat wajib diisi.',
            'type.required' => 'Jenis obat wajib dipilih.',
            'dosage.required' => 'Dosis pemakaian wajib diisi.',
        ]);

        $data['user_id'] = $user->id;
        $data['is_active'] = $request->boolean('is_active', true);

        Medication::create($data);

        return redirect()->route('medications.index')
            ->with('success', 'Obat atau suplemen berhasil ditambahkan.');
    }

    public function edit(Medication $medication): View
    {
        return view('medications.edit', compact('medication'));
    }

    public function update(Request $request, Medication $medication): RedirectResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'type' => ['required', new Enum(MedicationType::class)],
            'dosage' => ['required', 'string', 'max:50'],
        ]);

        $data['is_active'] = $request->boolean('is_active');
        $medication->update($data);

        return redirect()->route('medications.index')
            ->with('success', 'Data obat berhasil diperbarui.');
    }

    public function destroy(Medication $medication): RedirectResponse
    {
        $medication->delete();

        return redirect()->route('medications.index')
            ->with('success', 'Data obat berhasil dihapus.');
    }
}
