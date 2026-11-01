@extends('layouts.app')

@section('header_title', 'Siklus & Log Haid')

@section('breadcrumb')
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2 pb-2">
        <div>
            <h1 class="text-xl font-bold tracking-tight text-zinc-900">Kelola Siklus & Periode Haid</h1>
            <p class="text-xs text-zinc-500">Pencatatan siklus menstruasi dan durasi haid tersimpan di tabel MySQL.</p>
        </div>
        <nav aria-label="breadcrumb">
            <ol class="flex items-center gap-1.5 text-xs text-zinc-500">
                <li><a href="{{ route('dashboard') }}" class="hover:text-rose-600 transition-colors">Dashboard</a></li>
                <li class="text-zinc-300">/</li>
                <li class="text-rose-700 font-semibold" aria-current="page">Siklus Haid</li>
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
                        <i class="bi bi-arrow-repeat"></i>
                    </div>
                    <div>
                        <h3 class="text-sm font-bold text-zinc-900">Daftar Siklus ({{ $cycles->count() }})</h3>
                        <p class="text-[11px] text-zinc-500">Setiap siklus baru akan menutup siklus sebelumnya secara otomatis.</p>
                    </div>
                </div>

                <a href="{{ route('cycles.create') }}" class="btn-pink-primary text-xs shadow-sm shadow-rose-500/20">
                    <i class="bi bi-plus-circle text-xs"></i>
                    <span>Catat Siklus Baru</span>
                </a>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs">
                    <thead>
                        <tr class="bg-rose-50/40 border-b border-[#fed7dc]/60 text-zinc-600 uppercase text-[10px] tracking-wider">
                            <th class="py-3 px-4 font-semibold text-center w-12">#</th>
                            <th class="py-3 px-4 font-semibold">Tanggal Mulai</th>
                            <th class="py-3 px-4 font-semibold">Tanggal Selesai</th>
                            <th class="py-3 px-4 font-semibold">Panjang Siklus</th>
                            <th class="py-3 px-4 font-semibold">Durasi Haid</th>
                            <th class="py-3 px-4 font-semibold">Status</th>
                            <th class="py-3 px-4 text-end font-semibold">Opsi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-[#f0e6e8]">
                        @forelse ($cycles as $cycle)
                            <tr class="hover:bg-rose-50/20 transition-colors">
                                <td class="py-3.5 px-4 text-center font-mono text-zinc-500 text-[11px]">
                                    {{ $loop->iteration }}
                                </td>
                                <td class="py-3.5 px-4 font-semibold text-zinc-900">
                                    {{ $cycle->start_date->translatedFormat('d F Y') }}
                                </td>
                                <td class="py-3.5 px-4 text-zinc-600">
                                    {{ $cycle->end_date ? $cycle->end_date->translatedFormat('d F Y') : 'Berjalan (Aktif)' }}
                                </td>
                                <td class="py-3.5 px-4">
                                    @if ($cycle->cycle_length)
                                        <span class="font-mono font-bold text-zinc-800">{{ $cycle->cycle_length }} Hari</span>
                                    @else
                                        <span class="text-zinc-400 italic">Sedang berjalan</span>
                                    @endif
                                </td>
                                <td class="py-3.5 px-4">
                                    <span class="inline-flex items-center gap-1 font-semibold text-rose-700">
                                        <i class="bi bi-droplet-fill text-xs text-rose-500"></i>
                                        {{ $cycle->period_length ?? 5 }} Hari
                                    </span>
                                </td>
                                <td class="py-3.5 px-4">
                                    @if (!$cycle->end_date)
                                        <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-rose-100 text-rose-800 border border-rose-200">
                                            Siklus Aktif
                                        </span>
                                    @else
                                        <span class="px-2.5 py-0.5 rounded-full text-[10px] font-medium bg-zinc-100 text-zinc-600 border border-zinc-200">
                                            Selesai
                                        </span>
                                    @endif
                                </td>
                                <td class="py-3.5 px-4 text-end">
                                    <div class="inline-flex items-center gap-1.5">
                                        <a href="{{ route('cycles.edit', $cycle) }}" class="p-1.5 text-zinc-500 hover:text-rose-600 hover:bg-rose-50 rounded-lg border border-zinc-200 transition-colors" title="Ubah Siklus">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <form action="{{ route('cycles.destroy', $cycle) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus catatan siklus ini?')" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="p-1.5 text-zinc-500 hover:text-red-600 hover:bg-red-50 rounded-lg border border-zinc-200 transition-colors" title="Hapus Siklus">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="py-8 text-center text-zinc-500">Belum ada siklus yang dicatat.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

