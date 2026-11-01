@extends('layouts.app')

@section('header_title', 'Tambah Gejala')

@section('breadcrumb')
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2 pb-2">
        <div>
            <h1 class="text-xl font-bold tracking-tight text-zinc-900">Tambah Gejala Baru</h1>
            <p class="text-xs text-zinc-500">Daftarkan jenis keluhan atau kondisi fisik baru ke database.</p>
        </div>
        <nav aria-label="breadcrumb">
            <ol class="flex items-center gap-1.5 text-xs text-zinc-500">
                <li><a href="{{ route('dashboard') }}" class="hover:text-rose-600 transition-colors">Dashboard</a></li>
                <li class="text-zinc-300">/</li>
                <li><a href="{{ route('symptoms.index') }}" class="hover:text-rose-600 transition-colors">Gejala</a></li>
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
                    <h3 class="text-sm font-bold text-zinc-900">Form Tambah Gejala</h3>
                    <p class="text-[11px] text-zinc-500">Slug akan di-generate otomatis dari nama gejala.</p>
                </div>
                <a href="{{ route('symptoms.index') }}" class="btn-pink-outline text-xs">
                    <i class="bi bi-arrow-left-circle text-xs"></i>
                    <span>Kembali</span>
                </a>
            </div>

            <div class="p-6">
                <form action="{{ route('symptoms.store') }}" method="POST" class="space-y-4">
                    @csrf

                    <div>
                        <label for="name" class="block text-xs font-semibold text-zinc-800 mb-1.5">
                            Nama Gejala <span class="text-rose-500">*</span>
                        </label>
                        <input type="text"
                               id="name"
                               name="name"
                               value="{{ old('name') }}"
                               placeholder="contoh: Kram Perut Bawah"
                               class="w-full shadcn-input text-xs @error('name') border-red-500 @enderror" />
                        @error('name')
                            <p class="mt-1 text-[11px] text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="category" class="block text-xs font-semibold text-zinc-800 mb-1.5">
                            Kategori Gejala <span class="text-rose-500">*</span>
                        </label>
                        <select id="category" name="category" class="w-full shadcn-input text-xs @error('category') border-red-500 @enderror">
                            <option value="">-- Pilih Kategori --</option>
                            <option value="physical" @selected(old('category') === 'physical')>Fisik & Nyeri (Physical)</option>
                            <option value="digestive" @selected(old('category') === 'digestive')>Pencernaan (Digestive)</option>
                            <option value="skin" @selected(old('category') === 'skin')>Kulit & Rambut (Skin)</option>
                            <option value="emotional" @selected(old('category') === 'emotional')>Emosi & Mood (Emotional)</option>
                            <option value="energy" @selected(old('category') === 'energy')>Energi & Tidur (Energy)</option>
                        </select>
                        @error('category')
                            <p class="mt-1 text-[11px] text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="pt-4 border-t border-zinc-100 flex items-center justify-end gap-2.5">
                        <a href="{{ route('symptoms.index') }}" class="btn-ghost text-xs">Batal</a>
                        <button type="submit" class="btn-pink-primary text-xs shadow-sm shadow-rose-500/20">
                            <i class="bi bi-save text-xs"></i>
                            <span>Simpan Gejala</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

