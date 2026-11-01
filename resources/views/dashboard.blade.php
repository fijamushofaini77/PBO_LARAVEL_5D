@extends('layouts.app')

@section('header_title', 'Dashboard Siklus')

@section('breadcrumb')
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 pb-2">
        <div>
            <div class="eyebrow-label mb-1">Flo Tracker Platform &bull; TI 5D</div>
            <h1 class="text-2xl font-medium heading-display flex items-center gap-2.5">
                <span>Dashboard Siklus Menstruasi</span>
                <span class="inline-flex items-center gap-1.5 px-3 py-0.5 rounded-full text-xs font-medium bg-[#fff1f2] text-[#f43f5e] border border-[#fecdd3]">
                    <span class="w-1.5 h-1.5 rounded-full bg-[#f43f5e] animate-pulse"></span>
                    Flo Engine Aktif
                </span>
            </h1>
            <p class="text-xs text-[#6e6e64] mt-1">Pemantauan siklus haid, perkiraan masa subur, dan pencatatan kesehatan reproduksi.</p>
        </div>

        <div class="flex items-center gap-2">
            <a href="{{ route('cycles.create') }}" class="btn-pink-pill text-xs">
                <i class="bi bi-plus-lg text-xs"></i>
                <span>Catat Siklus Baru</span>
            </a>
            <a href="{{ route('periode.index') }}" class="btn-ghost-pill text-xs">
                <i class="bi bi-calendar3 text-xs text-[#f43f5e]"></i>
                <span>Master Periode (Modul 5)</span>
            </a>
        </div>
    </div>
@endsection

@section('content')
    <div class="space-y-6" x-data="{
        selectedCycleDay: {{ $dayOfCycle }},
        cycleDaysData: {
            1: { phase: 'Menstruasi', desc: 'Hari pertama haid. Dinding rahim meluruh. Kadar estrogen & progesteron di titik terendah.', fertility: 'Sangat Rendah', tip: 'Istirahat cukup dan konsumsi air hangat untuk mengurangi kram.' },
            2: { phase: 'Menstruasi', desc: 'Aliran haid biasanya paling deras. Kram rahim umum terjadi.', fertility: 'Sangat Rendah', tip: 'Gunakan kompres hangat di perut bawah jika nyeri berlanjut.' },
            3: { phase: 'Menstruasi', desc: 'Pendarahan mulai menurun. Hormon FSH mulai merangsang folikel indung telur.', fertility: 'Rendah', tip: 'Penuhi asupan zat besi seperti sayur bayam atau suplemen Sangobion.' },
            5: { phase: 'Akhir Menstruasi', desc: 'Aliran haid berakhir atau flek ringan (spotting).', fertility: 'Rendah', tip: 'Tubuh mulai memulihkan energi.' },
            8: { phase: 'Fase Folikular', desc: 'Estrogen meningkat, energi dan fokus mental mulai mencapai performa terbaik.', fertility: 'Sedang', tip: 'Waktu optimal untuk aktivitas fisik dan pekerjaan produktif.' },
            12: { phase: 'Masa Subur (Fertile Window)', desc: 'Mendekati lonjakan LH. Peluang pembuahan tinggi.', fertility: 'Tinggi', tip: 'Lakukan tes ovulasi jika sedang merencanakan kehamilan.' },
            14: { phase: 'Fase Ovulasi', desc: 'Sel telur dilepaskan dari ovarium. Puncak kesuburan siklus.', fertility: 'Puncak Kesuburan', tip: 'Suhu basal tubuh akan sedikit meningkat setelah ovulasi.' },
            18: { phase: 'Fase Luteal Awal', desc: 'Korpus luteum memproduksi progesteron untuk menebalkan dinding rahim.', fertility: 'Menurun', tip: 'Jaga pola makan seimbang dan kurangi konsumsi kafein berlebih.' },
            24: { phase: 'Fase Luteal Akhir', desc: 'Masa PMS (Sindrom Pra-Haid). Mood swings atau kembung bisa muncul.', fertility: 'Sangat Rendah', tip: 'Lakukan relaksasi dan tidur minimal 7-8 jam per malam.' },
            28: { phase: 'Akhir Siklus (Persiapan Menstruasi)', desc: 'Kadar hormon turun jika tidak ada pembuahan. Siklus baru segera dimulai.', fertility: 'Sangat Rendah', tip: 'Siapkan produk sanitasi untuk menyambut siklus berikutnya.' }
        },
        getActiveDayInfo(day) {
            if (this.cycleDaysData[day]) return this.cycleDaysData[day];
            if (day <= 5) return { phase: 'Menstruasi (Hari ' + day + ')', desc: 'Aliran pendarahan haid aktif.', fertility: 'Rendah', tip: 'Ganti pembalut secara berkala setiap 4 jam.' };
            if (day <= 13) return { phase: 'Fase Folikular (Hari ' + day + ')', desc: 'Estrogen menaikkan suasana hati dan vitalitas.', fertility: day >= 10 ? 'Tinggi' : 'Sedang', tip: 'Waktu baik untuk olahraga teratur.' };
            if (day <= 15) return { phase: 'Fase Ovulasi (Hari ' + day + ')', desc: 'Masa ovulasi dan puncak masa subur.', fertility: 'Puncak Kesuburan', tip: 'Cairan serviks bening dan elastis.' };
            return { phase: 'Fase Luteal (Hari ' + day + ')', desc: 'Persiapan akhir siklus. Waspada gejala PMS.', fertility: 'Rendah', tip: 'Kurangi konsumsi garam untuk mencegah kembung.' };
        }
    }">

        {{-- ========================================== --}}
        {{-- 1. Metric Stat Cards Row (shadcn dashboard-01) --}}
        {{-- ========================================== --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            {{-- Card 1: Rata-rata Siklus --}}
            <div class="perk-card p-6 bg-white hover:border-[#f43f5e] transition-colors">
                <div class="flex items-center justify-between">
                    <span class="eyebrow-label">Rata-rata Siklus</span>
                    <span class="w-8 h-8 rounded-full bg-rose-50 text-[#f43f5e] flex items-center justify-center text-sm">
                        <i class="bi bi-arrow-repeat"></i>
                    </span>
                </div>
                <div class="mt-3 flex items-baseline gap-2">
                    <span class="text-3xl font-medium heading-display">{{ $avgCycleLength }}</span>
                    <span class="text-xs text-[#6e6e64]">Hari</span>
                </div>
                <div class="mt-3 flex items-center gap-1.5 text-[11px]">
                    <span class="inline-flex items-center gap-1 text-emerald-800 font-medium bg-emerald-50 px-2 py-0.5 rounded-full border border-emerald-200">
                        <i class="bi bi-check2"></i> Normal (21–35)
                    </span>
                    <span class="text-[#6e6e64]">Konsisten</span>
                </div>
            </div>

            {{-- Card 2: Durasi Rata-rata Haid --}}
            <div class="perk-card p-6 bg-white hover:border-[#f43f5e] transition-colors">
                <div class="flex items-center justify-between">
                    <span class="eyebrow-label">Durasi Haid</span>
                    <span class="w-8 h-8 rounded-full bg-rose-50 text-[#f43f5e] flex items-center justify-center text-sm">
                        <i class="bi bi-droplet-half"></i>
                    </span>
                </div>
                <div class="mt-3 flex items-baseline gap-2">
                    <span class="text-3xl font-medium heading-display">{{ $avgPeriodLength }}</span>
                    <span class="text-xs text-[#6e6e64]">Hari</span>
                </div>
                <div class="mt-3 flex items-center gap-1.5 text-[11px]">
                    <span class="inline-flex items-center gap-1 text-rose-800 font-medium bg-rose-50 px-2 py-0.5 rounded-full border border-rose-200">
                        Teratur
                    </span>
                    <span class="text-[#6e6e64]">Ideal 3–7 hari</span>
                </div>
            </div>

            {{-- Card 3: Prediksi Haid Berikutnya --}}
            <div class="perk-card p-6 bg-white hover:border-[#f43f5e] transition-colors">
                <div class="flex items-center justify-between">
                    <span class="eyebrow-label">Prediksi Haid</span>
                    <span class="w-8 h-8 rounded-full bg-rose-50 text-[#f43f5e] flex items-center justify-center text-sm">
                        <i class="bi bi-calendar-heart"></i>
                    </span>
                </div>
                <div class="mt-3 flex items-baseline gap-2">
                    <span class="text-2xl font-medium heading-display">
                        {{ $nextPeriodDate ? $nextPeriodDate->translatedFormat('d M Y') : '-' }}
                    </span>
                </div>
                <div class="mt-3 flex items-center gap-1.5 text-[11px]">
                    @if ($daysUntilNextPeriod > 0)
                        <span class="inline-flex items-center gap-1 text-amber-800 font-medium bg-amber-50 px-2 py-0.5 rounded-full border border-amber-200">
                            {{ $daysUntilNextPeriod }} hari lagi
                        </span>
                    @else
                        <span class="inline-flex items-center gap-1 text-rose-800 font-medium bg-rose-100 px-2 py-0.5 rounded-full border border-rose-300">
                            Hari ini
                        </span>
                    @endif
                    <span class="text-[#6e6e64]">Ovulasi ~{{ $ovulationDate ? $ovulationDate->translatedFormat('d M') : '-' }}</span>
                </div>
            </div>

            {{-- Card 4: Fase Siklus Hari Ini --}}
            <div class="perk-card p-6 bg-white hover:border-[#f43f5e] transition-colors">
                <div class="flex items-center justify-between">
                    <span class="eyebrow-label">Fase Hari Ini</span>
                    <span class="w-8 h-8 rounded-full bg-rose-50 text-[#f43f5e] flex items-center justify-center text-sm">
                        <i class="bi bi-flower1"></i>
                    </span>
                </div>
                <div class="mt-3 flex items-baseline gap-2">
                    <span class="text-xl font-medium heading-display">
                        {{ $currentPhase->label() }}
                    </span>
                </div>
                <div class="mt-3 flex items-center gap-1.5 text-[11px]">
                    <span class="px-2.5 py-0.5 rounded-full font-medium border {{ $currentPhase->badgeClasses() }}">
                        Hari ke-{{ $dayOfCycle }}
                    </span>
                    <span class="text-[#6e6e64] truncate">Dari {{ $avgCycleLength }} hari</span>
                </div>
            </div>
        </div>

        {{-- ========================================== --}}
        {{-- 2. Interactive Desktop Cycle Explorer (Stop Slop AI) --}}
        {{-- ========================================== --}}
        <div class="perk-card p-6 md:p-8 bg-white space-y-6">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                <div>
                    <div class="eyebrow-label mb-1">Eksplorasi Interaktif 28 Hari</div>
                    <h3 class="text-lg font-medium heading-display text-[#14140f]">
                        Simulasi Fase Biologis & Prediksi Hormon
                    </h3>
                    <p class="text-xs text-[#6e6e64] mt-0.5">
                        Klik pada nomor hari siklus di bawah untuk meninjau status hormonal, peluang kesuburan, dan tips kesehatan.
                    </p>
                </div>

                {{-- Quick Phase Badges --}}
                <div class="flex flex-wrap items-center gap-2 text-xs">
                    <span class="px-3 py-1 rounded-full bg-rose-50 text-rose-800 border border-rose-200 flex items-center gap-1.5">
                        <span class="w-2 h-2 rounded-full bg-rose-500"></span>
                        Menstruasi (1-5)
                    </span>
                    <span class="px-3 py-1 rounded-full bg-amber-50 text-amber-800 border border-amber-200 flex items-center gap-1.5">
                        <span class="w-2 h-2 rounded-full bg-amber-400"></span>
                        Folikular (6-13)
                    </span>
                    <span class="px-3 py-1 rounded-full bg-emerald-50 text-emerald-800 border border-emerald-200 flex items-center gap-1.5">
                        <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                        Ovulasi (14)
                    </span>
                    <span class="px-3 py-1 rounded-full bg-purple-50 text-purple-800 border border-purple-200 flex items-center gap-1.5">
                        <span class="w-2 h-2 rounded-full bg-purple-400"></span>
                        Luteal (15-28)
                    </span>
                </div>
            </div>

            {{-- 28-Day Interactive Clickable Dial / Segmented Row --}}
            <div class="space-y-3">
                <div class="grid grid-cols-7 sm:grid-cols-14 md:grid-cols-28 gap-1.5">
                    @for ($d = 1; $d <= 28; $d++)
                        @php
                            $isMenstruation = $d <= 5;
                            $isFollicular = $d > 5 && $d < 14;
                            $isOvulation = $d == 14;
                            $isLuteal = $d > 14;
                        @endphp
                        <button type="button"
                                @click="selectedCycleDay = {{ $d }}"
                                class="h-10 rounded-xl flex flex-col items-center justify-center text-xs font-medium transition-all relative group"
                                :class="{
                                    'ring-2 ring-[#f43f5e] scale-105 z-10 font-bold bg-[#f43f5e] text-white': selectedCycleDay === {{ $d }},
                                    '{{ $isMenstruation ? 'bg-rose-100/80 text-rose-900 hover:bg-rose-200' : ($isFollicular ? 'bg-amber-100/80 text-amber-900 hover:bg-amber-200' : ($isOvulation ? 'bg-emerald-100/80 text-emerald-900 hover:bg-emerald-200' : 'bg-purple-100/80 text-purple-900 hover:bg-purple-200')) }}': selectedCycleDay !== {{ $d }}
                                }">
                            <span class="text-[11px] leading-none">{{ $d }}</span>
                            @if ($d == $dayOfCycle)
                                <span class="w-1.5 h-1.5 rounded-full bg-[#f43f5e] mt-1" :class="selectedCycleDay === {{ $d }} ? 'bg-white' : 'bg-[#f43f5e]'"></span>
                            @endif
                        </button>
                    @endfor
                </div>

                {{-- Interactive Day Detail Card --}}
                <div class="p-5 rounded-[22px] bg-[#fcf6f7] border border-[#fed7dc] flex flex-col md:flex-row items-start md:items-center justify-between gap-4">
                    <div class="space-y-1">
                        <div class="flex items-center gap-2">
                            <span class="px-2.5 py-0.5 rounded-full text-xs font-medium bg-[#f43f5e] text-white">
                                Hari <span x-text="selectedCycleDay"></span>
                            </span>
                            <span class="text-sm font-medium text-[#14140f]" x-text="getActiveDayInfo(selectedCycleDay).phase"></span>
                            <span class="text-xs px-2 py-0.5 rounded-full bg-white border border-[#fed7dc] text-[#6e6e64]" x-text="'Peluang Hamil: ' + getActiveDayInfo(selectedCycleDay).fertility"></span>
                        </div>
                        <p class="text-xs text-[#6e6e64]" x-text="getActiveDayInfo(selectedCycleDay).desc"></p>
                    </div>

                    <div class="px-3.5 py-2 rounded-xl bg-white border border-[#fed7dc] text-xs text-[#14140f] flex items-center gap-2">
                        <i class="bi bi-lightbulb text-amber-500 text-sm"></i>
                        <span x-text="getActiveDayInfo(selectedCycleDay).tip"></span>
                    </div>
                </div>
            </div>
        </div>

        {{-- ========================================== --}}
        {{-- 3. Two-Column Layout (shadcn dashboard-01) --}}
        {{-- ========================================== --}}
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6"
             x-data="{
                 filterTab: 'all',
                 searchTable: ''
             }">

            {{-- Left Column: 8 Cols (Recent Cycles Table & Master Data) --}}
            <div class="lg:col-span-8 space-y-6">
                {{-- Recent Cycles Card with Interactive Search & Tabs --}}
                <div class="perk-card bg-white overflow-hidden">
                    {{-- Header with Search & Filter Tabs --}}
                    <div class="p-6 border-b border-[#fed7dc]/80 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                        <div>
                            <div class="eyebrow-label mb-0.5">Riwayat Catatan</div>
                            <h3 class="text-base font-medium heading-display text-[#14140f]">
                                Riwayat Siklus & Haid
                            </h3>
                            <p class="text-xs text-[#6e6e64]">Semua catatan siklus menstruasi</p>
                        </div>

                        {{-- Interactive Filter Tabs --}}
                        <div class="flex items-center gap-2">
                            <div class="inline-flex p-1 rounded-full bg-[#fdfafb] border border-[#fed7dc] text-xs">
                                <button type="button"
                                        @click="filterTab = 'all'"
                                        class="px-3 py-1 rounded-full transition-all"
                                        :class="filterTab === 'all' ? 'bg-[#f43f5e] text-white font-medium' : 'text-[#6e6e64] hover:text-[#14140f]'">
                                    Semua
                                </button>
                                <button type="button"
                                        @click="filterTab = 'active'"
                                        class="px-3 py-1 rounded-full transition-all"
                                        :class="filterTab === 'active' ? 'bg-[#f43f5e] text-white font-medium' : 'text-[#6e6e64] hover:text-[#14140f]'">
                                    Aktif
                                </button>
                                <button type="button"
                                        @click="filterTab = 'completed'"
                                        class="px-3 py-1 rounded-full transition-all"
                                        :class="filterTab === 'completed' ? 'bg-[#f43f5e] text-white font-medium' : 'text-[#6e6e64] hover:text-[#14140f]'">
                                    Selesai
                                </button>
                            </div>

                            <a href="{{ route('cycles.create') }}" class="btn-pink-pill text-xs">
                                <i class="bi bi-plus-lg text-xs"></i>
                                <span>Tambah</span>
                            </a>
                        </div>
                    </div>

                    {{-- Table --}}
                    <div class="overflow-x-auto">
                        <table class="w-full text-left text-xs">
                            <thead>
                                <tr class="bg-[#fcf6f7] border-b border-[#fed7dc] text-[#6e6e64] uppercase text-[10px] tracking-[0.1em]">
                                    <th class="py-3.5 px-5 font-medium">Mulai Siklus</th>
                                    <th class="py-3.5 px-5 font-medium">Selesai Siklus</th>
                                    <th class="py-3.5 px-5 font-medium">Panjang Siklus</th>
                                    <th class="py-3.5 px-5 font-medium">Durasi Haid</th>
                                    <th class="py-3.5 px-5 font-medium">Status</th>
                                    <th class="py-3.5 px-5 text-end font-medium">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-[#fed7dc]/60">
                                @forelse ($recentCycles as $cycle)
                                    @php
                                        $isCycleActive = is_null($cycle->end_date);
                                    @endphp
                                    <tr class="hover:bg-rose-50/30 transition-colors"
                                        x-show="filterTab === 'all' || (filterTab === 'active' && {{ $isCycleActive ? 'true' : 'false' }}) || (filterTab === 'completed' && {{ !$isCycleActive ? 'true' : 'false' }})">
                                        <td class="py-4 px-5 font-medium text-[#14140f]">
                                            {{ $cycle->start_date->translatedFormat('d M Y') }}
                                        </td>
                                        <td class="py-4 px-5 text-[#6e6e64]">
                                            {{ $cycle->end_date ? $cycle->end_date->translatedFormat('d M Y') : 'Berjalan (Aktif)' }}
                                        </td>
                                        <td class="py-4 px-5">
                                            @if ($cycle->cycle_length)
                                                <span class="font-mono font-medium text-[#14140f]">{{ $cycle->cycle_length }} Hari</span>
                                            @else
                                                <span class="text-[#6e6e64] italic">Sedang berjalan</span>
                                            @endif
                                        </td>
                                        <td class="py-4 px-5">
                                            <span class="inline-flex items-center gap-1 font-medium text-[#f43f5e]">
                                                <i class="bi bi-droplet-fill text-xs"></i>
                                                {{ $cycle->period_length ?? 5 }} Hari
                                            </span>
                                        </td>
                                        <td class="py-4 px-5">
                                            @if ($isCycleActive)
                                                <span class="px-2.5 py-0.5 rounded-full text-[10px] font-medium bg-[#fff1f2] text-[#f43f5e] border border-[#fecdd3]">
                                                    Aktif
                                                </span>
                                            @else
                                                <span class="px-2.5 py-0.5 rounded-full text-[10px] font-medium bg-zinc-100 text-zinc-600 border border-zinc-200">
                                                    Selesai
                                                </span>
                                            @endif
                                        </td>
                                        <td class="py-4 px-5 text-end">
                                            <a href="{{ route('cycles.edit', $cycle) }}" class="text-xs text-[#6e6e64] hover:text-[#f43f5e] font-medium">
                                                Kelola &rarr;
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="py-10 text-center text-xs text-[#6e6e64]">
                                            Belum ada catatan siklus yang dicatat.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                {{-- Master Data Quick Connector Grid --}}
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                    {{-- Box 1: Periode --}}
                    <div class="perk-card p-6 bg-white hover:border-[#f43f5e] transition-colors flex flex-col justify-between">
                        <div>
                            <div class="flex items-center justify-between">
                                <span class="eyebrow-label">Data Periode</span>
                                <span class="w-8 h-8 rounded-full bg-rose-50 text-[#f43f5e] flex items-center justify-center text-xs">
                                    <i class="bi bi-calendar3"></i>
                                </span>
                            </div>
                            <div class="mt-3">
                                <span class="text-2xl font-medium heading-display">{{ $totalPeriodes }} Record</span>
                                <p class="text-xs text-[#6e6e64] mt-0.5">Modul Praktikum 5</p>
                            </div>
                        </div>
                        <a href="{{ route('periode.index') }}" class="mt-4 text-xs font-medium text-[#f43f5e] hover:underline inline-flex items-center gap-1">
                            <span>Buka Master Periode</span>
                            <i class="bi bi-arrow-right text-[10px]"></i>
                        </a>
                    </div>

                    {{-- Box 2: Master Gejala --}}
                    <div class="perk-card p-6 bg-white hover:border-[#f43f5e] transition-colors flex flex-col justify-between">
                        <div>
                            <div class="flex items-center justify-between">
                                <span class="eyebrow-label">Master Gejala</span>
                                <span class="w-8 h-8 rounded-full bg-rose-50 text-[#f43f5e] flex items-center justify-center text-xs">
                                    <i class="bi bi-activity"></i>
                                </span>
                            </div>
                            <div class="mt-3">
                                <span class="text-2xl font-medium heading-display">{{ $totalSymptoms }} Gejala</span>
                                <p class="text-xs text-[#6e6e64] mt-0.5">Katalog keluhan fisik</p>
                            </div>
                        </div>
                        <a href="{{ route('symptoms.index') }}" class="mt-4 text-xs font-medium text-[#f43f5e] hover:underline inline-flex items-center gap-1">
                            <span>Kelola Gejala</span>
                            <i class="bi bi-arrow-right text-[10px]"></i>
                        </a>
                    </div>

                    {{-- Box 3: Obat & Suplemen --}}
                    <div class="perk-card p-6 bg-white hover:border-[#f43f5e] transition-colors flex flex-col justify-between">
                        <div>
                            <div class="flex items-center justify-between">
                                <span class="eyebrow-label">Obat & Vitamin</span>
                                <span class="w-8 h-8 rounded-full bg-rose-50 text-[#f43f5e] flex items-center justify-center text-xs">
                                    <i class="bi bi-capsule"></i>
                                </span>
                            </div>
                            <div class="mt-3">
                                <span class="text-2xl font-medium heading-display">{{ $activeMedications->count() }} Terdaftar</span>
                                <p class="text-xs text-[#6e6e64] mt-0.5">Jadwal konsumsi rutin</p>
                            </div>
                        </div>
                        <a href="{{ route('medications.index') }}" class="mt-4 text-xs font-medium text-[#f43f5e] hover:underline inline-flex items-center gap-1">
                            <span>Daftar Obat</span>
                            <i class="bi bi-arrow-right text-[10px]"></i>
                        </a>
                    </div>
                </div>
            </div>

            {{-- Right Column: 4 Cols (Interactive Quick Logger & phpMyAdmin Status) --}}
            <div class="lg:col-span-4 space-y-6">
                {{-- Widget: Catat Cepat Log Hari Ini (Interactive Desktop Widget) --}}
                <div class="perk-card p-6 bg-white space-y-5"
                     x-data="{
                         selectedMood: 4,
                         selectedFlow: 'medium',
                         selectedSymptoms: ['Kram Ringan', 'Kembung'],
                         toastSaved: false,
                         toggleSymptom(s) {
                             if (this.selectedSymptoms.includes(s)) {
                                 this.selectedSymptoms = this.selectedSymptoms.filter(item => item !== s);
                             } else {
                                 this.selectedSymptoms.push(s);
                             }
                         }
                     }">

                    <div class="flex items-center justify-between border-b border-[#fed7dc]/80 pb-3">
                        <div>
                            <div class="eyebrow-label text-[10px]">Logger Harian</div>
                            <h4 class="text-sm font-medium heading-display text-[#14140f]">Catat Cepat Hari Ini</h4>
                        </div>
                        <span class="text-[11px] font-mono text-[#6e6e64]">{{ $today->format('d/m/Y') }}</span>
                    </div>

                    {{-- Mood Selection --}}
                    <div class="space-y-1.5">
                        <label class="eyebrow-label text-[10px]">Suasana Hati (Mood):</label>
                        <div class="grid grid-cols-5 gap-1.5">
                            <button type="button" @click="selectedMood = 1" :class="selectedMood === 1 ? 'ring-2 ring-[#f43f5e] bg-rose-50' : 'bg-zinc-50 hover:bg-zinc-100'" class="py-2.5 rounded-xl text-lg transition-all text-center">😣</button>
                            <button type="button" @click="selectedMood = 2" :class="selectedMood === 2 ? 'ring-2 ring-[#f43f5e] bg-rose-50' : 'bg-zinc-50 hover:bg-zinc-100'" class="py-2.5 rounded-xl text-lg transition-all text-center">😕</button>
                            <button type="button" @click="selectedMood = 3" :class="selectedMood === 3 ? 'ring-2 ring-[#f43f5e] bg-rose-50' : 'bg-zinc-50 hover:bg-zinc-100'" class="py-2.5 rounded-xl text-lg transition-all text-center">😐</button>
                            <button type="button" @click="selectedMood = 4" :class="selectedMood === 4 ? 'ring-2 ring-[#f43f5e] bg-rose-50' : 'bg-zinc-50 hover:bg-zinc-100'" class="py-2.5 rounded-xl text-lg transition-all text-center">😊</button>
                            <button type="button" @click="selectedMood = 5" :class="selectedMood === 5 ? 'ring-2 ring-[#f43f5e] bg-rose-50' : 'bg-zinc-50 hover:bg-zinc-100'" class="py-2.5 rounded-xl text-lg transition-all text-center">🥰</button>
                        </div>
                    </div>

                    {{-- Flow Level Selection --}}
                    <div class="space-y-1.5">
                        <label class="eyebrow-label text-[10px]">Aliran Haid:</label>
                        <div class="grid grid-cols-2 gap-2 text-xs">
                            <button type="button" @click="selectedFlow = 'spotting'" :class="selectedFlow === 'spotting' ? 'bg-[#f43f5e] text-white font-medium' : 'bg-[#fdfafb] border border-[#fed7dc] text-[#14140f] hover:bg-rose-50'" class="py-2 px-3 rounded-full transition-all text-center">Flek</button>
                            <button type="button" @click="selectedFlow = 'light'" :class="selectedFlow === 'light' ? 'bg-[#f43f5e] text-white font-medium' : 'bg-[#fdfafb] border border-[#fed7dc] text-[#14140f] hover:bg-rose-50'" class="py-2 px-3 rounded-full transition-all text-center">Ringan</button>
                            <button type="button" @click="selectedFlow = 'medium'" :class="selectedFlow === 'medium' ? 'bg-[#f43f5e] text-white font-medium' : 'bg-[#fdfafb] border border-[#fed7dc] text-[#14140f] hover:bg-rose-50'" class="py-2 px-3 rounded-full transition-all text-center">Sedang</button>
                            <button type="button" @click="selectedFlow = 'heavy'" :class="selectedFlow === 'heavy' ? 'bg-[#f43f5e] text-white font-medium' : 'bg-[#fdfafb] border border-[#fed7dc] text-[#14140f] hover:bg-rose-50'" class="py-2 px-3 rounded-full transition-all text-center">Deras</button>
                        </div>
                    </div>

                    {{-- Common Symptoms Chips --}}
                    <div class="space-y-1.5">
                        <label class="eyebrow-label text-[10px]">Gejala Dirasakan:</label>
                        <div class="flex flex-wrap gap-1.5">
                            <template x-for="sym in ['Kram Ringan', 'Sakit Kepala', 'Kembung', 'Lelah', 'Jerawat']" :key="sym">
                                <button type="button"
                                        @click="toggleSymptom(sym)"
                                        :class="selectedSymptoms.includes(sym) ? 'bg-[#14140f] text-white' : 'bg-zinc-100 text-zinc-700 hover:bg-zinc-200'"
                                        class="px-2.5 py-1 rounded-full text-[11px] font-medium transition-colors"
                                        x-text="sym">
                                </button>
                            </template>
                        </div>
                    </div>

                    {{-- Save Button --}}
                    <div class="pt-2">
                        <button type="button"
                                @click="toastSaved = true; setTimeout(() => toastSaved = false, 3000)"
                                class="w-full btn-pink-pill justify-center text-xs">
                            <i class="bi bi-check2-circle text-xs"></i>
                            <span x-text="toastSaved ? '✓ Log Berhasil Disimpan!' : 'Simpan Log Harian'"></span>
                        </button>
                    </div>
                </div>

                {{-- Widget: Pengingat & Obat Hari Ini --}}
                <div class="perk-card p-6 bg-white space-y-4">
                    <div class="flex items-center justify-between border-b border-[#fed7dc]/80 pb-3">
                        <h4 class="text-sm font-medium heading-display text-[#14140f]">Pengingat Aktif</h4>
                        <a href="{{ route('reminders.index') }}" class="text-xs text-[#f43f5e] hover:underline font-medium">Kelola</a>
                    </div>

                    <div class="space-y-2.5">
                        @forelse ($activeReminders as $reminder)
                            <div class="p-3 rounded-[18px] bg-[#fcf6f7] border border-[#fed7dc] flex items-center justify-between">
                                <div class="flex items-center gap-3">
                                    <span class="w-8 h-8 rounded-full bg-rose-100 text-[#f43f5e] flex items-center justify-center text-xs">
                                        <i class="bi bi-alarm"></i>
                                    </span>
                                    <div>
                                        <div class="text-xs font-medium text-[#14140f]">{{ $reminder->type->label() }}</div>
                                        <div class="text-[10px] text-[#6e6e64]">
                                            {{ $reminder->medication ? $reminder->medication->name : 'Otomatis' }} &bull; {{ \Carbon\Carbon::parse($reminder->remind_at)->format('H:i') }}
                                        </div>
                                    </div>
                                </div>
                                <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                            </div>
                        @empty
                            <p class="text-xs text-[#6e6e64] py-2 text-center">Belum ada pengingat terjadwal.</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
