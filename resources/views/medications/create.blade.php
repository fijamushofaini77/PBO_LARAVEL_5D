@extends('layouts.app')

@section('header_title', 'Tambah Obat')

@section('breadcrumb')
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2 pb-2">
        <div>
            <h1 class="text-xl font-bold tracking-tight text-zinc-900">Tambah Obat atau Suplemen</h1>
            <p class="text-xs text-zinc-500">Tambahkan jenis obat atau suplemen baru.</p>
        </div>
        <nav aria-label="breadcrumb">
            <ol class="flex items-center gap-1.5 text-xs text-zinc-500">
                <li><a href="{{ route('dashboard') }}" class="hover:text-rose-600 transition-colors">Dashboard</a></li>
                <li class="text-zinc-300">/</li>
                <li><a href="{{ route('medications.index') }}" class="hover:text-rose-600 transition-colors">Obat</a></li>
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
                    <h3 class="text-sm font-bold text-zinc-900">Form Tambah Obat</h3>
                    <p class="text-[11px] text-zinc-500">Lengkapi nama, kategori obat, dan petunjuk dosis.</p>
                </div>
                <a href="{{ route('medications.index') }}" class="btn-pink-outline text-xs">
                    <i class="bi bi-arrow-left-circle text-xs"></i>
                    <span>Kembali</span>
                </a>
            </div>

            <div class="p-6">
                <form action="{{ route('medications.store') }}" method="POST" class="space-y-4">
                    @csrf

                    <div>
                        <label for="name" class="block text-xs font-semibold text-zinc-800 mb-1.5">
                            Nama Obat / Suplemen <span class="text-rose-500">*</span>
                        </label>
                        <input type="text"
                               id="name"
                               name="name"
                               value="{{ old('name') }}"
                               placeholder="contoh: Sangobion (Zat Besi)"
                               class="w-full shadcn-input text-xs @error('name') border-red-500 @enderror" />
                        @error('name')
                            <p class="mt-1 text-[11px] text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="type" class="block text-xs font-semibold text-zinc-800 mb-1.5">
                            Jenis / Tipe Obat <span class="text-rose-500">*</span>
                        </label>
                        <select id="type" name="type" class="w-full shadcn-input text-xs @error('type') border-red-500 @enderror">
                            <option value="">-- Pilih Jenis Obat --</option>
                            <option value="supplement" @selected(old('type') === 'supplement')>Vitamin / Suplemen (Zat Besi, Asam Folat)</option>
                            <option value="painkiller" @selected(old('type') === 'painkiller')>Pereda Nyeri (Ibuprofen, Paracetamol)</option>
                            <option value="pill" @selected(old('type') === 'pill')>Pil KB / Hormonal</option>
                        </select>
                        @error('type')
                            <p class="mt-1 text-[11px] text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="dosage" class="block text-xs font-semibold text-zinc-800 mb-1.5">
                            Aturan Pakai / Dosis <span class="text-rose-500">*</span>
                        </label>
                        <input type="text"
                               id="dosage"
                               name="dosage"
                               value="{{ old('dosage') }}"
                               placeholder="contoh: 1 tablet sesudah makan"
                               class="w-full shadcn-input text-xs @error('dosage') border-red-500 @enderror" />
                        @error('dosage')
                            <p class="mt-1 text-[11px] text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="pt-2">
                        <label class="flex items-center gap-3 cursor-pointer">
                            <input type="checkbox"
                                   id="is_active"
                                   name="is_active"
                                   value="1"
                                   class="w-4 h-4 rounded text-rose-600 focus:ring-rose-500 border-zinc-300"
                                   @checked(old('is_active', true)) />
                            <span class="text-xs font-semibold text-zinc-800">Obat Sedang Aktif Dikonsumsi</span>
                        </label>
                    </div>

                    <div class="pt-4 border-t border-zinc-100 flex items-center justify-end gap-2.5">
                        <a href="{{ route('medications.index') }}" class="btn-ghost text-xs">Batal</a>
                        <button type="submit" class="btn-pink-primary text-xs shadow-sm shadow-rose-500/20">
                            <i class="bi bi-save text-xs"></i>
                            <span>Simpan Obat</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

