<?php

namespace App\Http\Controllers;

use App\Enums\ReminderType;
use App\Models\Medication;
use App\Models\Reminder;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules\Enum;
use Illuminate\View\View;

class ReminderController extends Controller
{
    public function index(): View
    {
        $user = User::first() ?? User::factory()->create();
        $reminders = Reminder::where('user_id', $user->id)
            ->with('medication')
            ->get();

        return view('reminders.index', compact('reminders'));
    }

    public function create(): View
    {
        $user = User::first() ?? User::factory()->create();
        $medications = Medication::where('user_id', $user->id)->get();

        return view('reminders.create', compact('medications'));
    }

    public function store(Request $request): RedirectResponse
    {
        $user = User::first() ?? User::factory()->create();

        $data = $request->validate([
            'type' => ['required', new Enum(ReminderType::class)],
            'medication_id' => ['nullable', 'exists:medications,id'],
            'days_before' => ['nullable', 'integer', 'min:0', 'max:10'],
            'remind_at' => ['required', 'date_format:H:i'],
        ]);

        $data['user_id'] = $user->id;
        $data['is_enabled'] = $request->boolean('is_enabled', true);

        Reminder::create($data);

        return redirect()->route('reminders.index')
            ->with('success', 'Pengingat baru berhasil diaktifkan.');
    }

    public function edit(Reminder $reminder): View
    {
        $user = User::first() ?? User::factory()->create();
        $medications = Medication::where('user_id', $user->id)->get();

        return view('reminders.edit', compact('reminder', 'medications'));
    }

    public function update(Request $request, Reminder $reminder): RedirectResponse
    {
        $data = $request->validate([
            'type' => ['required', new Enum(ReminderType::class)],
            'medication_id' => ['nullable', 'exists:medications,id'],
            'days_before' => ['nullable', 'integer', 'min:0', 'max:10'],
            'remind_at' => ['required'],
        ]);

        $data['is_enabled'] = $request->boolean('is_enabled');
        $reminder->update($data);

        return redirect()->route('reminders.index')
            ->with('success', 'Pengingat berhasil diperbarui.');
    }

    public function destroy(Reminder $reminder): RedirectResponse
    {
        $reminder->delete();

        return redirect()->route('reminders.index')
            ->with('success', 'Pengingat berhasil dinonaktifkan / dihapus.');
    }
}
