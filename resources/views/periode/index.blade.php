@extends('layouts.app')

@section('header_title', 'Master Data Periode')

@section('breadcrumb')
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 pb-2">
        <div>
            <div class="eyebrow-label mb-1">Master Data</div>
            <h1 class="text-2xl font-medium heading-display text-[#14140f] flex items-center gap-2.5">
                <span>Master Data Periode</span>
                <span class="text-xs px-3 py-0.5 rounded-full bg-[#fff1f2] text-[#f43f5e] font-medium border border-[#fecdd3]">
                    Master Periode
                </span>
            </h1>
            <p class="text-xs text-[#6e6e64] mt-0.5">Kelola data periode akademik untuk praktikum yang terhubung ke phpMyAdmin.</p>
        </div>
        <nav aria-label="breadcrumb">
            <ol class="flex items-center gap-2 text-xs text-[#6e6e64]">
                <li><a href="{{ route('dashboard') }}" class="hover:text-[#f43f5e] transition-colors">Dashboard</a></li>
                <li class="text-zinc-300">/</li>
                <li><span>Data Master</span></li>
                <li class="text-zinc-300">/</li>
                <li class="text-[#f43f5e] font-medium" aria-current="page">Periode</li>
            </ol>
        </nav>
    </div>
@endsection

@section('content')
    <div class="space-y-4"
         x-data="{
             search: '',
             statusFilter: 'all',
             matches(name, code, status) {
                 const q = this.search.toLowerCase();
                 const matchesQuery = !q || name.toLowerCase().includes(q) || code.toLowerCase().includes(q);
                 const matchesStatus = this.statusFilter === 'all' || (this.statusFilter === 'active' && status === '1') || (this.statusFilter === 'inactive' && status === '0');
                 return matchesQuery && matchesStatus;
             }
         }">

        {{-- Card Container (rounded-[28px], tonal contrast per docs/design) --}}
        <div class="perk-card bg-white overflow-hidden">
            {{-- Header Toolbar with Search & Filter Pills --}}
            <div class="p-6 border-b border-[#fed7dc]/80 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                <div class="flex items-center gap-3">
                    <span class="w-10 h-10 rounded-2xl bg-rose-50 text-[#f43f5e] flex items-center justify-center text-base">
                        <i class="bi bi-calendar3"></i>
                    </span>
                    <div>
                        {{-- Sesuai Latihan Modul: Periode (Jumlah) --}}
                        <h3 class="text-base font-medium heading-display text-[#14140f]">
                            Periode ({{ $semua_periode->count() }})
                        </h3>
                        <p class="text-xs text-[#6e6e64]">Kelola data master periode akademik</p>
                    </div>
                </div>

                {{-- Interactive Search & Filter Controls --}}
                <div class="flex flex-wrap items-center gap-3">
                    {{-- Search Box --}}
                    <div class="relative">
                        <i class="bi bi-search text-zinc-400 text-xs absolute left-3.5 top-2.5"></i>
                        <input type="text"
                               x-model="search"
                               placeholder="Cari periode atau singkatan..."
                               class="pl-9 pr-3 py-1.5 text-xs rounded-full border border-[#fed7dc] bg-[#fdfafb] focus:bg-white focus:outline-none focus:border-[#f43f5e] w-48 sm:w-56 transition-all" />
                    </div>

                    {{-- Status Filter Tabs --}}
                    <div class="inline-flex p-1 rounded-full bg-[#fdfafb] border border-[#fed7dc] text-xs">
                        <button type="button"
                                @click="statusFilter = 'all'"
                                class="px-3 py-1 rounded-full transition-all"
                                :class="statusFilter === 'all' ? 'bg-[#f43f5e] text-white font-medium' : 'text-[#6e6e64] hover:text-[#14140f]'">
                            Semua
                        </button>
                        <button type="button"
                                @click="statusFilter = 'active'"
                                class="px-3 py-1 rounded-full transition-all"
                                :class="statusFilter === 'active' ? 'bg-[#f43f5e] text-white font-medium' : 'text-[#6e6e64] hover:text-[#14140f]'">
                            Aktif
                        </button>
                        <button type="button"
                                @click="statusFilter = 'inactive'"
                                class="px-3 py-1 rounded-full transition-all"
                                :class="statusFilter === 'inactive' ? 'bg-[#f43f5e] text-white font-medium' : 'text-[#6e6e64] hover:text-[#14140f]'">
                            Nonaktif
                        </button>
                    </div>

                    {{-- Tambah Data Button per Modul --}}
                    <a href="{{ route('periode.create') }}" class="btn-pink-pill text-xs">
                        <i class="bi bi-plus-lg text-xs" aria-hidden="true"></i>
                        <span>Tambah Data</span>
                    </a>
                </div>
            </div>

            {{-- Table View --}}
            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs">
                    <thead>
                        <tr class="bg-[#fcf6f7] border-b border-[#fed7dc] text-[#6e6e64] uppercase text-[10px] tracking-[0.1em]">
                            <th scope="col" class="py-3.5 px-5 w-14 text-center font-medium">#</th>
                            <th scope="col" class="py-3.5 px-5 font-medium">Nama Periode</th>
                            <th scope="col" class="py-3.5 px-5 font-medium">Singkatan</th>
                            <th scope="col" class="py-3.5 px-5 font-medium">Status</th>
                            <th scope="col" class="py-3.5 px-5 w-32 text-end font-medium">Opsi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-[#fed7dc]/60">
                        @forelse ($semua_periode as $periode)
                            <tr class="hover:bg-rose-50/20 transition-colors"
                                x-show="matches('{{ $periode->periode }}', '{{ $periode->singkatan }}', '{{ $periode->status ? '1' : '0' }}')">
                                <td class="py-4 px-5 text-center font-mono text-[#6e6e64] text-[11px]">
                                    {{ $loop->iteration }}
                                </td>
                                <td class="py-4 px-5 font-medium text-[#14140f]">
                                    {{ $periode->periode }}
                                </td>
                                <td class="py-4 px-5">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full font-mono text-[11px] font-medium bg-[#fcf6f7] text-[#14140f] border border-[#fed7dc]">
                                        {{ $periode->singkatan }}
                                    </span>
                                </td>
                                <td class="py-4 px-5">
                                    @if ($periode->status)
                                        <span class="inline-flex items-center gap-1.5 px-3 py-0.5 rounded-full text-[11px] font-medium bg-emerald-50 text-emerald-800 border border-emerald-200">
                                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                            Aktif
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1.5 px-3 py-0.5 rounded-full text-[11px] font-medium bg-zinc-100 text-zinc-600 border border-zinc-200">
                                            <span class="w-1.5 h-1.5 rounded-full bg-zinc-400"></span>
                                            Tidak aktif
                                        </span>
                                    @endif
                                </td>
                                <td class="py-4 px-5 text-end">
                                    <div class="inline-flex items-center gap-1.5">
                                        <a href="{{ route('periode.edit', $periode) }}"
                                           class="p-2 text-[#6e6e64] hover:text-[#f43f5e] hover:bg-rose-50 rounded-xl border border-[#fed7dc] transition-colors"
                                           aria-label="Ubah {{ $periode->periode }}" title="Ubah Periode">
                                            <i class="bi bi-pencil" aria-hidden="true"></i>
                                        </a>
                                        <button type="button"
                                                onclick="document.getElementById('modal-hapus-{{ $periode->id }}').classList.remove('hidden')"
                                                class="p-2 text-[#6e6e64] hover:text-red-600 hover:bg-red-50 rounded-xl border border-[#fed7dc] transition-colors"
                                                aria-label="Hapus {{ $periode->periode }}" title="Hapus Periode">
                                            <i class="bi bi-trash" aria-hidden="true"></i>
                                        </button>
                                    </div>
                                    @include('periode.modal-hapus')
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="py-12 text-center text-[#6e6e64] text-xs">
                                    <div class="flex flex-col items-center justify-center gap-2">
                                        <span class="w-10 h-10 rounded-full bg-rose-50 text-[#f43f5e] flex items-center justify-center text-lg">
                                            <i class="bi bi-calendar-x"></i>
                                        </span>
                                        <span class="font-medium">Belum ada data periode.</span>
                                        <a href="{{ route('periode.create') }}" class="text-[#f43f5e] hover:underline text-xs">Tambah data pertama &rarr;</a>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Table Footer Summary --}}
            <div class="p-5 bg-[#fdfafb] border-t border-[#fed7dc]/80 flex items-center justify-between text-xs text-[#6e6e64]">
                <span>Menampilkan seluruh data periode akademik</span>
                <span class="font-medium text-[#14140f]">Total: {{ $semua_periode->count() }} Data</span>
            </div>
        </div>
    </div>
@endsection
