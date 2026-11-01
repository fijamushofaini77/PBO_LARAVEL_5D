@extends('layouts.app')

@section('header_title', 'Tambah Pengingat')

@section('breadcrumb')
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2 pb-2">
        <div>
            <h1 class="text-xl font-bold tracking-tight text-zinc-900">Tambah Jadwal Pengingat</h1>
            <p class="text-xs text-zinc-500">Pasang alarm notifikasi untuk siklus atau konsumsi obat.</p>
        </div>
        <nav aria-label="breadcrumb">
            <ol class="flex items-center gap-1.5 text-xs text-zinc-500">
                <li><a href="{{ route('dashboard') }}" class="hover:text-rose-600 transition-colors">Dashboard</a></li>
                <li class="text-zinc-300">/</li>
                <li><a href="{{ route('reminders.index') }}" class="hover:text-rose-600 transition-colors">Pengingat</a></li>
                <li class="text-zinc-300">/</li>
                <li class="text-rose-700 font-semibold" aria-current="page">Tambah</li>
            </ol>
        </nav>
    </div>
@endsection

@section('content')
    <div class="max-w-xl">
        <div class="bg-white rounded-2xl border border-[#fed7dc]/80 shadow-[0_1px_3px_0_rgba(225,29,72,0.02)] overflow-hidden">
            <div class="p-5 border-b border-[#f0e6e8] flex items-center justify-between">
                <div>
                    <h3 class="text-sm font-bold text-zinc-900">Form Pasang Pengingat</h3>
                    <p class="text-[11px] text-zinc-500">Pilih jenis alarm dan jam pengingat.</p>
                </div>
                <a href="{{ route('reminders.index') }}" class="btn-pink-outline text-xs">
                    <i class="bi bi-arrow-left-circle text-xs"></i>
                    <span>Kembali</span>
                </a>
            </div>

            <div class="p-6">
                <form action="{{ route('reminders.store') }}" method="POST" class="space-y-4">
                    @csrf

                    <div>
                        <label for="type" class="block text-xs font-semibold text-zinc-800 mb-1.5">
                            Jenis Pengingat <span class="text-rose-500">*</span>
                        </label>
                        <select id="type" name="type" class="w-full shadcn-input text-xs @error('type') border-red-500 @enderror">
                            <option value="period_soon" @selected(old('type') === 'period_soon')>Haid Segera Datang (Prediksi Haid)</option>
                            <option value="fertile" @selected(old('type') === 'fertile')>Masa Subur / Ovulasi</option>
                            <option value="pill" @selected(old('type') === 'pill')>Minum Obat / Vitamin</option>
                            <option value="daily_log" @selected(old('type') === 'daily_log')>Catat Log Harian Flo</option>
                        </select>
                        @error('type')
                            <p class="mt-1 text-[11px] text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="medication_id" class="block text-xs font-semibold text-zinc-800 mb-1.5">
                            Terkait Obat (Opsional)
                        </label>
                        <select id="medication_id" name="medication_id" class="w-full shadcn-input text-xs">
                            <option value="">-- Tanpa Obat Khusus --</option>
                            @foreach ($medications as $med)
                                <option value="{{ $med->id }}" @selected(old('medication_id') == $med->id)>{{ $med->name }} ({{ $med->dosage }})</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label for="remind_at" class="block text-xs font-semibold text-zinc-800 mb-1.5">
                                Jam Alarm <span class="text-rose-500">*</span>
                            </label>
                            <input type="time"
                                   id="remind_at"
                                   name="remind_at"
                                   value="{{ old('remind_at', '08:00') }}"
                                   class="w-full shadcn-input text-xs @error('remind_at') border-red-500 @enderror" />
                            @error('remind_at')
                                <p class="mt-1 text-[11px] text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="days_before" class="block text-xs font-semibold text-zinc-800 mb-1.5">
                                Hari Sebelum (H-...)
                            </label>
                            <input type="number"
                                   id="days_before"
                                   name="days_before"
                                   value="{{ old('days_before', 2) }}"
                                   min="0" max="10"
                                   class="w-full shadcn-input text-xs" />
                            <p class="mt-1 text-[10px] text-zinc-400">0 jika di hari H.</p>
                        </div>
                    </div>

                    <div class="pt-2">
                        <label class="flex items-center gap-3 cursor-pointer">
                            <input type="checkbox"
                                   id="is_enabled"
                                   name="is_enabled"
                                   value="1"
                                   class="w-4 h-4 rounded text-rose-600 focus:ring-rose-500 border-zinc-300"
                                   @checked(old('is_enabled', true)) />
                            <span class="text-xs font-semibold text-zinc-800">Aktifkan Pengingat Ini</span>
                        </label>
                    </div>

                    <div class="pt-4 border-t border-zinc-100 flex items-center justify-end gap-2.5">
                        <a href="{{ route('reminders.index') }}" class="btn-ghost text-xs">Batal</a>
                        <button type="submit" class="btn-pink-primary text-xs shadow-sm shadow-rose-500/20">
                            <i class="bi bi-save text-xs"></i>
                            <span>Simpan Pengingat</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

