@extends('layouts.app')

@section('header_title', 'Tambah Periode')

@section('breadcrumb')
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2 pb-2">
        <div>
            <h1 class="text-xl font-bold tracking-tight text-zinc-900">Tambah Data Periode</h1>
            <p class="text-xs text-zinc-500">Tambahkan periode akademik baru ke dalam sistem.</p>
        </div>
        <nav aria-label="breadcrumb">
            <ol class="flex items-center gap-1.5 text-xs text-zinc-500">
                <li><a href="{{ route('dashboard') }}" class="hover:text-rose-600 transition-colors">Dashboard</a></li>
                <li class="text-zinc-300">/</li>
                <li><a href="{{ route('periode.index') }}" class="hover:text-rose-600 transition-colors">Periode</a></li>
                <li class="text-zinc-300">/</li>
                <li class="text-rose-700 font-semibold" aria-current="page">Tambah</li>
            </ol>
        </nav>
    </div>
@endsection

@section('content')
    <div class="max-w-2xl">
        <div class="bg-white rounded-2xl border border-[#fed7dc]/80 shadow-[0_1px_3px_0_rgba(225,29,72,0.02)] overflow-hidden">
            {{-- Header --}}
            <div class="p-5 border-b border-[#f0e6e8] flex items-center justify-between">
                <div>
                    <h3 class="text-sm font-bold text-zinc-900">Form Tambah Periode</h3>
                    <p class="text-[11px] text-zinc-500">Semua input tervalidasi di sisi server Laravel.</p>
                </div>
                <a href="{{ route('periode.index') }}" class="btn-pink-outline text-xs">
                    <i class="bi bi-arrow-left-circle text-xs" aria-hidden="true"></i>
                    <span>Kembali</span>
                </a>
            </div>

            {{-- Form Body --}}
            <div class="p-6">
                <form action="{{ route('periode.store') }}" method="POST" class="space-y-5">
                    @csrf

                    {{-- Nama Periode --}}
                    <div>
                        <label for="periode" class="block text-xs font-semibold text-zinc-800 mb-1.5">
                            Nama Periode <span class="text-rose-500">*</span>
                        </label>
                        <input type="text"
                               id="periode"
                               name="periode"
                               value="{{ old('periode') }}"
                               placeholder="contoh: GANJIL 2027/2028"
                               class="w-full shadcn-input text-xs @error('periode') border-red-500 focus:border-red-500 focus:ring-red-200 @enderror" />
                        @error('periode')
                            <p class="mt-1.5 text-[11px] text-red-600 flex items-center gap-1">
                                <i class="bi bi-exclamation-circle"></i>
                                <span>{{ $message }}</span>
                            </p>
                        @enderror
                        <p class="mt-1 text-[10px] text-zinc-400">Gunakan format semester dan tahun akademik yang jelas.</p>
                    </div>

                    {{-- Singkatan --}}
                    <div>
                        <label for="singkatan" class="block text-xs font-semibold text-zinc-800 mb-1.5">
                            Singkatan <span class="text-rose-500">*</span>
                        </label>
                        <input type="text"
                               id="singkatan"
                               name="singkatan"
                               value="{{ old('singkatan') }}"
                               placeholder="contoh: 271"
                               class="w-full shadcn-input text-xs @error('singkatan') border-red-500 focus:border-red-500 focus:ring-red-200 @enderror" />
                        @error('singkatan')
                            <p class="mt-1.5 text-[11px] text-red-600 flex items-center gap-1">
                                <i class="bi bi-exclamation-circle"></i>
                                <span>{{ $message }}</span>
                            </p>
                        @enderror
                        <p class="mt-1 text-[10px] text-zinc-400">Kode unik singkatan periode (maks 10 karakter, harus unik)</p>
                    </div>

                    {{-- Status Switch --}}
                    <div class="pt-2">
                        <label class="flex items-center gap-3 cursor-pointer select-none">
                            <input type="checkbox"
                                   id="status"
                                   name="status"
                                   value="1"
                                   class="w-4 h-4 rounded text-rose-600 focus:ring-rose-500 border-zinc-300"
                                   @checked(old('status', true)) />
                            <div class="flex flex-col">
                                <span class="text-xs font-semibold text-zinc-800">Status Periode Aktif</span>
                                <span class="text-[11px] text-zinc-500">Centang untuk menjadikan periode ini sebagai periode berjalan.</span>
                            </div>
                        </label>
                    </div>

                    {{-- Buttons --}}
                    <div class="pt-4 border-t border-zinc-100 flex items-center justify-end gap-2.5">
                        <a href="{{ route('periode.index') }}" class="btn-ghost text-xs">
                            <i class="bi bi-x-circle text-xs" aria-hidden="true"></i>
                            <span>Batal</span>
                        </a>
                        <button type="submit" class="btn-pink-primary text-xs shadow-sm shadow-rose-500/20">
                            <i class="bi bi-save text-xs" aria-hidden="true"></i>
                            <span>Simpan</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

