@extends('layouts.app')

@section('header_title', 'Catat Siklus Baru')

@section('breadcrumb')
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2 pb-2">
        <div>
            <h1 class="text-xl font-bold tracking-tight text-zinc-900">Catat Awal Siklus Haid</h1>
            <p class="text-xs text-zinc-500">Mencatat hari pertama haid untuk menghitung prediksi dan fase secara otomatis.</p>
        </div>
        <nav aria-label="breadcrumb">
            <ol class="flex items-center gap-1.5 text-xs text-zinc-500">
                <li><a href="{{ route('dashboard') }}" class="hover:text-rose-600 transition-colors">Dashboard</a></li>
                <li class="text-zinc-300">/</li>
                <li><a href="{{ route('cycles.index') }}" class="hover:text-rose-600 transition-colors">Siklus</a></li>
                <li class="text-zinc-300">/</li>
                <li class="text-rose-700 font-semibold" aria-current="page">Catat Baru</li>
            </ol>
        </nav>
    </div>
@endsection

@section('content')
    <div class="max-w-xl">
        <div class="bg-white rounded-2xl border border-[#fed7dc]/80 shadow-[0_1px_3px_0_rgba(225,29,72,0.02)] overflow-hidden">
            <div class="p-5 border-b border-[#f0e6e8] flex items-center justify-between">
                <div>
                    <h3 class="text-sm font-bold text-zinc-900">Form Catat Siklus Baru</h3>
                    <p class="text-[11px] text-zinc-500">Siklus sebelumnya akan ditutup dan dihitung panjang harinya.</p>
                </div>
                <a href="{{ route('cycles.index') }}" class="btn-pink-outline text-xs">
                    <i class="bi bi-arrow-left-circle text-xs"></i>
                    <span>Kembali</span>
                </a>
            </div>

            <div class="p-6">
                <form action="{{ route('cycles.store') }}" method="POST" class="space-y-4">
                    @csrf

                    <div>
                        <label for="start_date" class="block text-xs font-semibold text-zinc-800 mb-1.5">
                            Tanggal Hari Pertama Haid <span class="text-rose-500">*</span>
                        </label>
                        <input type="date"
                               id="start_date"
                               name="start_date"
                               value="{{ old('start_date', now()->format('Y-m-d')) }}"
                               class="w-full shadcn-input text-xs @error('start_date') border-red-500 @enderror" />
                        @error('start_date')
                            <p class="mt-1 text-[11px] text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="period_length" class="block text-xs font-semibold text-zinc-800 mb-1.5">
                            Perkiraan Durasi Pendarahan (Hari)
                        </label>
                        <input type="number"
                               id="period_length"
                               name="period_length"
                               value="{{ old('period_length', 5) }}"
                               min="1" max="15"
                               class="w-full shadcn-input text-xs" />
                        <p class="mt-1 text-[10px] text-zinc-400">Standar durasi haid rata-rata 5 hari.</p>
                    </div>

                    <div class="pt-4 border-t border-zinc-100 flex items-center justify-end gap-2.5">
                        <a href="{{ route('cycles.index') }}" class="btn-ghost text-xs">Batal</a>
                        <button type="submit" class="btn-pink-primary text-xs shadow-sm shadow-rose-500/20">
                            <i class="bi bi-check2-circle text-xs"></i>
                            <span>Simpan Siklus</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

