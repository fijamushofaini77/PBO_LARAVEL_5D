<?php

namespace App\Http\Controllers;

use App\Models\Periode;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PeriodeController extends Controller
{
    /**
     * Tampilkan daftar periode master data.
     */
    public function index(): View
    {
        $semua_periode = Periode::orderBy('id', 'desc')->get();

        return view('periode.index', compact('semua_periode'));
    }

    /**
     * Tampilkan formulir penambahan periode baru.
     */
    public function create(): View
    {
        return view('periode.create');
    }

    /**
     * Simpan periode baru ke dalam database MySQL.
     */
    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'periode' => ['required', 'string', 'max:50'],
            'singkatan' => ['required', 'string', 'max:10', 'unique:periode,singkatan'],
        ], [
            'periode.required' => 'Nama periode wajib diisi.',
            'singkatan.required' => 'Singkatan wajib diisi.',
            'singkatan.unique' => 'Singkatan sudah dipakai periode lain.',
        ]);

        $data['status'] = $request->boolean('status');

        Periode::create($data);

        return redirect()->route('periode.index')
            ->with('success', 'Periode berhasil ditambahkan.');
    }

    /**
     * Tampilkan formulir pengubahan data periode.
     */
    public function edit(Periode $periode): View
    {
        return view('periode.edit', compact('periode'));
    }

    /**
     * Perbarui data periode di dalam database MySQL.
     */
    public function update(Request $request, Periode $periode): RedirectResponse
    {
        $data = $request->validate([
            'periode' => ['required', 'string', 'max:50'],
            'singkatan' => ['required', 'string', 'max:10', 'unique:periode,singkatan,'.$periode->id],
        ], [
            'periode.required' => 'Nama periode wajib diisi.',
            'singkatan.required' => 'Singkatan wajib diisi.',
            'singkatan.unique' => 'Singkatan sudah dipakai periode lain.',
        ]);

        $data['status'] = $request->boolean('status');

        $periode->update($data);

        return redirect()->route('periode.index')
            ->with('success', 'Periode berhasil diubah.');
    }

    /**
     * Hapus data periode dari database MySQL.
     */
    public function destroy(Periode $periode): RedirectResponse
    {
        $periode->delete();

        return redirect()->route('periode.index')
            ->with('success', 'Periode berhasil dihapus.');
    }
}
