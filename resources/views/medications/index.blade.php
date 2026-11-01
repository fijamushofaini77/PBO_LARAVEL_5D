@extends('layouts.app')

@section('header_title', 'Obat & Suplemen')

@section('breadcrumb')
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2 pb-2">
        <div>
            <h1 class="text-xl font-bold tracking-tight text-zinc-900">Master Obat & Suplemen</h1>
            <p class="text-xs text-zinc-500">Kelola daftar vitamin, pereda nyeri, atau pil KB yang dikonsumsi.</p>
        </div>
        <nav aria-label="breadcrumb">
            <ol class="flex items-center gap-1.5 text-xs text-zinc-500">
                <li><a href="{{ route('dashboard') }}" class="hover:text-rose-600 transition-colors">Dashboard</a></li>
                <li class="text-zinc-300">/</li>
                <li class="text-rose-700 font-semibold" aria-current="page">Obat</li>
            </ol>
        </nav>
    </div>
@endsection

@section('content')
    <div class="space-y-4">
        <div class="bg-white rounded-2xl border border-[#fed7dc]/80 shadow-[0_1px_3px_0_rgba(225,29,72,0.02)] overflow-hidden">
            <div class="p-5 border-b border-[#f0e6e8] flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                <div class="flex items-center gap-2.5">
                    <div class="w-8 h-8 rounded-lg bg-rose-50 text-rose-600 flex items-center justify-center font-bold">
                        <i class="bi bi-capsule"></i>
                    </div>
                    <div>
                        <h3 class="text-sm font-bold text-zinc-900">Daftar Obat ({{ $medications->count() }})</h3>
                        <p class="text-[11px] text-zinc-500">Tersimpan di tabel MySQL <code class="font-mono text-rose-600">medications</code></p>
                    </div>
                </div>

                <a href="{{ route('medications.create') }}" class="btn-pink-primary text-xs shadow-sm shadow-rose-500/20">
                    <i class="bi bi-plus-circle text-xs"></i>
                    <span>Tambah Obat</span>
                </a>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs">
                    <thead>
                        <tr class="bg-rose-50/40 border-b border-[#fed7dc]/60 text-zinc-600 uppercase text-[10px] tracking-wider">
                            <th class="py-3 px-4 font-semibold text-center w-12">#</th>
                            <th class="py-3 px-4 font-semibold">Nama Obat / Suplemen</th>
                            <th class="py-3 px-4 font-semibold">Jenis / Tipe</th>
                            <th class="py-3 px-4 font-semibold">Dosis</th>
                            <th class="py-3 px-4 font-semibold">Status</th>
                            <th class="py-3 px-4 text-end font-semibold">Opsi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-[#f0e6e8]">
                        @forelse ($medications as $med)
                            <tr class="hover:bg-rose-50/20 transition-colors">
                                <td class="py-3.5 px-4 text-center font-mono text-zinc-500 text-[11px]">
                                    {{ $loop->iteration }}
                                </td>
                                <td class="py-3.5 px-4 font-semibold text-zinc-900">
                                    {{ $med->name }}
                                </td>
                                <td class="py-3.5 px-4">
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-semibold bg-rose-50 text-rose-700 border border-rose-200">
                                        {{ $med->type->label() }}
                                    </span>
                                </td>
                                <td class="py-3.5 px-4 font-medium text-zinc-700">
                                    {{ $med->dosage }}
                                </td>
                                <td class="py-3.5 px-4">
                                    @if ($med->is_active)
                                        <span class="inline-flex items-center gap-1.5 px-2 py-0.5 rounded-full text-[10px] font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200">
                                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                            Aktif
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1.5 px-2 py-0.5 rounded-full text-[10px] font-semibold bg-zinc-100 text-zinc-600 border border-zinc-200">
                                            Nonaktif
                                        </span>
                                    @endif
                                </td>
                                <td class="py-3.5 px-4 text-end">
                                    <div class="inline-flex items-center gap-1.5">
                                        <a href="{{ route('medications.edit', $med) }}" class="p-1.5 text-zinc-500 hover:text-rose-600 hover:bg-rose-50 rounded-lg border border-zinc-200 transition-colors">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <form action="{{ route('medications.destroy', $med) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus obat ini?')" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="p-1.5 text-zinc-500 hover:text-red-600 hover:bg-red-50 rounded-lg border border-zinc-200 transition-colors">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="py-8 text-center text-zinc-500">Belum ada obat yang terdaftar.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

