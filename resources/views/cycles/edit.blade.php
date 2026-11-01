@extends('layouts.app')

@section('header_title', 'Ubah Siklus')

@section('breadcrumb')
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2 pb-2">
        <div>
            <h1 class="text-xl font-bold tracking-tight text-zinc-900">Ubah Data Siklus</h1>
            <p class="text-xs text-zinc-500">Perbarui tanggal mulai, tanggal selesai, atau panjang siklus.</p>
        </div>
        <nav aria-label="breadcrumb">
            <ol class="flex items-center gap-1.5 text-xs text-zinc-500">
                <li><a href="{{ route('dashboard') }}" class="hover:text-rose-600 transition-colors">Dashboard</a></li>
                <li class="text-zinc-300">/</li>
                <li><a href="{{ route('cycles.index') }}" class="hover:text-rose-600 transition-colors">Siklus</a></li>
                <li class="text-zinc-300">/</li>
                <li class="text-rose-700 font-semibold" aria-current="page">Ubah</li>
            </ol>
        </nav>
    </div>
@endsection

@section('content')
    <div class="max-w-xl">
        <div class="bg-white rounded-2xl border border-[#fed7dc]/80 shadow-[0_1px_3px_0_rgba(225,29,72,0.02)] overflow-hidden">
            <div class="p-5 border-b border-[#f0e6e8] flex items-center justify-between">
                <div>
                    <h3 class="text-sm font-bold text-zinc-900">Form Ubah Siklus</h3>
                    <p class="text-[11px] text-zinc-500">Mulai: {{ $cycle->start_date->translatedFormat('d M Y') }}</p>
                </div>
                <a href="{{ route('cycles.index') }}" class="btn-pink-outline text-xs">
                    <i class="bi bi-arrow-left-circle text-xs"></i>
                    <span>Kembali</span>
                </a>
            </div>

            <div class="p-6">
                <form action="{{ route('cycles.update', $cycle) }}" method="POST" class="space-y-4">
                    @csrf
                    @method('PUT')

                    <div>
                        <label for="start_date" class="block text-xs font-semibold text-zinc-800 mb-1.5">
                            Tanggal Mulai Haid <span class="text-rose-500">*</span>
                        </label>
                        <input type="date"
                               id="start_date"
                               name="start_date"
                               value="{{ old('start_date', $cycle->start_date->format('Y-m-d')) }}"
                               class="w-full shadcn-input text-xs @error('start_date') border-red-500 @enderror" />
                        @error('start_date')
                            <p class="mt-1 text-[11px] text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="end_date" class="block text-xs font-semibold text-zinc-800 mb-1.5">
                            Tanggal Selesai Siklus (Opsional)
                        </label>
                        <input type="date"
                               id="end_date"
                               name="end_date"
                               value="{{ old('end_date', $cycle->end_date ? $cycle->end_date->format('Y-m-d') : '') }}"
                               class="w-full shadcn-input text-xs @error('end_date') border-red-500 @enderror" />
                        @error('end_date')
                            <p class="mt-1 text-[11px] text-red-600">{{ $message }}</p>
                        @enderror
                        <p class="mt-1 text-[10px] text-zinc-400">Kosongkan jika siklus ini masih berjalan aktif.</p>
                    </div>

                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label for="cycle_length" class="block text-xs font-semibold text-zinc-800 mb-1.5">
                                Panjang Siklus (Hari)
                            </label>
                            <input type="number"
                                   id="cycle_length"
                                   name="cycle_length"
                                   value="{{ old('cycle_length', $cycle->cycle_length) }}"
                                   min="15" max="60"
                                   class="w-full shadcn-input text-xs" />
                        </div>
                        <div>
                            <label for="period_length" class="block text-xs font-semibold text-zinc-800 mb-1.5">
                                Durasi Haid (Hari)
                            </label>
                            <input type="number"
                                   id="period_length"
                                   name="period_length"
                                   value="{{ old('period_length', $cycle->period_length) }}"
                                   min="1" max="15"
                                   class="w-full shadcn-input text-xs" />
                        </div>
                    </div>

                    <div class="pt-4 border-t border-zinc-100 flex items-center justify-end gap-2.5">
                        <a href="{{ route('cycles.index') }}" class="btn-ghost text-xs">Batal</a>
                        <button type="submit" class="btn-pink-primary text-xs shadow-sm shadow-rose-500/20">
                            <i class="bi bi-save text-xs"></i>
                            <span>Simpan Perubahan</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

