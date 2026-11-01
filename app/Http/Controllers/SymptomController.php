<?php

namespace App\Http\Controllers;

use App\Models\Symptom;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class SymptomController extends Controller
{
    public function index(): View
    {
        $symptoms = Symptom::withCount('symptomLogs')->get();

        return view('symptoms.index', compact('symptoms'));
    }

    public function create(): View
    {
        return view('symptoms.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:100', 'unique:symptoms,name'],
            'category' => ['required', 'string', 'max:50'],
            'icon' => ['nullable', 'string', 'max:50'],
        ], [
            'name.required' => 'Nama gejala wajib diisi.',
            'name.unique' => 'Gejala ini sudah terdaftar.',
            'category.required' => 'Kategori wajib dipilih.',
        ]);

        $data['slug'] = Str::slug($data['name']);
        $data['icon'] = $data['icon'] ?? 'sparkles';

        Symptom::create($data);

        return redirect()->route('symptoms.index')
            ->with('success', 'Gejala baru berhasil ditambahkan.');
    }

    public function edit(Symptom $symptom): View
    {
        return view('symptoms.edit', compact('symptom'));
    }

    public function update(Request $request, Symptom $symptom): RedirectResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:100', 'unique:symptoms,name,'.$symptom->id],
            'category' => ['required', 'string', 'max:50'],
            'icon' => ['nullable', 'string', 'max:50'],
        ]);

        $data['slug'] = Str::slug($data['name']);
        $symptom->update($data);

        return redirect()->route('symptoms.index')
            ->with('success', 'Data gejala berhasil diubah.');
    }

    public function destroy(Symptom $symptom): RedirectResponse
    {
        $symptom->delete();

        return redirect()->route('symptoms.index')
            ->with('success', 'Gejala berhasil dihapus.');
    }
}
